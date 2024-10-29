<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Base;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\GeneralUtilsTrait;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\CaptchasUtilsTrait;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\MainSettings;
use GPLSCore\GPLS_PLUGIN_WADVCPA\CaptchaSelector;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Shortcodes\CaptchasShortcode;

/**
 * Free Captcha Handler Test Class.
 */
final class CaptchaHandlerTest extends Base {
	use GeneralUtilsTrait, CaptchasUtilsTrait;

	/**
	 * Instance.
	 *
	 * @var self
	 */
	private static $instance = null;

	/**
	 * Captcha Settings.
	 *
	 * @var MainSettings
	 */
	private $verifier;

	/**
	 * Captcha Selector
	 *
	 * @var CaptchaSelector
	 */
	private $selector;

	/**
	 * Captchas Settings
	 *
	 * @var MainSettings
	 */
	protected $settings;

	/**
	 * Captchas Shortcode.
	 *
	 * @var CaptchasShortcode
	 */
	protected $captchas_shortcode;

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
		$this->captchas_shortcode = CaptchasShortcode::init();
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

		add_action( 'init', array( $this, 'test_form_shortcode' ) );
		add_action( 'wp_loaded', array( $this, 'test_form_validation' ) );

	}

	public function test_form_shortcode() {
		add_shortcode(
			self::$plugin_info['prefix_under'] . '_capatchas_form_test',
			array( $this, 'shortcode_callback' )
		);
	}

	public function shortcode_callback( $attrs ) {
		?>
	<form >
		<input type="email" name="email" value="" placeholder="<?php echo esc_attr( 'Your email address' ); ?>" >
		<?php
		$this->captchas_shortcode->do_shortcode(
			array(
				'captchas'   => 'geetestv3,geetestv4,hcaptcha',
				'is_random'  => 'yes',
				'random_num' => 2,
			),
			true
		);
		?>
		<input type="submit" value="Submit">
	</form>
		<?php
	}

	public function test_form_validation() {
		if ( ! empty( $_REQUEST['email'] ) ) {
			$result = apply_filters(
				self::$plugin_info['prefix'] . '-verify-captchas',
				true,
				array(
					'geetestv3',
					'geetestv4',
					'hcaptcha',
				),
				true,
				2
			);

			if ( $result ) {
				echo 'Captcha Validation passed';
			} else {
				echo 'captcha validation failed';
			}
		}
	}
}
