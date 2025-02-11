<?php
/**
 * Server-side rendering of the `indrukwekkend/navigatie` block.
 *
 * @package WordPress
 */

/**
 * Renders the `indrukwekkend/navigatie` block on server.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 * 
 *  based on https://codepen.io/Coding_Journey/pen/RwNgYmm
 * 
 */

function render_block_indrukwekkend_navigatie( $attributes ) {

	$nav_top = "";
	$nav_primary = "";
	$hamburger = "";

	//search
	//$nav_top .=	"<button class='search-header-icon' id='search-open'><i class='fas fa-search'></i></button>";

	//menu
	if (has_nav_menu('top_navigation'))	:
		$nav_top .= wp_nav_menu(['theme_location' => 'top_navigation', 'menu_class' => 'nav', 'echo' => false]) ;
	endif;
	
	//hamburger
	$hamburger .=	'<div class="hamburger">
									<span class="bar1"></span>
									<span class="bar2"></span>
									<span class="bar3"></span>
								</div>';

	//primary nav
	if (has_nav_menu('primary_navigation'))	:
		$nav_primary .= wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'depth' => 1, 'echo' => false, 'walker' => new SUB_Menu_Maker_Walker()]);
	endif;

	
		// //output
		// echo sprintf(
		// 	'<header class="mobile-navigation-container">
		// 		<nav class="nav-mobile">
		// 		%2$s
		// 		%1$s
		// 		</nav>
		// 	</header>
		// 	',
		// 	$nav_top,
		// 	$nav_primary
		// );




	//output
	return sprintf(
		'<nav class="nav-top-indrukwekkend">
			%1$s
		</nav>
		<nav class="nav-primary-indrukwekkend">
			%3$s
		</nav>
		%2$s
		<script>
			var mobileHeader = document.createElement("header");
			mobileHeader.className = "mobile-navigation-container";
			mobileHeader.innerHTML = `<nav class="nav-mobile">%3$s%1$s</nav>`;
			document.body.appendChild(mobileHeader);
		</script>
		',
		$nav_top,
		$hamburger,
		$nav_primary
	);
}

/**
 * Registers the `indrukwekkend/faq` block on server.
 */
function register_block_indrukwekkend_navigatie() {
	register_block_type(
		'indrukwekkend/navigatie',
		array(
			'attributes'      => array(
				'className'               => array(
					'type' => 'string',
				),
			),
			'render_callback' => 'render_block_indrukwekkend_navigatie',
		)
	);
}
add_action( 'init', 'register_block_indrukwekkend_navigatie' );