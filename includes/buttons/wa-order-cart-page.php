<?php
// Add WhatsApp button on Cart page just below the Proceed to Checkout button
function wa_order_add_button_to_cart_page( $variations ) { 
	$add_button_to_cart = get_option(sanitize_text_field('wa_order_option_add_button_to_cart'));
	$hide_checkout_button = get_option(sanitize_text_field('wa_order_option_cart_hide_checkout'));
	if ( $add_button_to_cart === 'yes') {
		global $post;
		$wanumberpage = get_option( 'wa_order_selected_wa_number_cart' );
		$postid = get_page_by_path( $wanumberpage, '', 'wa-order-numbers');
		if( empty( $postid) ) {
		    $pid = 0;
		} else {
		    $pid = $postid->ID;
		}
		$phonenumb = get_post_meta($pid, 'wa_order_phone_number_input', true);

		// Getting cart items
		$items= WC()->cart->get_cart();

		// Set Default Button Text
		if ($cart_button_text = get_option(sanitize_text_field('wa_order_option_cart_button_text')));
		else $cart_button_text = "Complete Order via WhatsApp";

		// Set Default Custom Message
		$custom_message = get_option('wa_order_option_cart_custom_message');
		if ($custom_message== '') $message= urlencode("Hello, I want to purchase the item(s) below:");
		else $message = urlencode("$custom_message");

		$currency= get_woocommerce_currency();

		foreach($items as $item ) { 
			$_product =  wc_get_product( $item['product_id']);
			$product_name= $_product->get_name();
			$qty= $item['quantity'];            
			$price= wc_price($item['line_subtotal']);
			$format_price = wp_strip_all_tags($price);
			$var= $item['variation'];
			$product_url  = get_post_permalink($item['product_id']);
			// $total_amount = floatval( preg_replace( '#[^\d.]#', '', WC()->cart->cart_contents_total ) ); // in case needed
			$total_amount = wc_price(WC()->cart->get_cart_total());
			$format_total = wp_strip_all_tags($total_amount);

			$quantity_label = get_option( 'wa_order_option_quantity_label');
			$price_label 	= get_option( 'wa_order_option_price_label');
			$url_label 		= get_option( 'wa_order_option_url_label');
			$thanks_label 	= get_option( 'wa_order_option_thank_you_label');
			$total_label 	= get_option( 'wa_order_option_total_amount_label');

			$target = get_option(sanitize_text_field('wa_order_option_cart_open_new_tab'));

			// Remove product URL
			$removeproductURL = get_option(sanitize_text_field('wa_order_option_cart_hide_product_url'));

			// Message containing product name
			$message .= urlencode("\r\n\r\n*".$product_name."*");

			// Include product variation and loop
			$include_variation = get_option(sanitize_text_field('wa_order_option_cart_enable_variations'));	    
			if ( $item['variation_id'] > 0 && $_product->is_type( 'variable' ) && $include_variation === 'yes' ) {
				$variations = wc_get_formatted_variation($item['variation'], false);
			    	// $variation_detail = wc_get_formatted_variation( $variation_data, false );
				$variationx = rawurldecode($variations);
				$variation = str_replace(
					array('<dl class="variation"><dt>',"</dt><dd>", "</dd><dt>", "</dd></dl>"),
					array('', " ", "\r\n", "" ),
					$variations
				);
				// Message containing variation
				$message .= urlencode("\r\n".ucwords($variation)."");

			} else {
				// Return empty if not variable type or hide variation
				$message.= "";
			}

			if ($removeproductURL === 'yes') {
				$message.= urlencode("\r\n*".$quantity_label.":* ".$qty."\r\n*".$price_label.":* ");
				$message.= " ".$format_price." ";
			} else {
				$message.= urlencode("\r\n*".$quantity_label.":* ".$qty." ");
				$message.= urlencode("\r\n*".$price_label.":*");
				$message.= " ".$format_price." ";
				$message.= urlencode("\r\n*".$url_label.":* ".$product_url."");
			}
		}

		// Coupon item: Check if coupon code used
		global $woocommerce;
		global $subtotal;
		global $cart_item; 
		global $cart_item_key;
		$cart = WC()->cart;			

		// Get coupons.
		$coupons = WC()->cart->get_applied_coupons();
		// Loop through coupons.
		foreach ( $coupons as $coupon ) {

			// Create coupon object.
			$coupon = new WC_Coupon( $coupon );

			// Check if there is a coupon
			if ( $woocommerce->cart->has_discount( $coupon->get_code() ) ) {
				$currencyx = get_woocommerce_currency_symbol();
				$currency = html_entity_decode($currencyx);
				// If coupon type is fixed_product.
				if ( 'fixed_product' === $coupon->get_discount_type() && 'fixed_cart' === $coupon->get_discount_type() ) {
					$pre_symbol = $currency;
				} elseif ( 'percent' === $coupon->get_discount_type() ) {
					$pre_symbol = "%";
				} else {
					$pre_symbol = "";
				}

				// $currencyx = get_woocommerce_currency_symbol(); // in case needed
				// $currency = html_entity_decode($currencyx); // in case needed
				$coupons  = $cart->get_applied_coupons();
				$coupons  = count($coupons) > 0 ? implode(', ', $coupons) : '';
				$discountx = $cart->get_total_discount();
				$discounty =wp_strip_all_tags($discountx);
				$discount = html_entity_decode($discounty);
				$normalsubtotal = WC()->cart->subtotal;

	    		// Set coupon label
				$coupon_label = get_option(sanitize_text_field('wa_order_option_custom_thank_you_coupon_label'));
				if ($coupon_label== '') $voucher_label= "Voucher Code:";
				else $voucher_label= "$coupon_label";

	    		// If coupon type is fixed cart
				if ( $coupon->is_type( 'fixed_cart' ) ) {
	    			// Get individual discount amount
					$indv_discountx = wc_price($coupon->get_amount());
					$indv_discounty = wp_strip_all_tags($indv_discountx);
					$indv_discount = html_entity_decode($indv_discounty);
					$discount_format = "".$pre_symbol."".$indv_discount."";
					$coupon_code = "*".$voucher_label."*\r\n".ucwords($coupon->get_code()).": -".$discount_format."";
					$message.= urlencode("\r\n\r\n".$coupon_code."\r\n");
	        		// Formatted price with currency symbol - coupon
					$normaldiscounttotal = $cart->get_discount_total();
					$subtotalx = wp_strip_all_tags(WC()->cart->get_cart_subtotal());
					$subtotal = html_entity_decode($subtotalx);
					$numeric_subtotal = floatval( preg_replace( '#[^\d.]#', '', $subtotal ) );
					$numeric_discount = floatval( preg_replace( '#[^\d.]#', '', $indv_discount ) );
					$subtotalminusdiscount = $numeric_subtotal - $numeric_discount;
					$subtotalminusdiscountx = wc_price($subtotalminusdiscount);
					$subtotalminusdiscounty = wp_strip_all_tags($subtotalminusdiscountx);
					$subtotalminusdiscountz = html_entity_decode($subtotalminusdiscounty);
					$subtcalculatedoutput = "".$subtotal." - ".$indv_discount." = ".$subtotalminusdiscountz."";
					$subtlabel = __( 'Discount', 'woocommerce' );
					$message.=urlencode("*".$subtlabel.":* \r\n".$subtcalculatedoutput."\r\n");

	        	// If coupon type is fixed product
				} elseif( $coupon->is_type( 'fixed_product' ) ) {
	    			// Get individual discount amount
					$indv_discountx = wc_price($coupon->get_amount());
					$indv_discounty = wp_strip_all_tags($indv_discountx);
					$indv_discount = html_entity_decode($indv_discounty);
					$discount_format = "".$pre_symbol."".$indv_discount."";
					$coupon_code = "*".$voucher_label."*\r\n".ucwords($coupon->get_code()).": -".$discount_format."";
					$message.= urlencode("\r\n\r\n".$coupon_code."\r\n");
	        		// Formatted price with currency symbol - coupon
					$normaldiscounttotal = $cart->get_discount_total();
					$subtotalx = wp_strip_all_tags(WC()->cart->get_cart_subtotal());
					$subtotal = html_entity_decode($subtotalx);
					$numeric_subtotal = floatval( preg_replace( '#[^\d.]#', '', $subtotal ) );
					$numeric_discount = floatval( preg_replace( '#[^\d.]#', '', $indv_discount ) );
					$subtotalminusdiscount = $numeric_subtotal - $numeric_discount;
					$subtotalminusdiscountx = wc_price($subtotalminusdiscount);
					$subtotalminusdiscounty = wp_strip_all_tags($subtotalminusdiscountx);
					$subtotalminusdiscountz = html_entity_decode($subtotalminusdiscounty);
					$subtcalculatedoutput = "".$subtotal." - ".$indv_discount." = ".$subtotalminusdiscountz."";
					$subtlabel = __( 'Discount', 'woocommerce' );
					$message.=urlencode("*".$subtlabel.":* \r\n".$subtcalculatedoutput."\r\n");

	        		// If coupon type is percentage
				} elseif ( $coupon->is_type( 'percent' ) ) {
					$discount_percent = $coupon->get_amount();
					$discounted_pricex = wc_price(($discount_percent / 100) * $normalsubtotal);
					$discounted_pricey = wp_strip_all_tags($discounted_pricex);
					$discounted_price = html_entity_decode($discounted_pricey);
					$discount_format = "".$discount_percent."".$pre_symbol." (-".$discounted_price.")";
					$coupon_code = "*".$voucher_label."*\r\n".ucwords($coupon->get_code()).": -".$discount_format."";
					$message.= urlencode("\r\n\r\n".$coupon_code."\r\n");
	        		// Formatted price with currency symbol - coupon
					$normaldiscounttotal = $cart->get_discount_total();
					$subtotalx = wp_strip_all_tags(WC()->cart->get_cart_subtotal());
					$subtotal = html_entity_decode($subtotalx);
					$numeric_subtotal = floatval( preg_replace( '#[^\d.]#', '', $subtotal ) );
					$numeric_discount = floatval( preg_replace( '#[^\d.]#', '', $discounted_price ) );
					$subtotalminusdiscount = $numeric_subtotal - $numeric_discount;
					$subtotalminusdiscountx = wc_price($subtotalminusdiscount);
					$subtotalminusdiscounty = wp_strip_all_tags($subtotalminusdiscountx);
					$subtotalminusdiscountz = html_entity_decode($subtotalminusdiscounty);
					$subtcalculatedoutput = "".$subtotal." - ".$discounted_price." = ".$subtotalminusdiscountz."";
					$subtlabel = __( 'Discount', 'woocommerce' );
					$message.=urlencode("*".$subtlabel.":* \r\n".$subtcalculatedoutput."\r\n");

					$label_subtotal = __( 'Subtotal', 'woocommerce' );
					$subtotalx = wp_strip_all_tags(WC()->cart->get_cart_subtotal());
					$subtotal = html_entity_decode($subtotalx);
					$discountx = $cart->get_total_discount();
					$discounty =wp_strip_all_tags($discountx);
					$discount = html_entity_decode($discounty);
					$numeric_subtotal = floatval( preg_replace( '#[^\d.]#', '', $subtotal ) );
					$numeric_discount = floatval( preg_replace( '#[^\d.]#', '', $discount ) );
					$subtotalminusdiscount = $numeric_subtotal - $numeric_discount;
					$subtotalminusdiscountx = wc_price($subtotalminusdiscount);
					$subtotalminusdiscounty = wp_strip_all_tags($subtotalminusdiscountx);
					$subtotalminusdiscountz = html_entity_decode($subtotalminusdiscounty);
					$message.= urlencode("\r\n*".$label_subtotal.":* \r\n".$subtotalminusdiscountz."\r\n");

				} else {
					$discount_format = "";
					$coupon_code = "";
					$message.= "";
				}
	} else {  // return empty if none
	    // Formatted price with currency symbol
		$message.="";
	}
}
	
// Shipping details on cart page & Get Shipping Method + address
 // Exclude shipping from message if is_virtual & is_downloadable
  $products = $woocommerce->cart->get_cart();
  foreach( $products as $product ) {
	$product_id = $product['product_id'];
	$is_virtual		= get_post_meta( $product_id, '_virtual', true );
	$is_downloadable 	= get_post_meta( $product_id, '_downloadable', true );
  }
$customer = WC()->session->get('customer');
if( $is_virtual == 'no' && $is_downloadable == 'no' || $customer['calculated_shipping'] && !empty( $customer['address'] ) && !empty( $customer['city'] ) && !empty( $customer['state'] ) ) {
	if ( WC()->cart->show_shipping()  ) { // check if shipping exists
		// Check first name
		if ( WC()->cart->get_customer()->get_shipping_first_name() ) {
			$firstname = WC()->cart->get_customer()->get_shipping_first_name();
			$fname = "\r\n".$firstname."";
		} else {
			$fname = "";
		}
		// Check last name
		if ( WC()->cart->get_customer()->get_shipping_last_name() ) {	
			$lastname = WC()->cart->get_customer()->get_shipping_last_name();
			$lname = "".$lastname."";
		} else {
			$lname = "";
		}
		// Check postcode
		if ( WC()->cart->get_customer()->get_shipping_postcode() ) {
			$postcodex = WC()->cart->get_customer()->get_shipping_postcode();
			$postcode = "\r\n".$postcodex."";
		} else {
			$postcode = "";
		}
		// Check city
		if ( WC()->cart->get_customer()->get_shipping_city() ) {
			$cityx = WC()->cart->get_customer()->get_shipping_city();
			$city = "\r\n".$cityx."";
		} else {
			$city = "";
		}
		// Check address 1
		if ( WC()->cart->get_customer()->get_shipping_address() ) {
			$ad1x = WC()->cart->get_customer()->get_shipping_address();
			$ad1 = "\r\n".$ad1x."";
		} else {
			$ad1 = "";
		}
		// Check address 2
		if ( WC()->cart->get_customer()->get_shipping_address_2() ) {
			$ad2x = WC()->cart->get_customer()->get_shipping_address_2();
			$ad2 = "\r\n".$ad2x."";
		} else {
			$ad2 = "";
		}
		// Check current country 
		if ( WC()->customer->get_shipping_country() ) { 
			$current_cc = WC()->customer->get_shipping_country();
			$countryx = WC()->countries->countries[$current_cc];
			$country = "\r\n".$countryx."";
		} else {
			$country = "";
		}
		// Check state based on country 
		if ( WC()->customer->get_shipping_state() ) {
			$current_cc = WC()->customer->get_shipping_country();
			$current_r = WC()->customer->get_shipping_state();
			$statex = WC()->countries->get_states( $current_cc )[$current_r];
			$statesx = "\r\n".$statex."";
		} else {
			$statesx = "";
		}
		// Check states 
		if ( WC()->countries->get_states( $current_cc ) ) { 
			$states = WC()->countries->get_states( $current_cc );
		} else {
			$states = "";
		}

		$address = "".$fname." ".$lname."".$ad1."".$ad2."".$ad2."".$city."".$statesx."".$country."".$postcode."";
		$addressx = html_entity_decode($address);
		$ship_label = __( 'Shipping:', 'woocommerce' );
		$message.= urlencode("\r\n*".$ship_label."*");
		$message.= urlencode("".$addressx."\r\n");
		$customer = WC()->session->get('customer');
		if( $customer['calculated_shipping'] ) {
			foreach( WC()->session->get('shipping_for_package_0')['rates'] as $method_id => $rate ) {
				if( WC()->session->get('chosen_shipping_methods')[0] == $method_id ){
        $shipping_name = ucwords($rate->label); // The shipping method label name
        $rate_cost_excl_tax = floatval($rate->cost); // The cost excluding tax
        // The taxes cost
        $rate_taxes = 0;
        foreach ($rate->taxes as $rate_tax)
        	$rate_taxes += floatval($rate_tax);
        // The cost including tax
        $rate_cost_incl_tax = $rate_cost_excl_tax + $rate_taxes;
        $cost_incl_tax = wc_price($rate_cost_incl_tax);
        $final_shipping_cost = wp_strip_all_tags($cost_incl_tax);
        $currencyx = get_woocommerce_currency_symbol();
        $currency = html_entity_decode($currencyx);
        $sep = " - ";
        $message.= urlencode("*".$shipping_name."*");
        $message.= $sep . html_entity_decode($final_shipping_cost);
        $message.= urlencode("\r\n");
        break;
    }
	}
	}
	}
}
	$message.=urlencode("\r\n*".$total_label.":*\r\n");
	// Continue formatting the final message
	$total_amount = wp_kses_data( WC()->cart->get_total() );
	$message.= "".$total_amount."";
	$message.= urlencode("\r\n\r\n".$thanks_label."");

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
	$button_url = 'https://'.$wa_base.'.whatsapp.com/send?phone='.$phonenumb.'&text='.$message;
	?>
	<div class="wc-proceed-to-checkout">
		<a id="sendbtn" href="<?php echo $button_url ?>" target="<?php echo $target ?>" class="wa-order-checkout checkout-button button">
			<?php echo $cart_button_text ?>
		</a>
	</div>	    
	<?php
		}
	}
add_action( 'woocommerce_after_cart_totals', 'wa_order_add_button_to_cart_page' );

// Remove proceed to checkout button on Cart page
function disable_checkout_button_no_shipping() { 
	$hide_checkout_button = get_option(sanitize_text_field('wa_order_option_cart_hide_checkout'));
	if ($hide_checkout_button === 'yes') {
		remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
	}
}
add_action( 'woocommerce_proceed_to_checkout', 'disable_checkout_button_no_shipping', 1 );