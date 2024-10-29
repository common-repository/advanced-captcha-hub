<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Settings;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\SettingsBase\Settings;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\MTCaptcha;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\HCaptcha;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\GeeTestCaptchaV3;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\GeeTestCaptchaV4;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\GoogleRecaptchaV2;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\GoogleRecaptchaV3;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\CaptchasSettingsUtilsTrait;
use function GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\Fields\setup_main_settings_fields;


/**
 * Main Settings CLass.
 */
final class MainSettings extends Settings {

	use CaptchasSettingsUtilsTrait;

	/**
	 * Singleton Instance.
	 *
	 * @var self
	 */
	protected static $instance = null;

	/**
	 * Prepare Settings.
	 *
	 * @return void
	 */
	protected function prepare() {
		  $this->id             = self::$plugin_info['name'] . '-advanced-captcha-settings';
		  $this->autoload       = false;
		  $this->tab_key        = 'action';
		  $this->is_woocommerce = true;
	}

	/**
	 * Set Fields.
	 *
	 * @return void
	 */
	protected function set_fields() {
		$this->fields = setup_main_settings_fields( self::$plugin_info, $this, self::$core );
	}

	/**
	 * Settings Hooks.
	 *
	 * @return void
	 */
	protected function hooks() {
		add_action( $this->id . '-before-settings-field-captchas_places_woo_add_to_cart_status', array( $this, 'conflict_notice' ), 100, 1 );
		add_action( $this->id . '-just-after-settings-field-captchas_places_woo_add_to_cart_status', array( $this, 'woo_add_to_cart_status_sub_fields' ), 100, 1 );
		add_action( $this->id . '-just-after-settings-field-captchas_places_woo_checkout_status', array( $this, 'woo_checkout_status_sub_fields' ), 100, 1 );
		add_action( $this->id . '-just-after-settings-field-captchas_places_woo_login_status', array( $this, 'woo_login_status_sub_fields' ), 100, 1 );
		add_action( $this->id . '-just-after-settings-field-captchas_places_woo_register_status', array( $this, 'woo_register_status_sub_fields' ), 100, 1 );
		add_action( $this->id . '-just-after-settings-field-captchas_places_comments_status', array( $this, 'comments_status_sub_fields' ), 100, 1 );
		add_action( $this->id . '-just-after-settings-field-captchas_places_woo_lost_pass_status', array( $this, 'woo_lost_pass_sub_fields' ), 100, 1 );
		add_action( $this->id . '-just-after-settings-field-captchas_places_wp_login_status', array( $this, 'wp_login_sub_fields' ), 100, 1 );
		add_action( $this->id . '-just-after-settings-field-captchas_places_wp_register_status', array( $this, 'wp_register_sub_fields' ), 100, 1 );
		add_action( $this->id . '-just-after-settings-field-captchas_places_wp_lost_pass_status', array( $this, 'wp_lost_pass_sub_fields' ), 100, 1 );
		add_action( $this->id . '-just-after-settings-field-login_forms_bypass', array( $this, 'log_forms_bypass_generate_btn' ), 100, 1 );
		add_action( $this->id . '-after-settings-field-login_forms_bypass', array( $this, 'log_forms_bypass_field' ), 100, 1 );
	}

	/**
	 * Woo Add To Cart Form Status Sub fields.
	 *
	 * @param array $field
	 * @return void
	 */
	public function woo_add_to_cart_status_sub_fields( $field ) {
		self::print_field( 'captchas_places_woo_add_to_cart_select', true, array(), true, true );
	}

	/**
	 * Woo Checkout Form Status Sub fields.
	 *
	 * @param array $field
	 * @return void
	 */
	public function woo_checkout_status_sub_fields( $field ) {
		self::print_field( 'captchas_places_woo_checkout_select_type', true, array(), true, true );
		self::print_field( 'captchas_places_woo_checkout_select', true, array(), true, true );
		self::print_field( 'captchas_places_woo_checkout_random_select_num', true, array(), true, true );
	}

	/**
	 * Woo Login Form Status Sub fields.
	 *
	 * @param array $field
	 * @return void
	 */
	public function woo_login_status_sub_fields( $field ) {
		self::print_field( 'captchas_places_woo_login_select_type', true, array(), true, true );
		self::print_field( 'captchas_places_woo_login_select', true, array(), true, true );
		self::print_field( 'captchas_places_woo_login_random_select_num', true, array(), true, true );
	}

	/**
	 * Woo Register Form Status Sub fields.
	 *
	 * @param array $field
	 * @return void
	 */
	public function woo_register_status_sub_fields( $field ) {
		self::print_field( 'captchas_places_woo_register_select_type', true, array(), true, true );
		self::print_field( 'captchas_places_woo_register_select', true, array(), true, true );
		self::print_field( 'captchas_places_woo_register_random_select_num', true, array(), true, true );
	}

	/**
	 * Comments Form Review Sub fields.
	 *
	 * @param array $field
	 * @return void
	 */
	public function comments_status_sub_fields( $field ) {
		self::print_field( 'captchas_places_comments_select_type', true, array(), true, true );
		self::print_field( 'captchas_places_comments_select', true, array(), true, true );
		self::print_field( 'captchas_places_comments_random_select_num', true, array(), true, true );
	}

	/**
	 * Woo Lost Password Sub fields.
	 *
	 * @param array $field
	 * @return void
	 */
	public function woo_lost_pass_sub_fields( $field ) {
		self::print_field( 'captchas_places_woo_lost_pass_select_type', true, array(), true, true );
		self::print_field( 'captchas_places_woo_lost_pass_select', true, array(), true, true );
		self::print_field( 'captchas_places_woo_lost_pass_random_select_num', true, array(), true, true );
	}

	/**
	 * WP Login Sub fields.
	 *
	 * @param array $field
	 * @return void
	 */
	public function wp_login_sub_fields( $field ) {
		self::print_field( 'captchas_places_wp_login_select_type', true, array(), true, true );
		self::print_field( 'captchas_places_wp_login_select', true, array(), true, true );
		self::print_field( 'captchas_places_wp_login_random_select_num', true, array(), true, true );
	}
	/**
	 * WP Register Sub fields.
	 *
	 * @param array $field
	 * @return void
	 */
	public function wp_register_sub_fields( $field ) {
		self::print_field( 'captchas_places_wp_register_select_type', true, array(), true, true );
		self::print_field( 'captchas_places_wp_register_select', true, array(), true, true );
		self::print_field( 'captchas_places_wp_register_random_select_num', true, array(), true, true );
	}

	/**
	 * WP Lost Password Sub fields.
	 *
	 * @param array $field
	 * @return void
	 */
	public function wp_lost_pass_sub_fields( $field ) {
		self::print_field( 'captchas_places_wp_lost_pass_select_type', true, array(), true, true );
		self::print_field( 'captchas_places_wp_lost_pass_select', true, array(), true, true );
		self::print_field( 'captchas_places_wp_lost_pass_random_select_num', true, array(), true, true );
	}

	/**
	 * Login forms ByPass Generate Button.
	 *
	 * @param array $field
	 * @return void
	 */
	public function log_forms_bypass_generate_btn( $field ) {
		?>
		<button class="btn btn-primary d-inline-block generate-bypass-login-key"><?php esc_html_e( 'Generate', 'advanced-captcha-hub' ); ?></button>
		<?php
	}

	/**
	 * Login forms ByPass field description.
	 *
	 * @param array $field
	 * @return void
	 */
	public function log_forms_bypass_field( $field ) {
		$bypass_token = $this->get_settings( 'login_forms_bypass' );
		?>
		<p class="text-muted"><?php esc_html_e( 'In case you added wrong keys for captchas or there is a conflict with other plugin and you can\'t login. you can use these links to bypass the captchas on wp and woocommerce login forms', 'advanced-captcha-hub' ); ?></p>
		<p class="text-muted"><?php esc_html_e( 'Click on Generate button, copy and save the links then hit the save changes button. ', 'advanced-captcha-hub' ); ?></p>
		<p class="text-muted bypass-links">
			<code class="wp-login-link d-block">
			<?php
			echo esc_url(
				add_query_arg(
					array(
						self::$plugin_info['prefix'] . '-bypass' => '',
					),
					wp_login_url()
				)
			);
			?>
			<span class="bypass-val"><?php echo esc_html( $bypass_token ? ( '=' . $bypass_token ) : '' ); ?></span></code>
			<code class="woo-login-link d-block">
			<?php
			echo esc_url(
				add_query_arg(
					array(
						self::$plugin_info['prefix'] . '-bypass' => '',
					),
					wc_get_page_permalink( 'myaccount' )
				)
			);
			?>
			<span class="bypass-val"><?php echo esc_html( $bypass_token ? ( '=' . $bypass_token ) : '' ); ?></span></code>
		</p>
		<?php
	}

	/**
	 * Get Captcahs.
	 *
	 * @return array
	 */
	public function _get_captchas() {
		$captchas          = array(
			'geetestv3'         => GeeTestCaptchaV3::init(),
			'geetestv4'         => GeeTestCaptchaV4::init(),
			'hcaptcha'          => HCaptcha::init(),
			'googlerecaptchav2' => GoogleRecaptchaV2::init(),
			'googlerecaptchav3' => GoogleRecaptchaV3::init(),
		);
		$filtered_captchas = $this->filter_captchas_availability( $captchas );
		// $filtered_captchas = $filtered_captchas[0];
		return apply_filters( self::$plugin_info['name'] . '-captchas', $filtered_captchas );
	}

	/**
	 * Get Captchas Keys.
	 *
	 * @return array
	 */
	public function get_captchas_keys() {
		return array_keys( $this->_get_captchas() );
	}

	/**
	 * Captchas Keys - Names.
	 *
	 * @return array
	 */
	public function captchas_mapper( $exclude = array() ) {
		$captchas = array(
			'geetestv3'         => esc_html__( 'GeeTest V3' ),
			'geetestv4'         => esc_html__( 'GeeTest V4' ),
			'hcaptcha'          => esc_html__( 'HCaptcha' ),
			'googlerecaptchav2' => esc_html__( 'Google reCaptcha V2' ),
			'googlerecaptchav3' => esc_html__( 'Google reCaptcha V3' ),
		);

		return array_diff_key( $captchas, array_flip( $exclude ) );
	}

	/**
	 * Set Assets.
	 *
	 * @return void
	 */
	protected function set_assets() {
	}

	/**
	 * Get Failed Verification Notice.
	 *
	 * @return string
	 */
	public function get_failed_notice() {
		return $this->get_settings( 'failed_notice' );
	}

	/**
	 * Conflict Notice.
	 *
	 * @return void
	 */
	public function conflict_notice() {
		?>
		<div class="d-flex alert alert-warning" role="alert">
			<ul>
				<li><h6 class="text-small text-muted"><?php esc_html_e( '- Make sure to set the website domain correctly in the captchas accounts.', 'advanced-captcha-hub' ); ?></h6></li>
				<li><h6 class="text-small text-muted"><?php esc_html_e( '- hCatpcha was made to replace google recaptcha, so both can\'t be used together in the same form due to conflicts between both.', 'advanced-captcha-hub' ); ?></h6></li>
			</ul>
		</div>
		<?php
	}
}
