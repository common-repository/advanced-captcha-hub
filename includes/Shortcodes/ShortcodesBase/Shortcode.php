<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Shortcodes\ShortcodesBase;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\GeneralUtilsTrait;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Base;

/**
 * Shortcode Class.
 */
abstract class Shortcode extends Base {

	use GeneralUtilsTrait;

	/**
	 * Include HTML wrapper or not.
	 *
	 * @var boolean
	 */
	protected $include_wrapper = false;

	/**
	 * Wrapper Additional Classes.
	 *
	 * @var string
	 */
	protected $wrapper_classes = '';

	/**
	 * Shortcode Attributes.
	 *
	 * @var array
	 */
	protected $shortcode_attributes = array();

	/**
	 * Shortcode Required Attributes.
	 *
	 * @var array
	 */
	protected $required_shortcode_attributes = array();

	/**
	 * Shortcode Title.
	 *
	 * @var string
	 */
	protected $shortcode_title = '';

	/**
	 * Shortcode subtitle.
	 *
	 * @var string
	 */
	protected $shortcode_subtitle = '';

	/**
	 * Admin Page Constructor.
	 */
	protected function __construct() {
		$this->base_setup();
		$this->base_hooks();
	}

	/**
	 * Initialize Page.
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
	 * Setup
	 *
	 * @return void
	 */
	private function base_setup() {
		if ( method_exists( $this, 'setup' ) ) {
			$this->setup();
		}
	}

	/**
	 * Get Global Flag.
	 *
	 * @return string
	 */
	public static function get_global_flag() {
		return static::get_shortcode_name() . '-global-shortcode-trigger';
	}

	/**
	 * Get Inside Flag.
	 *
	 * @return string
	 */
	public static function get_inside_flag() {
		return static::get_shortcode_name() . '-inside-shortcode-trigger';
	}

	 /**
	  * Hooks.
	  *
	  * @return void
	  */
	private function base_hooks() {
		add_action( 'init', array( $this, 'setup_shortcode' ) );

		if ( method_exists( $this, 'hooks' ) ) {
			$this->hooks();
		}
	}

	/**
	 * Setup Shortcode.
	 *
	 * @return void
	 */
	public function setup_shortcode() {
		add_shortcode( static::get_shortcode_name(), array( $this, 'shortcode_callback' ) );
	}

	/**
	 * Get Shortcode.
	 *
	 * @param array $attrs
	 * @return string
	 */
	public function get_shortcode( $attrs = array() ) {
		return '[' . $this->get_shortcode_name() . ' ' . $this->custom_attributes_html( $attrs ) . ' ]';
	}

	/**
	 * Do Shortcode.
	 *
	 * @param array $attrs
	 * @return void
	 */
	public function do_shortcode( $attrs, $includes_inputs = false ) {
		$attrs = $this->handle_shortcode_attrs( $attrs );

		if ( false === $attrs ) {
			return;
		}
		if ( $includes_inputs ) {
			echo do_shortcode( $this->get_shortcode( $attrs ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			echo wp_kses_post( do_shortcode( $this->get_shortcode( $attrs ) ) );
		}
	}

	/**
	 * Get Custom Attributes HTML.
	 *
	 * @return string
	 */
	protected function custom_attributes_html( $attrs = array() ) {
		$attributes = '';
		foreach ( $attrs as $key => $value ) {
			$attributes .= esc_attr( $key ) . '="' . esc_attr( $value ) . '" ';
		}
		return $attributes;
	}

	/**
	 * Set Shortcode name.
	 *
	 * @return string
	 */
	abstract public static function get_shortcode_name();

	/**
	 * Shortcode Callback.
	 *
	 * @return void
	 */
	abstract protected function _shortcode_callback( $attrs, $content );

	/**
	 * Shortcode Callback Wrapper.
	 *
	 * @return string
	 */
	public function shortcode_callback( $attrs, $content, $shortcode_tag ) {
		$attrs = (array) $attrs;
		$attrs = $this->handle_shortcode_attrs( $attrs );

		if ( false === $attrs ) {
			return '';
		}

		$this->_shortcode_start();

		ob_start();

		// Shortcode Start.
		$this->shortcode_wrapper_start();

		// Shortcode Content.
		$this->_shortcode_callback( $attrs, $content );

		// Shortcode End.
		$this->shortcode_wrapper_end();

		$result = ob_get_clean();

		$this->_shortcode_end();

		return $result;
	}

	/**
	 * Prepare Shortcode Attributes - Sanitize - Check Required attrs.
	 *
	 * @param array $attrs
	 * @return array|false
	 */
	private function handle_shortcode_attrs( $attrs = array() ) {
		$filtered_attrs = array();
		foreach ( $attrs as $key => $value ) {
			$key   = sanitize_text_field( wp_unslash( $key ) );
			$value = sanitize_text_field( wp_unslash( $value ) );
			$filtered_attrs[ $key ] = $value;
		}

		if ( ! empty( $this->required_shortcode_attributes ) && ( count( array_intersect( $this->required_shortcode_attributes, array_keys( $filtered_attrs ) ) ) !== count( $this->required_shortcode_attributes ) ) ) {
			return false;
		}

		$attrs = shortcode_atts( $this->get_attrs_defaults(), $attrs, $this->get_shortcode_name() );

		return $attrs;
	}

	/**
	 * Get Attributes and their defautls pair.
	 *
	 * @return array
	 */
	private function get_attrs_defaults() {
		$default_attrs = array();
		foreach ( $this->shortcode_attributes as $attr_arr ) {
			if ( isset( $attr_arr['default_val'] ) ) {
				$default_attrs[ $attr_arr['name'] ] = $attr_arr['default_val'];
			}
		}

		return $default_attrs;
	}

	/**
	 * Shortcode Wrapper Start.
	 *
	 * @return void
	 */
	private function shortcode_wrapper_start() {
		if ( $this->include_wrapper ) :
			?><div class="<?php echo esc_attr( str_replace( '_', '-', static::get_shortcode_name() . ' ' . $this->wrapper_classes ) ); ?>">
			<?php
		endif;
	}

	/**
	 * Shortcode Wrapper End.
	 *
	 * @return void
	 */
	private function shortcode_wrapper_end() {
		if ( $this->include_wrapper ) :
			?>
			</div>
			<?php
		endif;
	}

	/**
	 * Before Shortcode Content.
	 *
	 * @return void
	 */
	private function _shortcode_start() {
		$GLOBALS[ self::get_inside_flag() ] = true;
		$GLOBALS[ self::get_global_flag() ] = true;

		if ( method_exists( $this, 'shortcode_start' ) ) {
			$this->shortcode_start();
		}
	}

	/**
	 * After Shortcode Content.
	 *
	 * @return void
	 */
	private function _shortcode_end() {
		unset( $GLOBALS[ self::get_inside_flag() ] );

		if ( method_exists( $this, 'shortcode_end' ) ) {
			$this->shortcode_end();
		}
	}

	/**
	 * Check if current page has the shortcode.
	 *
	 * @return boolean
	 */
	public static function has_shortcode() {
		return ! empty( $GLOBALS[ self::get_global_flag() ] );
	}

	/**
	 * Check if inside the shortcode.
	 *
	 * @return boolean
	 */
	public static function is_in_shortcode() {
		return ! empty( $GLOBALS[ self::get_inside_flag() ] );
	}

	/**
	 * Print Shortcode HTML and attributes details.
	 *
	 * @return void
	 */
	public function print_shortcode_details( $attrs = array() ) {
		?>
		<div class="shortcode-item my-4">
			<?php if ( ! empty( $this->shortcode_title ) ) : ?>
				<div class="shortcode-title">
					<h4 class="m-0 p-3 bg-light"><?php wp_kses_post( $this->shortcode_title ); ?></h4>
					<?php if ( ! empty( $this->shortcode_subtitle ) ) : ?>
					<span class="ps-3"><?php echo wp_kses_post( $this->shortcode_subtitle ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<div class="shortcode-text py-3 d-flex align-items-center justify-content-center">
				<code class="<?php echo esc_attr( str_replace( '_', '-', static::get_shortcode_name() ) . '-shortcode' ); ?>"><?php echo esc_html( '[' . static::get_shortcode_name() . ' ' . $this->custom_attributes_html( $attrs ) . ' ]' ); ?></code>
				<?php self::clipboard_icon( esc_attr( '.' . str_replace( '_', '-', static::get_shortcode_name() ) . '-shortcode' ) ); ?>
				 <?php if ( ! empty( $this->shortcode_attributes ) ) : ?>
					<button type="button" class="btn btn-secondary ms-2" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( str_replace( '_', '-', static::get_shortcode_name() ) . '-shortcode-attributes' ); ?>" aria-controls="<?php echo esc_attr( str_replace( '_', '-', static::get_shortcode_name() ) . '-shortcode-attributes' ); ?>" aria-expanded="false" ><?php esc_html_e( 'attributes' ); ?></button>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $this->shortcode_attributes ) ) : ?>
			<div id="<?php echo esc_attr( str_replace( '_', '-', static::get_shortcode_name() ) . '-shortcode-attributes' ); ?>" class="shortcode-attrs collapse">
				<table class="table table-striped table-bordered my-4">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Attribute' ); ?></th>
							<th><?php esc_html_e( 'Description' ); ?></th>
							<th><?php esc_html_e( 'Status' ); ?></th>
							<th><?php esc_html_e( 'Default value' ); ?></th>
							<th><?php esc_html_e( 'Possible values' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $this->shortcode_attributes as $attribute ) : ?>
						<tr>
							<td><?php echo esc_html( $attribute['name'] ?? '' ); ?></td>
							<td><?php echo wp_kses_post( $attribute['description'] ?? '' ); ?></td>
							<td><?php echo esc_html( $attribute['status'] ?? '' ); ?></td>
							<td><?php echo esc_html( $attribute['default'] ?? '' ); ?></td>
							<td><?php echo esc_html( $attribute['possible_values'] ?? '' ); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php endif; ?>
		</div>
		<?php
	}

}
