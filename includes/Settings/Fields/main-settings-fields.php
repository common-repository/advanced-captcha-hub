<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\Fields;

defined( 'ABSPATH' ) || exit;



/**
 * Setup Main Settings Fields.
 *
 * @param array $plugin_info
 * @return array
 */
function setup_main_settings_fields( $plugin_info, $settings, $core ) {
	return array(
		'general'  => array(
			'general' => array(
				'settings_list' => array(
					'failed_notice' => array(
						'key'          => 'failed_notice',
						'input_label'  => esc_html__( 'Verfication notice', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Captcha Verification notice', 'advanced-captcha-hub' ),
						'type'         => 'text',
						'classes'      => 'regular-text',
						'value'        => esc_html__( 'Please verify the captcha to proceed.', 'advanced-captcha-hub' ),
					),
				),
			),
		),
		'captchas' => array(
			'geetestv3'         => array(
				'section_title' => '<div class="d-flex align-items-center" >' . esc_html__( 'GeeTest Captcha v3', 'advanced-captcha-hub' ) . '<a class="ms-1" target="_blank" href="https://gtaccount.geetest.com/sensebot/" ><span class="dashicons dashicons-external"></span></a></div>',
				'settings_list' => array(
					'captchas_geetestv3_status'     => array(
						'key'          => 'captchas_geetestv3_status',
						'input_label'  => esc_html__( 'Enable', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable GeeTest v3', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_geetestv3_captchaid'  => array(
						'key'         => 'captchas_geetestv3_captchaid',
						'input_label' => esc_html__( 'Captcha ID', 'advanced-captcha-hub' ),
						'type'        => 'text',
						'classes'     => 'regular-text',
						'value'       => '',
					),
					'captchas_geetestv3_captchakey' => array(
						'key'         => 'captchas_geetestv3_captchakey',
						'input_label' => esc_html__( 'Captcha Key', 'advanced-captcha-hub' ),
						'type'        => 'text',
						'classes'     => 'regular-text',
						'value'       => '',
					),
				),
			),
			'geetestv4'         => array(
				'section_title' => '<div class="d-flex align-items-center" >' . esc_html__( 'GeeTest Captcha v4', 'advanced-captcha-hub' ) . '<a class="ms-1" target="_blank" href="https://console.geetest.com/sensbot/management" ><span class="dashicons dashicons-external"></span></a></div>',
				'settings_list' => array(
					'captchas_geetestv4_status'     => array(
						'key'          => 'captchas_geetestv4_status',
						'input_label'  => esc_html__( 'Enable', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable GeeTest v4', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_geetestv4_captchaid'  => array(
						'key'         => 'captchas_geetestv4_captchaid',
						'input_label' => esc_html__( 'Captcha ID', 'advanced-captcha-hub' ),
						'type'        => 'text',
						'classes'     => 'regular-text',
						'value'       => '',
					),
					'captchas_geetestv4_captchakey' => array(
						'key'         => 'captchas_geetestv4_captchakey',
						'input_label' => esc_html__( 'Captcha Key', 'advanced-captcha-hub' ),
						'type'        => 'text',
						'classes'     => 'regular-text',
						'value'       => '',
					),
				),
			),
			'hcaptcha'          => array(
				'section_title' => '<div class="d-flex align-items-center" >' . esc_html__( 'hCaptcha', 'advanced-captcha-hub' ) . '<a class="ms-1" target="_blank" href="https://hCaptcha.com/?r=13a1c9749dc2" ><span class="dashicons dashicons-external"></span></a></div>',
				'settings_list' => array(
					'captchas_hcaptcha_status'    => array(
						'key'          => 'captchas_hcaptcha_status',
						'input_label'  => esc_html__( 'Enable', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable hCaptcha', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_hcaptcha_sitekey'   => array(
						'key'         => 'captchas_hcaptcha_sitekey',
						'input_label' => esc_html__( 'Captcha site key', 'advanced-captcha-hub' ),
						'type'        => 'text',
						'classes'     => 'regular-text',
						'value'       => '',
					),
					'captchas_hcaptcha_secretkey' => array(
						'key'         => 'captchas_hcaptcha_secretkey',
						'input_label' => esc_html__( 'Captcha secret key', 'advanced-captcha-hub' ),
						'type'        => 'text',
						'classes'     => 'regular-text',
						'value'       => '',
					),
				),
			),
			'mtcaptcha'         => array(
				'section_title' => '<div class="d-flex align-items-center" >' . esc_html__( 'MTCaptcha', 'advanced-captcha-hub' ) . $core->pro_btn( '', 'Pro', '', '', true ) . ' <a class="ms-1" target="_blank" href="https://admin.mtcaptcha.com/admin/dashboard" ><span class="dashicons dashicons-external"></span></a></div>',
				'settings_list' => array(
					'captchas_mtcaptcha_status'     => array(
						'key'          => 'captchas_mtcaptcha_status',
						'input_label'  => esc_html__( 'Enable', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable MtCaptcha', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'classes'      => 'disabled',
						'attrs'        => array(
							'disabled' => 'disabled',
						),
						'value'        => 'off',
					),
					'captchas_mtcaptcha_sitekey'    => array(
						'key'         => 'captchas_mtcaptcha_sitekey',
						'input_label' => esc_html__( 'Captcha site key', 'advanced-captcha-hub' ),
						'type'        => 'text',
						'classes'     => 'regular-text disabled',
						'value'       => '',
					),
					'captchas_mtcaptcha_privatekey' => array(
						'key'         => 'captchas_mtcaptcha_privatekey',
						'input_label' => esc_html__( 'Captcha private key', 'advanced-captcha-hub' ),
						'type'        => 'text',
						'classes'     => 'regular-text disabled',
						'value'       => '',
					),
				),
			),
			'googlerecaptchav2' => array(
				'section_title' => '<div class="d-flex align-items-center" >' . esc_html__( 'Google reCaptcha V2', 'advanced-captcha-hub' ) . '<a class="ms-1" target="_blank" href="https://www.google.com/recaptcha/admin/create" ><span class="dashicons dashicons-external"></span></a></div>',
				'settings_list' => array(
					'captchas_googlerecaptchav2_status'  => array(
						'key'          => 'captchas_googlerecaptchav2_status',
						'input_label'  => esc_html__( 'Enable', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable reCaptcha', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_googlerecaptchav2_sitekey' => array(
						'key'         => 'captchas_googlerecaptchav2_sitekey',
						'input_label' => esc_html__( 'Captcha site key', 'advanced-captcha-hub' ),
						'type'        => 'text',
						'classes'     => 'regular-text',
						'value'       => '',
					),
					'captchas_googlerecaptchav2_privatekey' => array(
						'key'         => 'captchas_googlerecaptchav2_privatekey',
						'input_label' => esc_html__( 'Captcha private key', 'advanced-captcha-hub' ),
						'type'        => 'text',
						'classes'     => 'regular-text',
						'value'       => '',
					),
				),
			),
			'googlerecaptchav3' => array(
				'section_title' => '<div class="d-flex align-items-center" >' . esc_html__( 'Google reCaptcha V3', 'advanced-captcha-hub' ) . '<a class="ms-1" target="_blank" href="https://www.google.com/recaptcha/admin/create" ><span class="dashicons dashicons-external"></span></a></div>',
				'settings_list' => array(
					'captchas_googlerecaptchav3_status'  => array(
						'key'          => 'captchas_googlerecaptchav3_status',
						'input_label'  => esc_html__( 'Enable', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable Google reCaptcha', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_googlerecaptchav3_sitekey' => array(
						'key'         => 'captchas_googlerecaptchav3_sitekey',
						'input_label' => esc_html__( 'Captcha site key', 'advanced-captcha-hub' ),
						'type'        => 'text',
						'classes'     => 'regular-text',
						'value'       => '',
					),
					'captchas_googlerecaptchav3_privatekey' => array(
						'key'         => 'captchas_googlerecaptchav3_privatekey',
						'input_label' => esc_html__( 'Captcha private key', 'advanced-captcha-hub' ),
						'type'        => 'text',
						'classes'     => 'regular-text',
						'value'       => '',
					),
					'captchas_googlerecaptchav3_score_threshold' => array(
						'key'          => 'captchas_googlerecaptchav3_score_threshold',
						'input_label'  => esc_html__( 'Score threshold', 'advanced-captcha-hub' ),
						'type'         => 'number',
						'value'        => 0.5,
						'attrs'        => array(
							'min'  => 0.1,
							'step' => 0.1,
							'max'  => 1.0,
						),
					),
				),
			),
			'captchas_select'   => array(
				'section_title' => esc_html__( 'Captchas forms', 'advanced-captcha-hub' ),
				'settings_list' => array(
					// Woo Add To Cart.
					'captchas_places_woo_add_to_cart_status' => array(
						'key'          => 'captchas_places_woo_add_to_cart_status',
						'classes'      => 'captchas-captcha-woo-add-to-cart-status disabled',
						'input_label'  => esc_html__( 'Woo Add To Cart', 'advanced-captcha-hub' ) . $core->pro_btn( '', 'Pro', '', '', true ),
						'input_suffix' => esc_html__( 'Enable captcha on WooCommerce add to cart submit action.', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_places_woo_add_to_cart_select' => array(
						'key'          => 'captchas_places_woo_add_to_cart_select',
						'input_label'  => esc_html__( 'Select Captchas', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Google recaptcha V3 is the available to use for now. more will be added in upcoming updates', 'advanced-captcha-hub' ),
						'type'         => 'select',
						'hide'         => true,
						'multiple'     => true,
						'value'        => array(),
						'options'      => $settings->captchas_mapper( array( 'googlerecaptchav2', 'hcaptcha', 'geetestv4', 'geetestv3' ) ),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-captcha-woo-add-to-cart-status',
								'collapse_value'  => 'on',
							),
						),
						'attrs'        => array(
							'data-select_args' => wp_json_encode(
								array(
									'placeholder' => array(),
									'width'       => 250,
									'allowClear'  => true,
									'data'        => $settings->captchas_mapper(),
									'maximumSelectionLength' => 1,
								)
							),
						),
					),
					// Woo Checkout Form.
					'captchas_places_woo_checkout_status'  => array(
						'key'          => 'captchas_places_woo_checkout_status',
						'classes'      => 'captchas-places-woo-checkout-status',
						'input_label'  => esc_html__( 'WooCommerce Checkout Form', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable captchas on WooCommerce Checkout Form', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_places_woo_checkout_select_type' => array(
						'key'          => 'captchas_places_woo_checkout_select_type',
						'classes'      => 'captchas-places-woo-checkout-select-type',
						'input_label'  => esc_html__( 'Select Type', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Captcha Select Type', 'advanced-captcha-hub' ),
						'type'         => 'radio',
						'hide'         => true,
						'value'        => 2,
						'options'      => array(
							array(
								'classes'      => 'disabled',
								'value'        => 1,
								'attrs'        => array(
									'disabled' => 'disabled',
								),
								'input_suffix' => esc_html__( 'Random', 'gpls-waadtct-woo-advanced-add-to-cart' ) . $core->pro_btn( '', 'Pro', '', '', true ),
								'input_footer' => esc_html__( 'Select the captchas randomly.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
							array(
								'value'        => 2,
								'default'      => true,
								'input_suffix' => esc_html__( 'Manual', 'gpls-waadtct-woo-advanced-add-to-cart' ),
								'input_footer' => esc_html__( 'Select the exact captchas to use.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
						),
						'collapse'     => array(
							'collapse_source' => 'captchas-places-woo-checkout-status',
							'collapse_value'  => 'on',
						),
					),
					'captchas_places_woo_checkout_select'  => array(
						'key'         => 'captchas_places_woo_checkout_select',
						'input_label' => esc_html__( 'Select Captchas', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Multiple captchas per form are available in ', 'advanced-captcha-hub' ) . $core->pro_btn( '', 'Pro', '', '', true ),
						'type'        => 'select',
						'hide'        => true,
						'multiple'    => false,
						'value'       => array(),
						'options'     => $settings->captchas_mapper(),
						'collapse'    => array(
							array(
								'collapse_source' => 'captchas-places-woo-checkout-status',
								'collapse_value'  => 'on',
							),
						),
						'attrs'       => array(
							'data-select_args' => wp_json_encode(
								array(
									'placeholder' => array(),
									'width'       => 250,
									'allowClear'  => true,
									'data'        => $settings->captchas_mapper(),
								)
							),
						),
					),
					'captchas_places_woo_checkout_random_select_num' => array(
						'key'          => 'captchas_places_woo_checkout_random_select_num',
						'input_label'  => esc_html__( 'Captchas count', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Choose the number of captchas to be used', 'advanced-captcha-hub' ),
						'type'         => 'select',
						'hide'         => true,
						'value'        => 1,
						'options'      => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
						),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-places-woo-checkout-select-type',
								'collapse_value'  => 1,
							),
							array(
								'collapse_source' => 'captchas-places-woo-checkout-status',
								'collapse_value'  => 'on',
							),
						),
					),
					// Woo Login Form.
					'captchas_places_woo_login_status'     => array(
						'key'          => 'captchas_places_woo_login_status',
						'classes'      => 'captchas-places-woo-login-status',
						'input_label'  => esc_html__( 'WooCommerce Login Form', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable captchas on WooCommerce Login Form', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_places_woo_login_select_type' => array(
						'key'          => 'captchas_places_woo_login_select_type',
						'classes'      => 'captchas-places-woo-login-select-type',
						'input_label'  => esc_html__( 'Select Type', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Captcha Select Type', 'advanced-captcha-hub' ),
						'type'         => 'radio',
						'hide'         => true,
						'value'        => 2,
						'options'      => array(
							array(
								'classes'      => 'disabled',
								'value'        => 1,
								'attrs'        => array(
									'disabled' => 'disabled',
								),
								'input_suffix' => esc_html__( 'Random', 'gpls-waadtct-woo-advanced-add-to-cart' ) . $core->pro_btn( '', 'Pro', '', '', true ),
								'input_footer' => esc_html__( 'Select the captchas randomly.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
							array(
								'value'        => 2,
								'default'      => true,
								'input_suffix' => esc_html__( 'Manual', 'gpls-waadtct-woo-advanced-add-to-cart' ),
								'input_footer' => esc_html__( 'Select the exact captchas to use.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
						),
						'collapse'     => array(
							'collapse_source' => 'captchas-places-woo-login-status',
							'collapse_value'  => 'on',
						),
					),
					'captchas_places_woo_login_select'     => array(
						'key'          => 'captchas_places_woo_login_select',
						'input_label'  => esc_html__( 'Select Captchas', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Multiple captchas per form are available in ', 'advanced-captcha-hub' ) . $core->pro_btn( '', 'Pro', '', '', true ),
						'type'         => 'select',
						'hide'         => true,
						'multiple'     => false,
						'value'        => array(),
						'options'      => $settings->captchas_mapper(),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-places-woo-login-status',
								'collapse_value'  => 'on',
							),
						),
						'attrs'       => array(
							'data-select_args' => wp_json_encode(
								array(
									'placeholder' => array(),
									'width'       => 250,
									'allowClear'  => true,
									'data'        => $settings->captchas_mapper(),
								)
							),
						),
					),
					'captchas_places_woo_login_random_select_num' => array(
						'key'          => 'captchas_places_woo_login_random_select_num',
						'input_label'  => esc_html__( 'Captchas count', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Choose the number of captchas to be used', 'advanced-captcha-hub' ),
						'type'         => 'select',
						'hide'         => true,
						'value'        => 1,
						'options'      => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
						),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-places-woo-login-select-type',
								'collapse_value'  => 1,
							),
							array(
								'collapse_source' => 'captchas-places-woo-login-status',
								'collapse_value'  => 'on',
							),
						),
					),
					// Woo Register Form.
					'captchas_places_woo_register_status'  => array(
						'key'          => 'captchas_places_woo_register_status',
						'classes'      => 'captchas-places-woo-register-status',
						'input_label'  => esc_html__( 'WooCommerce Register Form', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable captchas on WooCommerce Register Form', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_places_woo_register_select_type' => array(
						'key'          => 'captchas_places_woo_register_select_type',
						'classes'      => 'captchas-places-woo-register-select-type',
						'input_label'  => esc_html__( 'Select Type', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Captcha Select Type', 'advanced-captcha-hub' ),
						'type'         => 'radio',
						'hide'         => true,
						'value'        => 2,
						'options'      => array(
							array(
								'classes'      => 'disabled',
								'value'        => 1,
								'attrs'        => array(
									'disabled' => 'disabled',
								),
								'input_suffix' => esc_html__( 'Random', 'gpls-waadtct-woo-advanced-add-to-cart' ) . $core->pro_btn( '', 'Pro', '', '', true ),
								'input_footer' => esc_html__( 'Select the captchas randomly.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
							array(
								'value'        => 2,
								'default'      => true,
								'input_suffix' => esc_html__( 'Manual', 'gpls-waadtct-woo-advanced-add-to-cart' ),
								'input_footer' => esc_html__( 'Select the exact captchas to use.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
						),
						'collapse'     => array(
							'collapse_source' => 'captchas-places-woo-register-status',
							'collapse_value'  => 'on',
						),
					),
					'captchas_places_woo_register_select'  => array(
						'key'          => 'captchas_places_woo_register_select',
						'input_label'  => esc_html__( 'Select Captchas', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Multiple captchas per form are available in ', 'advanced-captcha-hub' ) . $core->pro_btn( '', 'Pro', '', '', true ),
						'type'         => 'select',
						'hide'         => true,
						'multiple'     => false,
						'value'        => array(),
						'options'      => $settings->captchas_mapper(),
						'collapse'    => array(
							array(
								'collapse_source' => 'captchas-places-woo-register-status',
								'collapse_value'  => 'on',
							),
						),
						'attrs'       => array(
							'data-select_args' => wp_json_encode(
								array(
									'placeholder' => array(),
									'width'       => 250,
									'allowClear'  => true,
									'data'        => $settings->captchas_mapper(),
								)
							),
						),
					),
					'captchas_places_woo_register_random_select_num' => array(
						'key'          => 'captchas_places_woo_register_random_select_num',
						'input_label'  => esc_html__( 'Captchas count', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Choose the number of captchas to be used', 'advanced-captcha-hub' ),
						'type'         => 'select',
						'hide'         => true,
						'value'        => 1,
						'options'      => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
						),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-places-woo-register-select-type',
								'collapse_value'  => 1,
							),
							array(
								'collapse_source' => 'captchas-places-woo-register-status',
								'collapse_value'  => 'on',
							),
						),
					),
					// Comments and Woo Review Form.
					'captchas_places_comments_status'      => array(
						'key'          => 'captchas_places_comments_status',
						'classes'      => 'captchas-places-comments-status',
						'input_label'  => esc_html__( 'Comments / Reviews Forms', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable captchas on WooCommerce review and comments Form', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_places_comments_select_type' => array(
						'key'          => 'captchas_places_comments_select_type',
						'classes'      => 'captchas-places-comments-select-type',
						'input_label'  => esc_html__( 'Select Type', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Captcha Select Type', 'advanced-captcha-hub' ),
						'type'         => 'radio',
						'hide'         => true,
						'value'        => 2,
						'options'      => array(
							array(
								'classes'      => 'disabled',
								'value'        => 1,
								'attrs'        => array(
									'disabled' => 'disabled',
								),
								'input_suffix' => esc_html__( 'Random', 'gpls-waadtct-woo-advanced-add-to-cart' ) . $core->pro_btn( '', 'Pro', '', '', true ),
								'input_footer' => esc_html__( 'Select the captchas randomly.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
							array(
								'value'        => 2,
								'default'      => true,
								'input_suffix' => esc_html__( 'Manual', 'gpls-waadtct-woo-advanced-add-to-cart' ),
								'input_footer' => esc_html__( 'Select the exact captchas to use.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
						),
						'collapse'     => array(
							'collapse_source' => 'captchas-places-comments-status',
							'collapse_value'  => 'on',
						),
					),
					'captchas_places_comments_select'      => array(
						'key'          => 'captchas_places_comments_select',
						'input_label'  => esc_html__( 'Select Captchas', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Multiple captchas per form are available in ', 'advanced-captcha-hub' ) . $core->pro_btn( '', 'Pro', '', '', true ),
						'type'         => 'select',
						'hide'         => true,
						'multiple'     => false,
						'value'        => array(),
						'options'      => $settings->captchas_mapper(),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-places-comments-status',
								'collapse_value'  => 'on',
							),
						),
						'attrs'       => array(
							'data-select_args' => wp_json_encode(
								array(
									'placeholder' => array(),
									'width'       => 250,
									'allowClear'  => true,
									'data'        => $settings->captchas_mapper(),
								)
							),
						),
					),
					'captchas_places_comments_random_select_num' => array(
						'key'          => 'captchas_places_comments_random_select_num',
						'input_label'  => esc_html__( 'Captchas count', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Choose the number of captchas to be used', 'advanced-captcha-hub' ),
						'type'         => 'select',
						'hide'         => true,
						'value'        => 1,
						'options'      => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
						),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-places-comments-select-type',
								'collapse_value'  => 1,
							),
							array(
								'collapse_source' => 'captchas-places-comments-status',
								'collapse_value'  => 'on',
							),
						),
					),
					// Woo lost password Form.
					'captchas_places_woo_lost_pass_status' => array(
						'key'          => 'captchas_places_woo_lost_pass_status',
						'classes'      => 'captchas-places-woo-lost-pass-status',
						'input_label'  => esc_html__( 'WooCommerce Lost password Form', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable captchas on WooCommerce lost password Form', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_places_woo_lost_pass_select_type' => array(
						'key'          => 'captchas_places_woo_lost_pass_select_type',
						'classes'      => 'captchas-places-woo-lost-pass-select-type',
						'input_label'  => esc_html__( 'Select Type', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Captcha Select Type', 'advanced-captcha-hub' ),
						'type'         => 'radio',
						'hide'         => true,
						'value'        => 2,
						'options'      => array(
							array(
								'classes'      => 'disabled',
								'value'        => 1,
								'attrs'        => array(
									'disabled' => 'disabled',
								),
								'input_suffix' => esc_html__( 'Random', 'gpls-waadtct-woo-advanced-add-to-cart' ) . $core->pro_btn( '', 'Pro', '', '', true ),
								'input_footer' => esc_html__( 'Select the captchas randomly.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
							array(
								'default'      => true,
								'value'        => 2,
								'input_suffix' => esc_html__( 'Manual', 'gpls-waadtct-woo-advanced-add-to-cart' ),
								'input_footer' => esc_html__( 'Select the exact captchas to use.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
						),
						'collapse'     => array(
							'collapse_source' => 'captchas-places-woo-lost-pass-status',
							'collapse_value'  => 'on',
						),
					),
					'captchas_places_woo_lost_pass_select' => array(
						'key'          => 'captchas_places_woo_lost_pass_select',
						'input_label'  => esc_html__( 'Select Captchas', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Multiple captchas per form are available in ', 'advanced-captcha-hub' ) . $core->pro_btn( '', 'Pro', '', '', true ),
						'type'         => 'select',
						'hide'         => true,
						'multiple'     => false,
						'value'        => array(),
						'options'      => $settings->captchas_mapper(),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-places-woo-lost-pass-status',
								'collapse_value'  => 'on',
							),
						),
						'attrs'       => array(
							'data-select_args' => wp_json_encode(
								array(
									'placeholder' => array(),
									'width'       => 250,
									'allowClear'  => true,
									'data'        => $settings->captchas_mapper(),
								)
							),
						),
					),
					'captchas_places_woo_lost_pass_random_select_num' => array(
						'key'          => 'captchas_places_woo_lost_pass_random_select_num',
						'input_label'  => esc_html__( 'Captchas count', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Choose the number of captchas to be used', 'advanced-captcha-hub' ),
						'type'         => 'select',
						'hide'         => true,
						'value'        => 1,
						'options'      => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
						),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-places-woo-lost-pass-select-type',
								'collapse_value'  => 1,
							),
							array(
								'collapse_source' => 'captchas-places-woo-lost-pass-status',
								'collapse_value'  => 'on',
							),
						),
					),
					// WP Login Form.
					'captchas_places_wp_login_status'      => array(
						'key'          => 'captchas_places_wp_login_status',
						'classes'      => 'captchas-places-wp-login-status',
						'input_label'  => esc_html__( 'WP Login Form', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable captchas on WP Login Form', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_places_wp_login_select_type' => array(
						'key'          => 'captchas_places_wp_login_select_type',
						'classes'      => 'captchas-places-wp-login-select-type',
						'input_label'  => esc_html__( 'Select Type', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Captcha Select Type', 'advanced-captcha-hub' ),
						'type'         => 'radio',
						'hide'         => true,
						'value'        => 2,
						'options'      => array(
							array(
								'classes'      => 'disabled',
								'value'        => 1,
								'attrs'        => array(
									'disabled' => 'disabled',
								),
								'input_suffix' => esc_html__( 'Random', 'gpls-waadtct-woo-advanced-add-to-cart' ) . $core->pro_btn( '', 'Pro', '', '', true ),
								'input_footer' => esc_html__( 'Select the captchas randomly.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
							array(
								'default'      => true,
								'value'        => 2,
								'input_suffix' => esc_html__( 'Manual', 'gpls-waadtct-woo-advanced-add-to-cart' ),
								'input_footer' => esc_html__( 'Select the exact captchas to use.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
						),
						'collapse'     => array(
							'collapse_source' => 'captchas-places-wp-login-status',
							'collapse_value'  => 'on',
						),
					),
					'captchas_places_wp_login_select'      => array(
						'key'          => 'captchas_places_wp_login_select',
						'input_label'  => esc_html__( 'Select Captchas', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Multiple captchas per form are available in ', 'advanced-captcha-hub' ) . $core->pro_btn( '', 'Pro', '', '', true ),
						'type'         => 'select',
						'hide'         => true,
						'multiple'     => false,
						'value'        => array(),
						'options'      => $settings->captchas_mapper(),
						'collapse'    => array(
							array(
								'collapse_source' => 'captchas-places-wp-login-status',
								'collapse_value'  => 'on',
							),
						),
						'attrs'       => array(
							'data-select_args' => wp_json_encode(
								array(
									'placeholder' => array(),
									'width'       => 250,
									'allowClear'  => true,
									'data'        => $settings->captchas_mapper(),
								)
							),
						),
					),
					'captchas_places_wp_login_random_select_num' => array(
						'key'          => 'captchas_places_wp_login_random_select_num',
						'input_label'  => esc_html__( 'Captchas count', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Choose the number of captchas to be used', 'advanced-captcha-hub' ),
						'type'         => 'select',
						'hide'         => true,
						'value'        => 1,
						'options'      => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
						),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-places-wp-login-select-type',
								'collapse_value'  => 1,
							),
							array(
								'collapse_source' => 'captchas-places-wp-login-status',
								'collapse_value'  => 'on',
							),
						),
					),
					'login_forms_bypass'                   => array(
						'key'          => 'login_forms_bypass',
						'classes'      => 'login-forms-bypass long-input',
						'input_label'  => esc_html__( 'Bypass Login Forms', 'advanced-captcha-hub' ),
						'input_footer' => esc_html__( 'Captcha bypass parameter for login forms', 'advanced-captcha-hub' ),
						'type'         => 'text',
						'value'        => '',
					),
					// WP Register Form.
					'captchas_places_wp_register_status'   => array(
						'key'          => 'captchas_places_wp_register_status',
						'classes'      => 'captchas-places-wp-register-status',
						'input_label'  => esc_html__( 'WP Register Form', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable captchas on WP Register Form', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_places_wp_register_select_type' => array(
						'key'          => 'captchas_places_wp_register_select_type',
						'classes'      => 'captchas-places-wp-register-select-type',
						'input_label'  => esc_html__( 'Select Type', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Captcha Select Type', 'advanced-captcha-hub' ),
						'type'         => 'radio',
						'hide'         => true,
						'value'        => 2,
						'options'      => array(
							array(
								'classes'      => 'disabled',
								'value'        => 1,
								'attrs'        => array(
									'disabled' => 'disabled',
								),
								'input_suffix' => esc_html__( 'Random', 'gpls-waadtct-woo-advanced-add-to-cart' ) . $core->pro_btn( '', 'Pro', '', '', true ),
								'input_footer' => esc_html__( 'Select the captchas randomly.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
							array(
								'value'        => 2,
								'default'      => true,
								'input_suffix' => esc_html__( 'Manual', 'gpls-waadtct-woo-advanced-add-to-cart' ),
								'input_footer' => esc_html__( 'Select the exact captchas to use.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
						),
						'collapse'     => array(
							'collapse_source' => 'captchas-places-wp-register-status',
							'collapse_value'  => 'on',
						),
					),
					'captchas_places_wp_register_select'   => array(
						'key'          => 'captchas_places_wp_register_select',
						'input_label'  => esc_html__( 'Select Captchas', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Multiple captchas per form are available in ', 'advanced-captcha-hub' ) . $core->pro_btn( '', 'Pro', '', '', true ),
						'type'         => 'select',
						'hide'         => true,
						'multiple'     => false,
						'value'        => array(),
						'options'      => $settings->captchas_mapper(),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-places-wp-register-status',
								'collapse_value'  => 'on',
							),
						),
						'attrs'       => array(
							'data-select_args' => wp_json_encode(
								array(
									'placeholder' => array(),
									'width'       => 250,
									'allowClear'  => true,
									'data'        => $settings->captchas_mapper(),
								)
							),
						),
					),
					'captchas_places_wp_register_random_select_num' => array(
						'key'          => 'captchas_places_wp_register_random_select_num',
						'input_label'  => esc_html__( 'Captchas count', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Choose the number of captchas to be used', 'advanced-captcha-hub' ),
						'type'         => 'select',
						'hide'         => true,
						'value'        => 1,
						'options'      => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
						),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-places-wp-register-select-type',
								'collapse_value'  => 1,
							),
							array(
								'collapse_source' => 'captchas-places-wp-register-status',
								'collapse_value'  => 'on',
							),
						),
					),
					// WP Lost Password Form.
					'captchas_places_wp_lost_pass_status'  => array(
						'key'          => 'captchas_places_wp_lost_pass_status',
						'classes'      => 'captchas-places-wp-lost-pass-status',
						'input_label'  => esc_html__( 'WP Lost Password Form', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Enable captchas on WP Lost Password Form', 'advanced-captcha-hub' ),
						'type'         => 'checkbox',
						'value'        => 'off',
					),
					'captchas_places_wp_lost_pass_select_type' => array(
						'key'          => 'captchas_places_wp_lost_pass_select_type',
						'classes'      => 'captchas-places-wp-lost-pass-select-type',
						'input_label'  => esc_html__( 'Select Type', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Captcha Select Type', 'advanced-captcha-hub' ),
						'type'         => 'radio',
						'hide'         => true,
						'value'        => 2,
						'options'      => array(
							array(
								'classes'      => 'disabled',
								'value'        => 1,
								'attrs'        => array(
									'disabled' => 'disabled',
								),
								'input_suffix' => esc_html__( 'Random', 'gpls-waadtct-woo-advanced-add-to-cart' ) . $core->pro_btn( '', 'Pro', '', '', true ),
								'input_footer' => esc_html__( 'Select the captchas randomly.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
							array(
								'default'      => true,
								'value'        => 2,
								'input_suffix' => esc_html__( 'Manual', 'gpls-waadtct-woo-advanced-add-to-cart' ),
								'input_footer' => esc_html__( 'Select the exact captchas to use.', 'gpls-waadtct-woo-advanced-add-to-cart' ),
							),
						),
						'collapse'     => array(
							'collapse_source' => 'captchas-places-wp-lost-pass-status',
							'collapse_value'  => 'on',
						),
					),
					'captchas_places_wp_lost_pass_select'  => array(
						'key'          => 'captchas_places_wp_lost_pass_select',
						'input_label'  => esc_html__( 'Select Captchas', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Multiple captchas per form are available in ', 'advanced-captcha-hub' ) . $core->pro_btn( '', 'Pro', '', '', true ),
						'type'         => 'select',
						'hide'         => true,
						'multiple'     => false,
						'value'        => array(),
						'options'      => $settings->captchas_mapper(),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-places-wp-lost-pass-status',
								'collapse_value'  => 'on',
							),
						),
						'attrs'       => array(
							'data-select_args' => wp_json_encode(
								array(
									'placeholder' => array(),
									'width'       => 250,
									'allowClear'  => true,
									'data'        => $settings->captchas_mapper(),
								)
							),
						),
					),
					'captchas_places_wp_lost_pass_random_select_num' => array(
						'key'          => 'captchas_places_wp_lost_pass_random_select_num',
						'input_label'  => esc_html__( 'Captchas count', 'advanced-captcha-hub' ),
						'input_suffix' => esc_html__( 'Choose the number of captchas to be used', 'advanced-captcha-hub' ),
						'type'         => 'select',
						'hide'         => true,
						'value'        => 1,
						'options'      => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
						),
						'collapse'     => array(
							array(
								'collapse_source' => 'captchas-places-wp-lost-pass-select-type',
								'collapse_value'  => 1,
							),
							array(
								'collapse_source' => 'captchas-places-wp-lost-pass-status',
								'collapse_value'  => 'on',
							),
						),
					),
				),
			),
		),
	);
}
