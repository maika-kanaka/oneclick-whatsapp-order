<?php

// Hide WhatsApp button on selected pages
add_action('wp_head', 'wa_order_display_options');
function wa_order_display_options(){
// Hide button on shop loop - desktop
if ( get_option(sanitize_text_field('wa_order_display_option_shop_loop_hide_desktop')) === 'yes' ) {
		?>
		<style>
			@media only screen and (min-width: 768px) {
			.wa-shop-button{display:none!important;}
			}
		</style>
	    <?php
	}
// Hide button on shop loop - mobile
if ( get_option(sanitize_text_field('wa_order_display_option_shop_loop_hide_mobile')) === 'yes' ) {
		?>
		<style>
			@media only screen and (max-width: 767px) {
			.wa-shop-button{display:none!important;}
			}
		</style>
	    <?php
	}
// Hide button on cart page - desktop
if ( get_option(sanitize_text_field('wa_order_display_option_cart_hide_desktop')) === 'yes' ) {
		?>
		<style>
			@media only screen and (min-width: 767px) {
			.wc-proceed-to-checkout .wa-order-checkout{display:none!important;}
			}
		</style>
	    <?php
	}
// Hide button on cart page - mobile
if ( get_option(sanitize_text_field('wa_order_display_option_cart_hide_mobile')) === 'yes' ) {
		?>
		<style>
			@media only screen and (max-width: 767px) {
			.wc-proceed-to-checkout .wa-order-checkout{display:none!important;}
			}
		</style>
	    <?php
	}
// Hide button on thank you page - desktop
if ( get_option(sanitize_text_field('wa_order_display_option_checkout_hide_desktop')) === 'yes' ) {
		?>
		<style>
			@media only screen and (min-width: 767px) {
			a.wa-order-thankyou{display:none!important;}
			}
		</style>
	    <?php
	}
// Hide button on thank you page - mobile
if ( get_option(sanitize_text_field('wa_order_display_option_checkout_hide_mobile')) === 'yes' ) {
		?>
		<style>
			@media only screen and (max-width: 767px) {
			a.wa-order-thankyou{display:none!important;}
			}
		</style>
	    <?php
	}
}

// Button Colors
add_action('wp_head', 'wa_order_display_options_button_colors');
function wa_order_display_options_button_colors() {
	$bg 		= get_option(sanitize_text_field('wa_order_bg_color'));
	$txt 		= get_option(sanitize_text_field( 'wa_order_txt_color' ));
	$bg_hover 	= get_option(sanitize_text_field( 'wa_order_bg_hover_color' ));
	$txt_hover 	= get_option(sanitize_text_field( 'wa_order_txt_hover_color' ));
	if ( empty( $bg ) && empty( $txt ) && empty( $bg_hover ) && empty( $txt_hover ) ) {
		return;
	} elseif ( isset( $bg ) || isset( $txt ) || isset( $bg_hover ) || isset( $txt_hover ) ) {
		// Set default colors
		if( empty( $bg ) ) $bg = 'rgba(37, 211, 102, 1)';
		if( empty( $txt ) ) $txt = 'rgba(255, 255, 255, 1)';
		if( empty( $bg_hover ) ) $bg_hover = 'rgba(37, 211, 102, 1)';
		if( empty( $txt_hover ) ) $txt_hover = 'rgba(255, 255, 255, 1)';
		?>
		<style>
			#sendbtn, #sendbtn2, .wa-order-button, .gdpr_wa_button_input {
				background-color: <?php echo $bg; ?>!important;
				color: <?php echo $txt; ?>!important;
			}
			#sendbtn:hover, #sendbtn2:hover, .wa-order-button:hover, .gdpr_wa_button_input:hover {
				background-color: <?php echo $bg_hover; ?>!important;
				color: <?php echo $txt_hover; ?>!important;
			}
		</style>
	    <?php
	}
}

// Box Shadow
add_action('wp_head', 'wa_order_display_options_std_box_shadow');
function wa_order_display_options_std_box_shadow() {
		// Box Shadow
		$bshdw 		= get_option(sanitize_text_field( 'wa_order_btn_box_shdw' ));
		$bshdw_hz 	= get_option(sanitize_text_field( 'wa_order_bshdw_horizontal' ));
		$bshdw_v 	= get_option(sanitize_text_field( 'wa_order_bshdw_vertical' ));
		$bshdw_b 	= get_option(sanitize_text_field( 'wa_order_bshdw_blur' ));
		$bshdw_s 	= get_option(sanitize_text_field( 'wa_order_bshdw_spread' ));
		$bshdw_p 	= get_option(sanitize_text_field( 'wa_order_bshdw_position' ));

		// Standard Button's Box Shadow
		if ( empty( $bshdw ) && empty( $bshdw_hz ) && empty( $bshdw_v ) && empty( $bshdw_b ) && empty( $bshdw_s ) ) {
			return;
		} elseif ( isset( $bshdw ) || isset( $bshdw_hz ) || isset( $bshdw_v ) || isset( $bshdw_b ) || isset( $bshdw_s ) ) {
		// Set default colors
		if( empty( $bshdw ) ) $bshdw = 'rgba(0,0,0,0.25)';
		if( empty( $bshdw_hz ) ) $bshdw_hz = '0';
		if( empty( $bshdw_v ) ) $bshdw_v = '4';
		if( empty( $bshdw_b ) ) $bshdw_b = '7';
		if( empty( $bshdw_s ) ) $bshdw_s = '0';
		if ( $bshdw_p === '' || $bshdw_p === 'outline' ) { ?>
		<style>
			#sendbtn, #sendbtn2,
			.wa-order-button, 
			.gdpr_wa_button_input, 
			a.wa-order-checkout, 
			a.wa-order-thankyou, 
			.shortcode_wa_button, 
			.shortcode_wa_button_nt,
			.floating_button {
				-webkit-box-shadow: <?php echo $bshdw_hz; ?>px <?php echo $bshdw_v; ?>px <?php echo $bshdw_b; ?>px <?php echo $bshdw_s; ?>px <?php echo $bshdw_hov; ?>!important;
				-moz-box-shadow: <?php echo $bshdw_hz; ?>px <?php echo $bshdw_v; ?>px <?php echo $bshdw_b; ?>px <?php echo $bshdw_s; ?>px <?php echo $bshdw_hov; ?>!important;
				box-shadow: <?php echo $bshdw_hz; ?>px <?php echo $bshdw_v; ?>px <?php echo $bshdw_b; ?>px <?php echo $bshdw_s; ?>px <?php echo $bshdw_hov; ?>!important;
			}
		</style>
		<?php } else { ?>
			<style>
				#sendbtn, #sendbtn2,
				.wa-order-button, 
				.gdpr_wa_button_input, 
				a.wa-order-checkout, 
				a.wa-order-thankyou, 
				.shortcode_wa_button, 
				.shortcode_wa_button_nt,
				.floating_button {
					-webkit-box-shadow: inset <?php echo $bshdw_hz; ?>px <?php echo $bshdw_v; ?>px <?php echo $bshdw_b; ?>px <?php echo $bshdw_s; ?>px <?php echo $bshdw; ?>!important;
					-moz-box-shadow: inset <?php echo $bshdw_hz; ?>px <?php echo $bshdw_v; ?>px <?php echo $bshdw_b; ?>px <?php echo $bshdw_s; ?>px <?php echo $bshdw; ?>!important;
					box-shadow: inset <?php echo $bshdw_hz; ?>px <?php echo $bshdw_v; ?>px <?php echo $bshdw_b; ?>px <?php echo $bshdw_s; ?>px <?php echo $bshdw; ?>!important;
				}
			</style>
		<?php } ?>
	    <?php
			}
}

// Hover Box Shadow
add_action('wp_head', 'wa_order_display_options_hover_box_shadow');
function wa_order_display_options_hover_box_shadow() {
		// Box Shadow
		$bshdw_hov 	= get_option(sanitize_text_field( 'wa_order_btn_box_shdw_hover' ));
		$bshdw_h_h 	= get_option(sanitize_text_field( 'wa_order_bshdw_horizontal_hover' ));
		$bshdw_v_h 	= get_option(sanitize_text_field( 'wa_order_bshdw_vertical_hover' ));
		$bshdw_b_h 	= get_option(sanitize_text_field( 'wa_order_bshdw_blur_hover' ));
		$bshdw_s_h 	= get_option(sanitize_text_field( 'wa_order_bshdw_spread_hover' ));
		$bshdw_p_h 	= get_option(sanitize_text_field( 'wa_order_bshdw_position_hover' ));

		// Hover Button's Box Shadow
		if ( empty( $bshdw_hov ) && empty( $bshdw_h_h ) && empty( $bshdw_v_h ) && empty( $bshdw_b_h ) && empty( $bshdw_s_h ) ) {
			return;
		} elseif ( isset( $bshdw_hov ) || isset( $bshdw_h_h ) || isset( $bshdw_v_h ) || isset( $bshdw_b_h ) || isset( $bshdw_s_h ) ) {
		// Set default colors
		if( empty( $bshdw_hov ) ) $bshdw_hov = 'rgba(0,0,0,0.25)';
		if( empty( $bshdw_h_h ) ) $bshdw_h_h = '0';
		if( empty( $bshdw_v_h ) ) $bshdw_v_h = '4';
		if( empty( $bshdw_b_h ) ) $bshdw_b_h = '7';
		if( empty( $bshdw_s_h ) ) $bshdw_s_h = '0';

		if ( $bshdw_p_h === '' || $bshdw_p_h === 'outline' ) { ?>	
			<style>
				#sendbtn:hover, #sendbtn2:hover,
				.wa-order-button:hover, 
				.gdpr_wa_button_input:hover, 
				a.wa-order-checkout:hover, 
				a.wa-order-thankyou:hover, 
				.shortcode_wa_button:hover, 
				.shortcode_wa_button_nt:hover,
				.floating_button:hover {
					-webkit-box-shadow: <?php echo $bshdw_h_h; ?>px <?php echo $bshdw_v_h; ?>px <?php echo $bshdw_b_h; ?>px <?php echo $bshdw_s_h; ?>px <?php echo $bshdw_hov; ?>!important;
					-moz-box-shadow: <?php echo $bshdw_h_h; ?>px <?php echo $bshdw_v_h; ?>px <?php echo $bshdw_b_h; ?>px <?php echo $bshdw_s_h; ?>px <?php echo $bshdw_hov; ?>!important;
					box-shadow: <?php echo $bshdw_h_h; ?>px <?php echo $bshdw_v_h; ?>px <?php echo $bshdw_b_h; ?>px <?php echo $bshdw_s_h; ?>px <?php echo $bshdw_hov; ?>!important;
				}
			</style>
		<?php } else { ?>
			<style>
				#sendbtn:hover, #sendbtn2:hover,
				.wa-order-button:hover, 
				.gdpr_wa_button_input:hover, 
				a.wa-order-checkout:hover, 
				a.wa-order-thankyou:hover, 
				.shortcode_wa_button:hover, 
				.shortcode_wa_button_nt:hover,
				.floating_button:hover {
					-webkit-box-shadow: inset <?php echo $bshdw_h_h; ?>px <?php echo $bshdw_v_h; ?>px <?php echo $bshdw_b_h; ?>px <?php echo $bshdw_s_h; ?>px <?php echo $bshdw_hov; ?>!important;
					-moz-box-shadow: inset <?php echo $bshdw_h_h; ?>px <?php echo $bshdw_v_h; ?>px <?php echo $bshdw_b_h; ?>px <?php echo $bshdw_s_h; ?>px <?php echo $bshdw_hov; ?>!important;
					box-shadow: inset <?php echo $bshdw_h_h; ?>px <?php echo $bshdw_v_h; ?>px <?php echo $bshdw_b_h; ?>px <?php echo $bshdw_s_h; ?>px <?php echo $bshdw_hov; ?>!important;
				}
			</style>
			<?php } ?>
	    <?php
			}
}

// Button Margin
add_action('wp_head', 'wa_order_display_options_button_margin');
function wa_order_display_options_button_margin() {
		// Button Margin
		$bm_top 	= get_option( 'wa_order_single_button_margin_top' );
		$bm_right 	= get_option( 'wa_order_single_button_margin_right' );
		$bm_bottom 	= get_option( 'wa_order_single_button_margin_bottom' );
		$bm_left 	= get_option( 'wa_order_single_button_margin_left' );

		if ( empty( $bm_top ) && empty( $bm_right ) && empty( $bm_bottom ) && empty( $bm_left ) ) {
			return;
		} elseif ( is_product() && isset( $bm_top ) || isset( $bm_right ) || isset( $bm_bottom ) || isset( $bm_left ) ) { 
			if( empty( $bm_top ) ) $bm_top = '0';
			if( empty( $bm_right ) ) $bm_right = '0';
			if( empty( $bm_bottom ) ) $bm_bottom = '0';
			if( empty( $bm_left ) ) $bm_left = '0';
			?>
			<style>	
				.wa-order-button-under-atc,
				.wa-order-button-shortdesc,
				.wa-order-button-after-atc {
					margin: <?php echo $bm_top; ?>px <?php echo $bm_right; ?>px <?php echo $bm_bottom; ?>px <?php echo $bm_left; ?>px!important;
				} 
			</style>
    <?php
		}
}

// Button Margin
add_action('wp_head', 'wa_order_display_options_button_padding');
function wa_order_display_options_button_padding() {
	// Button Padding
	$bp_top 	= get_option( 'wa_order_single_button_padding_top' );
	$bp_right 	= get_option( 'wa_order_single_button_padding_right' );
	$bp_bottom 	= get_option( 'wa_order_single_button_padding_bottom' );
	$bp_left 	= get_option( 'wa_order_single_button_padding_left' );

	if ( empty( $bp_top ) && empty( $bp_right ) && empty( $bp_bottom ) && empty( $bp_left ) ) {
		return;
	} elseif ( is_product() && isset( $bp_top ) || isset( $bp_right ) || isset( $bp_bottom ) || isset( $bp_left ) ) { 
		if( empty( $bp_top ) ) $bp_top = '0';
		if( empty( $bp_right ) ) $bp_right = '0';
		if( empty( $bp_bottom ) ) $bp_bottom = '0';
		if( empty( $bp_left ) ) $bp_left = '0';
		?>
		<style>	
			.wa-order-button-under-atc,
			.wa-order-button-shortdesc,
			.wa-order-button {
				padding: <?php echo $bp_top; ?>px <?php echo $bp_right; ?>px <?php echo $bp_bottom; ?>px <?php echo $bp_left; ?>px!important;
			} 
		</style>
<?php
	}
}	

// Hide Product Quantity
function wa_order_remove_quantity( $return, $product ) {
	if ( get_option(sanitize_text_field('wa_order_option_remove_quantity')) )
    return true;
}
add_filter( 'woocommerce_is_sold_individually', 'wa_order_remove_quantity', 10, 2 );