<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\CaptchaBase\AbstractCaptcha;

defined( 'ABSPATH' ) || exit;

/**
 * HCaptcha.
 */
final class HCaptcha extends AbstractCaptcha {

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
		$this->verify_url = 'https://hcaptcha.com/siteverify';
	}

	/**
	 * Set Captcha ID.
	 *
	 * @return void
	 */
	protected function set_id() {
		$this->id = self::$plugin_info['name'] . '-hcaptcha';
	}

	/**
	 * Set Captcha Key.
	 *
	 * @return void
	 */
	protected function set_key() {
		$this->key = 'hcaptcha';
	}

	/**
	 * Get Token Name.
	 *
	 * @return string
	 */
	public function get_token_name() {
		return 'h-captcha-response';
	}

	/**
	 * Get OnLoad Functino name.
	 *
	 * @return string
	 */
	private function on_load_func() {
		return str_replace( '-', '_', $this->id . '_on_load_' . $this->get_identifier() );
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
		$localize_data['captchas']['hcaptcha'] = array(
			'token'     => $this->get_token_name(),
			'load_func' => $this->on_load_func(),
			'html_id'   => $this->get_html_id(),
			'key'       => $this->get_captcha_site_key(),
		);
		return $localize_data;
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
				'handle'    => self::$plugin_info['name'] . '-' . $this->get_id(),
				'type'      => 'js',
				'url'       => 'https://js.hcaptcha.com/1/api.js?onload=' . $this->on_load_func() . '&render=explicit',
				'in_footer' => true,
			),
		);
	}

	/**
	 * Captcha HTML.
	 *
	 * @return void
	 */
	public function captcha_html( $html_id, $form_key ) {
		?>
		<div <?php $this->compact_attr( $form_key ); ?> data-sitekey="<?php echo esc_attr( $this->get_captcha_site_key() ); ?>" class="h-captcha <?php echo esc_attr( $html_id ); ?>" <?php $this->compact_styles( $form_key ); ?> ></div>
		<?php
	}

	/**
	 * Get Captcha Submitted Keys.
	 *
	 * @return array
	 */
	protected function get_captcha_submitted_keys() {
		return array( 'h-captcha-response' );
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
					'response' => $posted_data['h-captcha-response'],
					'sitekey'  => $this->get_captcha_site_key(),
				),
			)
		);
		$response_body = wp_remote_retrieve_body( $result );
		$obj           = json_decode( $response_body, true );
		if ( ! empty( $obj['success'] ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Is captcha ready.
	 *
	 * @return boolean
	 */
	public function is_ready() {
		return ( ! empty( $this->settings->get_settings( 'captchas_hcaptcha_sitekey' ) ) && ! empty( $this->settings->get_settings( 'captchas_hcaptcha_secretkey' ) ) );
	}

	/**
	 * Is Captcha Enabled.
	 *
	 * @return boolean
	 */
	public function is_enabled() {
		return ( 'on' === $this->settings->get_settings( 'captchas_hcaptcha_status' ) );
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
		return $this->settings->get_settings( 'captchas_hcaptcha_sitekey' );
	}

	/**
	 * Get Captcha secret Key
	 *
	 * @return string
	 */
	public function get_captcha_secret_key() {
		return $this->settings->get_settings( 'captchas_hcaptcha_secretkey' );
	}
}
