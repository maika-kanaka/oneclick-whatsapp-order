<?php
// Make sure we don't expose any info if called directly
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

/* @wordpress-plugin
 * Plugin Name:       OneClick Chat to Order
 * Plugin URI:        https://onlinestorekit.com/oneclick-chat-to-order/
 * Description:       Make it easy for your customers to order via WhatsApp chat through a single button click with detailing information about a product including custom message. OneClick Chat to Order button can be displayed on a single product page and as a floating button. GDPR-ready!
 * Version:           1.0.4.1
 * Author:            Walter Pinem
 * Author URI:        https://walterpinem.me/
 * Developer:         Walter Pinem | Seni Berpikir
 * Developer URI:     https://www.seniberpikir.com/
 * Text Domain:       oneclick-wa-order
 * Domain Path:       /languages
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 * 
 * Requires at least: 4.1
 * Tested up to: 5.6
 * 
 * WC requires at least: 4.0.0
 * WC tested up to: 4.7.1
 *
 * Copyright: © 2019 - 2020 Walter Pinem.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('OCWAORDER_PLUGIN_DIR')) {
    define('OCWAORDER_PLUGIN_DIR', plugin_dir_url(__FILE__));
    define ('OCWAORDER_PLUGIN_VERSION', get_file_data(__FILE__, array('Version' => 'Version'), false)['Version'] );
}

add_action( 'plugins_loaded', 'OCWAORDER_plugin_init', 0 );
function OCWAORDER_plugin_init() {

// Start calling main css
function OCWAORDER_include_plugin_css() {
    wp_register_style( 'wa_order_style',  plugin_dir_url( __FILE__ ) . 'assets/css/main-style.css' );
    wp_enqueue_style( 'wa_order_style' );
}
add_action( 'wp_enqueue_scripts', 'OCWAORDER_include_plugin_css' );

// Start calling main frontend js
function OCWAORDER_include_plugin_main_js() {
    wp_register_script( 'wa_order_main_front_js',  plugin_dir_url( __FILE__ ) . 'assets/js/wa-single-button.js' );
}
add_action( 'wp_enqueue_scripts', 'OCWAORDER_include_plugin_main_js' );

// Start calling admin css
function OCWAORDER_include_admin_css () {
    wp_register_style( 'wa_order_style_admin',  plugin_dir_url( __FILE__ ) . 'assets/css/admin-style.css' );
    wp_register_style( 'wa_order_selet2_style',  plugin_dir_url( __FILE__ ) . 'assets/css/select2.min.css' );
    wp_enqueue_style( 'wa_order_style_admin' );
}
add_action( 'admin_enqueue_scripts', 'OCWAORDER_include_admin_css' );

function OCWAORDER_include_admin_js () {
    wp_register_script( 'wa_order_js_admin',  plugin_dir_url( __FILE__ ) . 'assets/js/admin-main.js' );
    wp_register_script( 'wa_order_js_select2',  plugin_dir_url( __FILE__ ) . 'assets/js/select2.min.js' );
    wp_register_script( 'wp-color-picker-alpha', plugins_url( 'assets/js/wp-color-picker-alpha.min.js',  __FILE__ ), array( 'wp-color-picker' ), '3.0.0', true );
    wp_register_script( 'wp-color-picker-init', plugins_url( 'assets/js/wp-color-picker-init.js',  __FILE__ ), array( 'wp-color-picker-alpha' ), '3.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'OCWAORDER_include_admin_js' );

// Start calling main files
require_once dirname(__FILE__).'/admin/wa-admin-page.php';
require_once dirname(__FILE__).'/includes/wa-button.php';
require_once dirname(__FILE__).'/includes/wa-gdpr.php';
require_once dirname(__FILE__).'/includes/wa-metabox.php';
require_once dirname(__FILE__).'/includes/multiple-numbers.php';

// Make sure WooCommerce is active
function OCWAORDER_check_woocommece_active(){
if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
    echo "<div class='error'><p><strong>WA Order</strong> requires <strong>WooCommerce plugin.</strong>Please install and activate it.</p></div>";
    }
}
add_action('admin_notices', 'OCWAORDER_check_woocommece_active');

// Localize this plugin
function OCWAORDER_languages_init() {
    $plugin_dir = basename(dirname(__FILE__));
    load_plugin_textdomain( 'oneclick-wa-order', false, $plugin_dir . '/languages' );
}
add_action('plugins_loaded', 'OCWAORDER_languages_init');
}

// Add setting link plugin page
function OCWAORDER_settings_link( $links_array, $plugin_file_name ){
  if( strpos( $plugin_file_name, basename(__FILE__) ) ) {
    array_unshift( $links_array, '<a href="admin.php?page=wa-order">Settings</a>' );
    }
  return $links_array;
}
add_filter( 'plugin_action_links', 'OCWAORDER_settings_link', 10, 2 );

// Add Donate Link
function wa_order_donate_link_plugin( $links ) {
  $links = array_merge( $links, array(
    '<a href="https://www.paypal.me/WalterPinem" target="_blank">' . __( 'Buy Me a Coffee ☕', 'oneclick-wa-order' ) . '</a>'
  ) );
  return $links;
}
add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wa_order_donate_link_plugin' );

// Disable Auto Draft for WA Number CPT
add_action( 'admin_enqueue_scripts', 'wa_order_disable_auto_drafts' );
function wa_order_disable_auto_drafts() {
    if ( 'wa-order-numbers' == get_post_type() )
        wp_dequeue_script( 'autosave' );
}

// Redirect Phone Number CPT directly to WhatsApp
// Since version 1.0.1, we no longer need this
// add_filter('single_template', 'wa_order_redirect_phone_number_cpt');
// function wa_order_redirect_phone_number_cpt($single) {
//   global $post;
// /* Checks for single template by post type */
//   if ($post->post_type == 'wa-order-numbers') {
//     if (file_exists(plugin_dir_path(__FILE__) . 'includes/number-redirect.php')) {
//       return plugin_dir_path(__FILE__) . 'includes/number-redirect.php';
//     }
//   }
//   return $single;
// }