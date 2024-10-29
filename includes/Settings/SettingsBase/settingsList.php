<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\SettingsBase;

defined( 'ABSPATH' ) || exit;


use GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\MainSettings;

/**
 * Setup Metaboxes.
 *
 * @return void
 */
function setup_settings() {
	MainSettings::init();
}
