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

class WA_GDPR {

	// Begin creating
		function __construct()	{
			if ( get_option( 'wa_order_gdpr_status_enable' ) != 'yes' )
				return;
			
			add_shortcode( 'gdpr_link', array( $this, 'get_gdpr_link' ) );
			add_action( 'wa_order_action_plugin', array( $this, 'display_gdpr' ) );
		}

	// Construct the display
		function display_gdpr() {
			?>
			<div class="wa_order-gdpr">
				<div>
					<label for="wa_order-gdpr-checkbox">
						<input type="checkbox" id="wa_order-gdpr-checkbox"> <?php echo do_shortcode( stripslashes( do_shortcode(  get_option( 'wa_order_gdpr_privacy_page' ) ) ) ) ?>
						</label>
				</div>
			</div>
			<?php
		}

	// Generate GDPR Link
		function get_gdpr_link() {

			$page_slug 				= get_option( 'wa_order_gdpr_privacy_page' );
			$page 						= get_page_by_path( $page_slug );
			$page_title 			= get_the_title( $page );
			$page_permalink 	= site_url( '/'.$page_slug.'/' );

			return "<a href='$page_permalink' target='_blank'><strong>$page_title</strong></a>";
		}

	// Get option if enabled
		private function _get_option( $data ) {

			$option = get_option( 'wa_order_gdpr_status_enable' );
			
			return $option[$data];
		}

	} // WA_GDPR

new WA_GDPR;