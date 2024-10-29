<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\CaptchaBase\AbstractCaptcha;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\NoticeUtilsTrait;


/**
 * GeeTest Captcha V3.
 */
final class GeeTestCaptchaV3 extends AbstractCaptcha {

	use NoticeUtilsTrait;

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
	 * Validate URL.
	 *
	 * @var string
	 */
	private $validate_url;

	/**
	 * Register URL.
	 *
	 * @var string
	 */
	private $register_url;

	/**
	 * Set Captcha ID.
	 *
	 * @return void
	 */
	protected function set_id() {
		$this->id = self::$plugin_info['name'] . '-geetest-v3';
	}

	/**
	 * Set Captcha Key.
	 *
	 * @return void
	 */
	protected function set_key() {
		$this->key = 'geetestv3';
	}

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setup() {
		$this->register_url = 'https://api.geetest.com/register.php';
		$this->validate_url = 'https://api.geetest.com/validate.php';
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
		$localize_data['captchas']['geetestv3'] = array(
			'seccode_key'   => 'geetest_seccode',
			'challenge_key' => 'geetest_challenge',
			'nonce'         => wp_create_nonce( $this->get_register_nonce_key() ),
			'action'        => $this->get_id() . '-' . self::$plugin_info['prefix'] . '-register',
			'html_id'       => $this->get_html_id(),
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
				'handle'    => $this->get_id(),
				'type'      => 'js',
				'url'       => self::$plugin_info['url'] . 'assets/libs/gt.0.4.9.js',
				'in_footer' => false,
			),
		);
	}

	/**
	 * Get Register Nonce key.
	 *
	 * @return string
	 */
	private function get_register_nonce_key() {
		return self::$plugin_info['prefix'] . '-nonce';
	}

	/**
	 * Captcha Hooks.
	 *
	 * @return void
	 */
	protected function hooks() {
		add_action( 'wp_ajax_nopriv_' . $this->get_id() . '-' . self::$plugin_info['prefix'] . '-register', array( $this, 'ajax_register_captcha' ) );
		add_action( 'wp_ajax_' . $this->get_id() . '-' . self::$plugin_info['prefix'] . '-register', array( $this, 'ajax_register_captcha' ) );
		add_filter( self::$plugin_info['prefix'] . '-localize-data', array( $this, 'localize_data' ), 100, 1 );
	}

	/**
	 * AJAX Register Captcha.
	 *
	 * @return void
	 */
	public function ajax_register_captcha() {
		if ( ! empty( $_REQUEST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ), $this->get_register_nonce_key() ) ) {
			$result = $this->server_register();
			if ( is_array( $result ) ) {
				self::ajax_response(
					'',
					'success',
					true,
					'register-captcha',
					$result
				);
			}

			self::ajax_error_response( '' );
		}

		self::expired_response();
	}

	/**
	 * Server Register.
	 *
	 * @return array|false
	 */
	private function server_register() {
		$url           = $this->register_url . '?';
		$params        = array(
			'gt'          => $this->get_captcha_id(),
			'new_captcha' => 1,
			'user_id'     => '',
			'client_type' => 'web',
			'ip_address'  => '',
		);
		$query         = http_build_query( $params );
		$result        = wp_remote_get(
			$url . $query,
			array(
				'timeout' => 5,
			)
		);
		$response_body = wp_remote_retrieve_body( $result );
		if ( ! empty( $response_body ) ) {
			return array(
				'success'     => 1,
				'gt'          => $this->get_captcha_id(),
				'challenge'   => md5( $response_body . $this->get_captcha_key() ),
				'new_captcha' => 1,
			);
		}

		return false;
	}

	/**
	 * Captcha HTML.
	 *
	 * @return void
	 */
	public function captcha_html( $html_id, $form_key ) {
		?>
		<div class="<?php echo esc_attr( $html_id ); ?>" <?php $this->compact_styles( $form_key ); ?> ></div>
		<?php
	}

	/**
	 * Get Captcha Submitted Keys.
	 *
	 * @return array
	 */
	protected function get_captcha_submitted_keys() {
		return array( 'geetest_challenge', 'geetest_validate', 'geetest_seccode' );
	}

	/**
	 * Verify Captcha.
	 *
	 * @return boolean
	 */
	public function verify_captcha() {
		$posted_data = $this->pypass_submitted();
		if ( ! $posted_data ) {
			return false;
		}

		$params = array(
			'user_id'     => '',
			'client_type' => 'web',
			'ip_address'  => '',
			'seccode'     => $posted_data['geetest_seccode'],
			'timestamp'   => time(),
			'challenge'   => $posted_data['geetest_challenge'],
			'captchaid'   => $this->get_captcha_id(),
			'json_format' => 1,
			'sdk'         => 'php_3.0.0',
		);
		$result = wp_remote_post(
			$this->validate_url,
			array(
				'timeout' => 5,
				'body'    => $params,
			)
		);

		$body = wp_remote_retrieve_body( $result );
		$obj  = json_decode( $body, true );

		if ( ! $obj || empty( $obj['seccode'] ) || ( md5( $posted_data['geetest_seccode'] ) !== $obj['seccode'] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Is captcha ready.
	 *
	 * @return boolean
	 */
	public function is_ready() {
		return ( ! empty( $this->settings->get_settings( 'captchas_geetestv3_captchaid' ) ) && ! empty( $this->settings->get_settings( 'captchas_geetestv3_captchakey' ) ) );
	}

	/**
	 * Is Captcha Enabled.
	 *
	 * @return boolean
	 */
	public function is_enabled() {
		return ( 'on' === $this->settings->get_settings( 'captchas_geetestv3_status' ) );
	}

	/**
	 * Get Captcha ID.
	 *
	 * @return string
	 */
	public function get_captcha_id() {
		return $this->settings->get_settings( 'captchas_geetestv3_captchaid' );
	}

	/**
	 * Get Captcha Key
	 *
	 * @return string
	 */
	public function get_captcha_key() {
		return $this->settings->get_settings( 'captchas_geetestv3_captchakey' );
	}
}
