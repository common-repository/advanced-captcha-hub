<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Shortcodes\ShortcodesBase;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Shortcodes\CaptchasShortcode;

/**
 * Setup Shortcodes.
 *
 * @return void
 */
function setup_shortcodes() {
    CaptchasShortcode::init();
}
