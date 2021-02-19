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

// Donate button
function wa_order_donate_button_shortcode( $atts , $content = null ) {
  return '<center>
<div class="donate-container">
<p>To keep this plugin free, I spent cups of coffee building it. If you love and find it really useful for your business, you can always</p>
<a href="https://www.paypal.me/WalterPinem" target="_blank">
<button class="donatebutton">
  ☕ Buy Me a Coffee
  </button>
</a>
</div>
</center>';
}
add_shortcode( 'donate', 'wa_order_donate_button_shortcode' );

// WA Number Post Type Submenu
function wa_order_add_number_submenu() {
    add_submenu_page('wa-order','OneClick Chat to Order Options', 'Global Settings','manage_options', 'admin.php?page=wa-order&tab=welcome' );
    add_submenu_page('wa-order','WhatsApp Numbers', 'WhatsApp Numbers','manage_options', 'edit.php?post_type=wa-order-numbers' );
    add_submenu_page('wa-order','Add Number', 'Add New Number','manage_options', 'post-new.php?post_type=wa-order-numbers' );
};
add_action( 'admin_menu', 'wa_order_add_number_submenu' );

// Build plugin admin setting page
function wa_order_add_admin_page() {
// Generate Chat to Order Admin Page
add_menu_page( 'OneClick Chat to Order Options', 'Chat to Order', 'manage_options', 'wa-order', 'wa_order_create_admin_page', plugin_dir_url( dirname( __FILE__ ) ) . '/assets/images/wa-icon.svg', 98 );
// Begin building
add_action( 'admin_init', 'wa_order_register_settings' );
}
add_action( 'admin_menu', 'wa_order_add_admin_page' );
function wa_order_register_settings() {

    // Register the settings
    // Basic tab options
    // register_setting( 'wa-order-settings-group-button-config', 'wa_order_option_phone_number' ); // Old phone number option
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_selected_wa_number_single_product' ); // New phone number 
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_option_dismiss_notice_confirmation' ); // dismiss notice after adding at least one WA number
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_whatsapp_base_url' ); // dismiss notice after adding at least one WA number
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_single_product_button_position' ); // button position
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_option_enable_single_product' );
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_option_message' );
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_option_text_button' );
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_option_target' );
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_exclude_price' );
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_exclude_product_url' );
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_option_quantity_label' );
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_option_price_label' );
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_option_url_label' );
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_option_total_amount_label' );
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_option_payment_method_label' );
    register_setting( 'wa-order-settings-group-button-config', 'wa_order_option_thank_you_label' );
    // Display tab options
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_bg_color' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_bg_hover_color' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_txt_color' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_txt_hover_color' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_btn_box_shdw' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_bshdw_horizontal' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_bshdw_vertical' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_bshdw_blur' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_bshdw_spread' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_bshdw_position' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_btn_box_shdw_hover' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_bshdw_horizontal_hover' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_bshdw_vertical_hover' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_bshdw_blur_hover' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_bshdw_spread_hover' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_bshdw_position_hover' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_option_remove_btn' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_option_remove_btn_mobile' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_option_remove_price' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_option_remove_cart_btn' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_option_remove_quantity' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_option_exlude_single_product_cats' ); // Single product category exclusion 
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_option_exlude_single_product_tags' ); // Single product tag exclusion
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_single_button_margin_top' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_single_button_margin_right' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_single_button_margin_bottom' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_single_button_margin_left' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_single_button_padding_top' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_single_button_padding_right' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_single_button_padding_bottom' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_single_button_padding_left' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_display_option_shop_loop_hide_desktop' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_display_option_shop_loop_hide_mobile' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_option_exlude_shop_product_cats' ); // Shop loop product category exclusion
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_exlude_shop_product_cats_archive' ); // Shop loop product category archive
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_option_exlude_shop_product_tags' ); // Shop loop product tag exclusion
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_exlude_shop_product_tags_archive' ); // Shop loop product tag archive    
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_display_option_cart_hide_desktop' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_display_option_cart_hide_mobile' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_display_option_checkout_hide_desktop' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_display_option_checkout_hide_mobile' );
    register_setting( 'wa-order-settings-group-display-options', 'wa_order_option_convert_phone_order_details' );
    // GDPR tab options
    register_setting( 'wa-order-settings-group-gdpr', 'wa_order_gdpr_status_enable' );
    register_setting( 'wa-order-settings-group-gdpr', 'wa_order_gdpr_message' );
    register_setting( 'wa-order-settings-group-gdpr', 'wa_order_gdpr_privacy_page' );
    // Floating Button tab options
    register_setting( 'wa-order-settings-group-floating', 'wa_order_selected_wa_number_floating' ); // New phone number option
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_button' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_button_position' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_message' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_target' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_tooltip_enable' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_tooltip' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_hide_mobile' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_hide_desktop' ); // Hide floating button desktop
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_source_url' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_source_url_label' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_hide_all_single_posts' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_hide_all_single_pages' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_hide_specific_posts' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_hide_specific_pages' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_hide_product_cats' );
    register_setting( 'wa-order-settings-group-floating', 'wa_order_floating_hide_product_tags' );
    // Shortcode tab options
    register_setting( 'wa-order-settings-group-shortcode', 'wa_order_selected_wa_number_shortcode' ); // New phone number option
    register_setting( 'wa-order-settings-group-shortcode', 'wa_order_shortcode_message' );
    register_setting( 'wa-order-settings-group-shortcode', 'wa_order_shortcode_text_button' );
    register_setting( 'wa-order-settings-group-shortcode', 'wa_order_shortcode_target' );
    // Cart page tab options
    register_setting( 'wa-order-settings-group-cart-options', 'wa_order_selected_wa_number_cart' ); // New phone number option
    register_setting( 'wa-order-settings-group-cart-options', 'wa_order_option_add_button_to_cart' );
    register_setting( 'wa-order-settings-group-cart-options', 'wa_order_option_cart_custom_message' );
    register_setting( 'wa-order-settings-group-cart-options', 'wa_order_option_cart_button_text' );
    register_setting( 'wa-order-settings-group-cart-options', 'wa_order_option_cart_hide_checkout' );
    register_setting( 'wa-order-settings-group-cart-options', 'wa_order_option_cart_hide_product_url' );
    register_setting( 'wa-order-settings-group-cart-options', 'wa_order_option_cart_open_new_tab' );
    register_setting( 'wa-order-settings-group-cart-options', 'wa_order_option_cart_enable_variations' );
    // Thank You page tab options
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_selected_wa_number_thanks' ); // New phone number option
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_thank_you_redirect_checkout' );
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_enable_button_thank_you' );
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_custom_thank_you_title' );
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_custom_thank_you_subtitle' );
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_custom_thank_you_button_text' );
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_custom_thank_you_custom_message' );
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_custom_thank_you_include_order_date' ); // Include order date
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_custom_thank_you_order_number' ); // Include order number
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_custom_thank_you_order_number_label' ); // Include order number label
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_custom_thank_you_open_new_tab' );
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_custom_thank_you_customer_details_label' ); // customer details label
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_custom_thank_you_include_sku' ); // include product SKU
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_custom_thank_you_inclue_coupon' );
    register_setting( 'wa-order-settings-group-order-completion', 'wa_order_option_custom_thank_you_coupon_label' );
    // Shop page tab options
    register_setting( 'wa-order-settings-group-shop-loop', 'wa_order_selected_wa_number_shop' ); // New phone number option
    register_setting( 'wa-order-settings-group-shop-loop', 'wa_order_option_enable_button_shop_loop' );
    register_setting( 'wa-order-settings-group-shop-loop', 'wa_order_option_hide_atc_shop_loop' );
    register_setting( 'wa-order-settings-group-shop-loop', 'wa_order_option_button_text_shop_loop' );
    register_setting( 'wa-order-settings-group-shop-loop', 'wa_order_option_custom_message_shop_loop' );
    register_setting( 'wa-order-settings-group-shop-loop', 'wa_order_option_shop_loop_hide_product_url' );
    register_setting( 'wa-order-settings-group-shop-loop', 'wa_order_option_shop_loop_exclude_price' );
    register_setting( 'wa-order-settings-group-shop-loop', 'wa_order_option_shop_loop_open_new_tab' );
}

    // Delete option upon deactivation
function wa_order_deactivation() {
    // delete_option( 'wa_order_option_phone_number' ); // Old phone number option
    delete_option( 'wa_order_selected_wa_number' ); // New phone number option
    delete_option( 'wa_order_option_dismiss_notice_confirmation' );
    delete_option( 'wa_order_whatsapp_base_url' );
    delete_option( 'wa_order_single_product_button_position' );
    delete_option( 'wa_order_option_enable_single_product' );
    delete_option( 'wa_order_option_message' );
    delete_option( 'wa_order_option_text_button' );
    delete_option( 'wa_order_option_target' );
    delete_option( 'wa_order_exclude_product_url' );
    delete_option( 'wa_order_option_remove_btn' );
    delete_option( 'wa_order_option_remove_btn_mobile' );
    delete_option( 'wa_order_option_remove_price' );
    delete_option( 'wa_order_option_remove_cart_btn' );
    delete_option( 'wa_order_option_remove_quantity' );
    delete_option( 'wa_order_option_exlude_single_product_cats' );
    delete_option( 'wa_order_option_exlude_single_product_tags' );
    delete_option( 'wa_order_single_button_margin_top' );
    delete_option( 'wa_order_single_button_margin_right' );
    delete_option( 'wa_order_single_button_margin_bottom' );
    delete_option( 'wa_order_single_button_margin_left' );
    delete_option( 'wa_order_single_button_padding_top' );
    delete_option( 'wa_order_single_button_padding_right' );
    delete_option( 'wa_order_single_button_padding_bottom' );
    delete_option( 'wa_order_single_button_padding_left' );
    delete_option( 'wa_order_exlude_shop_product_cats_archive' );
    delete_option( 'wa_order_exlude_shop_product_tags_archive' );
    delete_option( 'wa_order_display_option_shop_loop_hide_desktop' );
    delete_option( 'wa_order_display_option_shop_loop_hide_mobile' );
    delete_option( 'wa_order_btn_box_shdw' );
    delete_option( 'wa_order_bshdw_horizontal' );
    delete_option( 'wa_order_bshdw_vertical' );
    delete_option( 'wa_order_bshdw_blur' );
    delete_option( 'wa_order_bshdw_spread' );
    delete_option( 'wa_order_bshdw_position' );
    delete_option( 'wa_order_option_exlude_shop_product_cats' );
    delete_option( 'wa_order_option_exlude_shop_product_tags' );
    delete_option( 'wa_order_display_option_cart_hide_desktop' );
    delete_option( 'wa_order_display_option_cart_hide_mobile' );
    delete_option( 'wa_order_display_option_checkout_hide_desktop' );
    delete_option( 'wa_order_display_option_checkout_hide_mobile' );
    delete_option( 'wa_order_option_convert_phone_order_details' );
    delete_option( 'wa_order_gdpr_status_enable' );
    delete_option( 'wa_order_gdpr_message' );
    delete_option( 'wa_order_gdpr_privacy_page' );
    delete_option( 'wa_order_floating_button' );
    delete_option( 'wa_order_floating_button_position' );
    delete_option( 'wa_order_floating_message' );
    delete_option( 'wa_order_floating_target' );
    delete_option( 'wa_order_floating_tooltip_enable' );
    delete_option( 'wa_order_floating_tooltip' );
    delete_option( 'wa_order_floating_hide_mobile' );
    delete_option( 'wa_order_floating_hide_desktop' );
    delete_option( 'wa_order_floating_source_url' );
    delete_option( 'wa_order_floating_source_url_label' );
    delete_option( 'wa_order_floating_hide_all_single_posts' );
    delete_option( 'wa_order_floating_hide_all_single_pages' );
    delete_option( 'wa_order_floating_hide_specific_posts' );
    delete_option( 'wa_order_floating_hide_specific_pages' );
    delete_option( 'wa_order_floating_hide_product_cats' );
    delete_option( 'wa_order_floating_hide_product_tags' );
    delete_option( 'wa_order_shortcode_message' );
    delete_option( 'wa_order_shortcode_text_button' );
    delete_option( 'wa_order_shortcode_target' );
    delete_option( 'wa_order_option_add_button_to_cart' );
    delete_option( 'wa_order_option_cart_custom_message' );
    delete_option( 'wa_order_option_cart_button_text' );
    delete_option( 'wa_order_option_cart_hide_checkout' );
    delete_option( 'wa_order_option_cart_hide_product_url' );
    delete_option( 'wa_order_option_cart_open_new_tab' );
    delete_option( 'wa_order_option_cart_enable_variations' );
    delete_option( 'wa_order_option_quantity_label' );
    delete_option( 'wa_order_option_price_label' );
    delete_option( 'wa_order_option_url_label' );
    delete_option( 'wa_order_option_total_amount_label' );
    delete_option( 'wa_order_option_payment_method_label' );
    delete_option( 'wa_order_option_thank_you_label' ); 
    delete_option( 'wa_order_option_thank_you_redirect_checkout' );
    delete_option( 'wa_order_option_enable_button_thank_you' );
    delete_option( 'wa_order_option_custom_thank_you_title' ); 
    delete_option( 'wa_order_option_custom_thank_you_subtitle' );
    delete_option( 'wa_order_option_custom_thank_you_button_text' );
    delete_option( 'wa_order_option_custom_thank_you_custom_message' );
    delete_option( 'wa_order_option_custom_thank_you_include_order_date' );
    delete_option( 'wa_order_option_custom_thank_you_order_number' );
    delete_option( 'wa_order_option_custom_thank_you_order_number_label' );
    delete_option( 'wa_order_option_custom_thank_you_open_new_tab' );
    delete_option( 'wa_order_option_custom_thank_you_customer_details_label' );
    delete_option( 'wa_order_option_custom_thank_you_include_sku' );
    delete_option( 'wa_order_option_custom_thank_you_inclue_coupon' );
    delete_option( 'wa_order_option_custom_thank_you_coupon_label' );
    delete_option( 'wa_order_option_enable_button_shop_loop' ); 
    delete_option( 'wa_order_option_hide_atc_shop_loop' );
    delete_option( 'wa_order_option_button_text_shop_loop' );
    delete_option( 'wa_order_option_custom_message_shop_loop' );
    delete_option( 'wa_order_option_shop_loop_hide_product_url' );
    delete_option( 'wa_order_option_shop_loop_exclude_price' );
    delete_option( 'wa_order_option_shop_loop_open_new_tab' );
}
register_deactivation_hook( __FILE__, 'wa_order_deactivation' );

// Begin Building the Admin Tabs
function wa_order_create_admin_page(){
     if( $active_tab = isset( $_GET[ 'tab' ] ) ) {
            $active_tab = esc_attr($_GET[ 'tab' ]);
        } else if( $active_tab == 'button_config' ) {
            $active_tab = 'button_config';
        } else if( $active_tab == 'floating_button' ) {
            $active_tab = 'floating_button';
        } else if( $active_tab == 'display_option' ) {
            $active_tab = 'display_option';
        } else if( $active_tab == 'shop_page' ) {
            $active_tab = 'shop_page';    
        } else if( $active_tab == 'cart_button' ) {
            $active_tab = 'cart_button'; 
        } else if( $active_tab == 'thanks_page' ) {
            $active_tab = 'thanks_page';        
        } else if( $active_tab == 'gdpr_notice' ) {
            $active_tab = 'gdpr_notice';
        } else if( $active_tab == 'generate_shortcode' ) {
            $active_tab = 'generate_shortcode';
        } else if( $active_tab == 'tutorial_support' ) {
            $active_tab = 'tutorial_support';                   
        } else {
            $active_tab = 'welcome';
        } // end if/else 
?>
<div class="wrap OCWAORDER_pluginpage_title">
<h1><?php _e( 'OneClick Chat to Order', 'oneclick-wa-order' ); ?></h1>
<hr>
<h2 class="nav-tab-wrapper">
    <a href="?page=wa-order&tab=welcome" class="nav-tab <?php echo esc_attr( $active_tab == 'welcome' ) ? 'nav-tab-active' : ''; ?>"><?php _e( 'Welcome', 'oneclick-wa-order' ); ?></a>
    <a href="edit.php?post_type=wa-order-numbers" class="nav-tab <?php echo esc_attr( $active_tab == 'phone-numbers' ) ? 'nav-tab-active' : ''; ?>"><?php _e( 'Numbers', 'oneclick-wa-order' ); ?></a>
    <a href="?page=wa-order&tab=button_config" class="nav-tab <?php echo esc_attr( $active_tab == 'button_config' ) ? 'nav-tab-active' : ''; ?>"><?php _e( 'Basic', 'oneclick-wa-order' ); ?></a>
    <a href="?page=wa-order&tab=floating_button" class="nav-tab <?php echo esc_attr( $active_tab == 'floating_button' ) ? 'nav-tab-active' : ''; ?>"><?php _e( 'Floating', 'oneclick-wa-order' ); ?></a>
    <a href="?page=wa-order&tab=display_option" class="nav-tab <?php echo esc_attr( $active_tab == 'display_option' ) ? 'nav-tab-active' : ''; ?>"><?php _e( 'Display Options', 'oneclick-wa-order' ); ?></a>
    <a href="?page=wa-order&tab=shop_page" class="nav-tab <?php echo esc_attr( $active_tab == 'shop_page' ) ? 'nav-tab-active' : ''; ?>"><?php _e( 'Shop', 'oneclick-wa-order' ); ?></a>
        <a href="?page=wa-order&tab=cart_button" class="nav-tab <?php echo esc_attr( $active_tab == 'cart_button' ) ? 'nav-tab-active' : ''; ?>"><?php _e( 'Cart', 'oneclick-wa-order' ); ?></a>
    <a href="?page=wa-order&tab=thanks_page" class="nav-tab <?php echo esc_attr( $active_tab == 'thanks_page' ) ? 'nav-tab-active' : ''; ?>"><?php _e( 'Checkout', 'oneclick-wa-order' ); ?></a>
    <a href="?page=wa-order&tab=gdpr_notice" class="nav-tab <?php echo esc_attr( $active_tab == 'gdpr_notice' ) ? 'nav-tab-active' : ''; ?>"><?php _e( 'GDPR', 'oneclick-wa-order' ); ?></a>
    <a href="?page=wa-order&tab=generate_shortcode" class="nav-tab <?php echo esc_attr( $active_tab == 'generate_shortcode' ) ? 'nav-tab-active' : ''; ?>"><?php _e( 'Shortcode', 'oneclick-wa-order' ); ?></a>
    <a href="?page=wa-order&tab=tutorial_support" class="nav-tab <?php echo esc_attr( $active_tab == 'tutorial_support' ) ? 'nav-tab-active' : ''; ?>"><?php _e( 'Support', 'oneclick-wa-order' ); ?></a>
</h2>
            <?php if ( $active_tab == 'generate_shortcode' ) { ?>
                <?php wp_enqueue_script( 'wa_order_js_admin' ); ?>
                <h2 class="section_wa_order"><?php _e( 'Generate Shortcode', 'oneclick-wa-order' ); ?></h2>
                <p>
                    <?php _e('Use shortcode to display OneClick Chat to Order\'s WhatsApp button anywhere on your site. There are two options; global and dynamic, which can be used based on your needs.', 'oneclick-wa-order'); ?>
                        <br />
                </p>
                <hr />
                  <h3 class="section_wa_order"><?php _e( 'Shortcode Generator', 'oneclick-wa-order' ); ?></h3>
                  <p>
                      <?php _e('Create a dynamic shortcode using below generator.', 'oneclick-wa-order'); ?>
                          <br />
                  </p>
                  <hr />
                  <form>
                  	<!-- Shortcode Generator -->
                  	<table class="form-table">
                  		<tbody>
                  			<!-- Dropdown WA Number -->
                  			<tr>
                  				<th scope="row">
                  					<label>
                  						<?php _e('WhatsApp Number', 'oneclick-wa-order') ?>
                  					</label>
                  				</th>
                  				<td>
                  					<?php wa_order_phone_numbers_dropdown_shortcode_generator( 
                  						array(
                  							'name'      => 'wa_order_phone_numbers_dropdown_shortcode_generator',
                  							'selected'  => ( get_option('wa_order_selected_wa_number_shortcode')), 
                  						) 
                  					) 
                  					?>
                  					<p class="description">
                  						<?php _e( 'WhatsApp number is <strong style="color:red;">required</strong>. Please set it on <a href="edit.php?post_type=wa-order-numbers"><strong>Numbers</strong></a> tab.', 'oneclick-wa-order' ); ?>
                  					</p>
                  				</td>
                  			</tr>
                  			<!-- Dropdown WA Number -->
                  			<tr class="wa_order_btn_text">
                  				<th scope="row">
                  					<label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Text on Button', 'oneclick-wa-order' ); ?></b></label>
                  				</th>
                  				<td>
                  					<input type="text" id="WAbuttonText" name="WAbuttonText" onChange="generateWAshortcode();" class="wa_order_input" placeholder="<?php _e( 'e.g. Order via WhatsApp', 'oneclick-wa-order' ); ?>">
                  				</td>
                  			</tr>
                  			<tr class="wa_order_message">
                  				<th scope="row">
                  					<label class="wa_order_message_label" for="message_wbw"><b><?php _e( 'Custom Message', 'oneclick-wa-order' ); ?></b></label>
                  				</th>
                  				<td>
                  					<textarea class="wa_order_input_areatext" rows="5" placeholder="<?php _e( 'e.g. Hello, I need to know more about', 'oneclick-wa-order' ); ?>" id="WAcustomMessage" name="WAcustomMessage" onChange="generateWAshortcode();"></textarea>
                  					<p class="description">
                  						<?php _e( 'Enter custom message, e.g. <code>Hello, I need to know more about</code>', 'oneclick-wa-order' ); ?></p></td>
                  					</tr>
                  					<tr class="wa_order_message">
                  						<th scope="row">
                  							<label for="WAnewTab"><?php _e('Open in New Tab?', 'oneclick-wa-order') ?>

                  						</label>
                  					</th>
                  					<td>
                  						<select name="WAnewTab" id="WAnewTab" onChange="generateWAshortcode();">
                  							<option value="no"><?php _e('No', 'oneclick-wa-order') ?></option>
                  							<option value="yes"><?php _e('Yes', 'oneclick-wa-order') ?></option>
                  						</select>
                  					</td>
                  				</tr>        
                  				<tr class="wa_order_message">
                  					<th scope="row">
                  						<label class="wa_order_message_label" for="message_wbw"><b><?php _e( 'Copy Shortcode', 'oneclick-wa-order' ); ?></b>
                  						</label>
                  					</th>
                  					<td>
                  						<textarea class="wa_order_input_areatext" rows="5" id="generatedShortcode" onclick="this.setSelectionRange(0, this.value.length)"></textarea>
                  						<p class="description">
                  							<?php _e( 'Copy above shortcode and paste it anywhere.', 'oneclick-wa-order' ); ?></p>
                  						</td>
                  					</tr>
                  				</tbody>
                  			</table>
                  		</tbody>
                  	</table>
                  </form>
                <hr />
                <!-- End - Shortcode Generator -->

                <!-- Start Global Shortcode -->
                <form method="post" action="options.php">
                <?php settings_errors(); ?>
                <?php settings_fields( 'wa-order-settings-group-shortcode' ); ?> 
                <?php do_settings_sections( 'wa-order-settings-group-shortcode' ); ?>
                <h3 class="section_wa_order"><?php _e( 'Global Shortcode', 'oneclick-wa-order' ); ?></h3>
                <p>
                    <?php _e('You need to click the <b>Save Changes</b> button below in order to use the <code>[wa-order]</code> shortcode.', 'oneclick-wa-order'); ?>
                        <br />
                </p>
                <table class="form-table">
                    <tbody>
                        <!-- Dropdown WA Number -->
                        <tr>
                            <th scope="row">
                                <label>
                                    <?php _e('WhatsApp Number', 'oneclick-wa-order') ?>
                                </label>
                            </th>
                            <td>
                                <?php wa_order_phone_numbers_dropdown( 
                                    array(
                                        'name'      => 'wa_order_selected_wa_number_shortcode',
                                        'selected'  => ( get_option('wa_order_selected_wa_number_shortcode')), 
                                        ) 
                                    ) 
                                ?>
                                <p class="description">
                                    <?php _e( 'WhatsApp number is <strong style="color:red;">required</strong>. Please set it on <a href="edit.php?post_type=wa-order-numbers"><strong>Numbers</strong></a> tab.', 'oneclick-wa-order' ); ?>
                                    </p>
                            </td>
                        </tr>
                        <!-- Dropdown WA Number -->
                        <tr class="wa_order_btn_text">
                            <th scope="row">
                                <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Text on Button', 'oneclick-wa-order' ); ?></b></label>
                            </th>
                            <td>
                                <input type="text" name="wa_order_shortcode_text_button" class="wa_order_input" value="<?php echo get_option('wa_order_shortcode_text_button'); ?>" placeholder="<?php _e( 'e.g. Order via WhatsApp', 'oneclick-wa-order' ); ?>">
                            </td>
                        </tr>
                        <tr class="wa_order_message">
                            <th scope="row">
                                <label class="wa_order_message_label" for="message_wbw"><b><?php _e( 'Custom Message', 'oneclick-wa-order' ); ?></b></label>
                            </th>
                            <td>
                                <textarea name="wa_order_shortcode_message" class="wa_order_input_areatext" rows="5" placeholder="<?php _e( 'e.g. Hello, I need to know more about', 'oneclick-wa-order' ); ?>"><?php echo get_option('wa_order_shortcode_message'); ?></textarea>
                                <p class="description">
                                    <?php _e( 'Enter custom message, e.g. <code>Hello, I need to know more about</code>', 'oneclick-wa-order' ); ?></p></td>
                        </tr>
                        <tr class="wa_order_target">
                            <th scope="row">
                                <label class="wa_order_copy_label" for="wa_order_copy"><b><?php _e( 'Copy Shortcode', 'oneclick-wa-order' ); ?></b></label>
                            </th>
                            <td>
                                <input style="letter-spacing: 1px;" class="wa_order_shortcode_input" onClick="this.setSelectionRange(0, this.value.length)" value="[wa-order]" />
                                    <br>
                            </td>
                        </tr>

                        <tr class="wa_order_target">
                            <th scope="row">
                                <label class="wa_order_target_label" for="wa_order_target"><b><?php _e( 'Open in New Tab?', 'oneclick-wa-order' ); ?></b></label>
                            </th>
                            <td>
                                <input type="checkbox" name="wa_order_shortcode_target" class="wa_order_input_check" value="_blank" <?php checked( get_option( 'wa_order_shortcode_target'), '_blank' );?>>
                                <?php _e( 'Yes, Open in New Tab', 'oneclick-wa-order' ); ?>
                                    <br>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                    </tbody>
                </table>
        <?php submit_button(); ?>
        </form>
        <!-- End - Shortcode Tab Setting Page -->
 <?php } elseif( $active_tab == 'button_config' ) { ?>
    <!-- Basic Configurations -->
    <form method="post" action="options.php">
    <?php settings_errors(); ?>
    <?php settings_fields( 'wa-order-settings-group-button-config' ); ?> 
    <?php do_settings_sections( 'wa-order-settings-group-button-config' ); ?>

    <!-- Basic Configuration tab -->
    <h2 class="section_wa_order"><?php _e( 'Confirmation', 'oneclick-wa-order' ); ?></h2>
    <p>
        <?php _e('Make sure that you have added at least one WhatsApp number to dismiss the admin notice. Please <a href="edit.php?post_type=wa-order-numbers"><strong>set it here</strong></a> to get started. <a href="https://walterpinem.me/projects/oneclick-chat-to-order-mutiple-numbers-feature/?utm_source=admin-notice&utm_medium=admin-dashboard&utm_campaign=OneClick-Chat-to-Order" target="_blank"><strong>Learn more</strong></a>.', 'oneclick-wa-order'); ?>
            <br />
    </p>
    <table class="form-table">
        <tbody>
            <tr class="wa_order_target">
                <th scope="row">
                    <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Dismiss Notice', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_option_dismiss_notice_confirmation" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_dismiss_notice_confirmation'), 'yes' );?>>
                    <?php _e( 'Check this if you have added at least one WhatsApp number.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr> 
                </tbody>
            </table>
            <hr>
            <h2 class="section_wa_order"><?php _e( 'WhatsApp Base URL', 'oneclick-wa-order' ); ?></h2>
            <p class="description">
                <?php _e( 'Just in case, if the WhatsApp link cannot be opened in a mobile device, you can choose <code>api</code> instead of <code>web</code> for desktop (default is <code>web</code> for desktop and <code>api</code> for mobile).', 'oneclick-wa-order' ); ?>
            </p>
            <hr>
            <table class="form-table">
                <tbody>
                    <tr class="wa_order_target">
                        <th scope="row">
                            <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn">
                                <strong><?php _e( 'Choose Base URL', 'oneclick-wa-order' ); ?></strong>
                            </label>
                        </th>
                    <td>
                        <select name="wa_order_whatsapp_base_url" id="wa_order_whatsapp_base_url" class="wa_order-admin-select2">
                            <option value="web" <?php echo esc_attr(get_option('wa_order_whatsapp_base_url') == 'web' ? 'selected' : '') ?>>
                                <?php echo __('web (default)', 'oneclick-wa-order') ?>
                            </option>
                            <option value="api" <?php echo esc_attr(get_option('wa_order_whatsapp_base_url') == 'api' ? 'selected' : '') ?>>
                                <?php echo __('api', 'oneclick-wa-order') ?>
                            </option>
                        </select>
                        <p class="description">
                            <?php _e( 'It\'s only applicable for desktop.', 'oneclick-wa-order' ); ?>
                        </p>
                        <br>
                    </td>
                        <tr>
                </tbody>
            </table>
            <hr>

    <table class="form-table">
        <tbody>  
    <h2 class="section_wa_order"><?php _e( 'Single Product Page', 'oneclick-wa-order' ); ?></h2>
    <p>
        <?php _e('These configurations will be only effective on single product page.', 'oneclick-wa-order'); ?>
            <br />
    </p>

    <tr class="wa_order_target">
        <th scope="row">
            <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Display Button?', 'oneclick-wa-order' ); ?></b></label>
        </th>
        <td>
            <input type="checkbox" name="wa_order_option_enable_single_product" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_enable_single_product'), 'yes' );?>>
            <?php _e( 'This will display WhatsApp button on single product page', 'oneclick-wa-order' ); ?>
                <br>
        </td>
    </tr> 
    <!-- Dropdown WA Number -->
    <tr>
        <th scope="row">
            <label>
                <?php _e('WhatsApp Number', 'oneclick-wa-order') ?>
            </label>
        </th>
        <td>
            <?php wa_order_phone_numbers_dropdown( 
                array(
                    'name'      => 'wa_order_selected_wa_number_single_product',
                    'selected'  => ( get_option('wa_order_selected_wa_number_single_product')), 
                    ) 
                ) 
            ?>
            <p class="description">
                <?php _e( 'WhatsApp number is <strong style="color:red;">required</strong>. Please set it on <a href="edit.php?post_type=wa-order-numbers"><strong>Numbers</strong></a> tab.', 'oneclick-wa-order' ); ?>
                </p>
        </td>
    </tr>
    <!-- END - Dropdown WA Number -->

    <!-- Dropdown Button Position -->
    <tr>
        <th scope="row">
            <label for="wa_order_single_product_button_position"><?php echo __('Button Position', 'oneclick-wa-order') ?></label></th>
        <td>
            <select name="wa_order_single_product_button_position" id="wa_order_single_product_button_position" class="wa_order-admin-select2">
                <option value="after_atc" <?php echo esc_attr(get_option('wa_order_single_product_button_position') == 'after_atc' ? 'selected' : '') ?>><?php echo __('After Add to Cart Button (Default)', 'oneclick-wa-order') ?></option>
                <option value="under_atc" <?php echo esc_attr(get_option('wa_order_single_product_button_position') == 'under_atc' ? 'selected' : '') ?>><?php echo __('Under Add to Cart Button', 'oneclick-wa-order') ?></option>
                <option value="after_shortdesc" <?php echo esc_attr(get_option('wa_order_single_product_button_position') == 'after_shortdesc' ? 'selected' : '') ?>><?php echo __('After Short Description', 'oneclick-wa-order') ?></option>
            </select>
            <p class="description">
                <?php _e( 'Choose where to put the WhatsApp button on single product page.', 'oneclick-wa-order' ); ?>
                </p>
        </td>
    </tr>
    <!-- END - Dropdown Button Position -->

            <tr class="wa_order_message">
                <th scope="row">
                    <label class="wa_order_message_label" for="message_owo"><b><?php _e( 'Custom Message', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <textarea name="wa_order_option_message" class="wa_order_input_areatext" rows="5" placeholder="<?php _e( 'e.g. Hello, I want to buy:', 'oneclick-wa-order' ); ?>"><?php echo get_option('wa_order_option_message'); ?></textarea>
                    <p class="description">
                        <?php _e( 'Fill this form with custom message, e.g. <code>Hello, I want to buy:</code>', 'oneclick-wa-order' ); ?>
                    </p>
                </td>
            </tr>

            <tr class="wa_order_btn_text">
                <th scope="row">
                    <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Text on Button', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="text" name="wa_order_option_text_button" class="wa_order_input" value="<?php echo get_option('wa_order_option_text_button'); ?>" placeholder="<?php _e( 'e.g. Order via WhatsApp', 'oneclick-wa-order' ); ?>">
                </td>
            </tr>

            <tr class="wa_order_target">
                <th scope="row">
                    <label class="wa_order_target_label" for="wa_order_target"><b><?php _e( 'Open in New Tab?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_option_target" class="wa_order_input_check" value="_blank" <?php checked( get_option( 'wa_order_option_target'), '_blank' );?>>
                    <?php _e( 'Yes, Open in New Tab', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>
                </tbody>
            </table>
    <hr>        
    <table class="form-table">
        <tbody>            
            <h2 class="section_wa_order"><?php _e( 'Exclusion', 'oneclick-wa-order' ); ?></h2>
            <p><?php _e( 'The following option is only for the output message you\'ll receieve on WhatsApp. To hide some elements, please go to <a href="admin.php?page=wa-order&tab=display_option"><strong>Display Options</strong></a> tab.', 'oneclick-wa-order' ); ?></p>
            <tr class="wa_order_price">
                <th scope="row">
                    <label class="wa_order_price_label" for="wa_order_price"><b><?php _e( 'Exclude Price?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_exclude_price" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_exclude_price'), 'yes' );?>>
                    <?php _e( 'Yes, exclude price in WhatsApp message.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>

            <tr class="wa_order_price">
                <th scope="row">
                    <label class="wa_order_price_label" for="wa_order_price"><b><?php _e( 'Remove Product URL?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_exclude_product_url" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_exclude_product_url'), 'yes' );?>>
                    <?php _e( 'This will remove product URL from WhatsApp message sent from single product page.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>

        </tbody>
    </table>
    <hr>
    <table class="form-table">
        <tbody>            
            <h2 class="section_wa_order"><?php _e( 'Text Translations', 'oneclick-wa-order' ); ?></h2>
            <p><?php _e( 'You can translate the following strings which will be included in the sent message. By default, the labels are used in the message. You can translate or change them below accordingly.', 'oneclick-wa-order' ); ?></p>

            <tr class="wa_order_btn_text">
                <th scope="row">
                    <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Quantity', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="text" name="wa_order_option_quantity_label" class="wa_order_input" value="<?php echo get_option('wa_order_option_quantity_label', 'Quantity'); ?>" placeholder="<?php _e( 'e.g. Quantity', 'oneclick-wa-order' ); ?>">
                </td>
            </tr>

            <tr class="wa_order_btn_text">
                <th scope="row">
                    <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Price', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="text" name="wa_order_option_price_label" class="wa_order_input" value="<?php echo get_option('wa_order_option_price_label', 'Price'); ?>" placeholder="<?php _e( 'e.g. Price', 'oneclick-wa-order' ); ?>">
                </td>
            </tr>


            <tr class="wa_order_btn_text">
                <th scope="row">
                    <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'URL', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="text" name="wa_order_option_url_label" class="wa_order_input" value="<?php echo get_option('wa_order_option_url_label', 'URL'); ?>" placeholder="<?php _e( 'e.g. Link', 'oneclick-wa-order' ); ?>">
                </td>
            </tr>

            <tr class="wa_order_btn_text">
                <th scope="row">
                    <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Total Amount', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="text" name="wa_order_option_total_amount_label" class="wa_order_input" value="<?php echo get_option('wa_order_option_total_amount_label', 'Total Price'); ?>" placeholder="<?php _e( 'e.g. Total Amount', 'oneclick-wa-order' ); ?>">
                </td>
            </tr>      

            <tr class="wa_order_btn_text">
                <th scope="row">
                    <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Payment Method', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="text" name="wa_order_option_payment_method_label" class="wa_order_input" value="<?php echo get_option('wa_order_option_payment_method_label', 'Payment Method'); ?>" placeholder="<?php _e( 'e.g. Payment via', 'oneclick-wa-order' ); ?>">
                </td>
            </tr>   

            <tr class="wa_order_btn_text">
                <th scope="row">
                    <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Thank you!', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="text" name="wa_order_option_thank_you_label" class="wa_order_input" value="<?php echo get_option('wa_order_option_thank_you_label', 'Thank you!'); ?>" placeholder="<?php _e( 'e.g. Thank you in advance!', 'oneclick-wa-order' ); ?>">
                </td>
            </tr>

        </tbody>
    </table>
    <hr>
        <?php submit_button(); ?>
        </form>
<?php } elseif( $active_tab == 'floating_button' ) { ?>
    <form method="post" action="options.php">
    <?php settings_errors(); ?>
    <?php settings_fields( 'wa-order-settings-group-floating' ); ?> 
    <?php do_settings_sections( 'wa-order-settings-group-floating' ); ?>
    <!-- Floating Button -->
    <h2 class="section_wa_order"><?php _e( 'Floating Button', 'oneclick-wa-order' ); ?></h2>
    <p>
        <?php _e('Enable / disable a floating WhatsApp button on your entire pages. You can configure the floating button below.', 'oneclick-wa-order'); ?>
            <br />
    </p>
    <table class="form-table">
        <tbody>
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Display Floating Button?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_floating_button" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_floating_button'), 'yes' );?>>
                    <?php _e( 'This will show floating WhatsApp Button', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>
            <!-- Dropdown WA Number -->
            <tr>
                <th scope="row">
                    <label>
                        <?php _e('WhatsApp Number', 'oneclick-wa-order') ?>
                    </label>
                </th>
                <td>
                    <?php wa_order_phone_numbers_dropdown( 
                        array(
                            'name'      => 'wa_order_selected_wa_number_floating',
                            'selected'  => ( get_option('wa_order_selected_wa_number_floating')), 
                            ) 
                        ) 
                    ?>
                    <p class="description">
                        <?php _e( 'WhatsApp number is <strong style="color:red;">required</strong>. Please set it on <a href="edit.php?post_type=wa-order-numbers"><strong>Numbers</strong></a> tab.', 'oneclick-wa-order' ); ?>
                        </p>
                </td>
            </tr>
            <!-- END- Dropdown WA Number -->
           
            <tr class="wa_order_message">
                <th scope="row">
                    <label class="wa_order_message_label" for="message_wbw"><b><?php _e( 'Custom Message', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <textarea name="wa_order_floating_message" class="wa_order_input_areatext" rows="5" placeholder="<?php _e( 'e.g. Hello, I need to know more about', 'oneclick-wa-order' ); ?>"><?php echo get_option('wa_order_floating_message'); ?></textarea>
                    <p class="description">
                        <?php _e( 'Enter custom message, e.g. <code>Hello, I need to know more about</code>', 'oneclick-wa-order' ); ?></p>
                    </td>
            </tr>

            <tr class="wa_order_target">
                <th scope="row">
                    <label class="wa_order_target_label" for="wa_order_target"><b><?php _e( 'Show Source Page URL?', 'oneclick-wa-order' ); ?></b></label>
                </th>                                
                <td>
                    <input type="checkbox" name="wa_order_floating_source_url" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_floating_source_url'), 'yes' );?>>
                    <?php _e( 'This will include the URL of the page where the button is clicked in the message.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>

            <tr class="wa_order_btn_text">
                <th scope="row">
                    <label class="wa_order_btn_txt_label" for="wa_order_floating_source_url_label"><b><?php _e( 'Source Page URL Label', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="text" name="wa_order_floating_source_url_label" class="wa_order_input" value="<?php echo get_option('wa_order_floating_source_url_label'); ?>" placeholder="<?php _e( 'From URL:', 'oneclick-wa-order' ); ?>">
                    <p class="description">
                        <?php _e( 'Add a label for the source page URL. <code>e.g. From URL:</code>', 'oneclick-wa-order' ); ?></p>
                </td>
            </tr>     

            <tr class="wa_order_target">
                <th scope="row">
                    <label class="wa_order_target_label" for="wa_order_target"><b><?php _e( 'Open in New Tab?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_floating_target" class="wa_order_input_check" value="_blank" <?php checked( get_option( 'wa_order_floating_target'), '_blank' );?>>
                    <?php _e( 'Yes, Open in New Tab', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Floating Button Display Options -->
    <table class="form-table">
        <tbody>
            <hr />
            <h2 class="section_wa_order"><?php _e( 'Display Options', 'oneclick-wa-order' ); ?></h2>
            <p>
                <?php _e('Configure where and how you\'d like the floating button to be displayed..', 'oneclick-wa-order'); ?>
                    <br />
            </p>
            <hr />
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label>
                        <?php _e('Floating Button Position', 'oneclick-wa-order') ?>
                    </label>
                </th>
                <td>
                    <input type="radio" name="wa_order_floating_button_position" value="left" <?php checked( 'left', get_option( 'wa_order_floating_button_position'), true); ?>>
                    <?php _e( 'Left', 'oneclick-wa-order' ); ?>
                    <input type="radio" name="wa_order_floating_button_position" value="right" <?php checked( 'right', get_option( 'wa_order_floating_button_position'), true); ?>>
                    <?php _e( 'Right', 'oneclick-wa-order' ); ?>
                </td>
            </tr>
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn">
                        <strong><?php _e( 'Display Tooltip?', 'oneclick-wa-order' ); ?></strong>
                    </label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_floating_tooltip_enable" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_floating_tooltip_enable'), 'yes' );?>>
                    <?php _e( 'This will show a custom tooltip', 'oneclick-wa-order' ); ?>
                    <br>
                </td>
            </tr>
            <tr class="wa_order_btn_text">
                <th scope="row">
                    <label class="wa_order_btn_txt_label" for="floating_tooltip">
                        <strong><?php _e( 'Button Tooltip', 'oneclick-wa-order' ); ?></strong>
                    </label>
                </th>
                <td>
                    <input type="text" name="wa_order_floating_tooltip" class="wa_order_input" value="<?php echo get_option('wa_order_floating_tooltip'); ?>" placeholder="<?php _e( 'e.g. Let\'s Chat', 'oneclick-wa-order' ); ?>">
                    <p class="description">
                        <?php _e( 'Use this to greet your customers. The tooltip container size is very <br>limited so make sure to make it as short as possible.', 'oneclick-wa-order' ); ?>
                    </p>
                </td>
            </tr>                         
            <tr class="wa_order_target">
                <th scope="row">
                    <label class="wa_order_target_label" for="wa_order_target">
                        <strong><?php _e( 'Hide Floating Button on Mobile?', 'oneclick-wa-order' ); ?></strong>
                    </label>
                </th>                                
                <td>
                    <input type="checkbox" name="wa_order_floating_hide_mobile" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_floating_hide_mobile'), 'yes' );?>>
                    <?php _e( 'This will hide Floating Button on Mobile.', 'oneclick-wa-order' ); ?>
                    <br>
                </td>
            </tr>
            <tr class="wa_order_target">
                <th scope="row">
                    <label class="wa_order_target_label" for="wa_order_target">
                        <strong><?php _e( 'Hide Floating Button on Desktop?', 'oneclick-wa-order' ); ?></strong>
                    </label>
                </th>                                
                <td>
                    <input type="checkbox" name="wa_order_floating_hide_desktop" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_floating_hide_desktop'), 'yes' );?>>
                    <?php _e( 'This will hide Floating Button on Desktop.', 'oneclick-wa-order' ); ?>
                    <br>
                </td>
            </tr>
            <!-- Hide floating button on all posts -->
            <tr class="wa_order_target">
                <th scope="row">
                    <label class="wa_order_target_label" for="wa_order_target">
                        <strong><?php _e( 'Hide Floating Button on All Single Posts?', 'oneclick-wa-order' ); ?></strong>
                    </label>
                </th>                                
                <td>
                    <input type="checkbox" name="wa_order_floating_hide_all_single_posts" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_floating_hide_all_single_posts'), 'yes' );?>>
                    <?php _e( 'This will hide Floating Button on all single posts.', 'oneclick-wa-order' ); ?>
                    <br>
                </td>
            </tr>
            <!-- END - Hide floating button on all posts -->

            <!-- Hide floating button on all pages -->
            <tr class="wa_order_target">
                <th scope="row">
                    <label class="wa_order_target_label" for="wa_order_target">
                        <strong><?php _e( 'Hide Floating Button on All Single Posts?', 'oneclick-wa-order' ); ?></strong>
                    </label>
                </th>                                
                <td>
                    <input type="checkbox" name="wa_order_floating_hide_all_single_pages" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_floating_hide_all_single_pages'), 'yes' );?>>
                    <?php _e( 'This will hide Floating Button on all single pages.', 'oneclick-wa-order' ); ?>
                    <br>
                </td>
            </tr>
            <!-- END - Hide floating button on all pages -->

            <!-- Multiple posts selection -->
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn">
                        <strong><?php _e( 'Hide Floating Button on Selected Post(s)', 'oneclick-wa-order' ); ?></strong>
                    </label>
                </th>
                <td>
                    <?php wp_enqueue_script( 'wa_order_js_select2'); ?>
                    <?php wp_enqueue_script( 'wa_order_js_admin'); ?>
                    <?php wp_enqueue_style( 'wa_order_selet2_style'); ?>
                    <select multiple="multiple" name="wa_order_floating_hide_specific_posts[]" class="postform octo-post-filter" style="width: 50%;">
                        <?php 
                        global $post;
                        $option = get_option('wa_order_floating_hide_specific_posts'); 
                        $option_array = (array) $option;
                        $args = array(
                         'post_type'        => 'post',
                         'orderby'          => 'title',
                         'order'            => 'ASC',
                         'post_status'      => 'publish',
                         'posts_per_page'   => -1
                     );
                        $posts = get_posts( $args );
                        foreach ($posts as $post) { ?>
                            <?php $selected = in_array( $post->ID, $option_array ) ? ' selected="selected" ' : ''; ?>
                            <option value="<?php echo $post->ID; ?>" <?php echo $selected; ?> >
                                <?php echo ucwords($post->post_title); ?>
                            </option>
                        <?php } //endforeach ?>
                    </select>
                    <p><?php _e('You can hide the floating button on the selected post(s).', 'oneclick-wa-order'); ?></p><br>
                </td>
            </tr>
            <!-- END - Multiple posts selection -->

            <!-- Multiple pages selection -->
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn">
                        <strong><?php _e( 'Hide Floating Button on Selected Page(s)', 'oneclick-wa-order' ); ?></strong>
                    </label>
                </th>
                <td>
                    <select multiple="multiple" name="wa_order_floating_hide_specific_pages[]" class="postform octo-page-filter" style="width: 50%;">
                        <?php 
                        global $post;
                        $option = get_option('wa_order_floating_hide_specific_pages'); 
                        $option_array = (array) $option;
                        $args = array(
                        'post_type'        => 'page',
                        'orderby'          => 'title',
                        'order'            => 'ASC',
                        'post_status'      => 'publish',
                        'posts_per_page'   => -1
                        );
                        $pages = get_posts( $args );
                        foreach ($pages as $page) { ?>
                            <?php $selected = in_array( $page->ID, $option_array ) ? ' selected="selected" ' : ''; ?>
                            <option value="<?php echo $page->ID; ?>" <?php echo $selected; ?> >
                                <?php echo ucwords($page->post_title); ?>
                            </option>
                        <?php } //endforeach ?>
                    </select>
                    <p><?php _e('You can hide the floating button on the selected page(s).', 'oneclick-wa-order'); ?></p><br>
                </td>
            </tr>
            <!-- END - Multiple pages selection -->

            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn">
                        <strong><?php _e( 'Hide Floating Button on Products in Categories', 'oneclick-wa-order' ); ?></strong>
                    </label>
                </th>
                <td>
                    <select multiple="multiple" name="wa_order_floating_hide_product_cats[]" class="postform octo-category-filter" style="width: 50%;">
                        <?php 
                        $option = get_option('wa_order_floating_hide_product_cats'); 
                        $option_array = (array) $option;
                        $args = array(
                            'taxonomy' => 'product_cat',
                            'orderby'  => 'name'
                        );
                        $categories = get_categories( $args );
                        foreach ($categories as $category) { 
                           $selected = in_array( $category->cat_ID, $option_array ) ? ' selected="selected" ' : ''; ?>
                           <option value="<?php echo $category->term_id; ?>" <?php echo $selected; ?> >
                              <?php echo ucwords($category->cat_name) . ' (' . $category->category_count .')'; ?>
                          </option>
                      <?php } //endforeach ?>
                  </select>
                  <p><?php _e('You can hide the floating button on products in the selected categories.', 'oneclick-wa-order'); ?></p>
                  <br>
              </td>
            </tr>
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Hide Floating Button on Products in Tags', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <select multiple="multiple" name="wa_order_floating_hide_product_tags[]" class="postform octo-category-filter" style="width: 50%;">
                        <?php 
                        $option = get_option('wa_order_floating_hide_product_tags'); 
                        $option_array = (array) $option;
                        $args = array(
                         'taxonomy' => 'product_tag',
                         'orderby'  => 'name'
                     );
                        $tag_query = get_terms( $args );
                        foreach ($tag_query as $term) { ?>
                            <?php $selected = in_array( $term->term_id, $option_array ) ? ' selected="selected" ' : ''; ?>
                            <option value="<?php echo $term->term_id; ?>" <?php echo $selected; ?> >
                              <?php echo ucwords($term->name) . ' (' . $term->count .')'; ?>
                          </option>
                      <?php } //endforeach ?>
                  </select>
                  <p>
                    <?php _e('You can hide the floating button on products in the selected tags.', 'oneclick-wa-order'); 
                    ?>
                    <br />
                </p>
                <br>
            </td>
            </tr>
        </tbody>
    </table>
    <!-- END - Floating Button Display Options -->
    <hr>
        <?php submit_button(); ?>
        </form>
<?php } elseif( $active_tab == 'display_option' ) { ?>
    <form method="post" action="options.php">
    <?php settings_errors(); ?>
    <?php settings_fields( 'wa-order-settings-group-display-options' ); ?> 
    <?php do_settings_sections( 'wa-order-settings-group-display-options' ); ?>
    <?php wp_enqueue_script( 'wa_order_js_select2'); ?>
    <?php wp_enqueue_style( 'wp-color-picker' ); ?>
    <?php wp_enqueue_style( 'wa_order_selet2_style' ); ?>
    <?php wp_enqueue_script( 'wp-color-picker-alpha'); ?>
    <?php wp_enqueue_script( 'wp-color-picker-init'); ?>
    <?php wp_enqueue_script( 'wa_order_js_admin'); ?>
    <h2 class="section_wa_order"><?php _e( 'Display Options', 'oneclick-wa-order' ); ?></h2>
        <p>
        <?php _e('Here, you can configure some options for hiding elements to convert customers phone number into clickable WhatsApp link.', 'oneclick-wa-order'); ?>
            <br />
    </p>
    <hr>
        <!-- Button Colors - Display Options -->
        <table class="form-table">
            <tbody>
                <h3 class="section_wa_order"><?php _e( 'Button Colors', 'oneclick-wa-order' ); ?></h3>
                <p><?php _e( 'Customize the WhatsApp button appearance however you like.', 'oneclick-wa-order' ); ?></p>
                <!-- Button Background Color -->
                <tr class="wa_order_remove_add_btn">
                    <th scope="row">
                        <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Background Color', 'oneclick-wa-order' ); ?></b></label>
                    </th>
                    <td>
                    <?php $bg = get_option( 'wa_order_bg_color' ); ?>    
                    <?php if( empty( $bg ) ) $bg = 'rgba(37, 211, 102, 1)'; ?>    
                    <input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="rgba(37, 211, 102, 1)" name="wa_order_bg_color" value="<?php echo sanitize_text_field( $bg ); ?>"/>
                            <br>
                    </td>
                </tr>
                <!-- Button Background Hover Color -->
                <tr class="wa_order_option_remove_quantity">
                    <th scope="row">
                        <label class="wa_order_option_remove_quantity" for="wa_order_option_remove_quantity"><b><?php _e( 'Background Hover Color', 'oneclick-wa-order' ); ?></b></label>
                    </th>
                    <td>
                    <?php $bg_hover = get_option( 'wa_order_bg_hover_color' ); ?>    
                    <?php if( empty( $bg_hover ) ) $bg_hover = 'rgba(37, 211, 102, 1)'; ?>
                    <input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="rgba(37, 211, 102, 1)" name="wa_order_bg_hover_color" value="<?php echo sanitize_text_field( $bg_hover ); ?>"/>
                            <br>
                    </td>
                </tr>
                <!-- Button Text Color -->
                <tr class="wa_order_remove_add_btn">
                    <th scope="row">
                        <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Text Color', 'oneclick-wa-order' ); ?></b></label>
                    </th>
                    <td>
                    <?php $txt = get_option( 'wa_order_txt_color' ); ?>    
                    <?php if( empty( $txt ) ) $txt = 'rgba(255, 255, 255, 1)'; ?>    
                    <input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="rgba(255, 255, 255, 1)" name="wa_order_txt_color" value="<?php echo sanitize_text_field( $txt ); ?>"/>
                            <br>
                    </td>
                </tr>
                <!-- Button Text Hover Color -->
                <tr class="wa_order_remove_price">
                    <th scope="row">
                        <label class="wa_order_price_label" for="wa_order_remove_price"><b><?php _e( 'Text Hover Color', 'oneclick-wa-order' ); ?></b></label>
                    </th>
                    <td>
                    <?php $txt_hover = get_option( 'wa_order_txt_hover_color' ); ?>    
                    <?php if( empty( $txt_hover ) ) $txt_hover = 'rgba(255, 255, 255, 1)'; ?>  
                    <input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="rgba(255, 255, 255, 1)" name="wa_order_txt_hover_color" value="<?php echo sanitize_text_field( $txt_hover ); ?>"/>
                            <br>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <!-- Button Box Shadow -->
        <table class="form-table">
        <tbody>
        <h3 class="section_wa_order"><?php _e( 'Button Box Shadow Color', 'oneclick-wa-order' ); ?></h3>
        <p><?php _e( 'Customize the box shadow color for the WhatsApp button.', 'oneclick-wa-order' ); ?></p>
        <tr class="wa_order_remove_price">
            <th scope="row">
                <label class="wa_order_price_label" for="wa_order_remove_price">
                    <strong><?php _e( 'Box Shadow', 'oneclick-wa-order' ); ?></strong>
                </label>
            </th>
            <td>
                <ul class="boxes-control">
                    <li class="box-control">
                        <?php $bshdw_hz = get_option( 'wa_order_bshdw_horizontal' ); ?>    
                        <?php if( !isset( $bshdw_hz ) ) $bshdw_hz = '0'; ?>
                        <input id="wa_order_bshdw_horizontal" type="number" name="wa_order_bshdw_horizontal" value="<?php echo get_option('wa_order_bshdw_horizontal'); ?>" placeholder="">
                        <p class="control-label"><?php _e('Horizontal', 'oneclick-wa-order'); ?><br /></p>
                    </li>
                    <li class="box-control">
                        <?php $bshdw_v = get_option( 'wa_order_bshdw_vertical' ); ?>    
                        <?php if( !isset( $bshdw_v ) ) $bshdw_v = '4'; ?>
                        <input id="wa_order_bshdw_vertical" type="number" name="wa_order_bshdw_vertical" value="<?php echo get_option('wa_order_bshdw_vertical'); ?>" placeholder="">
                        <p class="control-label"><?php _e('Vertical', 'oneclick-wa-order'); ?><br /></p>
                    </li>
                    <li class="box-control">
                        <?php $bshdw_b = get_option( 'wa_order_bshdw_blur' ); ?>    
                        <?php if( !isset( $bshdw_b ) ) $bshdw_b = '7'; ?>
                        <input id="wa_order_bshdw_blur" type="number" name="wa_order_bshdw_blur" value="<?php echo get_option('wa_order_bshdw_blur'); ?>" placeholder="">
                        <p class="control-label"><?php _e('Blur', 'oneclick-wa-order'); ?><br /></p>
                    </li>
                    <li class="box-control">
                        <?php $bshdw_s = get_option( 'wa_order_bshdw_spread' ); ?>    
                        <?php if( !isset( $bshdw_s ) ) $bshdw_s = '0'; ?>
                        <input id="wa_order_bshdw_spread" type="number" name="wa_order_bshdw_spread" value="<?php echo get_option('wa_order_bshdw_spread'); ?>" placeholder="">
                        <p class="control-label"><?php _e('Spread', 'oneclick-wa-order'); ?><br /></p>
                    </li>
                    <li class="box-color-control">
                        <?php $bshdw = get_option( 'wa_order_btn_box_shdw' ); ?>
                        <?php if( !isset( $bshdw ) ) $bshdw = 'rgba(0,0,0,0.25)'; ?>
                        <input id="wa_order_btn_box_shdw" type="text" class="color-picker" data-alpha-enabled="true" data-default-color="rgba(0,0,0,.25)" name="wa_order_btn_box_shdw" value="<?php echo sanitize_text_field( $bshdw ); ?>"/>
                    </li>
                </ul>
            </td>
        </tr>        
        <tr class="wa_order_remove_price">
            <th scope="row">
                <label class="wa_order_price_label" for="wa_order_remove_price"><b><?php _e( 'Position', 'oneclick-wa-order' ); ?></b></label>
            </th>
            <td>
                <input type="radio" name="wa_order_bshdw_position" value="outline" <?php checked( 'outline', get_option( 'wa_order_bshdw_position'), true); ?>>
                <?php _e( 'Outline', 'oneclick-wa-order' ); ?>
                <input type="radio" name="wa_order_bshdw_position" value="inset" <?php checked( 'inset', get_option( 'wa_order_bshdw_position'), true); ?>>
                <?php _e( 'Inset', 'oneclick-wa-order' ); ?>
            </td>
        </tr>
        <!-- Hover -->
        <tr class="wa_order_remove_price">
            <th scope="row">
                <label class="wa_order_price_label" for="wa_order_remove_price">
                    <strong><?php _e( 'Box Shadow Hover', 'oneclick-wa-order' ); ?></strong>
                </label>
            </th>
            <td>
                <ul class="boxes-control">
                    <li class="box-control">
                        <?php $bshdw_h_h = get_option( 'wa_order_bshdw_horizontal_hover' ); ?>    
                        <?php if( !isset( $bshdw_h_h ) ) $bshdw_h_h = '0'; ?>
                        <input id="wa_order_bshdw_horizontal_hover" type="number" name="wa_order_bshdw_horizontal_hover" value="<?php echo get_option('wa_order_bshdw_horizontal_hover'); ?>" placeholder="">
                        <p class="control-label"><?php _e('Horizontal', 'oneclick-wa-order'); ?><br /></p>
                    </li>
                    <li class="box-control">
                        <?php $bshdw_v_h = get_option( 'wa_order_bshdw_vertical_hover' ); ?>    
                        <?php if( !isset( $bshdw_v_h ) ) $bshdw_v_h = '4'; ?>
                        <input id="wa_order_bshdw_vertical_hover" type="number" name="wa_order_bshdw_vertical_hover" value="<?php echo get_option('wa_order_bshdw_vertical_hover'); ?>" placeholder="">
                        <p class="control-label"><?php _e('Vertical', 'oneclick-wa-order'); ?><br /></p>
                    </li>
                    <li class="box-control">
                        <?php $bshdw_b_h = get_option( 'wa_order_bshdw_blur_hover' ); ?>    
                        <?php if( !isset( $bshdw_b_h ) ) $bshdw_b_h = '7'; ?>
                        <input id="wa_order_bshdw_blur_hover" type="number" name="wa_order_bshdw_blur_hover" value="<?php echo get_option('wa_order_bshdw_blur_hover'); ?>" placeholder="">
                        <p class="control-label"><?php _e('Blur', 'oneclick-wa-order'); ?><br /></p>
                    </li>
                    <li class="box-control">
                        <?php $bshdw_s_h = get_option( 'wa_order_bshdw_spread_hover' ); ?>    
                        <?php if( !isset( $bshdw_s_h ) ) $bshdw_s_h = '0'; ?>
                        <input id="wa_order_bshdw_spread_hover" type="number" name="wa_order_bshdw_spread_hover" value="<?php echo get_option('wa_order_bshdw_spread_hover'); ?>" placeholder="">
                        <p class="control-label"><?php _e('Spread', 'oneclick-wa-order'); ?><br /></p>
                    </li>
                    <li class="box-color-control">
                        <?php $bshdw = get_option( 'wa_order_btn_box_shdw_hover' ); ?>
                        <?php if( !isset( $bshdw ) ) $bshdw = 'rgba(0,0,0,.25)'; ?>
                        <input id="wa_order_btn_box_shdw_hover" type="text" class="color-picker" data-alpha-enabled="true" data-default-color="rgba(0,0,0,.25)" name="wa_order_btn_box_shdw_hover" value="<?php echo sanitize_text_field( $bshdw ); ?>"/>
                    </li>
                </ul>
            </td>
        </tr>        
        <tr class="wa_order_remove_price">
            <th scope="row">
                <label class="wa_order_price_label" for="wa_order_remove_price"><b><?php _e( 'Hover Position', 'oneclick-wa-order' ); ?></b></label>
            </th>
            <td>
                <input type="radio" name="wa_order_bshdw_position_hover" value="outline" <?php checked( 'outline', get_option( 'wa_order_bshdw_position_hover'), true); ?>>
                <?php _e( 'Outline', 'oneclick-wa-order' ); ?>
                <input type="radio" name="wa_order_bshdw_position_hover" value="inset" <?php checked( 'inset', get_option( 'wa_order_bshdw_position_hover'), true); ?>>
                <?php _e( 'Inset', 'oneclick-wa-order' ); ?>
            </td>
        </tr>
        </tbody>
    </table>
    <!-- END of Button Customizations - Display Options -->
    <hr>
    <!-- Single Product Page Display Options -->
    <table class="form-table">
        <tbody>
            <h3 class="section_wa_order"><?php _e( 'Single Product Page', 'oneclick-wa-order' ); ?></h3>
            <p><?php _e( 'The following options will be only effective on single product page.', 'oneclick-wa-order' ); ?></p>
            <!-- Hide Button on Desktop -->
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Hide Button on Desktop?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_option_remove_btn" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_remove_btn'), 'yes' );?>>
                    <?php _e( 'This will hide WhatsApp Button on Desktop.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>
            <!-- Hide Button on Mobile -->
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Hide Button on Mobile?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_option_remove_btn_mobile" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_remove_btn_mobile'), 'yes' );?>>
                    <?php _e( 'This will hide WhatsApp Button on Mobile.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>

			<tr class="wa_order_option_remove_quantity">
			    <th scope="row">
			        <label class="wa_order_option_remove_quantity" for="wa_order_option_remove_quantity"><b><?php _e( 'Hide Product Quantity Option?', 'oneclick-wa-order' ); ?></b></label>
			    </th>
			    <td>
			        <input type="checkbox" name="wa_order_option_remove_quantity" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_remove_quantity'), 'yes' );?>>
			        <?php _e( 'This will hide product quantity option field.', 'oneclick-wa-order' ); ?>
			            <br>
			    </td>
			</tr>
            <tr class="wa_order_remove_price">
                <th scope="row">
                    <label class="wa_order_price_label" for="wa_order_remove_price"><b><?php _e( 'Hide Price in Product Page?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_option_remove_price" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_remove_price'), 'yes' );?>>
                    <?php _e( 'This will hide price in Product page.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Hide Add to Cart button?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_option_remove_cart_btn" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_remove_cart_btn'), 'yes' );?>>
                    <?php _e( 'This will hide Add to Cart button.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Hide WA Button on Products in Categories', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <select multiple="multiple" name="wa_order_option_exlude_single_product_cats[]" class="postform octo-category-filter" style="width: 50%;">
                       <?php 
                       $option = get_option('wa_order_option_exlude_single_product_cats'); 
                       $option_array = (array) $option;
                       $args = array(
                         'taxonomy' => 'product_cat',
                         'orderby'  => 'name'
                       );
                       $categories = get_categories( $args );
                       foreach ($categories as $category) { 
                       $selected = in_array( $category->cat_ID, $option_array ) ? ' selected="selected" ' : ''; ?>
                           <option value="<?php echo $category->term_id; ?>" <?php echo $selected; ?> >
                              <?php echo ucwords($category->cat_name) . ' (' . $category->category_count .')'; ?>
                           </option>
                       <?php } //endforeach ?>
                    </select>
                    <p>
                    <?php _e('You can hide the WhatsApp button on products in the selected categories.', 'oneclick-wa-order'); ?>
                    <br />
                    </p>
                    <br>
                </td>
            </tr>
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Hide WA Button on Products in Tags', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <select multiple="multiple" name="wa_order_option_exlude_single_product_tags[]" class="postform octo-category-filter" style="width: 50%;">
                    <?php 
                    $option = get_option('wa_order_option_exlude_single_product_tags'); 
                    $option_array = (array) $option;
                    $args = array(
                     'taxonomy' => 'product_tag',
                     'orderby'  => 'name'
                    );
                    $tag_query = get_terms( $args );
                    foreach ($tag_query as $term) { ?>
                    <?php $selected = in_array( $term->term_id, $option_array ) ? ' selected="selected" ' : ''; ?>
                       <option value="<?php echo $term->term_id; ?>" <?php echo $selected; ?> >
                          <?php echo ucwords($term->name) . ' (' . $term->count .')'; ?>
                       </option>
                   <?php } //endforeach ?>
                    </select>
                    <p>
                    <?php _e('You can hide the WhatsApp button on products in the selected tags.', 'oneclick-wa-order'); 
                    ?>
                    <br />
                    </p>
                    <br>
                </td>
            </tr>
            <!-- Button Margin -->
            <tr class="wa_order_remove_price">
                <th scope="row">
                    <label class="wa_order_price_label" for="wa_order_remove_price">
                        <strong><?php _e( 'Button Margin', 'oneclick-wa-order' ); ?></strong>
                    </label>
                </th>
                <td>
                    <ul class="boxes-control">
                        <li class="box-control">
                            <input id="wa_order_single_button_margin_top" type="number" name="wa_order_single_button_margin_top" value="<?php echo get_option('wa_order_single_button_margin_top'); ?>" placeholder="">
                            <p class="control-label"><?php _e('Top', 'oneclick-wa-order'); ?><br /></p>
                        </li>
                        <li class="box-control">
                            <input id="wa_order_single_button_margin_right" type="number" name="wa_order_single_button_margin_right" value="<?php echo get_option('wa_order_single_button_margin_right'); ?>" placeholder="">
                            <p class="control-label"><?php _e('Right', 'oneclick-wa-order'); ?><br /></p>
                        </li>
                        <li class="box-control">
                            <input id="wa_order_single_button_margin_bottom" type="number" name="wa_order_single_button_margin_bottom" value="<?php echo get_option('wa_order_single_button_margin_bottom'); ?>" placeholder="">
                            <p class="control-label"><?php _e('Bottom', 'oneclick-wa-order'); ?><br /></p>
                        </li>
                        <li class="box-control">
                            <input id="wa_order_single_button_margin_left" type="number" name="wa_order_single_button_margin_left" value="<?php echo get_option('wa_order_single_button_margin_left'); ?>" placeholder="">
                            <p class="control-label"><?php _e('Left', 'oneclick-wa-order'); ?><br /></p>
                        </li>
                    </ul>
                </td>
            </tr>
            <!-- END - Button Margin -->

            <!-- Button Padding -->
            <tr class="wa_order_remove_price">
                <th scope="row">
                    <label class="wa_order_price_label" for="wa_order_remove_price">
                        <strong><?php _e( 'Button Padding', 'oneclick-wa-order' ); ?></strong>
                    </label>
                </th>
                <td>
                    <ul class="boxes-control">
                        <li class="box-control">
                            <input id="wa_order_single_button_padding_top" type="number" name="wa_order_single_button_padding_top" value="<?php echo get_option('wa_order_single_button_padding_top'); ?>" placeholder="">
                            <p class="control-label"><?php _e('Top', 'oneclick-wa-order'); ?><br /></p>
                        </li>
                        <li class="box-control">
                            <input id="wa_order_single_button_padding_right" type="number" name="wa_order_single_button_padding_right" value="<?php echo get_option('wa_order_single_button_padding_right'); ?>" placeholder="">
                            <p class="control-label"><?php _e('Right', 'oneclick-wa-order'); ?><br /></p>
                        </li>
                        <li class="box-control">
                            <input id="wa_order_single_button_padding_bottom" type="number" name="wa_order_single_button_padding_bottom" value="<?php echo get_option('wa_order_single_button_padding_bottom'); ?>" placeholder="">
                            <p class="control-label"><?php _e('Bottom', 'oneclick-wa-order'); ?><br /></p>
                        </li>
                        <li class="box-control">
                            <input id="wa_order_single_button_padding_left" type="number" name="wa_order_single_button_padding_left" value="<?php echo get_option('wa_order_single_button_padding_left'); ?>" placeholder="">
                            <p class="control-label"><?php _e('Left', 'oneclick-wa-order'); ?><br /></p>
                        </li>
                    </ul>
                </td>
            </tr>
            <!-- END - Button Padding -->
        </tbody>
    </table>
    <!-- END of Single Product Page Display Options -->
    <hr>
    <!-- Shop Loop Display Options -->
        <table class="form-table">
        <tbody>            
            <h2 class="section_wa_order"><?php _e( 'Shop Loop Page', 'oneclick-wa-order' ); ?></h2>
            <p><?php _e( 'The following options will be only effective on shop loop page.', 'oneclick-wa-order' ); ?></p>
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Hide Button on Desktop?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_display_option_shop_loop_hide_desktop" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_display_option_shop_loop_hide_desktop'), 'yes' );?>>
                    <?php _e( 'This will hide WhatsApp Button on Desktop.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Hide Button on Mobile?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_display_option_shop_loop_hide_mobile" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_display_option_shop_loop_hide_mobile'), 'yes' );?>>
                    <?php _e( 'This will hide WhatsApp Button on Mobile.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>

            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Hide WA Button Under Products in Categories', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <?php wp_enqueue_script( 'wa_order_js_select2'); ?>
                    <?php wp_enqueue_script( 'wa_order_js_admin'); ?>
                    <?php wp_enqueue_style( 'wa_order_selet2_style'); ?>
                    <select multiple="multiple" name="wa_order_option_exlude_shop_product_cats[]" class="postform octo-category-filter" style="width: 50%;">
                       <?php 
                       $option = get_option('wa_order_option_exlude_shop_product_cats'); 
                       $option_array = (array) $option;
                       $args = array(
                         'taxonomy' => 'product_cat',
                         'orderby'  => 'name'
                       );
                       $categories = get_categories( $args );
                       foreach ($categories as $category) { 
                       $selected = in_array( $category->cat_ID, $option_array ) ? ' selected="selected" ' : ''; ?>
                           <option value="<?php echo $category->term_id; ?>" <?php echo $selected; ?> >
                              <?php echo ucwords($category->cat_name) . ' (' . $category->category_count .')'; ?>
                           </option>
                       <?php } //endforeach ?>
                    </select>
                    <p>
                    <?php _e('You can hide the WhatsApp button under products in the selected categories.', 'oneclick-wa-order'); ?>
                    <br />
                    </p>
                    <br>
                </td>
            </tr>

            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Also Hide on Category Archive Page(s)?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_exlude_shop_product_cats_archive" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_exlude_shop_product_cats_archive'), 'yes' );?>>
                    <?php _e( 'This will hide WhatsApp Button on the selected category archive page(s).', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>

            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Hide WA Button Under Products in Tags', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <select multiple="multiple" name="wa_order_option_exlude_shop_product_tags[]" class="postform octo-category-filter" style="width: 50%;">
                    <?php 
                    $option = get_option('wa_order_option_exlude_shop_product_tags'); 
                    $option_array = (array) $option;
                    $args = array(
                     'taxonomy' => 'product_tag',
                     'orderby'  => 'name'
                    );
                    $tag_query = get_terms( $args );
                    foreach ($tag_query as $term) { ?>
                    <?php $selected = in_array( $term->term_id, $option_array ) ? ' selected="selected" ' : ''; ?>
                       <option value="<?php echo $term->term_id; ?>" <?php echo $selected; ?> >
                          <?php echo ucwords($term->name) . ' (' . $term->count .')'; ?>
                       </option>
                   <?php } //endforeach ?>
                    </select>
                    <p>
                    <?php _e('You can hide the WhatsApp button under products in the selected tags.', 'oneclick-wa-order'); 
                    ?>
                    <br />
                    </p>
                    <br>
                </td>
            </tr>

            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Also Hide on Tag Archive Page(s)?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_exlude_shop_product_tags_archive" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_exlude_shop_product_tags_archive'), 'yes' );?>>
                    <?php _e( 'This will hide WhatsApp Button on the selected tag archive page(s).', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- END of Shop Loop Display Options -->
    <hr>

        <!-- Cart Display Options -->
        <table class="form-table">
        <tbody>            
            <h2 class="section_wa_order"><?php _e( 'Cart Page', 'oneclick-wa-order' ); ?></h2>
            <p><?php _e( 'The following options will be only effective on cart page.', 'oneclick-wa-order' ); ?></p>
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Hide Button on Desktop?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_display_option_cart_hide_desktop" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_display_option_cart_hide_desktop'), 'yes' );?>>
                    <?php _e( 'This will hide WhatsApp Button on Desktop.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Hide Button on Mobile?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_display_option_cart_hide_mobile" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_display_option_cart_hide_mobile'), 'yes' );?>>
                    <?php _e( 'This will hide WhatsApp Button on Mobile.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- END of Cart Display Options -->
    <hr>

        <!-- Checkout / Thank You Page Display Options -->
        <table class="form-table">
        <tbody>            
            <h2 class="section_wa_order"><?php _e( 'Thank You Page', 'oneclick-wa-order' ); ?></h2>
            <p><?php _e( 'The following options will be only effective on cart page.', 'oneclick-wa-order' ); ?></p>
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Hide Button on Desktop?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_display_option_checkout_hide_desktop" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_display_option_checkout_hide_desktop'), 'yes' );?>>
                    <?php _e( 'This will hide WhatsApp Button on Desktop.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>
            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_remove_add_btn"><b><?php _e( 'Hide Button on Mobile?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_display_option_checkout_hide_mobile" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_display_option_checkout_hide_mobile'), 'yes' );?>>
                    <?php _e( 'This will hide WhatsApp Button on Mobile.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- END of Checkout / Thank You Page Display Options -->
    <hr>
    <!-- Miscellaneous Display Options -->
    <table class="form-table">
        <tbody>            
            <h2 class="section_wa_order"><?php _e( 'Miscellaneous', 'oneclick-wa-order' ); ?></h2>
            <p><?php _e( 'An additional option you might need.', 'oneclick-wa-order' ); ?></p>

            <tr class="wa_order_remove_add_btn">
                <th scope="row">
                    <label class="wa_order_remove_add_label" for="wa_order_convert_phone"><b><?php _e( 'Convert Phone Number into WhatsApp in Order Details?', 'oneclick-wa-order' ); ?></b></label>
                </th>
                <td>
                    <input type="checkbox" name="wa_order_option_convert_phone_order_details" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_convert_phone_order_details'), 'yes' );?>>
                    <?php _e( 'This will convert phone number link into WhatsApp chat link.', 'oneclick-wa-order' ); ?>
                        <br>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- END of Miscellaneous Display Options -->
    <hr>
        <?php submit_button(); ?>
    </form>
        <?php } elseif ( $active_tab == 'shop_page' ) { ?>
            <!-- Custom Shortcode -->
            <form method="post" action="options.php">
            <?php settings_errors(); ?>
            <?php settings_fields( 'wa-order-settings-group-shop-loop' ); ?> 
            <?php do_settings_sections( 'wa-order-settings-group-shop-loop' ); ?>
            <h2 class="section_wa_order"><?php _e( 'WhatsApp Button on Shop Page', 'oneclick-wa-order' ); ?></h2>
            <p>
                <?php _e('Add custom WhatsApp button on <strong>Shop</strong> page or product loop page right under / besides of the <strong>Add to Cart</strong> button.', 'oneclick-wa-order'); ?>
                    <br />
            </p>
            <table class="form-table">
                <tbody>
                    <tr class="wa_order_target">
                        <th scope="row">
                            <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Display button on Shop page?', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <input type="checkbox" name="wa_order_option_enable_button_shop_loop" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_enable_button_shop_loop'), 'yes' );?>>
                            <?php _e( 'This will display WhatsApp button on Shop page', 'oneclick-wa-order' ); ?>
                                <br>
                        </td>
                    </tr> 
                    <!-- Dropdown WA Number -->
                    <tr>
                        <th scope="row">
                            <label>
                                <?php _e('WhatsApp Number', 'oneclick-wa-order') ?>
                            </label>
                        </th>
                        <td>
                            <?php wa_order_phone_numbers_dropdown( 
                                array(
                                    'name'      => 'wa_order_selected_wa_number_shop',
                                    'selected'  => ( get_option('wa_order_selected_wa_number_shop')),
                                    ) 
                                ) 
                            ?>
                            <p class="description">
                                <?php _e( 'WhatsApp number is <strong style="color:red;">required</strong>. Please set it on <a href="edit.php?post_type=wa-order-numbers"><strong>Numbers</strong></a> tab.', 'oneclick-wa-order' ); ?>
                                </p>
                        </td>
                    </tr>
                    <!-- Dropdown WA Number -->
                    <tr class="wa_order_target">
                        <th scope="row">
                            <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Hide Add to Cart button?', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <input type="checkbox" name="wa_order_option_hide_atc_shop_loop" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_hide_atc_shop_loop'), 'yes' );?>>
                            <?php _e( 'This will only display WhatsApp button and hide the <code>Add to Cart</code> button', 'oneclick-wa-order' ); ?>
                                <br>
                        </td>
                    </tr>                    

                    <tr class="wa_order_btn_text">
                        <th scope="row">
                            <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Text on Button', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <input type="text" name="wa_order_option_button_text_shop_loop" class="wa_order_input" value="<?php echo get_option('wa_order_option_button_text_shop_loop'); ?>" placeholder="<?php _e( 'e.g. Buy via WhatsApp', 'oneclick-wa-order' ); ?>">
                        </td>
                    </tr>
                    <tr class="wa_order_message">
                        <th scope="row">
                            <label class="wa_order_message_label" for="message_wbw"><b><?php _e( 'Custom Message', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <textarea name="wa_order_option_custom_message_shop_loop" class="wa_order_input_areatext" rows="5" placeholder="<?php _e( 'e.g. Hello, I want to purchase:', 'oneclick-wa-order' ); ?>"><?php echo get_option('wa_order_option_custom_message_shop_loop'); ?></textarea>
                            <p class="description">
                                <?php _e( 'Enter custom message, e.g. <code>Hello, I want to purchase:</code>', 'oneclick-wa-order' ); ?></p></td>
                    </tr>

                    <tr class="wa_order_target">
                        <th scope="row">
                            <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Exclude Price?', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <input type="checkbox" name="wa_order_option_shop_loop_exclude_price" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_shop_loop_exclude_price'), 'yes' );?>>
                            <?php _e( 'This will remove product price from WhatsApp message sent from Shop loop page.', 'oneclick-wa-order' ); ?>
                                <br>
                        </td>
                    </tr>

                    <tr class="wa_order_target">
                        <th scope="row">
                            <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Remove Product URL?', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <input type="checkbox" name="wa_order_option_shop_loop_hide_product_url" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_shop_loop_hide_product_url'), 'yes' );?>>
                            <?php _e( 'This will remove product URL from WhatsApp message sent from Shop loop page.', 'oneclick-wa-order' ); ?>
                                <br>
                        </td>
                    </tr>

                    <tr class="wa_order_target">
                        <th scope="row">
                            <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Open in New Tab?', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <input type="checkbox" name="wa_order_option_shop_loop_open_new_tab" value="_blank" class="wa_order_input_check" <?php checked( get_option( 'wa_order_option_shop_loop_open_new_tab'), '_blank' );?>>
                            <?php _e( 'Yes, Open in New Tab', 'oneclick-wa-order' ); ?>
                                <br>
                        </td>
                    </tr> 

                </tbody>
            </table>
            <hr>
                </tbody>
            </table>
    <?php submit_button(); ?>
    </form>
        <?php } elseif ( $active_tab == 'cart_button' ) { ?>
            <!-- Custom Shortcode -->
            <form method="post" action="options.php">
            <?php settings_errors(); ?>
            <?php settings_fields( 'wa-order-settings-group-cart-options' ); ?> 
            <?php do_settings_sections( 'wa-order-settings-group-cart-options' ); ?>
            <h2 class="section_wa_order"><?php _e( 'WhatsApp Button on Cart Page', 'oneclick-wa-order' ); ?></h2>
            <p>
                <?php _e('Add custom WhatsApp button on <strong>Cart</strong> page right under the <strong>Proceed to Checkout</strong> button.', 'oneclick-wa-order'); ?>
                    <br />
            </p>
            <table class="form-table">
                <tbody>
                    <tr class="wa_order_target">
                        <th scope="row">
                            <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Display button on Cart page?', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <input type="checkbox" name="wa_order_option_add_button_to_cart" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_add_button_to_cart'), 'yes' );?>>
                            <?php _e( 'This will display WhatsApp button on Cart page', 'oneclick-wa-order' ); ?>
                                <br>
                        </td>
                    </tr> 
                    <!-- Dropdown WA Number -->
                    <tr>
                        <th scope="row">
                            <label>
                                <?php _e('WhatsApp Number', 'oneclick-wa-order') ?>
                            </label>
                        </th>
                        <td>
                            <?php wa_order_phone_numbers_dropdown( 
                                array(
                                    'name'      => 'wa_order_selected_wa_number_cart',
                                    'selected'  => ( get_option('wa_order_selected_wa_number_cart')), 
                                    ) 
                                ) 
                            ?>
                            <p class="description">
                                <?php _e( 'WhatsApp number is <strong style="color:red;">required</strong>. Please set it on <a href="edit.php?post_type=wa-order-numbers"><strong>Numbers</strong></a> tab.', 'oneclick-wa-order' ); ?>
                                </p>
                        </td>
                    </tr>
                    <!-- Dropdown WA Number -->
                    <tr class="wa_order_target">
                        <th scope="row">
                            <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Hide Proceed to Checkout button?', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <input type="checkbox" name="wa_order_option_cart_hide_checkout" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_cart_hide_checkout'), 'yes' );?>>
                            <?php _e( 'This will only display WhatsApp button and hide the <code>Proceed to Checkout</code> button', 'oneclick-wa-order' ); ?>
                                <br>
                        </td>
                    </tr>                    

                    <tr class="wa_order_btn_text">
                        <th scope="row">
                            <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Text on Button', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <input type="text" name="wa_order_option_cart_button_text" class="wa_order_input" value="<?php echo get_option('wa_order_option_cart_button_text'); ?>" placeholder="<?php _e( 'e.g. Complete Order via WhatsApp', 'oneclick-wa-order' ); ?>">
                        </td>
                    </tr>
                    <tr class="wa_order_message">
                        <th scope="row">
                            <label class="wa_order_message_label" for="message_wbw"><b><?php _e( 'Custom Message', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <textarea name="wa_order_option_cart_custom_message" class="wa_order_input_areatext" rows="5" placeholder="<?php _e( 'e.g. Hello, I want to purchase the item(s) below:', 'oneclick-wa-order' ); ?>"><?php echo get_option('wa_order_option_cart_custom_message'); ?></textarea>
                            <p class="description">
                                <?php _e( 'Enter custom message, e.g. <code>Hello, I want to purchase the item(s) below:</code>', 'oneclick-wa-order' ); ?></p></td>
                    </tr>

                    <tr class="wa_order_target">
                        <th scope="row">
                            <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Remove Product URL?', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <input type="checkbox" name="wa_order_option_cart_hide_product_url" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_cart_hide_product_url'), 'yes' );?>>
                            <?php _e( 'This will remove product URL from WhatsApp message sent from Cart page.', 'oneclick-wa-order' ); ?>
                                <br>
                        </td>
                    </tr>

                    <tr class="wa_order_target">
                        <th scope="row">
                            <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Include Product Variation?', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <input type="checkbox" name="wa_order_option_cart_enable_variations" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_cart_enable_variations'), 'yes' );?>>
                            <?php _e( 'This will include the product variation in the message. Note: Works only if the variation stored by WooCommerce, might not all.', 'oneclick-wa-order' ); ?>
                                <br>
                        </td>
                    </tr> 

                    <tr class="wa_order_target">
                        <th scope="row">
                            <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Open in New Tab?', 'oneclick-wa-order' ); ?></b></label>
                        </th>
                        <td>
                            <input type="checkbox" name="wa_order_option_cart_open_new_tab" class="wa_order_input_check" value="_blank" <?php checked( get_option( 'wa_order_option_cart_open_new_tab'), '_blank' );?>>
                            <?php _e( 'Yes, Open in New Tab', 'oneclick-wa-order' ); ?>
                                <br>
                        </td>
                    </tr> 

                </tbody>
            </table>
            <hr>
                </tbody>
            </table>
    <?php submit_button(); ?>
    </form>
        <?php } elseif ( $active_tab == 'thanks_page' ) { ?>
                    <!-- Custom Shortcode -->
                    <form method="post" action="options.php">
                    <?php settings_errors(); ?>
                    <?php settings_fields( 'wa-order-settings-group-order-completion' ); ?> 
                    <?php do_settings_sections( 'wa-order-settings-group-order-completion' ); ?>


                    <h2 class="section_wa_order"><?php _e( 'Thank You Page Customization', 'oneclick-wa-order' ); ?></h2>
                    <p>
                        <?php _e('Add a WhatsApp button on <strong>Thank You</strong> / <strong>Order Received</strong>. If enabled, it will add a new section under the <strong>Order Received</strong> or <strong>Thank You</strong> title and override default text by using below data, including adding a WhatsApp button to send order details. <br /><strong>Tip:</strong> You can use this to make it quick for your customers to send their own order receipt to you via WhatsApp.', 'oneclick-wa-order'); ?>
                            <br />
                    </p>
                    <table class="form-table">
                        <tbody>
                            <tr class="wa_order_target">
                                <th scope="row">
                                    <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Enable Setting?', 'oneclick-wa-order' ); ?></b></label>
                                </th>
                                <td>
                                    <input type="checkbox" name="wa_order_option_enable_button_thank_you" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_enable_button_thank_you'), 'yes' );?>>
                                    <?php _e( 'This will override default appearance and add a WhatsApp button.', 'oneclick-wa-order' ); ?>
                                        <br>
                                </td>
                            </tr>
                            <!-- Dropdown WA Number -->
                            <tr>
                                <th scope="row">
                                    <label>
                                        <?php _e('WhatsApp Number', 'oneclick-wa-order') ?>
                                    </label>
                                </th>
                                <td>
                                    <?php wa_order_phone_numbers_dropdown( 
                                        array(
                                            'name'      => 'wa_order_selected_wa_number_thanks',
                                            'selected'  => ( get_option('wa_order_selected_wa_number_thanks')), 
                                            ) 
                                        ) 
                                    ?>
                                    <p class="description">
                                        <?php _e( 'WhatsApp number is <strong style="color:red;">required</strong>. Please set it on <a href="edit.php?post_type=wa-order-numbers"><strong>Numbers</strong></a> tab.', 'oneclick-wa-order' ); ?>
                                        </p>
                                </td>
                            </tr>
                            <!-- Dropdown WA Number -->       
                            <tr class="wa_order_btn_text">
                                <th scope="row">
                                    <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Text on Button', 'oneclick-wa-order' ); ?></b></label>
                                </th>
                                <td>
                                    <input type="text" name="wa_order_option_custom_thank_you_button_text" class="wa_order_input" value="<?php echo get_option('wa_order_option_custom_thank_you_button_text'); ?>" placeholder="<?php _e( 'e.g. Send Order Details', 'oneclick-wa-order' ); ?>">
                                    <p class="description">
                                        <?php _e( 'Enter the text on WhatsApp button.<code>e.g. Send Order Details</code>', 'oneclick-wa-order' ); ?>
                                    </p>
                                </td>
                            </tr>
                            <tr class="wa_order_message">
                                <th scope="row">
                                    <label class="wa_order_message_label" for="message_wbw"><b><?php _e( 'Custom Message', 'oneclick-wa-order' ); ?></b></label>
                                </th>
                                <td>
                                    <textarea name="wa_order_option_custom_thank_you_custom_message" class="wa_order_input_areatext" rows="5" placeholder="<?php _e( 'e.g. Hello, here\'s my order details:', 'oneclick-wa-order' ); ?>"><?php echo get_option('wa_order_option_custom_thank_you_custom_message'); ?></textarea>
                                    <p class="description">
                                        <?php _e( 'Enter custom message to send along with order details. e.g. <br><code>Hello, here\'s my order details:</code>', 'oneclick-wa-order' ); ?></p></td>
                            </tr>
                            <tr class="wa_order_btn_text">
                                <th scope="row">
                                    <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Custom Title', 'oneclick-wa-order' ); ?></b></label>
                                </th>
                                <td>
                                    <input type="text" name="wa_order_option_custom_thank_you_title" class="wa_order_input" value="<?php echo get_option('wa_order_option_custom_thank_you_title'); ?>" placeholder="<?php _e( 'e.g. Thanks and You\'re  Awesome', 'oneclick-wa-order' ); ?>">
                                    <p class="description">
                                        <?php _e( 'You can personalize the title by changing it here. This will be shown like this:<br/> <code>[your custom title], [customer\'s first name]</code>.<br/>e.g. Thanks and You\'re  Awesome, Igor!', 'oneclick-wa-order' ); ?>
                                    </p>
                                </td>
                            </tr>
                            <tr class="wa_order_message">
                                <th scope="row">
                                    <label class="wa_order_message_label" for="message_wbw"><b><?php _e( 'Custom Subtitle', 'oneclick-wa-order' ); ?></b></label>
                                </th>
                                <td>
                                    <textarea name="wa_order_option_custom_thank_you_subtitle" class="wa_order_input_areatext" rows="5" placeholder="<?php _e( 'e.g. For faster response, send your order details by clicking below button.', 'oneclick-wa-order' ); ?>"><?php echo get_option('wa_order_option_custom_thank_you_subtitle'); ?></textarea>
                                    <p class="description">
                                        <?php _e( 'Enter custom subtitle. e.g. <br><code>For faster response, send your order details by clicking below button.</code>', 'oneclick-wa-order' ); ?></p></td>
                            </tr>

                            <!-- Customer Details Label -->
                            <tr class="wa_order_target">
                                <th scope="row">
                                    <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Customer Details Label', 'oneclick-wa-order' ); ?></b></label>
                                </th>
                                <td>
                                    <input type="text" name="wa_order_option_custom_thank_you_customer_details_label" class="wa_order_input" value="<?php echo get_option('wa_order_option_custom_thank_you_customer_details_label'); ?>" placeholder="<?php _e( 'e.g. Customer Details', 'oneclick-wa-order' ); ?>">
                                    <p class="description">
                                        <?php _e( 'Enter a label. e.g. <code>Customer Details</code>', 'oneclick-wa-order' ); ?>
                                    </p>
                                </td>
                            </tr>

                            <!-- END - Customer Details Label -->

                            <tr class="wa_order_target">
                                <th scope="row">
                                    <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Include Coupon Discount?', 'oneclick-wa-order' ); ?></b></label>
                                </th>
                                <td>
                                    <input type="checkbox" name="wa_order_option_custom_thank_you_inclue_coupon" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_custom_thank_you_inclue_coupon'), 'yes' );?>>
                                    <?php _e( 'This will include coupon code and its deduction amount, including a label (the label must be set below if it\'s enabled).', 'oneclick-wa-order' ); ?>
                                        <br>
                                </td>
                            </tr>

                            <tr class="wa_order_btn_text">
                                <th scope="row">
                                    <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Coupon Label', 'oneclick-wa-order' ); ?></b></label>
                                </th>
                                <td>
                                    <input type="text" name="wa_order_option_custom_thank_you_coupon_label" class="wa_order_input" value="<?php echo get_option('wa_order_option_custom_thank_you_coupon_label'); ?>" placeholder="<?php _e( 'e.g. Voucher Code', 'oneclick-wa-order' ); ?>">
                                    <p class="description">
                                        <?php _e( 'Enter a label. e.g. <code>Voucher Code</code>', 'oneclick-wa-order' ); ?>
                                    </p>
                                </td>
                            </tr>
                            <!-- Include Order Number -->
                            <tr class="wa_order_target">
                                <th scope="row">
                                    <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Include Order Number?', 'oneclick-wa-order' ); ?></b></label>
                                </th>
                                <td>
                                    <input type="checkbox" name="wa_order_option_custom_thank_you_order_number" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_custom_thank_you_order_number'), 'yes' );?>>
                                    <?php _e( 'This will include the order number including a label (the label must be set below if it\'s enabled).', 'oneclick-wa-order' ); ?>
                                        <br>
                                </td>
                            </tr>
                            <!-- END - Include Order Number -->

                            <!-- Order Number Label -->
                            <tr class="wa_order_btn_text">
                                <th scope="row">
                                    <label class="wa_order_btn_txt_label" for="text_button"><b><?php _e( 'Order Number Label', 'oneclick-wa-order' ); ?></b></label>
                                </th>
                                <td>
                                    <input type="text" name="wa_order_option_custom_thank_you_order_number_label" class="wa_order_input" value="<?php echo get_option('wa_order_option_custom_thank_you_order_number_label'); ?>" placeholder="<?php _e( 'e.g. Order Number:', 'oneclick-wa-order' ); ?>">
                                    <p class="description">
                                        <?php _e( 'Enter a label. e.g. <code>Order Number:</code>', 'oneclick-wa-order' ); ?>
                                    </p>
                                </td>
                            </tr>
                            <!-- END - Order Number Label -->

                            <!-- Order Date -->
                            <tr class="wa_order_target">
                                <th scope="row">
                                    <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Include Product SKU?', 'oneclick-wa-order' ); ?></b></label>
                                </th>
                                <td>
                                    <input type="checkbox" name="wa_order_option_custom_thank_you_include_sku" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_custom_thank_you_include_sku'), 'yes' );?>>
                                    <?php _e( 'Yes, Include Product SKU', 'oneclick-wa-order' ); ?>
                                        <br>
                                </td>
                            </tr>
                            <!-- END - Order Date -->

                            <!-- Order Date -->
                            <tr class="wa_order_target">
                                <th scope="row">
                                    <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Include Order Date?', 'oneclick-wa-order' ); ?></b></label>
                                </th>
                                <td>
                                    <input type="checkbox" name="wa_order_option_custom_thank_you_include_order_date" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_option_custom_thank_you_include_order_date'), 'yes' );?>>
                                    <?php _e( 'Yes, Include Order Date', 'oneclick-wa-order' ); ?>
                                        <br>
                                </td>
                            </tr>
                            <!-- END - Order Date -->
                            <tr class="wa_order_target">
                                <th scope="row">
                                    <label class="wa_order_remove_btn_label" for="wa_order_remove_wa_order_btn"><b><?php _e( 'Open in New Tab?', 'oneclick-wa-order' ); ?></b></label>
                                </th>
                                <td>
                                    <input type="checkbox" name="wa_order_option_custom_thank_you_open_new_tab" class="wa_order_input_check" value="_blank" <?php checked( get_option( 'wa_order_option_custom_thank_you_open_new_tab'), '_blank' );?>>
                                    <?php _e( 'Yes, Open in New Tab', 'oneclick-wa-order' ); ?>
                                        <br>
                                </td>
                            </tr>

                    </tbody>
                </table> 
            <hr>    
                <?php submit_button(); ?>
            </form>       
        <?php } elseif( $active_tab == 'gdpr_notice' ) { ?>
    <form method="post" action="options.php">
    <?php settings_errors(); ?>
    <?php settings_fields( 'wa-order-settings-group-gdpr' ); ?> 
    <?php do_settings_sections( 'wa-order-settings-group-gdpr' ); ?>
        <!-- GDPR Notice -->
        <h2 class="section_wa_order"><?php _e( 'GDPR Notice', 'oneclick-wa-order' ); ?></h2>
        <p>
            <?php _e('You can enable or disable the GDPR notice to make your site more GDPR compliant. <br>The GDPR notice you configure below will be displayed right under the WhatsApp Order button. <br>
            Please note that this option will only show the GDPR notice on single product page.', 'oneclick-wa-order'); ?>
                <br />
        </p>
        <table class="form-table">
            <tbody>

                <tr>
                    <th scope="row">
                        <label>
                            <?php _e('Enable GDPR Notice', 'oneclick-wa-order') ?>
                        </label>
                    </th>
                    <td>
                        <input type="checkbox" name="wa_order_gdpr_status_enable" class="wa_order_input_check" value="yes" <?php checked( get_option( 'wa_order_gdpr_status_enable'), 'yes' ); ?>>
                        <?php _e( 'Check to Enable GDPR Notice.', 'oneclick-wa-order' ) ?>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label>
                            <?php _e('GDPR Message', 'oneclick-wa-order') ?>
                        </label>
                    </th>
                    <td>
                        <textarea name="wa_order_gdpr_message" class="wa_order_input_areatext" rows="5" placeholder="<?php _e( 'e.g. I have read the [gdpr_link]', 'oneclick-wa-order' ); ?>"><?php echo get_option('wa_order_gdpr_message'); ?></textarea>
                        <p class="description">
                            <?php printf( __('Use %s to display Privacy Policy page link.', 'oneclick-wa-order') , '<code>[gdpr_link]</code>' ) ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label>
                            <?php _e('Privacy Policy Page', 'oneclick-wa-order') ?>
                        </label>
                    </th>
                    <td>
                        <?php wa_order_options_dropdown( 
                            array(
                                'name'      => 'wa_order_gdpr_privacy_page',
                                'selected'  => ( get_option('wa_order_gdpr_privacy_page')), 
                                ) 
                            ) 
                        ?>
                    </td>
                </tr>
            </tbody>
        </table> 
    <hr>    
        <?php submit_button(); ?>
    </form>
 <?php } elseif( $active_tab == 'tutorial_support' ) { ?>
    <!-- Begin creating plugin admin page --> 
    <div class="wrap">
            <div class="feature-section one-col wrap about-wrap">
     
        <div class="about-text">
            <h4><?php printf( __( "<strong>OneClick Chat to Order</strong> is Waiting for Your Feedback", 'oneclick-wa-order' )); ?></h>
        </div>
                <div class="indo-about-description">
                    <?php printf( __( "<strong>OneClick Chat to Order</strong> is my second plugin and it's open source. I acknowledge that there are still a lot to fix, here and there, that's why I really need your feedback. <br>Let's get in touch and show some love by <a href=\"https://wordpress.org/support/plugin/oneclick-whatsapp-order/reviews/?rate=5#new-post\" target=\"_blank\"><strong>leaving a review</strong></a>.", 'oneclick-wa-order' )); ?>
                        </div>                    

<table class="tg" style="table-layout: fixed; width: 269px">
    <colgroup>
        <col style="width: 105px">
            <col style="width: 164px">
    </colgroup>
    <tr>
        <th class="tg-kiyi">
        	<?php _e( 'Author:', 'oneclick-wa-order' ); ?></th>
        <th class="tg-fymr">
        	<?php _e( 'Walter Pinem', 'oneclick-wa-order' ); ?></th>
    </tr>
    <tr>
        <td class="tg-kiyi">
        	<?php _e( 'Website:', 'oneclick-wa-order' ); ?></td>
        <td class="tg-fymr"><a href="https://walterpinem.me/" target="_blank">
        	<?php _e( 'walterpinem.me', 'oneclick-wa-order' ); ?></a></td>
    </tr>
    <tr>
        <td class="tg-kiyi" rowspan="2"></td>
        <td class="tg-fymr"><a href="https://www.seniberpikir.com/" target="_blank">
        	<?php _e( 'www.seniberpikir.com', 'oneclick-wa-order' ); ?></a></td>
    </tr>
    <tr>
        <td class="tg-fymr"><a href="https://kerjalepas.com/" target="_blank">
        	<?php _e( 'www.kerjalepas.com', 'oneclick-wa-order' ); ?></a></td>
    </tr>
    <tr>
        <td class="tg-kiyi">
        	<?php _e( 'Email:', 'oneclick-wa-order' ); ?></td>
        <td class="tg-fymr"><a href="mailto:hello@walterpinem.me" target="_blank">
        	<?php _e( 'hello@walterpinem.me', 'oneclick-wa-order' ); ?></a></td>
    </tr>
    <tr>
        <td class="tg-kiyi"><?php _e( 'More:', 'oneclick-wa-order' ); ?></td>
        <td class="tg-fymr"><a href="https://youtu.be/LuURM5vZyB8" target="_blank">
            <?php _e( 'Complete Tutorial', 'oneclick-wa-order' ); ?></a></td>
    </tr>
    <tr>
        <td class="tg-kiyi" rowspan="3"></td>
        <td class="tg-fymr"><a href="https://walterpinem.me/projects/contact/" target="_blank">
            <?php _e( 'Support & Feature Request', 'oneclick-wa-order' ); ?></a></td>
    </tr>
    <tr>
        <td class="tg-fymr"><a href="https://walterpinem.me/portfolio/" target="_blank">
        	<?php _e( 'Portfolio', 'oneclick-wa-order' ); ?></a></td>
    </tr>
    <tr>
        <td class="tg-fymr"><a href="https://www.linkedin.com/in/walterpinem/" target="_blank">
        	<?php _e( 'Linkedin', 'oneclick-wa-order' ); ?></a></td>
    </tr>
    <tr>
        <td class="tg-kiyi" rowspan="3"></td>
        <td class="tg-fymr"><a href="https://www.paypal.me/WalterPinem" target="_blank">
        	<?php _e( 'Donate', 'oneclick-wa-order' ); ?></a></td>
    </tr>
</table>
<br>
<hr>
<?php echo do_shortcode("[donate]"); ?>

<center><p><?php printf( __( "Created with ❤ and ☕ in Central Jakarta, Indonesia by <a href=\"https://walterpinem.me\" target=\"_blank\"><strong>Walter Pinem</strong></a>", 'oneclick-wa-order' )); ?></p></center>             
    </div>
    </div>
  <?php } elseif ( $active_tab == 'welcome' ) { ?>
    <!-- Begin creating plugin admin page --> 
    <div class="wrap">
            <div class="feature-section one-col wrap about-wrap">
    <!-- <div class="wp-badge welcome__logo"></div> --> 
        <div class="indo-title-text"><h2><?php printf( __( 'Thank you for using <br><strong>OneClick Chat to Order</strong>', 'oneclick-wa-order' )); ?></h2>
    <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/oneclick-chat-to-order.png'; ?>" />
        </div>
     
        <div class="feature-section one-col about-text">
            <h3><?php printf( __( "Make It Easy for Customers to Reach You!", 'oneclick-wa-order' )); ?></h3>
        </div>
        <div class="feature-section one-col indo-about-description">
            <p>
                <?php _e( '<strong>OneClick Chat to Order</strong> will enable you to connect your WooCommerce-powered online store with WhatsApp and make it super quick and easy for your customers to complete their order via WhatsApp.', 'oneclick-wa-order' ); 
                ?>
            </p>
            <p>
                <?php _e( '<a href="https://onlinestorekit.com/oneclick-chat-to-order/" target="_blank"><strong>Learn More</strong></a>', 'oneclick-wa-order' ); 
                ?>
            </p>
        </div>
    <div class="clear"></div>
    <hr>
        <div class="feature-section one-col about-text">
            <h4><?php printf( __( "<strong style=\"color:red;\">NEW!</strong> Build a Powerful Multi-Vendor Online Marketplace", 'oneclick-wa-order' )); ?></h4>
        </div>
        <div class="feature-section one-col indo-about-description">
            <p>
                <?php _e( 'Seamlessly combine the power of WordPress & WooCommerce, OneClick Chat to Order, WCFM Marketplace, WCFM Frontend Manager and WhatsApp with the new and most requested add-on, <a href="https://onlinestorekit.com/oneclick-wcfm-connector/" target="_blank"><strong>OneClick WCFM Connector</strong></a>, that your vendors will love.', 'oneclick-wa-order' ); 
                ?>
            </p>
            <p>
                <?php _e( 'Help them increase their sales, increase your revenue.', 'oneclick-wa-order' ); 
                ?>
            </p>
            <p>
                <?php _e( '<a href="https://onlinestorekit.com/oneclick-wcfm-connector/" target="_blank"><strong>Read Details</strong></a>', 'oneclick-wa-order' ); 
                ?>
            </p>
        </div>
    <div class="clear"></div>
    <hr />
    <div class="feature-section one-col">
        <h3 style="text-align: center;"><?php _e( 'Watch the Complete Overview and Tutorial', 'oneclick-wa-order' ); ?></h3>
        <div class="headline-feature feature-video">
            <div class='embed-container'>
                <iframe src='https://www.youtube.com/embed/?listType=playlist&list=PLwazGJFvaLnBTOw4pNvPcsFW1ls4tn1Uj' frameborder='0' allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <hr />
        <div class="feature-section one-col">
            <div class="indo-get-started"><h3><?php _e( 'Let\'s Get Started', 'oneclick-wa-order' ); ?></h3>
            <ul>
                <li><strong><?php _e( 'Step #1:', 'oneclick-wa-order' ); ?></strong> <?php _e( 'Start adding your <strong>WhatsApp number</strong> on <a href="post-new.php?post_type=wa-order-numbers"><strong>WhatsApp Numbers</strong></a> post type. You can add unlimited numbers! <a href="https://walterpinem.me/projects/oneclick-chat-to-order-mutiple-numbers-feature/?utm_source=admin-notice&utm_medium=admin-dashboard&utm_campaign=OneClick-Chat-to-Order" target="_blank"><strong>Learn more</strong></a> or <a href="admin.php?page=wa-order&tab=button_config"><strong>dismiss notice</strong></a>.', 'oneclick-wa-order' ); ?></li>
                <li><strong><?php _e( 'Step #2:', 'oneclick-wa-order' ); ?></strong> <?php _e( 'Show a fancy<strong> Floating Button</strong> with customized message and tooltip which you can customize easily on <a href="admin.php?page=wa-order&tab=floating_button"><strong>Floating Button</strong></a> setting panel.', 'oneclick-wa-order' ); ?></li>
                <li><strong><?php _e( 'Step #3:', 'oneclick-wa-order' ); ?></strong> <?php _e( 'Configure some options to <strong>display or hide buttons</strong>, including the WhatsApp button on <a href="admin.php?page=wa-order&tab=display_option"><strong>Display Options</strong></a> setting panel.', 'oneclick-wa-order' ); ?></li>
                <li><strong><?php _e( 'Step #4:', 'oneclick-wa-order' ); ?></strong> <?php _e( 'Make your online store GDPR-ready by showing <strong>GDPR Notice</strong> right under the WhatsApp Order button on <a href="admin.php?page=wa-order&tab=gdpr_notice"><strong>GDPR Notice</strong></a> setting panel.', 'oneclick-wa-order' ); ?></li>
                <li><strong><?php _e( 'Step #5:', 'oneclick-wa-order' ); ?></strong> <?php _e( 'Display WhatsApp button anywhere you like with a <strong>single shortcode</strong>. You can generate it with a customized message and a nice text on button on <a href="admin.php?page=wa-order&tab=generate_shortcode"><strong>Generate Shortcode</strong></a> setting panel.', 'oneclick-wa-order' ); ?></li>
                <li><strong><?php _e( 'Step #6:', 'oneclick-wa-order' ); ?></strong> <?php _e( '<strong>Have an inquiry?</strong> Find out how to reach me out on <a href="admin.php?page=wa-order&tab=tutorial_support"><strong>Support</strong></a> panel.', 'oneclick-wa-order' ); ?></li>
            </ul>
         </div>
         </div>
<!-- iframe -->     <hr>
        <div class="feature-section two-col">
            <div class="col">
                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/simple-chat-button.png'; ?>" />
                <h3><?php _e( 'Simple Chat to Order Button', 'oneclick-wa-order' ); ?></h3>
                <p><?php _e( 'Replace the default Add to Cart button or simply show both. Once the Chat to Order button is clicked, the message along with the product details are sent to you through WhatsApp.', 'oneclick-wa-order' ); ?></p>
            </div>
            <div class="col">
                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/fancy-floating-button.png'; ?>" />
                <h3><?php _e( 'Fancy Floating Button', 'oneclick-wa-order' ); ?></h3>
                <p><?php _e( 'Make it easy for any customers/visitors to reach you out through a click of a floating WhatsApp button, displayed on the left of right with tons of customization options.', 'oneclick-wa-order' ); ?></p>
            </div>
        </div>
     
        <div class="feature-section two-col">
            <div class="col">
                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/display-this-or-hide-that.png'; ?>" />
                <h3><?php _e( 'Display This or Hide That', 'oneclick-wa-order' ); ?></h3>
                <p><?php _e( 'Wanna hide some buttons or elements you don\'t like? You have the command to rule them all. Just visit the panel and all of the options are there to configure.', 'oneclick-wa-order' ); ?></p>
            </div>
     
            <div class="col">
                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/gdpr-ready.png'; ?>" />
                <h3><?php _e( 'Make It GDPR-Ready', 'oneclick-wa-order' ); ?></h3>
                <p><?php _e( 'The regulations are real and it\'s time to make your site ready for them. Make your site GDPR-ready with some simple configurations, really easy!', 'oneclick-wa-order' ); ?></p>
            </div>
        </div>

        <div class="feature-section two-col">
            <div class="col">
                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/shortcode.png'; ?>" />
                <h3><?php _e( 'Shortcode Generator', 'oneclick-wa-order' ); ?></h3>
                <p><?php _e( 'Are the previous options still not enough for you? You can extend the flexibility to display a WhatsApp button using a shortcode, which you can generate easily.', 'oneclick-wa-order' ); ?></p>
            </div>
     
            <div class="col">
                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/documentation.png'; ?>" />
                <h3><?php _e( 'Comprehensive Documentation', 'oneclick-wa-order' ); ?></h3>
                <p><?php _e( 'You will not be left alone. My complete documentation or tutorial will always help and support all your needs to get started.<br /><a href="https://www.youtube.com/watch?list=PLwazGJFvaLnBTOw4pNvPcsFW1ls4tn1Uj&v=LuURM5vZyB8" target="_blank"><strong>Watch tutorial videos</strong></a>.', 'oneclick-wa-order' ); ?></p>
            </div>
        </div>    
        	<br>
            <hr>
        	<?php echo do_shortcode("[donate]"); ?>
        <center><p><?php printf( __( "Created with ❤ and ☕ in Jakarta, Indonesia by <a href=\"https://walterpinem.me\" target=\"_blank\"><strong>Walter Pinem</strong></a>", 'oneclick-wa-order' )); ?></p></center>
     
    </div>
    </div>    
		<br>
    </div>
    <?php
	}
}