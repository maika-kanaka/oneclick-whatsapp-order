<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

/**
 * @package     OneClick Chat to Order
 * @author      Walter Pinem
 * @link        https://walterpinem.me
 * @link        https://www.seniberpikir.com/oneclick-wa-order-woocommerce/
 * @copyright   Copyright (c) 2019, Walter Pinem, Seni Berpikir
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 * @category    Admin Page
 */

// Include important files
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/buttons/wa-order-cart-page.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/buttons/wa-order-display-options.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/buttons/wa-order-floating-button.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/buttons/wa-order-shop-archive.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/buttons/wa-order-single-product.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/buttons/wa-order-thank-you.php';

// Display admin notice message if confirmation check is unchecked
function wa_order_confirm_if_number_added(){
	$dismiss_notice = get_option('wa_order_option_dismiss_notice_confirmation');
	$error = __( '<strong style="color:red;">Important!</strong> With <strong>OneClick Chat to Order</strong>, you can now set multiple WhatsApp numbers. Please <a href="edit.php?post_type=wa-order-numbers"><strong>set it here</strong></a> to get started. <a href="https://walterpinem.me/projects/oneclick-chat-to-order-mutiple-numbers-feature/?utm_source=admin-notice&utm_medium=admin-dashboard&utm_campaign=OneClick-Chat-to-Order" target="_blank"><strong>Learn more</strong></a>. <a href="admin.php?page=wa-order&tab=button_config">Dismiss</a>', 'oneclick-wa-order' );
	if ( $dismiss_notice !== 'yes' ) {
		printf( __( '<div class="notice wa-order-notice-dismissible notice-warning is-dismissible">%s</div>', 'oneclick-wa-order' ), $error );
	}
}
add_action('admin_notices', 'wa_order_confirm_if_number_added');

// Global Shortcode Function
function wa_order_shortcode_button( $atts, $content = null ) {
		global $post;
        // WA Number from Setting
        $wanumberpage = get_option( 'wa_order_selected_wa_number_shortcode' );
        $postid = get_page_by_path( $wanumberpage, '', 'wa-order-numbers');
        if( empty( $postid) ) {
            $pid = 0;
        } else {
            $pid = $postid->ID;;
        }
        $phonenumb = get_post_meta($pid, 'wa_order_phone_number_input', true);

        $target_blank = get_option('wa_order_shortcode_target');
        $custom_message = get_option('wa_order_shortcode_message');

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
        if ($iphone || $android || $berry || $ipod || $ipad || $webOS || $silk || $kindle || $opera || $mobi !== false ) {
          $wa_base = 'api';  
        } else {
            if ( get_option('wa_order_whatsapp_base_url') == 'api') {
               $wa_base_url = 'api'; 
            } else {
               $wa_base_url = 'web'; 
            }
           $wa_base = $wa_base_url; 
        }

        // Define shortcode button click target
        if ( $target_blank === '_blank' ) {
            $blank = 'target="_blank"';
        } else {
            $blank = '';
        }
   	 	if ( $button_text = get_option(sanitize_text_field('wa_order_shortcode_text_button')) )
 		//Check text button is filled or not
    	$out = "<a id=\"sendbtn\" class=\"shortcode_wa_button\" href=\"https://".$wa_base.".whatsapp.com/send?phone=" .$phonenumb. "&text=" . $custom_message . "\" ".$blank."><span>" .do_shortcode($content). "$button_text</span></a>";
    	else
    	$out = "<a id=\"sendbtn\" class=\"shortcode_wa_button_nt\" href=\"https://".$wa_base.".whatsapp.com/send?phone=" .$phonenumb. "&text=" . $custom_message . "\" ".$blank."><span>" .do_shortcode($content). "</span></a>";
    	return $out;
}
add_shortcode('wa-order', 'wa_order_shortcode_button');

// Dynamic Shortcode Generator
// Shortcode: [waorder phone="" button="" message="" target=""]
function wa_order_shortcode_generator_button($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'phone'     => '',
            'button'    => '',
            'message'   => '',
            'target'    => '',
        ),
        $atts,
        'waorder'
    );
    $phone      = $atts['phone'];
    $button     = $atts['button'];
    $message    = $atts['message'];
    $target     = $atts['target'];
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
    if ($iphone || $android || $berry || $ipod || $ipad || $webOS || $silk || $kindle || $opera || $mobi !== false ) {
      $wa_base = 'api';  
    } else {
        if ( get_option('wa_order_whatsapp_base_url') == 'api') {
           $wa_base_url = 'api'; 
        } else {
           $wa_base_url = 'web'; 
        }
       $wa_base = $wa_base_url; 
    }
    // Define shortcode button click target
    if ( 'yes' == $atts['target']) {
        $blank = 'target="_blank"';
    } else {
        $blank = '';
    }
    // Build the output
    $output     = "<a id=\"sendbtn\" class=\"shortcode_wa_button\" href=\"https://".$wa_base.".whatsapp.com/send?phone=" .$phone. "&text=" . $message . "\" ".$blank."><span>" .do_shortcode($content). "$button</span></a>";
    return $output;
}
add_shortcode( 'waorder', 'wa_order_shortcode_generator_button' );

// Convert phone number link into WhatsApp chat link in Order Details page
function wa_order_convert_phone_link() {
	$convert_phone_no = get_option(sanitize_text_field('wa_order_option_convert_phone_order_details'));
	if ( $convert_phone_no === 'yes' ) { ?>
		<script text/javascript>
			function wa_order_chage_href(){
			var number=document.querySelector(".address p:nth-of-type(3) a").text;
			if (number !=null){
			var changephonelinktowhatsapp="https://wa.me/"+number;
			document.querySelector(".address p:nth-of-type(3) a").setAttribute("href", changephonelinktowhatsapp);
			}
			}window.onload=wa_order_chage_href;
		</script>
     <?php
    }     
}
if ( is_admin()) { 
	add_action('admin_head','wa_order_convert_phone_link');
}