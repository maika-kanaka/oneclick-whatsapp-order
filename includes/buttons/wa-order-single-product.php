<?php
// Default button position single product page
$wa_order_position = get_option('wa_order_single_product_button_position');
if (!$wa_order_position) {
    $wa_order_position['wa_order_single_product_button_position'] = 'after_atc';
}
// Start processing the WhatsApp button
function wa_order_add_button_plugin() {
	$showbutton = get_option(sanitize_text_field('wa_order_option_enable_single_product'));
	if ($showbutton === 'yes') {
	global $product;
	// Get and define phone number, custom message and button text
	global $post;
	// WA Number from Setting
	$wanumberpage = get_option( 'wa_order_selected_wa_number_single_product' );
	$postid = get_page_by_path( $wanumberpage, '', 'wa-order-numbers');
	if( empty( $postid) ) {
		$pid = 0;
	} else {
		$pid = $postid->ID;
	}
	$phonenumb = get_post_meta($pid, 'wa_order_phone_number_input', true);

	// Check if a number is assigned to a product 
	$single_number_check = get_post_meta( $post->ID, '_wa_order_phone_number_check', true );
	if ($single_number_check === 'yes') {
	// WA Number from Metabox
	$wanumber_meta = get_post_meta( $post->ID, '_wa_order_phone_number', true );
	$postid_meta = get_page_by_title( $wanumber_meta, '', 'wa-order-numbers');
	$pid_meta = $postid_meta->ID;
	if( empty( $postid_meta) ) {
		$pid_meta = 0;
	} else {
		$pid_meta = $postid_meta->ID;
	}
	$phonenumb_meta = get_post_meta($pid_meta, 'wa_order_phone_number_input', true);
		$phone = $phonenumb_meta;
	} else {
		$phone = $phonenumb;
	}

	// Choose final phone number to show
	// if ($phone = get_post_meta( $postid_meta->ID, 'wa_order_phone_number_input', true ));
	// else $phone = $phonenumb;

	$custom_message = get_option(sanitize_text_field('wa_order_option_message'));
	$target = get_option(sanitize_text_field('wa_order_option_target'));
	$gdpr_privacy_policy = get_option(sanitize_text_field('wa_order_gdpr_privacy_page'));
	$gdpr_status = get_option(sanitize_text_field('wa_order_gdpr_status_enable'));
	$gdpr_message = get_option(sanitize_text_field('wa_order_gdpr_message'));
	
	// Get the product info
	global $product;
	global $post;
	$product_url = get_permalink( $product->get_id() );
	$title = $product->get_name();
	$currency = get_woocommerce_currency_symbol();
	// $price = wc_get_price_including_tax( $product ); old way
	$price = wc_price(wc_get_price_including_tax( $product ));
	$format_price = wp_strip_all_tags($price); // fixed price format
	if ($button_text = get_post_meta( $post->ID, '_wa_order_button_text', true ));
	elseif ($button_text = get_option(sanitize_text_field('wa_order_option_text_button')));
	else $button_text = "Buy via WhatsApp";

	if ($custom_message = get_post_meta( $post->ID, '_wa_order_custom_message', true ));
	else $custom_message = get_option(sanitize_text_field('wa_order_option_message'));

	if ($custom_message== '') $message_price= "Hello, I want to buy:";
	else $message_price= "$custom_message";

	if ($custom_message== '') $message_ex_price= "Hello, I want to buy:";
	else $message_ex_price= "$custom_message";
	
	// Labels
	$price_label = get_option( 'wa_order_option_price_label');
	$url_label = get_option( 'wa_order_option_url_label');
	$thanks_label = get_option( 'wa_order_option_thank_you_label');

	// URL Encoding
	$encode_custom_message_price = urlencode($message_price);
	$encode_custom_message_price_ex_price = urlencode($message_ex_price);
	$encode_title = urlencode($title);
	$encode_product_url = urlencode($product_url);
	$encode_thanks = urlencode($thanks_label);
	$encode_url_label = urlencode($url_label);
	// $format_price = urlencode($price); // old way
	$format_price_label = urlencode($price_label);

	// Message content with price
	$final_message_price = "$encode_custom_message_price%0D%0A%0D%0A*$encode_title*%0D%0A*$format_price_label:*%20$format_price%0D%0A";
	// Remove product URL
	$removeproductURL = get_option(sanitize_text_field('wa_order_exclude_product_url'));
	if ($removeproductURL === 'yes') {
		$final_message_price .= "%0D%0A";
	} else {
		$final_message_price .= "*$encode_url_label:*%20$encode_product_url%0D%0A%0D%0A";
	}
	$final_message_price .= "$encode_thanks";

	// Button URL with price
	// Check if it's mobile or desktop
	// Default WhatsApp base URL
	$iphone     = strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone' );
	$android    = strpos($_SERVER['HTTP_USER_AGENT'], 'Android' );
	$berry      = strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry' );
	$ipod       = strpos($_SERVER['HTTP_USER_AGENT'], 'iPod' );
	$ipad       = strpos($_SERVER['HTTP_USER_AGENT'], 'iPad' );
	$webOS      = strpos($_SERVER['HTTP_USER_AGENT'], 'webOS' );
	$silk       = strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/' );
	$kindle     = strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle' );
	$opera      = strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini' );
	$mobi       = strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi' );
	if ($iphone || $android || $berry || $ipod || $ipad || $webOS || $silk || $kindle || $opera || $mobi == true) {
	  $wa_base = 'api';  
	} else {
		if ( get_option('wa_order_whatsapp_base_url') == 'api') {
		   $wa_base_url = 'api'; 
		} else {
		   $wa_base_url = 'web'; 
		}
	   $wa_base = $wa_base_url; 
	}
	$button_url = "https://$wa_base.whatsapp.com/send?phone=$phone&text=$final_message_price";

	// Message content without price
	$final_message_ex_price = "$encode_custom_message_price_ex_price%0D%0A%0D%0A*$encode_title*%0D%0A";
	// Remove product URL
	$removeproductURL = get_option(sanitize_text_field('wa_order_exclude_product_url'));
	if ($removeproductURL === 'yes') {
		$final_message_ex_price .= "%0D%0A";
	} else {
		$final_message_ex_price .= "*$encode_url_label:*%20$encode_product_url%0D%0A%0D%0A";
	}
	$final_message_ex_price .= "$encode_thanks";
	
	// Button URL without price
	// Check if it's mobile or desktop
	// Default WhatsApp base URL
	$iphone     = strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone' );
	$android    = strpos($_SERVER['HTTP_USER_AGENT'], 'Android' );
	$berry      = strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry' );
	$ipod       = strpos($_SERVER['HTTP_USER_AGENT'], 'iPod' );
	$ipad       = strpos($_SERVER['HTTP_USER_AGENT'], 'iPad' );
	$webOS      = strpos($_SERVER['HTTP_USER_AGENT'], 'webOS' );
	$silk       = strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/' );
	$kindle     = strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle' );
	$opera      = strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini' );
	$mobi       = strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi' );
	if ($iphone || $android || $berry || $ipod || $ipad || $webOS || $silk || $kindle || $opera || $mobi == true) {
	  $wa_base = 'api';  
	} else {
		if ( get_option('wa_order_whatsapp_base_url') == 'api') {
		   $wa_base_url = 'api'; 
		} else {
		   $wa_base_url = 'web'; 
		}
	   $wa_base = $wa_base_url; 
	}
	$button_url_ex_price = "https://$wa_base.whatsapp.com/send?phone=$phone&text=$final_message_ex_price";

	// Create button + URL
	$ex_price = get_option(sanitize_text_field('wa_order_exclude_price'));
	if ($ex_price === 'yes') {
	// Button position
	if ( get_option('wa_order_single_product_button_position') === 'after_atc') {
		echo "<a id=\"sendbtn wa-order-button-click\" href=$button_url_ex_price class=\"wa-order-class\" role=\"button\" target=\"$target\"><button type=\"button\" id=\"sendbtn wa-order-button-click\" class=\"wa-order-button wa-order-button-after-atc single_add_to_cart_button button alt\">$button_text</button></a>";

	} else {

		if ( get_option('wa_order_single_product_button_position') === 'under_atc') {
		echo "<a id=\"sendbtn wa-order-button-click\" href=$button_url_ex_price class=\"wa-order-class\" role=\"button\" target=\"$target\"><button type=\"button\" id=\"sendbtn wa-order-button-click\" class=\"wa-order-button wa-order-button-under-atc button alt\">$button_text</button></a>";
		} elseif ( get_option('wa_order_single_product_button_position') === 'after_shortdesc') {
		echo "<a id=\"sendbtn wa-order-button-click\" href=$button_url_ex_price class=\"wa-order-class\" role=\"button\" target=\"$target\"><button type=\"button\" id=\"sendbtn wa-order-button-click\" class=\"wa-order-button wa-order-button-shortdesc button alt\">$button_text</button></a>";
		}
	}

	} else {
	// Button position
	if ( get_option('wa_order_single_product_button_position') === 'after_atc') {
		echo "<a id=\"sendbtn wa-order-button-click\" href=$button_url class=\"wa-order-class\" role=\"button\" target=\"$target\"><button type=\"button\" id=\"sendbtn wa-order-button-click\" class=\"wa-order-button wa-order-button-after-atc single_add_to_cart_button button alt\">$button_text</button></a>";

	} else {

		if ( get_option('wa_order_single_product_button_position') === 'under_atc') {
		echo "<a id=\"sendbtn wa-order-button-click\" href=$button_url class=\"wa-order-class\" role=\"button\" target=\"$target\"><button type=\"button\" id=\"sendbtn wa-order-button-click\" class=\"wa-order-button wa-order-button-under-atc button alt\">$button_text</button></a>";
		} elseif ( get_option('wa_order_single_product_button_position') === 'after_shortdesc') {
		echo "<a id=\"sendbtn wa-order-button-click\" href=$button_url class=\"wa-order-class\" role=\"button\" target=\"$target\"><button type=\"button\" id=\"sendbtn wa-order-button-click\" class=\"wa-order-button wa-order-button-shortdesc button alt\">$button_text</button></a>";
		}

		}
	}

	// Display GDPR compliant checkbox
	if ($gdpr_status === 'yes') { ?>
	<?php global $product;
	// Get and define phone number, custom message and button text
	global $post;
	// WA Number from Setting
	$wanumberpage = get_option( 'wa_order_selected_wa_number_single_product' );
	$postid = get_page_by_path( $wanumberpage, '', 'wa-order-numbers');
	if( empty( $postid) ) {
		$pid = 0;
	} else {
		$pid = $postid->ID;
	}
	$phonenumb = get_post_meta($pid, 'wa_order_phone_number_input', true);

	// Check if a number is assigned to a product 
	$single_number_check = get_post_meta( $post->ID, '_wa_order_phone_number_check', true );
	if ($single_number_check === 'yes') {
	// WA Number from Metabox
	$wanumber_meta = get_post_meta( $post->ID, '_wa_order_phone_number', true );
	$postid_meta = get_page_by_title( $wanumber_meta, '', 'wa-order-numbers');
	$pid_meta = $postid_meta->ID;
	if( empty( $postid_meta) ) {
		$pid_meta = 0;
	} else {
		$pid_meta = $postid_meta->ID;
	}
	$phonenumb_meta = get_post_meta($pid_meta, 'wa_order_phone_number_input', true);
		$phone = $phonenumb_meta;
	} else {
		$phone = $phonenumb;
	}
	$custom_message = get_option(sanitize_text_field('wa_order_option_message'));
	$target = get_option(sanitize_text_field('wa_order_option_target'));
	$gdpr_privacy_policy = get_option(sanitize_text_field('wa_order_gdpr_privacy_page'));
	$gdpr_status = get_option(sanitize_text_field('wa_order_gdpr_status_enable'));
	$gdpr_message = get_option(sanitize_text_field('wa_order_gdpr_message'));
	$product_url = get_permalink( $product->get_id() );
	$title = $product->get_name();
	$currency = get_woocommerce_currency_symbol();
	// $price = wc_get_price_including_tax( $product ); old way
	$price = wc_price(wc_get_price_including_tax( $product ));
	$format_price = wp_strip_all_tags($price); // fixed price format

	if ($button_text = get_post_meta( $post->ID, '_wa_order_button_text', true ));
	else $button_text = get_option(sanitize_text_field('wa_order_option_text_button'));

	if ($custom_message = get_post_meta( $post->ID, '_wa_order_custom_message', true ));
	else $custom_message = get_option(sanitize_text_field('wa_order_option_message'));

	if ($custom_message== '') $message_price= "Hello, I want to buy:";
	else $message_price= "$custom_message";

	if ($custom_message== '') $message_ex_price= "Hello, I want to buy:";
	else $message_ex_price= "$custom_message";
	
	// Labels
	$price_label = get_option( 'wa_order_option_price_label');
	$url_label = get_option( 'wa_order_option_url_label');
	$thanks_label = get_option( 'wa_order_option_thank_you_label');

	// URL Encoding
	$encode_custom_message_price = urlencode($message_price);
	$encode_custom_message_price_ex_price = urlencode($message_ex_price);
	$encode_title = urlencode($title);
	$encode_product_url = urlencode($product_url);
	$encode_thanks = urlencode($thanks_label);
	$encode_url_label = urlencode($url_label);
	// $format_price = urlencode($price);// old way
	$format_price_label = urlencode($price_label);

	// Check if hide product URL is true
	$removeproductURL = get_option(sanitize_text_field('wa_order_exclude_product_url'));
	if ($removeproductURL === 'yes') {
		$final_product_url = "";
	} else {
		$final_product_url = "*$encode_url_label:*%20$encode_product_url%0D%0A";
	}

	// Message content with price
	$final_message_price = "$encode_custom_message_price%0D%0A%0D%0A*$encode_title*%0D%0A*$format_price_label:*%20$format_price%0D%0A$final_product_url%0D%0A%0D%0A$encode_thanks";

	//Check if it's mobile or desktop
	// Default WhatsApp base URL
	$iphone     = strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone' );
	$android    = strpos($_SERVER['HTTP_USER_AGENT'], 'Android' );
	$berry      = strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry' );
	$ipod       = strpos($_SERVER['HTTP_USER_AGENT'], 'iPod' );
	$ipad       = strpos($_SERVER['HTTP_USER_AGENT'], 'iPad' );
	$webOS      = strpos($_SERVER['HTTP_USER_AGENT'], 'webOS' );
	$silk       = strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/' );
	$kindle     = strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle' );
	$opera      = strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini' );
	$mobi       = strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi' );
	if ($iphone || $android || $berry || $ipod || $ipad || $webOS || $silk || $kindle || $opera || $mobi == true) {
	  $wa_base = 'api';  
	} else {
		if ( get_option('wa_order_whatsapp_base_url') == 'api') {
		   $wa_base_url = 'api'; 
		} else {
		   $wa_base_url = 'web'; 
		}
	   $wa_base = $wa_base_url; 
	}
	$button_url = "https://$wa_base.whatsapp.com/send?phone=$phone&text=$final_message_price";

	// Message content without price
	$final_message_ex_price = "$encode_custom_message_price_ex_price%0D%0A%0D%0A*$encode_title*%0D%0A$final_product_url%0D%0A$encode_thanks";

	//Check if it's mobile or desktop
	// Default WhatsApp base URL
	$iphone     = strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone' );
	$android    = strpos($_SERVER['HTTP_USER_AGENT'], 'Android' );
	$berry      = strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry' );
	$ipod       = strpos($_SERVER['HTTP_USER_AGENT'], 'iPod' );
	$ipad       = strpos($_SERVER['HTTP_USER_AGENT'], 'iPad' );
	$webOS      = strpos($_SERVER['HTTP_USER_AGENT'], 'webOS' );
	$silk       = strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/' );
	$kindle     = strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle' );
	$opera      = strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini' );
	$mobi       = strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi' );
	if ($iphone || $android || $berry || $ipod || $ipad || $webOS || $silk || $kindle || $opera || $mobi == true) {
	  $wa_base = 'api';  
	} else {
		if ( get_option('wa_order_whatsapp_base_url') == 'api') {
		   $wa_base_url = 'api'; 
		} else {
		   $wa_base_url = 'web'; 
		}
	   $wa_base = $wa_base_url; 
	}
	$button_url_ex_price = "https://$wa_base.whatsapp.com/send?phone=$phone&text=$final_message_ex_price";

	// Create button + URL
	$ex_price = get_option(sanitize_text_field('wa_order_exclude_price'));

	if ($ex_price === 'yes') {
	?>
	<script>
		function WAOrder() {
			var phone 	= "<?php echo esc_attr($phone); ?>",
			wa_message 	= "<?php echo esc_attr($message_ex_price); ?>",
			button_url 	= "<?php echo esc_attr($button_url_ex_price); ?>",
			target 		= "<?php echo esc_attr($target); ?>";
		}
	</script>
		<style>
		.wa-order-button, 
		.wa-order-button .wa-order-class {
			display: none !important;
		}
		</style>
		<!-- Button position -->
		<?php if ( get_option('wa_order_single_product_button_position') === 'after_atc') { ?>
			<label class="wa-button-gdpr2">
				<a id="sendbtn" href="<?= $button_url_ex_price ?>" class="gdpr_wa_button" role="button" target="<?= $target ?>">
					<button type="button" id="sendbtn2 wa-order-button-click" class="gdpr_wa_button_input wa-order-button-after-atc single_add_to_cart_button button alt" disabled="disabled" onclick="WAOrder();">
						<?php _e( $button_text ) ?>
					</button>
				</a>
			</label>
		<?php } else { ?>
			<?php if ( get_option('wa_order_single_product_button_position') === 'under_atc') { ?>
				<label class="wa-button-gdpr2">
					<a id="sendbtn" href="<?= $button_url_ex_price ?>" class="gdpr_wa_button" role="button" target="<?= $target ?>">
						<button type="button" id="sendbtn2 wa-order-button-click" class="gdpr_wa_button_input wa-order-button-under-atc button alt" disabled="disabled" onclick="WAOrder();">
							<?php _e( $button_text ) ?>
						</button>
					</a>
				</label>
			<?php } elseif ( get_option('wa_order_single_product_button_position') === 'after_shortdesc') { ?>
					<label class="wa-button-gdpr2">
						<a id="sendbtn" href="<?= $button_url_ex_price ?>" class="gdpr_wa_button" role="button" target="<?= $target ?>">
							<button type="button" id="sendbtn2 wa-order-button-click" class="gdpr_wa_button_input wa-order-button-shortdesc button alt" disabled="disabled" onclick="WAOrder();">
								<?php _e( $button_text ) ?>
							</button>
						</a>
					</label>
				<?php } ?>
			<?php } ?>
		<div class="wa-order-gdprchk">
			<input type="checkbox" name="wa_order_gdpr_status_enable" class="css-checkbox wa_order_input_check" id="gdprChkbx" />
			<label for="gdprChkbx" class="label-gdpr"><?php echo do_shortcode( stripslashes (get_option( 'wa_order_gdpr_message' ))) ?></label>
        </div>
        <script type="text/javascript">
        	document.getElementById('gdprChkbx').addEventListener('click', function (e) {
        	document.getElementById('sendbtn2 wa-order-button-click').disabled = !e.target.checked;
        	});
        </script>
	<?php } else { ?>
		<script>
			function WAOrder() {
				var phone 	= "<?php echo esc_attr($phone); ?>",
				wa_message 	= "<?php echo esc_attr($message_ex_price); ?>",
				button_url 	= "<?php echo esc_attr($button_url_ex_price); ?>",
				target 		= "<?php echo esc_attr($target); ?>";
			}
		</script>
		<style>
		.wa-order-button, 
		.wa-order-button .wa-order-class {
			display: none !important;
		}
		</style>
		<!-- Button position -->
		<?php if ( get_option('wa_order_single_product_button_position') === 'after_atc') { ?>
			<label class="wa-button-gdpr2">
				<a id="sendbtn" href="<?= $button_url ?>" class="gdpr_wa_button" role="button" target="<?= $target ?>">
					<button type="button" id="sendbtn2 wa-order-button-click" class="gdpr_wa_button_input wa-order-button-after-atc single_add_to_cart_button button alt" disabled="disabled" onclick="WAOrder();">
						<?php _e( $button_text ) ?>
					</button>
				</a>
			</label>
		<?php } else { ?>
			<?php if ( get_option('wa_order_single_product_button_position') === 'under_atc') { ?>
				<label class="wa-button-gdpr2">
					<a id="sendbtn" href="<?= $button_url ?>" class="gdpr_wa_button" role="button" target="<?= $target ?>">
						<button type="button" id="sendbtn2 wa-order-button-click" class="gdpr_wa_button_input wa-order-button-under-atc button alt" disabled="disabled" onclick="WAOrder();">
							<?php _e( $button_text ) ?>
						</button>
					</a>
				</label>
				<?php } elseif ( get_option('wa_order_single_product_button_position') === 'after_shortdesc') { ?>
					<label class="wa-button-gdpr2">
						<a id="sendbtn" href="<?= $button_url ?>" class="gdpr_wa_button" role="button" target="<?= $target ?>">
							<button type="button" id="sendbtn2 wa-order-button-click" class="gdpr_wa_button_input wa-order-button-shortdesc button alt" disabled="disabled" onclick="WAOrder();">
								<?php _e( $button_text ) ?>
							</button>
						</a>
					</label>
				<?php } ?>
			<?php } ?>
			
		<div class="wa-order-gdprchk">
			<input type="checkbox" name="wa_order_gdpr_status_enable" class="css-checkbox wa_order_input_check" id="gdprChkbx" />
			<label for="gdprChkbx" name="checkbox1_lbl" class="css-label lite-green-check"><?php echo do_shortcode( stripslashes (get_option( 'wa_order_gdpr_message' ))) ?></label>
        </div>
        <script type="text/javascript">
        	document.getElementById('gdprChkbx').addEventListener('click', function (e) {
    		document.getElementById('sendbtn2 wa-order-button-click').disabled = !e.target.checked;
        	});
        </script>
		<?php
			}
		}
	}
}
if ( get_option('wa_order_single_product_button_position') == 'after_atc') {
    add_action( 'woocommerce_after_add_to_cart_button', 'wa_order_add_button_plugin', 5 );
} elseif ( get_option('wa_order_single_product_button_position') == 'under_atc') {
    add_action( 'woocommerce_after_add_to_cart_form', 'wa_order_add_button_plugin', 5 );
} elseif (get_option('wa_order_single_product_button_position') == 'after_shortdesc') {
	add_action( 'woocommerce_before_add_to_cart_form', 'wa_order_add_button_plugin', 5 );
} else {
	add_action( 'woocommerce_after_add_to_cart_button', 'wa_order_add_button_plugin', 5 );
}

// Single product custom metabox
// Hide button checkbox
add_action('wp_head', 'wa_order_execute_metabox_value');
function wa_order_execute_metabox_value() {
	global $post;
	if ( is_product() && get_post_meta( $post->ID, '_hide_wa_button', true ) == 'yes' ) {
		remove_action( 'woocommerce_after_add_to_cart_button', 'wa_order_add_button_plugin', 5 );
		remove_action( 'woocommerce_after_add_to_cart_form', 'wa_order_add_button_plugin', 5 );
		remove_action( 'woocommerce_before_add_to_cart_form', 'wa_order_add_button_plugin', 5 );
	}
}

// Hide WA button based on categories & tags
add_action('wp_head', 'wa_order_hide_single_taxonomies');
function wa_order_hide_single_taxonomies() {
	global $product, $post; 
	$option_cats = get_option('wa_order_option_exlude_single_product_cats');
	$option_cats_array = (array) $option_cats;
	$option_tags = get_option('wa_order_option_exlude_single_product_tags');
	$option_tags_array = (array) $option_tags;
	
	if ( empty($option_cats) && empty($option_tags)) {
		return;
	}

	if ( is_product() && isset($option_cats) && !empty($option_cats) ) {
		if ( has_term( array_values($option_cats_array)[0], 'product_cat', $post->ID ) ) {
			remove_action( 'woocommerce_after_add_to_cart_button', 'wa_order_add_button_plugin', 5 );
			remove_action( 'woocommerce_after_add_to_cart_form', 'wa_order_add_button_plugin', 5 );
			remove_action( 'woocommerce_before_add_to_cart_form', 'wa_order_add_button_plugin', 5 );
		}
	}
	if ( is_product() && isset($option_tags) && !empty($option_tags) ) {
		if ( has_term( array_values($option_tags_array)[0], 'product_tag', $post->ID ) ) {
			remove_action( 'woocommerce_after_add_to_cart_button', 'wa_order_add_button_plugin', 5 );
			remove_action( 'woocommerce_after_add_to_cart_form', 'wa_order_add_button_plugin', 5 );
			remove_action( 'woocommerce_before_add_to_cart_form', 'wa_order_add_button_plugin', 5 );
		}
	}

}
// Hide ATC button checkbox
add_action('wp_head', 'wa_order_hide_atc_button', 5);
function wa_order_hide_atc_button() {
	global $post;
	if ( is_product() && get_post_meta( $post->ID, '_hide_atc_button', true ) == 'yes' ) {
		add_filter( 'woocommerce_is_purchasable', '__return_false');
    ?>
	<script>
		var elems = document.getElementsByName('add-to-cart');
		for (var i=0;i<elems.length;i+=1){
		  elems[i].style.display = 'none';
		}
	</script>
	<style>
		[name="add-to-cart"],
		.woocommerce-variation-add-to-cart button[type="submit"] {
		display: none!important;
		}
	</style>	
    <?php
}
}

// New way to remove Add to Cart button
add_action('wp_head', 'wa_order_remove_atc_button', 5);
function wa_order_remove_atc_button() {
    $hide_atc_button = get_option(sanitize_text_field('wa_order_option_remove_cart_btn'));
    if ( $hide_atc_button === 'yes') {
    ?>
	<script>
		var elems = document.getElementsByName('add-to-cart');
		for (var i=0;i<elems.length;i+=1){
		  elems[i].style.display = 'none';
		}
	</script>
	<style>
		[name="add-to-cart"],
		.woocommerce-variation-add-to-cart button[type="submit"] {
		display: none!important;
		}
	</style>	
    <?php
}
}

// Force show Add to Cart button product metabox
function wa_order_force_show_atc_button() {
	global $post;
	if ( is_product() && get_post_meta( $post->ID, '_force_show_atc_button', true ) == 'yes' ) {
		remove_action('wp_head', 'wa_order_remove_atc_button', 5);
		remove_action('wp_head', 'wa_order_hide_atc_button', 5);
		}
	}
add_action('wp_head', 'wa_order_force_show_atc_button', 0);

// New way to remove elements on single product page
add_action('wp_head', 'wa_order_function_remove_elements');
function wa_order_function_remove_elements() {
	$hide_price = get_option(sanitize_text_field('wa_order_option_remove_price'));
	$hide_button = get_option(sanitize_text_field('wa_order_option_remove_btn'));
	$hide_button_mobile = get_option(sanitize_text_field('wa_order_option_remove_btn_mobile'));
	//Set option hide price
	if ($hide_price === 'yes') { // Remove price on single product
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    ?>
    <style>
    		.product-summary .woocommerce-Price-amount,
    		.product-summary p.price {
    			display: none !important;
    		}
    </style>
    <?php
}
	if ($hide_button === 'yes') { // Remove WA button on desktop, single product
    ?>
    <style>
    	@media screen and (min-width: 768px) {
    		.wa-order-button, .gdpr_wa_button_input, .wa-order-gdprchk, button.gdpr_wa_button_input:disabled, button.gdpr_wa_button_input {
    			display: none !important;
    		}
    	}	
    }
    </style>
    <?php
}    
	// Don't Remove WA button on desktop, single product
	if ($hide_button === 'no') { // WA button on single product
    ?>
    		<style>
    			@media screen and (min-width: 768px) {
     			.wa-order-button, .gdpr_wa_button_input, .wa-order-gdprchk, button.gdpr_wa_button_input:disabled, button.gdpr_wa_button_input {
    				display: block !important;
    				}
    			}
    		}
    		</style>
    <?php
}    
	// Don't Remove WA button on mobile, single product
	if ($hide_button_mobile === 'no') { // Mobile button on single product
    ?>
    <style>
    	@media screen and (max-width: 768px) {
    	.wa-order-button, .gdpr_wa_button_input, .wa-order-gdprchk, button.gdpr_wa_button_input:disabled, button.gdpr_wa_button_input {
    		display: block !important;
    		}
    	}
    }
    </style>
    <?php
}    
	// Don't Remove WA button on mobile, single product
	if ($hide_button_mobile === 'yes') { // Mobile button on single product
    ?>
    <style>
    		@media screen and (max-width: 768px) {
    		.wa-order-button, .gdpr_wa_button_input, .wa-order-gdprchk, button.gdpr_wa_button_input:disabled, button.gdpr_wa_button_input {
    			display: none !important;
    			}
    		}		
    	}
    </style>
    <?php
}
}