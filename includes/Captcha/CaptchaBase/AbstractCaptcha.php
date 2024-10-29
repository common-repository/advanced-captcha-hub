<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\CaptchaBase;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Base;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\CaptchaBase\CaptchaInterface;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\MainSettings;

/**
 * Captcha interface.
 *
 * @property string $id
 */
abstract class AbstractCaptcha extends Base implements CaptchaInterface {

	/**
	 * Captcha ID.
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * Assets Keys.
	 *
	 * @var array
	 */
	protected $assets_keys = array();

	/**
	 * MainSettings
	 *
	 * @var MainSettings
	 */
	protected $settings;

	/**
	 * Unique Identifier.
	 *
	 * @var string
	 */
	protected $identifier = '';

	/**
	 * Form Key.
	 *
	 * @var string
	 */
	protected $form_key = '';

	/**
	 * Compact Forms.
	 *
	 * @var array
	 */
	private $compact_forms = array( 'wp_login', 'wp_register', 'wp_lost_pass' );

	/**
	 * Assets served?.
	 *
	 * @var boolean
	 */
	private $assets_done = false;

	/**
	 * Is captcha Printed.
	 *
	 * @var boolean
	 */
	protected $captcha_printed = false;

	/**
	 * Captcha Key.
	 *
	 * @var string
	 */
	protected $key;

	/**
	 * Get Captcha ID.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Get Captcha Key.
	 *
	 * @return string
	 */
	public function get_key() {
		return $this->key;
	}

	/**
	 * Compact Attribute.
	 *
	 * @param string $form_key
	 * @return void
	 */
	protected function compact_attr( $form_key ) {
		if ( in_array( $form_key, $this->compact_forms ) ) {
			echo esc_attr( 'data-size' ) . '="' . esc_attr( 'compact' ) . '"';
		}
	}

	/**
	 * Compact Forms Styles
	 *
	 * @param string $form_key
	 * @return void
	 */
	protected function compact_styles( $form_key ) {
		if ( in_array( $form_key, $this->compact_forms ) ) {
			echo esc_attr( 'style' ) . '="' . esc_attr( 'display:flex;justify-content:center;' ) . '"';
		}
	}

	/**
	 * Singular Init.
	 *
	 * @return self
	 */
	public static function init() {
		if ( is_null( static::$instance ) ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Constructor.
	 */
	protected function __construct() {
		$this->settings = MainSettings::init();
		$this->set_id();
		$this->set_identifier();

		if ( method_exists( $this, 'setup' ) ) {
			$this->setup();
		}

		if ( method_exists( $this, 'hooks' ) ) {
			$this->hooks();
		}
	}

	/**
	 * Get Form Key.
	 *
	 * @return string
	 */
	public function get_form_key() {
		return $this->form_key;
	}

	/**
	 * Set Form Key.
	 *
	 * @param string $form_key
	 * @return void
	 */
	public function set_form_key( $form_key ) {
		$this->form_key = $form_key;
	}

	/**
	 * Get Captcha Verficiation HTML ID.
	 *
	 * @return string
	 */
	protected function generate_identifier() {
		return wp_generate_password( 12, false, false );
	}

	/**
	 * Set Captcha Unique ID.
	 *
	 * @return void
	 */
	abstract protected function set_id();

	/**
	 * Set Captcha Key.
	 *
	 * @return void
	 */
	abstract protected function set_key();

	/**
	 * Get Assets Keys.
	 *
	 * @return array
	 */
	public function get_assets_handles() {
		return array_column( $this->get_assets(), 'handle' );
	}

	/**
	 * Get Captcha Localize.
	 *
	 * @return array
	 */
	public function get_captcha_localize() {
		return array();
	}

	/**
	 * Set Identifier.
	 *
	 * @return void
	 */
	private function set_identifier() {
		$this->identifier = $this->generate_identifier();
	}

	/**
	 * Get Identifier.
	 *
	 * @return string
	 */
	protected function get_identifier() {
		return $this->identifier;
	}

	/**
	 * Get HTML ID.
	 *
	 * @return string
	 */
	protected function get_html_id() {
		return $this->id . '-' . $this->identifier;
	}


	/**
	 * Captcha HTML.
	 *
	 * @return void
	 */
	public function print_captcha_html( $form_key ) {
		?>
		<div class="<?php echo esc_attr( self::$plugin_info['prefix'] . '-captcha-container-' . $this->generate_identifier() ); ?>" style="margin: 10px;" >
			<?php $this->captcha_html( $this->get_html_id(), $form_key ); ?>
			<?php $this->trigger_captcha(); ?>
		</div>
		<?php
		$this->register_inline_js( $form_key );
	}

	/**
	 * Trigger Captcha is added.
	 *
	 * @return void
	 */
	private function trigger_captcha() {
		$this->captcha_printed = true;
	}

	/**
	 * Register Captcha inline js.
	 *
	 * @param string $form_key
	 * @return void
	 */
	private function register_inline_js( $form_key ) {
		$this->set_form_key( $form_key );
	}

	/**
	 * Captchas Assets.
	 *
	 * @return void
	 */
	public function captcha_assets() {
		if ( $this->assets_done ) {
			return;
		}
		$assets = $this->get_assets();
		foreach ( $assets as $asset ) {
			if ( 'js' === $asset['type'] ) {
				?>
				<script async handle="<?php echo esc_attr( $asset['handle'] ); ?>" src="<?php echo esc_url( $asset['url'] ); ?>"></script>
				<?php
			} else {
				?>
				<style rel="preload" handle="<?php echo esc_attr( $asset['handle'] ); ?>" src="<?php echo esc_url( $asset['url'] ); ?>"></style>
				<?php
			}
		}

		$this->assets_done = true;
	}

	/**
	 * Get Captcha Submitted Keys.
	 *
	 * @return array
	 */
	abstract protected function get_captcha_submitted_keys();

	/**
	 * Pypass Submitted.
	 *
	 * @return array|false
	 */
	public function pypass_submitted() {
		$posted_data = array();
		foreach ( $this->get_captcha_submitted_keys() as $key ) {
			$posted_data[ $key ] = ! empty( $_REQUEST[ $key ] ) ? sanitize_text_field( wp_unslash( $_REQUEST[ $key ] ) ) : '';
			if ( empty( $posted_data[ $key ] ) ) {
				return false;
			}
		}
		return $posted_data;
	}

}
