<?php

// Custom Thank You title
function wa_order_thank_you_override( $title, $id ) {
        global $wp;
        global $post;
        // WA Number from Setting: Check if number exists
        $wanumberpage = get_option( 'wa_order_selected_wa_number_thanks' );
        $postid = get_page_by_path( $wanumberpage, '', 'wa-order-numbers');
        if( empty( $postid) ) {
            $pid = 0;
        } else {
            $pid = $postid->ID;
        }
        $phonenumb = get_post_meta($pid, 'wa_order_phone_number_input', true);

        $custom_title = get_option('wa_order_option_custom_thank_you_title');
        $custom_subtitle = get_option('wa_order_option_custom_thank_you_subtitle');
        $button_text = get_option('wa_order_option_custom_thank_you_button_text');
        $custom_message = get_option('wa_order_option_custom_thank_you_custom_message');
        $thanks_label = get_option( 'wa_order_option_thank_you_label');
        $include_order_number = get_option( 'wa_order_option_custom_thank_you_order_number');
        $order_number_label = get_option( 'wa_order_option_custom_thank_you_order_number_label');
        $customer_details_label = get_option( 'wa_order_option_custom_thank_you_customer_details_label');

        if ($custom_message== '') $message= urlencode("Hello, here's my order details:\r\n\r\n");
            else $message= urlencode("$custom_message\r\n\r\n");
        if ($custom_title== '') $thetitle= "Thanks and You're Awesome";
            else $thetitle= "$custom_title";
        if ($custom_subtitle== '') $subtitle= "For faster response, send your order details by clicking below button.";
            else $subtitle= "$custom_subtitle";
        if ($button_text== '') $button= "Send Order Details";
            else $button= "$button_text";
        if ($customer_details_label == '') $customer_details= "Customer Details";
            else $customer_details= "$customer_details_label";   

        $order_id = (int) $wp->query_vars['order-received'];
        if ( $order_id ) {
            $order = new WC_Order( $order_id );
        }
        if ( isset ( $order ) ) {
            $first_name = $order->get_billing_first_name();
            $last_name = $order->get_billing_last_name();
            $thetitle = $thetitle. ', ' .$first_name. '!';
            $subtitle = $subtitle;
            $customer = $first_name . ' ' . $last_name;
            $customer_email = $order->get_billing_email();
            $adress_1 = $order->get_billing_address_1();
            $adress_2x = $order->get_billing_address_2();
            $postcode = $order->get_billing_postcode();
            $state = $order->get_billing_state();
            $country = $order->get_billing_country();
            $customer_phone = $order->get_billing_phone();
            $full_state = WC()->countries->get_states( $country )[$state];
            $full_country = WC()->countries->get_countries( $country )[$country];
            if (empty($address_2x)) {
                $adress_2 = "";
            } else {
                $adress_2 = urlencde("\r\n".$adress_2x."");
            }
            // $billing_details = "".$customer."\r\n".$adress_1."".$adress_2."\r\n".$postcode."\r\n".$full_state."\r\n".$full_country."\r\n".$customer_phone."\r\n".$customer_email."";
            $billing_address = $order->get_formatted_billing_address();
            $formatted_billingx = str_replace('<br/>', "\r\n", $billing_address);
            $formatted_billing = "".$formatted_billingx."\r\n".$customer_phone."\r\n".$customer_email."";

            $shipping_address = $order->get_formatted_shipping_address();
            $formatted_shipping = str_replace('<br/>', "\r\n", $shipping_address);

            // Check if shipping address is set instead of billing address | We'll use it later
            // if ( ! empty($_POST['ship_to_different_address']) )  {
            //     $final_address = $billing_address;
            // } else {
            //     $final_address = $formatted_shipping;
            // }
            
            // Fill in the final address to send | We'll use it later
            // $address = "\r\n".$final_address."";

            $total_label = get_option( 'wa_order_option_total_amount_label');
            $payment_label = get_option( 'wa_order_option_payment_method_label');
            $normalsubtotal = $order->get_subtotal();
            $subtotal_price = $order->get_subtotal_to_display();
            $format_subtotal_pricex = wp_strip_all_tags($subtotal_price);
            $format_subtotal_price = html_entity_decode($format_subtotal_pricex);
            // $format_price = number_format($price, 2, '.', ',');
            $currencyx = get_woocommerce_currency_symbol();
            $currency = html_entity_decode($currencyx);
            // $total_price = "\r\n*".$total_label.":*\r\n".$currency." ".$format_price."\r\n";
            $label_total = urlencode("\r\n*".$total_label.":*\r\n");
            $total_format_subtotal_price = "".$label_total."".$format_subtotal_price."";
            $payment_method = $order->get_payment_method_title();
            $payment = "\r\n*".$payment_label.":*\r\n".$payment_method."\r\n";
            $date = date( 'F j, Y – g:i A', $order->get_date_created ()->getOffsetTimestamp());
            $order_number = $order->get_order_number();
            if ($order_number_label== '') $on_label= "Order Number:";
            else $on_label= "$order_number_label";

            // If Order Number inclusion is checked
            if ( get_option(sanitize_text_field('wa_order_option_custom_thank_you_order_number')) === 'yes' ) {
                $message.= urlencode("*".$on_label."*\r\n#".$order_number."\r\n\r\n");
            } else {
                // Final output of the message
                $message.= "";
            }

        }

        $order = new WC_Order( $order_id );
        foreach ( $order->get_items() as $item_id => $item ) {
            $product_id   = $item->get_product_id(); //Get the product ID
            $quantity     = $item->get_quantity(); //Get the product QTY
            $product_name = $item->get_name(); //Get the product NAME
            $quantity = $item->get_quantity();
            $message .= urlencode("".$quantity."x - *".$product_name."*\r\n");
                // get order item data (in an unprotected array)
                $item_data = $item->get_data();

                // get order item meta data (in an unprotected array)
                $item_meta_data = $item->get_meta_data();

                // get only All item meta data even hidden (in an unprotected array)
                $formatted_meta_data = $item->get_formatted_meta_data( '_', true );
                $array = json_decode(json_encode($formatted_meta_data), true);
                $arrayx = array_values($array);
                $arrayxxx = array_merge($array);
                $result = array();
            foreach( (array) $arrayxxx as $value) {
                $product_meta = "";
                $result[]=array($value["display_key"], wp_strip_all_tags($value["display_value"]));
                foreach ($result as $key) {
                    $result = array();
                    $product_meta .= "     - ```".$key[0].":``` ```".$key[1]."```\r\n";
                    $message.= urlencode("".$product_meta."");
               }
            }
                $productsku = $item->get_product( $item );
                $include_sku = get_option(sanitize_text_field('wa_order_option_custom_thank_you_include_sku'));
                $sku = $productsku->get_sku();
                $sku_label = __( 'SKU', 'woocommerce' );
                if ( ! empty($sku) && $include_sku === 'yes' ) {
                $message.= urlencode("     - ```".$sku_label.": ".$sku."```\r\n");
                } else {
                $message.= "";
                }
        }
        $message.= "".$total_format_subtotal_price."";
        $message.= urlencode("\r\n");

        // Coupon item: Check if coupon code used
        $order_items = $order->get_items('coupon');
        // Let's loop
        foreach( $order_items as $item_id => $item ) {

            // Retrieving the coupon ID reference
            $coupon_post_obj = get_page_by_title( $item->get_name(), OBJECT, 'shop_coupon' );
            $coupon_id = $coupon_post_obj->ID;

            // Retrive an instance of WC_Coupon object
            $coupon = new WC_Coupon($coupon_id);

            // Conditional discount type + its symbol
            if( $coupon->is_type( 'fixed_cart' ) && $coupon->is_type( 'fixed_product' ) ) {
                $pre_symbol = $currency;
            } elseif ( $coupon->is_type( 'percent' ) ) {
                $pre_symbol = "%";
            } else {
                $pre_symbol = "";
            }

            // Check if any discount code used and enabled from admin plugin setting
            $include_coupon = get_option(sanitize_text_field('wa_order_option_custom_thank_you_inclue_coupon'));
            if (  $order->get_total_discount() > 0 && $include_coupon === 'yes' ) {
                $coupons  = $order->get_coupon_codes();
                $coupons  = count($coupons) > 0 ? implode(',', $coupons) : '';
                $discountx = $order->get_total_discount();
                $discounty =wp_strip_all_tags($discountx);
                $discount = html_entity_decode($discounty);

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
                    $message.= urlencode("\r\n".$coupon_code."\r\n");
                    // Formatted price with currency symbol - coupon
                    $normaldiscounttotal = $order->get_discount_total();
                    $subtotalx = wp_strip_all_tags(wc_price($order->get_subtotal()));
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
                    $message.= urlencode("\r\n".$coupon_code."\r\n");
                    // Formatted price with currency symbol - coupon
                    $normaldiscounttotal = $order->get_discount_total();
                    $subtotalx = wp_strip_all_tags(wc_price($order->get_subtotal()));
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
                    $message.= urlencode("\r\n".$coupon_code."\r\n");
                    // Formatted price with currency symbol - coupon
                    $normaldiscounttotal = $order->get_discount_total();
                    $subtotalx = wp_strip_all_tags(wc_price($order->get_subtotal()));
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

                } else {
                    $discount_format = "";
                    $coupon_code = "";
                    $message.= "";
                }
            }
        }

        // Check if customer purchase note exits
        $note = $order->get_customer_note();
        if ( $note ) { 
        $note_label = __( 'Note:', 'woocommerce' );
        $purchase_note = "*".$note_label."*\r\n".$note."\r\n\r\n";
        } else {
            $purchase_note = "";
        }
        $message.= urlencode("".$payment."\r\n*".$customer_details."*");

        // Get Shipping Method
        $ship_method = $order->get_shipping_method();
        $ship_label = __( 'Shipping:', 'woocommerce' );
        if( empty($ship_method) && empty($_POST['ship_to_different_address']) ) {
            $message.=urlencode("\r\n".$formatted_billing."");
        } else {
            $ship_cost = $order->get_shipping_to_display();
            $shipping_cost = wp_strip_all_tags($ship_cost);
            $shipping_method = $ship_method . $shipping_cost;
            $message.=urlencode("\r\n".$formatted_shipping."\r\n");
            $message.= urlencode("\r\n*".$ship_label."*\r\n");
            $message.= $shipping_cost;
        }

        // Show the total price
        $price = $order->get_formatted_order_total();
        $format_price = wp_strip_all_tags($price);
        $currency= get_woocommerce_currency();
        $label_total = urlencode("\r\n\r\n*Total:*\r\n");
        $total_price = "".$label_total."".$format_price."";
        $message.= $total_price;

        // Include or Exclude Order date & time
        $order_date = get_option(sanitize_text_field('wa_order_option_custom_thank_you_include_order_date'));
        if( $order_date !== 'yes' ) { 
            $message.= urlencode("\r\n\r\n".$purchase_note."".$thanks_label.""); // Final message
        } else {
            $message.= urlencode("\r\n\r\n".$purchase_note."".$thanks_label."\r\n\r\n(".$date.")"); // Final message
        }
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
        $target = get_option(sanitize_text_field('wa_order_option_custom_thank_you_open_new_tab'));

        $final_output = '<div class="thankyoucustom_wrapper">
        <h2 class="thankyoutitle">'.$thetitle.'</h2>
        <p class="subtitle">'.$subtitle.'</p>
        <a id="sendbtn" href="'.$button_url.'" target="'.$target.'" class="wa-order-thankyou">
            '.$button.'
        </a>
        </div>';
        return $final_output;
}
$override_thankyou_page = get_option(sanitize_text_field('wa_order_option_enable_button_thank_you'));
if ( get_option(sanitize_text_field('wa_order_option_enable_button_thank_you')) === 'yes') {
    add_filter( 'woocommerce_thankyou_order_received_text', 'wa_order_thank_you_override', 10, 2 );
}

// Thank you page default class
// Remove element based on class
add_action('wp_footer', 'wa_order_remove_default_thankyou_class');
function wa_order_remove_default_thankyou_class(){
    $override_thankyou_page = get_option(sanitize_text_field('wa_order_option_enable_button_thank_you'));
    if ( $override_thankyou_page === 'yes') {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery(".woocommerce-thankyou-order-received").remove();
        });
    </script>
    <?php
}
}