<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\CaptchaBase\AbstractCaptcha;

defined( 'ABSPATH' ) || exit;

/**
 * GeeTest Captcha V4.
 */
final class GeeTestCaptchaV4 extends AbstractCaptcha {

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
	 * Set Captcha ID.
	 *
	 * @return void
	 */
	protected function set_id() {
		$this->id = self::$plugin_info['name'] . '-geetest-v4';
	}

	/**
	 * Set Captcha Key.
	 *
	 * @return void
	 */
	protected function set_key() {
		$this->key = 'geetestv4';
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
		$localize_data['captchas']['geetestv4'] = array(
			'html_id'        => $this->get_html_id(),
			'captcha_id'     => $this->get_captcha_id(),
			'lot_number'     => 'lot_number-' . $this->get_identifier(),
			'captcha_output' => 'captcha_output-' . $this->get_identifier(),
			'pass_token'     => 'pass_token-' . $this->get_identifier(),
			'gen_time'       => 'gen_time-' . $this->get_identifier(),
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
				'url'       => self::$plugin_info['url'] . 'assets/libs/gt4.js',
				'in_footer' => false,
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
		<div class="<?php echo esc_attr( $html_id ); ?>" <?php $this->compact_styles( $form_key ); ?> ></div>
		<style>#<?php echo esc_attr( $html_id ); ?> .geetest_panel { position: relative; display: block; opacity: 1; width: auto; height: auto; z-index: 999;}</style>
		<?php foreach ( $this->get_captcha_submitted_keys() as $prop ) : ?>
			<input type="hidden" name="<?php echo esc_attr( $prop ); ?>" class="<?php echo esc_attr( $prop . '-' . $this->get_identifier() ); ?>" value="">
			<?php
		endforeach;
	}

	/**
	 * Get Captcha Submitted Keys.
	 *
	 * @return array
	 */
	protected function get_captcha_submitted_keys() {
		return array(
			'lot_number',
			'captcha_output',
			'pass_token',
			'gen_time',
		);
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

		$sign_token                = hash_hmac( 'sha256', $posted_data['lot_number'], $this->get_captcha_key() );
		$posted_data['sign_token'] = $sign_token;
		$result                    = wp_remote_post(
			'https://gcaptcha4.geetest.com/validate?captcha_id=' . $this->get_captcha_id(),
			array(
				'timeout' => 5,
				'body'    => $posted_data,
			)
		);
		$response_body             = wp_remote_retrieve_body( $result );
		$obj                       = json_decode( $response_body, true );
		if ( ! empty( $obj['result'] ) && 'success' === $obj['result'] ) {
			if ( ! empty( $obj['captcha_args'] ) && ! empty( $obj['captcha_args']['referer'] ) ) {
				$home_url = parse_url( home_url() );
				$referer  = parse_url( $obj['captcha_args']['referer'] );
				if ( $home_url['host'] === $referer['host'] ) {
					return true;
				}
				return false;
			}
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
		return ( ! empty( $this->settings->get_settings( 'captchas_geetestv4_captchaid' ) ) && ! empty( $this->settings->get_settings( 'captchas_geetestv4_captchakey' ) ) );
	}

	/**
	 * Is Captcha Enabled.
	 *
	 * @return boolean
	 */
	public function is_enabled() {
		return ( 'on' === $this->settings->get_settings( 'captchas_geetestv4_status' ) );
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
	 * Get Captcha ID.
	 *
	 * @return string
	 */
	public function get_captcha_id() {
		return $this->settings->get_settings( 'captchas_geetestv4_captchaid' );
	}

	/**
	 * Get Captcha Key
	 *
	 * @return string
	 */
	public function get_captcha_key() {
		return $this->settings->get_settings( 'captchas_geetestv4_captchakey' );
	}
}
