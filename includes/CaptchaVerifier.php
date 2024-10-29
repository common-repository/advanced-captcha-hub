<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\CaptchaSelector;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\CaptchasUtilsTrait;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\MainSettings;

/**
 * Captcha Verifier Class.
 */
final class CaptchaVerifier extends Base {
	use CaptchasUtilsTrait;

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
	 * Diff between Woo and WP Login Forms.
	 *
	 * @var boolean
	 */
	private $is_already_woo_login = false;

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
		$this->captchas_selector = CaptchaSelector::init();
		$this->settings          = MainSettings::init();
	}

	/**
	 * Hooks.
	 *
	 * @return void
	 */
	private function hooks() {
		add_action( 'woocommerce_checkout_process', array( $this, 'verify_checkout_captchas' ) );
		add_filter( 'preprocess_comment', array( $this, 'verify_comments_captchas' ), 100, 1 );
		add_filter( 'woocommerce_process_login_errors', array( $this, 'verify_woo_login' ), PHP_INT_MAX, 1 );
		add_filter( 'woocommerce_process_registration_errors', array( $this, 'verify_woo_register' ), PHP_INT_MAX, 1 );
		add_action( 'lostpassword_post', array( $this, 'verify_woo_lost_pass' ), PHP_INT_MAX, 1 );
		add_filter( 'wp_authenticate_user', array( $this, 'verify_wp_login' ), PHP_INT_MAX, 1 );
		add_filter( 'registration_errors', array( $this, 'verify_wp_register' ), PHP_INT_MAX, 1 );
		add_filter( 'lostpassword_errors', array( $this, 'verify_wp_lost_pass' ), PHP_INT_MAX, 1 );
	}


	/**
	 * Verify Woo Checkout Form Captchas.
	 *
	 * @return void
	 */
	public function verify_checkout_captchas() {
		$result = $this->verify_captchas( 'woo_checkout' );
		if ( ! $result ) {
			wc_add_notice( $this->settings->get_failed_notice(), 'error' );
		}
	}

	/**
	 * Verify Woo Login
	 *
	 * @param \WP_Error $validation_error
	 * @param string    $user_login
	 * @param string    $user_pass
	 * @return \WP_Error
	 */
	public function verify_woo_login( $validation_error ) {
		// Check bypass.
		$bypass_token = $this->settings->get_settings( 'login_forms_bypass' );
		if ( ! empty( $bypass_token ) && ! empty( $_REQUEST[ self::$plugin_info['prefix'] . '-bypass' ] ) ) {
			$submitted_bypass_token = sanitize_text_field( wp_unslash( $_REQUEST[ self::$plugin_info['prefix'] . '-bypass' ] ) );
			if ( $submitted_bypass_token === $bypass_token ) {
				return $validation_error;
			}
		}
		$this->is_already_woo_login = true;
		$result                     = $this->verify_captchas( 'woo_login' );
		if ( ! $result ) {
			$validation_error->add(
				401,
				$this->settings->get_failed_notice()
			);
		}

		return $validation_error;
	}

	/**
	 * Verify Woo Register
	 *
	 * @param \WP_Error $validation_error
	 * @param string    $user_login
	 * @param string    $user_pass
	 * @return \WP_Error
	 */
	public function verify_woo_register( $validation_error ) {
		$result = $this->verify_captchas( 'woo_register' );
		if ( ! $result ) {
			$validation_error->add(
				401,
				$this->settings->get_failed_notice()
			);
		}

		return $validation_error;
	}

	/**
	 * Verify Comments Forms Captchas.
	 *
	 * @return array
	 */
	public function verify_comments_captchas( $comment_data ) {
		$result = $this->verify_captchas( 'comments' );
		if ( ! $result ) {
			wp_die(
				'<p>' . esc_html( $this->settings->get_failed_notice() ) . '</p>',
				esc_html__( 'Comment Submission Failure' ),
				array(
					'back_link' => true,
				)
			);
		}

		return $comment_data;
	}

	/**
	 * Verify WP Login Form Captcha.
	 *
	 * @param \WP_User $user
	 * @return \WP_User|\WP_Error
	 */
	public function verify_wp_login( $user ) {
		// Check bypass.
		$bypass_token = $this->settings->get_settings( 'login_forms_bypass' );
		if ( ! empty( $bypass_token ) && ! empty( $_REQUEST[ self::$plugin_info['prefix'] . '-bypass' ] ) ) {
			$submitted_bypass_token = sanitize_text_field( wp_unslash( $_REQUEST[ self::$plugin_info['prefix'] . '-bypass' ] ) );
			if ( $submitted_bypass_token === $bypass_token ) {
				return $user;
			}
		}
		if ( $this->is_already_woo_login ) {
			return $user;
		}
		$result = $this->verify_captchas( 'wp_login' );
		if ( ! $result ) {
			$user = new \WP_Error(
				401,
				$this->settings->get_failed_notice()
			);
		}
		return $user;
	}

	/**
	 * Verify WP Register Form Captcha.
	 *
	 * @param \WP_Error $errors
	 * @return \WP_Error
	 */
	public function verify_wp_register( $errors ) {
		$result = $this->verify_captchas( 'wp_register' );
		if ( ! $result ) {
			$errors->add(
				401,
				$this->settings->get_failed_notice()
			);
		}
		return $errors;
	}

	/**
	 * Verify Woo Lost Password for Cpatchas.
	 *
	 * @param \WP_Error $errors
	 * @return void
	 */
	public function verify_woo_lost_pass( $errors ) {
		$nonce_value = ! empty( $_REQUEST['woocommerce-lost-password-nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['woocommerce-lost-password-nonce'] ) ) : '';
		if ( empty( $nonce_value ) || ! wp_verify_nonce( $nonce_value, 'lost_password' ) ) {
			return;
		}
		$result = $this->verify_captchas( 'woo_lost_pass' );
		if ( ! $result ) {
			$errors->add(
				401,
				$this->settings->get_failed_notice()
			);
		}
	}

	/**
	 * Verify WP Register Form Captcha.
	 *
	 * @param \WP_Error $errors
	 * @return \WP_Error
	 */
	public function verify_wp_lost_pass( $errors ) {
		if ( ! is_login() ) {
			return $errors;
		}
		$result = $this->verify_captchas( 'wp_lost_pass' );
		if ( ! $result ) {
			$errors->add(
				401,
				$this->settings->get_failed_notice()
			);
		}
		return $errors;
	}

	/**
	 * Verify Captchas.
	 *
	 * @param string $form_key
	 *
	 * @return boolean
	 */
	private function verify_captchas( $form_key ) {
		if ( ! $this->is_form_enabled( $form_key ) ) {
			return true;
		}

		// 1) Get form Captchas.
		$captchas_keys = $this->get_form_captchas( $form_key );
		if ( empty( $captchas_keys ) ) {
			return true;
		}
		$captchas = $this->get_captchas_by_keys( $captchas_keys );
		$captchas = $this->filter_captchas_availability( $captchas );
		if ( empty( $captchas ) ) {
			return true;
		}

		// 2) Check the form captchas select type.
		$form_captchas_select_type = $this->get_form_captcha_select_type( $form_key );

		foreach ( $captchas as $captcha ) {
			$result = $captcha->verify_captcha();
			if ( ! $result ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Get Submitted Captchas.
	 *
	 * @return array
	 */
	public function get_submitted_captchas( $captchas ) {
		$submitted_captchas = array();
		foreach ( $captchas as $captcha ) {
			if ( $captcha->pypass_submitted() ) {
				$submitted_captchas[] = $captcha;
			}
		}
		return $submitted_captchas;
	}
}
