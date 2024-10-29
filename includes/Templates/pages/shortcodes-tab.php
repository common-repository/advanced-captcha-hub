<?php



$shortcode = $args['shortcode'];
$core      = $args['core'];

?>
<div class="d-flex justify-content-center">
    <h3 class="bg-white p-3 text-center d-inline-block mx-auto"><?php esc_html_e( 'This feature is part of the Pro version', 'advanced-captcha-hub' ); ?><span class="ms-2"><?php $core->pro_btn( '', 'Pro', '', 'd-inline' ); ?></span></h3>
</div>
<?php
$shortcode->print_shortcode_details(
	array(
		'captchas'  => 'geetestv4,googlerecaptchav3',
		'is_random' => 'no',
	)
);
?>

<div class="container mx-auto">
    <p class="text bg-white shadow-sm border p-4 m-5">
        <span><?php esc_html_e( 'Check Docs for more details on how to use it.', 'advanced-captcha-hub' ); ?></span>
        <a href="https://grandplugins.com/documentation/advanced-captcha" target="_blank" class="text-center"><?php esc_html_e( 'Documentation', 'advanced-captcha-hub' ); ?></a>
    </p>

</div>
