<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Pages;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\MainSettings;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Shortcodes\CaptchasShortcode;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\NoticeUtilsTrait;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Pages\PagesBase\AdminPage;

/**
 * Advanced Catpcha Settings Page CLass.
 */
final class SettingsPage extends AdminPage {

	use NoticeUtilsTrait;

	/**
	 * Singular Instance.
	 *
	 * @var self
	 */
	protected static $instance = null;

	/**
	 * Prepare Page.
	 *
	 * @return void
	 */
	protected function prepare() {
		$this->page_props['page_title']       = esc_html__( 'Advanced Captcha', 'advanced-captcha-hub' );
		$this->page_props['menu_title']       = esc_html__( 'Advanced Captcha [GrandPlugins]', 'advanced-captcha-hub' );
		$this->page_props['menu_slug']        = self::$plugin_info['name'] . '-settings';
		$this->page_props['is_woocommerce']   = false;
		$this->page_props['parent_slug']      = 'tools.php';
		$this->page_props['hide_save_button'] = true;
		$this->page_props['tab_key']          = 'action';
		$this->tabs                           = array(
			'general' => array(
				'default'           => true,
				'title'             => esc_html__( 'General', 'advanced-captcha-hub' ),
				'hide_title'        => true,
				'woo_hide_save_btn' => true,
			),
			'captchas'   => array(
				'title'             => esc_html__( 'Captchas', 'advanced-captcha-hub' ),
				'hide_title'        => true,
				'woo_hide_save_btn' => true,
			),
			'shortcodes' => array(
				'title'             => esc_html__( 'Shortcodes', 'advanced-captcha-hub' ) . self::$core->new_keyword( 'Pro', true ),
				'hide_title'        => true,
				'woo_hide_save_btn' => true,
				'template'          => 'shortcodes-tab.php',
				'args'              => array(
					'shortcode' => CaptchasShortcode::init(),
				),
			),
		);
		$this->settings                       = MainSettings::init();
	}

	/**
	 * Page Hooks.
	 *
	 * @return void
	 */
	protected function hooks() {
		add_filter( 'plugin_action_links_' . self::$plugin_info['basename'], array( $this, 'page_link' ), 10, 1 );
	}

	/**
	 * Page Link.
	 *
	 * @param array $links
	 * @return array
	 */
	public function page_link( $links ) {
		$links[] = '<a href="' . esc_url( $this->get_page_path() ) . '" >' . esc_html__( 'Settings' ) . '</a>';
		return $links;
	}

	/**
	 * General tab Settings fields.
	 *
	 * @return void
	 */
	protected function general_tab() {
		$this->settings->print_settings( 'general' );
	}

	/**
	 * General tab Settings fields.
	 *
	 * @return void
	 */
	protected function captchas_tab() {
		$this->settings->print_settings( 'captchas' );
	}

	/**
	 * Set Assets.
	 *
	 * @return void
	 */
	protected function set_assets() {
		$this->assets = array(
			array(
				'handle' => self::$plugin_info['prefix'] . '-settings-actions',
				'type'   => 'js',
				'url'    => self::$plugin_info['url'] . 'assets/dist/js/admin/actions.min.js',
			),
		);
	}
}
