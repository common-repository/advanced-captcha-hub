<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\CaptchaBase\AbstractCaptcha;

/**
 * GoogleRecaptchaV3.
 */
final class GoogleRecaptchaV3 extends AbstractCaptcha {

	/**
	 * Singular Instance.
	 *
	 * @var self
	 */
	protected static $instance = null;

	/**
	 * Captcha ID.
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * HTML ID.
	 *
	 * @var string
	 */
	protected $html_id;

	/**
	 * Verify URL.
	 *
	 * @var string
	 */
	private $verify_url;

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setup() {
		$this->verify_url = 'https://www.google.com/recaptcha/api/siteverify';
	}

	/**
	 * Set Captcha ID.
	 *
	 * @return void
	 */
	protected function set_id() {
		$this->id = self::$plugin_info['name'] . '-google-recaptchav3';
	}

	/**
	 * Set Captcha Key.
	 *
	 * @return void
	 */
	protected function set_key() {
		$this->key = 'googlerecaptchav3';
	}

	/**
	 * Get OnLoad Function name.
	 *
	 * @return string
	 */
	private function on_load_func() {
		return str_replace( '-', '_', $this->id . '_on_load_' . $this->get_identifier() );
	}

	/**
	 * Get Callback Function name.
	 *
	 * @return string
	 */
	private function callback_func() {
		return str_replace( '-', '_', $this->id . '_callback_' . $this->get_identifier() );
	}

	/**
	 * Get Assets.
	 *
	 * @return array
	 */
	public function get_assets() {
		if ( ! $this->captcha_printed ) {
			return array();
		}
		return array(
			array(
				'handle'    => self::$plugin_info['name'] . '-google-recaptcha',
				'type'      => 'js',
				'url'       => 'https://www.google.com/recaptcha/api.js?render=explicit&onload=' . $this->on_load_func(),
				'in_footer' => false,
			),
		);
	}

	/**
	 * Get Loaded Function name.
	 *
	 * @return string
	 */
	public function get_on_submit_func() {
		return str_replace( '-', '_', $this->id );
	}

	/**
	 * Captcha HTML.
	 *
	 * @return void
	 */
	public function captcha_html( $html_id, $form_key ) {
		?>
		<div id="<?php echo esc_attr( $this->get_id() . '-' . $this->generate_identifier() ); ?>" class="<?php echo esc_attr( $html_id ); ?>" data-sitekey="<?php echo esc_attr( $this->get_captcha_site_key() ); ?>" data-callback="<?php echo esc_attr( $this->callback_func() ); ?>" data-size="invisible" ></div>
		<?php
	}

	/**
	 * Get Token Input field.
	 *
	 * @return string
	 */
	public function get_token_name() {
		return $this->get_id() . '-token';
	}

	/**
	 * Hooks.
	 *
	 * @return void
	 */
	protected function hooks() {
		add_filter( self::$plugin_info['prefix'] . '-localize-data', array( $this, 'localize_data' ), 100, 1 );
	}

	/**
	 * Localize Data.
	 *
	 * @param array $localize_data
	 * @return array
	 */
	public function localize_data( $localize_data ) {
		if ( ! $this->captcha_printed ) {
			return $localize_data;
		}
		$localize_data['captchas']['googlerecaptchav3'] = array(
			'token'     => $this->get_token_name(),
			'load_func' => $this->on_load_func(),
			'html_id'   => $this->get_html_id(),
			'key'       => $this->get_captcha_site_key(),
		);
		return $localize_data;
	}

	 /**
	  * Get Captcha Submitted Keys.
	  *
	  * @return array
	  */
	protected function get_captcha_submitted_keys() {
		return array( $this->get_token_name() );
	}

	/**
	 * Captcha Verification.
	 *
	 * @return boolean
	 */
	public function verify_captcha() {
		$posted_data = $this->pypass_submitted();
		if ( ! $posted_data ) {
			return false;
		}
		$result        = wp_remote_post(
			$this->verify_url,
			array(
				'timeout' => 5,
				'body'    => array(
					'secret'   => $this->get_captcha_secret_key(),
					'response' => $posted_data[ $this->get_token_name() ],
				),
			)
		);
		$response_body = wp_remote_retrieve_body( $result );
		$obj           = json_decode( $response_body, true );
		if ( ! empty( $obj['success'] ) ) {
			if ( ! empty( $obj['score'] ) && $this->get_minimum_score_threshold() < (float) $obj['score'] ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Is captcha ready.
	 *
	 * @return boolean
	 */
	public function is_ready() {
		return ( ! empty( $this->settings->get_settings( 'captchas_googlerecaptchav3_sitekey' ) ) && ! empty( $this->settings->get_settings( 'captchas_googlerecaptchav3_privatekey' ) ) );
	}

	/**
	 * Is Captcha Enabled.
	 *
	 * @return boolean
	 */
	public function is_enabled() {
		return ( 'on' === $this->settings->get_settings( 'captchas_googlerecaptchav3_status' ) );
	}

	/**
	 * Get minimum score threshold
	 *
	 * @return float|int
	 */
	public function get_minimum_score_threshold() {
		return (float) $this->settings->get_settings( 'captchas_googlerecaptchav3_score_threshold' );
	}

	/**
	 * Get Captcha Localize vars.
	 *
	 * @return array
	 */
	public function get_captcha_localize() {
		return array();
	}

	/**
	 * Get Captcha Key
	 *
	 * @return string
	 */
	public function get_captcha_site_key() {
		return $this->settings->get_settings( 'captchas_googlerecaptchav3_sitekey' );
	}

	/**
	 * Get Captcha secret Key
	 *
	 * @return string
	 */
	public function get_captcha_secret_key() {
		return $this->settings->get_settings( 'captchas_googlerecaptchav3_privatekey' );
	}
}
