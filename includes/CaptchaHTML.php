<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Base;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\GeneralUtilsTrait;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\CaptchasUtilsTrait;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\MainSettings;
use GPLSCore\GPLS_PLUGIN_WADVCPA\CaptchaSelector;

/**
 * Captcha HTML Class.
 */
final class CaptchaHTML extends Base {
	use GeneralUtilsTrait, CaptchasUtilsTrait;

	/**
	 * Instance.
	 *
	 * @var self
	 */
	private static $instance = null;

	/**
	 * Main Settings.
	 *
	 * @var MainSettings
	 */
	private $settings;

	/**
	 * CaptchaSelector
	 *
	 * @var CaptchaSelector
	 */
	private $captchas_selector;

	/**
	 * Current Captchas.
	 *
	 * @var array
	 */
	private $current_captchas = array();

	/**
	 * Singular Init.
	 *
	 * @return self
	 */
	public static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->setup();
		$this->hooks();
	}

	/**
	 * Setup.
	 *
	 * @return void
	 */
	private function setup() {
		$this->settings          = MainSettings::init();
		$this->captchas_selector = CaptchaSelector::init();
	}

	/**
	 * Hooks.
	 *
	 * @return void
	 */
	private function hooks() {
		if ( is_admin() ) {
			return;
		}
		add_action( 'woocommerce_review_order_before_payment', array( $this, 'captcha_woo_checkout' ) );
		add_action( 'woocommerce_login_form', array( $this, 'captcha_woo_login' ) );
		add_action( 'woocommerce_register_form', array( $this, 'captcha_woo_register' ) );
		add_filter( 'comment_form_submit_field', array( $this, 'captcha_comments_form' ), PHP_INT_MAX, 2 );
		add_action( 'woocommerce_lostpassword_form', array( $this, 'captcha_woo_lost_pass_form' ) );
		add_action( 'login_form', array( $this, 'captcha_wp_login_form' ) );
		add_action( 'register_form', array( $this, 'captcha_wp_register_form' ) );
		add_action( 'lostpassword_form', array( $this, 'captcha_wp_lost_pass_form' ) );
		add_action( 'wp_print_footer_scripts', array( $this, 'front_assets' ), 1 );
	}

	/**
	 * Front Assets.
	 *
	 * @return void
	 */
	public function front_assets() {
		wp_enqueue_script( self::$plugin_info['prefix'] . '-front-actions', self::$plugin_info['url'] . 'assets/dist/js/front/actions.min.js', array( 'jquery' ), self::$plugin_info['version'], true );
		$localize_data = apply_filters(
			self::$plugin_info['prefix'] . '-localize-data',
			array(
				'prefix'       => self::$plugin_info['prefix'],
				'prefix_under' => str_replace( '-', '_', self::$plugin_info['prefix'] ),
				'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
				'captchas'     => array(),
				'WooAddToCart' => $this->is_form_enabled( 'woo_add_to_cart' ),
			)
		);
		wp_localize_script(
			self::$plugin_info['prefix'] . '-front-actions',
			str_replace( '-', '_', self::$plugin_info['prefix'] . '-localize-data' ),
			$localize_data
		);
	}

	/**
	 * Form Captcha HTML.
	 *
	 * @param string $form_key
	 * @return void
	 */
	private function form_captcha( $form_key ) {
		if ( ! $this->is_form_enabled( $form_key ) ) {
			return;
		}

		if ( ( in_array( $form_key, array( 'wp_login', 'woo_login' ) ) ) && ! empty( $_GET[ self::$plugin_info['prefix'] . '-bypass' ] ) ) {
			?>
			<input type="hidden" value="<?php echo esc_attr( wp_unslash( $_GET[ self::$plugin_info['prefix'] . '-bypass' ] ) ); ?>" name="<?php echo esc_attr( self::$plugin_info['prefix'] . '-bypass' ); ?>">
			<?php
		} else {
			$captchas = $this->captchas_selector->get_chosen_captchas( $form_key );
			foreach ( $captchas as $captcha ) {
				$captcha->print_captcha_html( $form_key );
				$captcha->captcha_assets();
			}
			$this->current_captchas = $captchas;
		}
	}

	/**
	 * Get Current Captchas.
	 *
	 * @return array
	 */
	public function get_current_captchas() {
		return $this->current_captchas;
	}

	/**
	 * Woo Checkout Form Captcha.
	 *
	 * @return void
	 */
	public function captcha_woo_checkout() {
		$this->form_captcha( 'woo_checkout' );
	}

	/**
	 * Captcha Woo Login Form.
	 *
	 * @return void
	 */
	public function captcha_woo_login() {
		$this->form_captcha( 'woo_login' );
	}

	/**
	 * Captcha Woo Regiter Form.
	 *
	 * @return void
	 */
	public function captcha_woo_register() {
		$this->form_captcha( 'woo_register' );
	}

	/**
	 * Captcha WP login Form.
	 *
	 * @return void
	 */
	public function captcha_wp_login_form() {
		$this->form_captcha( 'wp_login' );
	}

	/**
	 * Captcha WP Register Form.
	 *
	 * @return void
	 */
	public function captcha_wp_register_form() {
		$this->form_captcha( 'wp_register' );
	}

	/**
	 * Captcha Woo Lost Pass Form.
	 *
	 * @return void
	 */
	public function captcha_woo_lost_pass_form() {
		$this->form_captcha( 'woo_lost_pass' );
	}

	/**
	 * Captcha WP Lost Password Form.
	 *
	 * @return void
	 */
	public function captcha_wp_lost_pass_form() {
		$this->form_captcha( 'wp_lost_pass' );
	}

	/**
	 * Captcha Comments Forms.
	 *
	 * @return string
	 */
	public function captcha_comments_form( $submit_field, $args ) {
		ob_start();
		$this->form_captcha( 'comments' );
		$captcha      = ob_get_clean();
		$submit_field = $captcha . $submit_field;
		return $submit_field;
	}

}
