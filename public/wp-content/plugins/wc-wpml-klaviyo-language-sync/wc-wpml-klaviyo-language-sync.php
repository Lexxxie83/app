<?php
/**
 * Plugin Name: WC + WPML Klaviyo Language Sync
 * Description: Sync WooCommerce order customers to language-specific Klaviyo lists (WPML) and store ordered categories/brands.
 * Version: 1.0.0
 * Author: Indrukwekkend
 */

if (!defined('ABSPATH')) {
	exit;
}

class WC_WPML_Klaviyo_Language_Sync {
	/**
	 * ====== CONFIG ======
	 * Vul hieronder je eigen waarden in.
	 */
	private const KLAVIYO_PRIVATE_API_KEY = 'pk_U2tbPA_55bf589314718b62ad3f9bce6219f4f68f'; // bv: pk_xxx of sk_xxx afhankelijk van endpoint permissies
	private const KLAVIYO_API_REVISION = '2026-04-15';

	// Koppel WPML taalcode => Klaviyo List ID
	private const LANGUAGE_LIST_MAP = [
		'en' => 'VTheVU',
		'nl' => 'UzNTkW',
		'de' => 'UUxb87',
	];

	// Taxonomy slug voor merken. Pas aan naar jullie setup (bv: product_brand, yith_product_brand, pwb-brand, ...)
	private const BRAND_TAXONOMY = 'product_brand';

	public function __construct() {
		// Trigger zodra order is geplaatst
		add_action('woocommerce_checkout_order_processed', [$this, 'handle_order'], 20, 1);

		// Fallback triggers (voor gateways die afwijkend gedrag hebben)
		add_action('woocommerce_order_status_processing', [$this, 'handle_order_status_change'], 20, 1);
		add_action('woocommerce_order_status_completed', [$this, 'handle_order_status_change'], 20, 1);
	}

	public function handle_order_status_change($order_id) {
		$this->handle_order((int) $order_id);
	}

	public function handle_order($order_id) {
		$order = wc_get_order($order_id);
		if (!$order) {
			return;
		}

		$email = sanitize_email((string) $order->get_billing_email());
		if (empty($email) || !is_email($email)) {
			return;
		}

		$first_name = (string) $order->get_billing_first_name();
		$last_name  = (string) $order->get_billing_last_name();
		$language   = $this->get_order_language($order);
		$list_id    = self::LANGUAGE_LIST_MAP[$language] ?? '';

		if (empty($list_id)) {
			// Geen mapping voor deze taal
			return;
		}

		$categories = $this->get_order_term_names($order, 'product_cat');
		$brands     = $this->get_order_term_names($order, self::BRAND_TAXONOMY);

		$profile_id = $this->upsert_profile($email, $first_name, $last_name, $language, $categories, $brands);
		if (!$profile_id) {
			return;
		}

		$this->subscribe_profile_to_list($profile_id, $list_id);
	}

	private function get_order_language(WC_Order $order) {
		// WCML zet de klanttaal bij checkout op de order (betrouwbaarder dan wpml_post_language_details voor shop_order).
		$wpml = trim((string) $order->get_meta('wpml_language'));
		if ($wpml !== '') {
			return $this->normalize_language_code($wpml);
		}

		if (has_filter('wpml_post_language_details')) {
			$details = apply_filters('wpml_post_language_details', null, $order->get_id());
			if (is_array($details) && !empty($details['language_code'])) {
				return $this->normalize_language_code((string) $details['language_code']);
			}
		}

		// Laatste redmiddel: WordPress-locale (op lokale sites vaak en_US → ten onrechte "en").
		return $this->normalize_language_code(get_locale());
	}

	/** WPML/WCML kan o.a. `de`, `de-de`, `de_de` teruggeven; map naar 2-letterige code voor LANGUAGE_LIST_MAP. */
	private function normalize_language_code($raw) {
		$raw = strtolower(trim((string) $raw));
		if ($raw === '') {
			return '';
		}
		if (strpos($raw, '-') !== false) {
			$raw = explode('-', $raw, 2)[0];
		} elseif (strpos($raw, '_') !== false) {
			$raw = explode('_', $raw, 2)[0];
		}
		return substr($raw, 0, 2);
	}

	private function get_order_term_names(WC_Order $order, $taxonomy) {
		$values = [];

		foreach ($order->get_items() as $item) {
			if (!($item instanceof WC_Order_Item_Product)) {
				continue;
			}
			$product_id = $item->get_product_id();
			if (!$product_id || !taxonomy_exists($taxonomy)) {
				continue;
			}

			$terms = wp_get_post_terms($product_id, $taxonomy, ['fields' => 'names']);
			if (!is_wp_error($terms) && !empty($terms)) {
				$values = array_merge($values, $terms);
			}
		}

		$values = array_values(array_unique(array_filter(array_map('trim', $values))));
		return $values;
	}

	private function upsert_profile($email, $first_name, $last_name, $language, array $categories, array $brands) {
		$properties = [
			'wpml_language' => $language,
			'ordered_categories' => $categories,
			'ordered_brands' => $brands,
		];
		$body = [
			'data' => [
				'type' => 'profile',
				'attributes' => [
					'email' => $email,
					'first_name' => $first_name,
					'last_name' => $last_name,
					'properties' => $properties,
				],
			],
		];

		// Gebruik profile-import (upsert). POST /api/profiles/ is alleen "nieuw aanmaken" en faalt vaak bij bestaand e-mailadres;
		// de oude fallback zocht alleen het profiel-id op en zette custom properties dan nooit.
		$url = 'https://a.klaviyo.com/api/profile-import';
		$response = wp_remote_post($url, [
			'headers' => $this->get_jsonapi_headers(),
			'body'    => wp_json_encode($body),
			'timeout' => 20,
		]);

		if (is_wp_error($response)) {
			error_log('[Klaviyo Sync] upsert_profile wp_error: ' . $response->get_error_message());
			return null;
		}

		$status = (int) wp_remote_retrieve_response_code($response);
		$raw    = wp_remote_retrieve_body($response);
		$json   = json_decode($raw, true);

		if (($status === 200 || $status === 201) && !empty($json['data']['id'])) {
			return $json['data']['id'];
		}

		error_log('[Klaviyo Sync] profile-import failed. Status: ' . $status . ' Body: ' . $raw);

		$profile_id = $this->find_profile_id_by_email($email);
		if (!$profile_id) {
			return null;
		}

		$this->patch_profile_properties($profile_id, $properties);
		return $profile_id;
	}

	/**
	 * @param array<string, mixed> $properties
	 */
	private function patch_profile_properties($profile_id, array $properties) {
		$url = 'https://a.klaviyo.com/api/profiles/' . rawurlencode($profile_id) . '/';
		$body = [
			'data' => [
				'type' => 'profile',
				'id' => $profile_id,
				'attributes' => [
					'properties' => $properties,
				],
			],
		];

		$response = wp_remote_request($url, [
			'method'  => 'PATCH',
			'headers' => $this->get_jsonapi_headers(),
			'body'    => wp_json_encode($body),
			'timeout' => 20,
		]);

		if (is_wp_error($response)) {
			error_log('[Klaviyo Sync] patch_profile_properties wp_error: ' . $response->get_error_message());
			return;
		}

		$status = (int) wp_remote_retrieve_response_code($response);
		if ($status < 200 || $status >= 300) {
			error_log('[Klaviyo Sync] patch_profile_properties failed. Status: ' . $status . ' Body: ' . wp_remote_retrieve_body($response));
		}
	}

	private function get_jsonapi_headers() {
		return array_merge($this->get_headers(), [
			'Content-Type' => 'application/vnd.api+json',
			'Accept'       => 'application/vnd.api+json',
		]);
	}

	private function find_profile_id_by_email($email) {
		$url = 'https://a.klaviyo.com/api/profiles/?filter=' . rawurlencode('equals(email,"' . $email . '")');

		$response = wp_remote_get($url, [
			'headers' => $this->get_headers(),
			'timeout' => 20,
		]);

		if (is_wp_error($response)) {
			error_log('[Klaviyo Sync] find_profile wp_error: ' . $response->get_error_message());
			return null;
		}

		$status = (int) wp_remote_retrieve_response_code($response);
		$raw    = wp_remote_retrieve_body($response);
		$json   = json_decode($raw, true);

		if ($status === 200 && !empty($json['data'][0]['id'])) {
			return $json['data'][0]['id'];
		}

		error_log('[Klaviyo Sync] find_profile failed. Status: ' . $status . ' Body: ' . $raw);
		return null;
	}

	private function subscribe_profile_to_list($profile_id, $list_id) {
		$url = 'https://a.klaviyo.com/api/lists/' . rawurlencode($list_id) . '/relationships/profiles/';
		$body = [
			'data' => [
				[
					'type' => 'profile',
					'id'   => $profile_id,
				],
			],
		];

		$response = wp_remote_post($url, [
			'headers' => $this->get_headers(),
			'body'    => wp_json_encode($body),
			'timeout' => 20,
		]);

		if (is_wp_error($response)) {
			error_log('[Klaviyo Sync] subscribe wp_error: ' . $response->get_error_message());
			return;
		}

		$status = (int) wp_remote_retrieve_response_code($response);
		if ($status < 200 || $status >= 300) {
			error_log('[Klaviyo Sync] subscribe failed. Status: ' . $status . ' Body: ' . wp_remote_retrieve_body($response));
		}
	}

	private function get_headers() {
		return [
			'Authorization' => 'Klaviyo-API-Key ' . self::KLAVIYO_PRIVATE_API_KEY,
			'Revision'      => self::KLAVIYO_API_REVISION,
			'Content-Type'  => 'application/json',
			'Accept'        => 'application/json',
		];
	}
}

new WC_WPML_Klaviyo_Language_Sync();