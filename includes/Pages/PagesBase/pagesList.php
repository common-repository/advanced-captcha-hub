<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Pages\PagesBase;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GPLSCore\GPLS_PLUGIN_WADVCPA\Pages\SettingsPage;

/**
 * Init Pages.
 *
 */
function setup_pages() {

	SettingsPage::init();
}
