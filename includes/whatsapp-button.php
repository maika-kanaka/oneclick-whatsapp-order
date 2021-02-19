<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

/**
 * @package     OneClick Chat to Order
 * @author      Walter Pinem
 * @link        https://walterpinem.me
 * @link        https://www.seniberpikir.com/oneclick-whatsapp-order-woocommerce/
 * @copyright   Copyright (c) 2019, Walter Pinem, Seni Berpikir
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 * @category    Admin Page
 */

function wa_order_add_button_plugin() {
	//get and define phone number, custom message and button text
	$phone = get_option(sanitize_text_field('wa_order_option_phone_number'));
	$custom_message = get_option(sanitize_text_field('wa_order_option_message'));
	$button_text = get_option(sanitize_text_field('wa_order_option_text_button'));
	$target = get_option(sanitize_text_field('wa_order_option_target'));
	$hide_button = get_option(sanitize_text_field('wa_order_option_remove_btn'));
	$gdpr_privacy_policy = get_option(sanitize_text_field('wa_order_gdpr_privacy_page'));
	$gdpr_status = get_option(sanitize_text_field('wa_order_gdpr_status_enable'));
	$gdpr_message = get_option(sanitize_text_field('wa_order_gdpr_message'));
	$hide_price = get_option(sanitize_text_field('wa_order_option_remove_price'));
	$hide_atc_button = get_option(sanitize_text_field('wa_order_option_remove_cart_btn'));
	
	//Set option hide add to cart button
	if ($hide_atc_button === 'yes') {
		?>
	<style>
		.wa-order-button, .gdpr_wa_button_input input[type="submit"], .gdpr_wa_button_input, .wa-order-gdprchk, .wa-order-gdprchk label {
			display: inline-block !important;
		}
		button.single_add_to_cart_button {
			display: none !important;
		}
	</style>
		<?php
	}
		
	//Set option hide price
	if ($hide_price === 'yes') {
		?>
	<style>
			.woocommerce-Price-amount {
				display: none !important;
			}
	</style>
		<?php
	}

	// If yes, hide button on desktop
	if ($hide_button === 'yes') { ?>
	<style>
			.wa-order-button, .gdpr_wa_button_input input[type="submit"], .gdpr_wa_button_input, .wa-order-gdprchk, .wa-order-gdprchk label {
				display: none !important;
			}
		@media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
			.wa-order-button, .gdpr_wa_button_input input[type="submit"], .gdpr_wa_button_input, .wa-order-gdprchk, .wa-order-gdprchk label {
				display: inline-block !important;
				}
			}
		}
	</style>
		<?php
	}
	
	// Get the product info
	global $product;
	$product_url = get_permalink( $product->get_id() );
	$title = $product->get_name();
	$currency = get_woocommerce_currency_symbol();
	$price = wc_get_price_including_tax( $product );
	$format_price = number_format($price, 2, ',', '.');

	// Generate encoded URL
	$title_text = "*$title*";
	$fp_text = $format_price;
	$url_text = "URL: $product_url";
	$custom_message = get_option(sanitize_text_field('wa_order_option_message'));
	$encode_msg = urlencode($custom_message);
	$encode_title = urlencode($title_text);
	$encode_url = urlencode($url_text);
	$encode_fp = urlencode($fp_text);
	$wa_message = "$encode_msg%0D%0A%0D%0A$encode_title%0D%0A$encode_url";
	$wa_message_price = "$encode_msg%0D%0A%0D%0A$encode_title%0D%0A$currency%20$encode_fp%0D%0A$encode_url";

	// Create button + URL
	$button_url = "https://wa.me/$phone?text=$wa_message";
	$button_url_price = "https://wa.me/$phone?text=$wa_message_price";
	$ex_price = get_option(sanitize_text_field('wa_order_exclude_price'));
	if ($ex_price === 'yes') {
	echo "<a class=\"wa-order-button single_add_to_cart_button button\" href=$button_url class=\"wa-order-class\" role=\"button\" target=\"$target\">$button_text</button></a>";
	} else {
		echo "<a class=\"wa-order-button single_add_to_cart_button button\" href=$button_url_price class=\"wa-order-class\" role=\"button\" target=\"$target\">$button_text</button></a>";
	}

	
	// Display GDPR compliant checkbox
	if ($gdpr_status === 'yes') { ?>
	<?php global $product;
	$phone = get_option(sanitize_text_field('wa_order_option_phone_number'));
	$custom_message = get_option(sanitize_text_field('wa_order_option_message'));
	$button_text = get_option(sanitize_text_field('wa_order_option_text_button'));
	$target = get_option(sanitize_text_field('wa_order_option_target'));
	$gdpr_privacy_policy = get_option(sanitize_text_field('wa_order_gdpr_privacy_page'));
	$gdpr_status = get_option(sanitize_text_field('wa_order_gdpr_status_enable'));
	$gdpr_message = get_option(sanitize_text_field('wa_order_gdpr_message'));
	$product_url = get_permalink( $product->get_id() );
	$title = $product->get_name();
	$currency = get_woocommerce_currency_symbol();
	$price = wc_get_price_including_tax( $product );
	$format_price = number_format($price, 2, ',', '.');

	//create link and encode to paste in url
	$title_text = "*$title*";
	$fp_text = $format_price;
	$url_text = "URL: $product_url";
	$encode_msg = urlencode($custom_message);
	$encode_title = urlencode($title_text);
	$encode_url = urlencode($url_text);
	$encode_fp = urlencode($fp_text);
	$wa_message = "$encode_msg%0D%0A%0D%0A$encode_title%0D%0A$encode_url";
	$wa_message_price = "$encode_msg%0D%0A%0D%0A$encode_title%0D%0A$currency%20$encode_fp%0D%0A$encode_url";

	// Create button + URL
	$button_url = "https://wa.me/$phone?text=$wa_message";
	$button_url_price = "https://wa.me/$phone?text=$wa_message_price";
	$ex_price = get_option(sanitize_text_field('wa_order_exclude_price'));

	if ($ex_price === 'yes') {
	?>
		<style>
		.wa-order-button, 
		.wa-order-button .wa-order-class {
			display: none !important;
		}	 
		</style>
	<label>
		<a href="<?= $button_url ?>" class="gdpr_wa_button single_add_to_cart_button" role="button" target="<?= $target ?>">
			<button type="button" id="sendbtn" class="gdpr_wa_button_input" disabled="disabled" onclick="WhatsAppOrder()">
				<?php _e( $button_text ) ?>
			</button>
		</a>
	</label>
		<div class="wa-order-gdprchk">
            <label>
	            <input type="checkbox" name="wa_order_gdpr_status_enable" class="wa_order_input_check" id="gdprChkbx">
					<?php echo do_shortcode( stripslashes (get_option( 'wa_order_gdpr_message' ))) ?>
            </label>
        </div>
			<script type="text/javascript">
				document.getElementById('gdprChkbx').addEventListener('click', function (e) {
  				document.getElementById('sendbtn').disabled = !e.target.checked;
				});
			</script>
			<script>
				function WhatsAppOrder() {
					var phone = "<?php echo esc_attr($phone); ?>",
						wa_message = "<?php echo esc_attr($wa_message); ?>";
						button_url = "<?php echo esc_attr($button_url); ?>";
						$target = "<?php echo esc_attr($target); ?>";
				}
			</script>
	<?php } else { ?>
		<style>
		.wa-order-button, 
		.wa-order-button .wa-order-class {
			display: none !important;
		}
		</style>
	<label>
		<a href="<?= $button_url_price ?>" class="gdpr_wa_button single_add_to_cart_button" role="button" target="<?= $target ?>">
			<button type="button" id="sendbtn" class="gdpr_wa_button_input" disabled="disabled" onclick="WhatsAppOrder()">
				<?php _e( $button_text ) ?>
			</button>
		</a>
	</label>
		<div class="wa-order-gdprchk">
            <label>
	            <input type="checkbox" name="wa_order_gdpr_status_enable" class="wa_order_input_check" id="gdprChkbx">
					<?php echo do_shortcode( stripslashes (get_option( 'wa_order_gdpr_message' ))) ?>
            </label>
        </div>
			<script type="text/javascript">
				document.getElementById('gdprChkbx').addEventListener('click', function (e) {
  				document.getElementById('sendbtn').disabled = !e.target.checked;
				});
			</script>
			<script>
				function WhatsAppOrder() {
					var phone = "<?php echo esc_attr($phone); ?>",
						wa_message = "<?php echo esc_attr($wa_message_price); ?>";
						button_url = "<?php echo esc_attr($button_url_price); ?>";
						$target = "<?php echo esc_attr($target); ?>";
				}
			</script>

		<?php
	}
}
}
add_action( 'woocommerce_after_add_to_cart_button', 'wa_order_add_button_plugin', 5 );


// Display error message if basic configuration is empty
function wa_order_check_input_empty(){
	$phone = get_option('wa_order_option_phone_number');
	$custom_message = get_option('wa_order_option_message');
	$button_text = get_option('wa_order_option_text_button');
	$error = __( '<p><strong>WhatsApp Order</strong> requires <strong> WhatsApp Number!</strong> <a href="?page=whatsapp-order&tab=button_config"><strong>Click here</strong></a> to fill it.</p>', 'oneclick-whatsapp-order' );
	
	if ( $phone === '' || $custom_message === '' || $button_text === '' ) {
		printf( __( '<div class="error">%s</div>', 'oneclick-whatsapp-order' ), $error );
	}
}
add_action('admin_notices', 'wa_order_check_input_empty');

// GDPR Page Selection
if ( ! function_exists( 'wa_order_options_dropdown' ) ) {
	function wa_order_options_dropdown( $args ) {
		global $wpdb;
		$query 		= $wpdb->get_results( "SELECT post_name, post_title FROM {$wpdb->posts} WHERE post_type = 'page'", ARRAY_A );
		$name 		= ( $args['name'] ) ? 'name="' . $args['name'] . '" ' : '';
		$multiple = ( isset( $args['multiple'] ) ) ? 'multiple' : '';
		echo '<select '.$name .' id="" class="wa_order-admin-select2 regular-text" '. $multiple .' >';		
			foreach ( $query as $key => $value ) {
				if ( $args['selected'] ) {
					if ( $multiple ) {
						if ( in_array( $value['post_name'], $args['selected']) ) {
							$selected = 'selected="selected"';
						} else {
							$selected = '';
						}
					} else {
						if ( $value['post_name'] == $args['selected'] ) {
							$selected = 'selected="selected"';
						} else {
							$selected = '';
						}
					}
				}
				echo '<option value="'.$value['post_name'].'" '. $selected .'>'.$value['post_title'].'</option>';		
			}
		echo '</select>';
	}
}

// Display Floating Button
function display_floating_button() {
	$floating = get_option(sanitize_text_field('wa_order_floating_button'));
	$floating_position = get_option(sanitize_text_field('wa_order_floating_button_position'));
	$floating_message = get_option(sanitize_text_field('wa_order_floating_message'));
	$floating_target = get_option(sanitize_text_field('wa_order_floating_target'));
	$button_text = get_option(sanitize_text_field('wa_order_option_text_button'));
	$target = get_option(sanitize_text_field('wa_order_option_target'));
	$phone = get_option('wa_order_option_phone_number');
	$custom_message = get_option('wa_order_option_message');
	$floating_link = "https://wa.me/$phone?text=$floating_message";
	$tooltip_enable = get_option(sanitize_text_field('wa_order_floating_tooltip_enable'));
	$tooltip = get_option(sanitize_text_field('wa_order_floating_tooltip'));
	$floating_mobile = get_option(sanitize_text_field('wa_order_floating_hide_mobile'));

	    if ( $floating === 'yes' && $floating_position === 'left' ) { ?>
			<a class="floating_button" href="<?php echo $floating_link ?>" role="button" target="<?php echo $floating_target ?>">
				<i class="fab fa-whatsapp"></i>
			</a>

				<style>
					.floating_button {
						left: 20px;
					}
					@media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
					    .floating_button {
					        left: 10px!important;
					    }
					}
				</style>

	 	<?php  } elseif ( $floating === 'yes' && $floating_position === 'right' ) { ?>
		<a class="floating_button" href="<?php echo $floating_link ?>" role="button" target="<?php echo $floating_target ?>">		
			<i class="fab fa-whatsapp"></i>
		</a>
			<style>
				.floating_button {
					right: 20px;
				}
				@media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
				    .floating_button {
				        right: 10px!important;
				    }
				}
			</style>			
     <?php
    }
}
add_filter('wp_head', 'display_floating_button');

// Display Floating Button with Tooltip
function display_floating_tooltip() {
	$floating = get_option(sanitize_text_field('wa_order_floating_button'));
	$floating_position = get_option(sanitize_text_field('wa_order_floating_button_position'));
	$floating_message = get_option(sanitize_text_field('wa_order_floating_message'));
	$floating_target = get_option(sanitize_text_field('wa_order_floating_target'));
	$button_text = get_option(sanitize_text_field('wa_order_option_text_button'));
	$target = get_option(sanitize_text_field('wa_order_option_target'));
	$phone = get_option('wa_order_option_phone_number');
	$custom_message = get_option('wa_order_option_message');
	$floating_link = "https://wa.me/$phone?text=$floating_message";
	$tooltip_enable = get_option(sanitize_text_field('wa_order_floating_tooltip_enable'));
	$tooltip = get_option(sanitize_text_field('wa_order_floating_tooltip'));
	$floating_mobile = get_option(sanitize_text_field('wa_order_floating_hide_mobile'));

			if ( $floating === 'yes' && $floating_position === 'left' && $tooltip_enable === 'yes' ) { ?>
				<a href="<?php echo $floating_link ?>" role="button" target="<?php echo $floating_target ?>" class="floating_button">
				    <i class="fab fa-whatsapp"></i>
				</a>
				<div class="label-container">
				    <i class="fa fa-caret-left label-arrow"></i>
				    <div class="label-text"><i class="fas fa-comments"></i>
				        <?php echo $tooltip ?>
				    </div>
				</div>
			<style>
			.floating_button {
				left: 20px;
			}
				.label-container {
  					left: 85px;
				}	
				.label-text i {
				    margin-right: 5px;
				}			
			</style>
		<?php  } elseif ( $floating === 'yes' && $floating_position === 'right' && $tooltip_enable === 'yes' ) { ?>
				<a href="<?php echo $floating_link ?>" role="button" target="<?php echo $floating_target ?>" class="floating_button">
					<i class="fab fa-whatsapp"></i>
				</a>
				<div class="label-container">
					<div class="label-text">
						<?php echo $tooltip ?> 
						<i class="fas fa-comments"></i>
					</div>
					<i class="fa fa-caret-right label-arrow"></i>
				</div>	
			<style>
				.floating_button {
					right: 20px;
				}
				.label-container {
  					right: 85px;
				}	
				.label-text i {
				    margin-left: 5px;
				}				
			</style>	
     <?php
    }
}
add_filter('wp_head', 'display_floating_tooltip');

// Hide Button on Mobile
function hide_floating_button() {
	$floating_mobile = get_option(sanitize_text_field('wa_order_floating_hide_mobile'));
	if ( $floating_mobile === 'yes' ) { ?>
			<style>
			@media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
				.floating_button {
					display: none !important;
				}
			}		
			</style>
     <?php
    }     
}
add_filter('wp_head', 'hide_floating_button');

// Shortcode Function
function wa_order_shortcode_button( $atts, $content = null ) {
		$phone = get_option('wa_order_option_phone_number');
        $target_blank = "target=\"_blank\"";
        $custom_message = get_option('wa_order_shortcode_message');

    if ( $button_text = get_option(sanitize_text_field('wa_order_shortcode_text_button')) )
    $out = "<a class=\"shortcode_wa_button\" href=\"https://wa.me/" .$phone. "?text=" . $custom_message . "\"" .$target_blank."><span>" .do_shortcode($content). "$button_text</span></a>";
    else
    	$out = "<a class=\"shortcode_wa_button_nt\" href=\"https://wa.me/" .$phone. "?text=" . $custom_message . "\"" .$target_blank."><span>" .do_shortcode($content). "</span></a>";
    return $out;
}
add_shortcode('wa-order', 'wa_order_shortcode_button');

// Hide Product Quantity
function wa_order_remove_quantity( $return, $product ) {
	if ( get_option(sanitize_text_field('wa_order_option_remove_quantity')) )
    return true;
}
add_filter( 'woocommerce_is_sold_individually', 'wa_order_remove_quantity', 10, 2 );