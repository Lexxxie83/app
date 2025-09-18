<?php
/**
 * [Short description]
 *
 * @package    DEVRY\WFL
 * @copyright  Copyright (c) 2025, Developry Ltd.
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU Public License
 * @since      1.3
 */

namespace DEVRY\WFL;

! defined( ABSPATH ) || exit; // Exit if accessed directly.

// The slug for plugin main page.
define( __NAMESPACE__ . '\WFL_SETTINGS_SLUG', 'wfl_settings' );

require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/settings/settings-menu.php';
require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/settings/settings-page.php';
require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/settings/settings-actions.php';
require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/settings/settings-register.php';

require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/settings/body-font-family-weight.php';
require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/settings/heading-1-font-family-weight.php';
require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/settings/heading-2-font-family-weight.php';
require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/settings/heading-3-font-family-weight.php';
require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/settings/heading-4-font-family-weight.php';
require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/settings/heading-5-font-family-weight.php';
require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/settings/heading-6-font-family-weight.php';

require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/settings/compact-mode.php';
