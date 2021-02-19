<?php

// Add WhatsApp button under each product on Shop page
function wa_order_display_button_shop_page() {
	$enable_button = get_option(sanitize_text_field('wa_order_option_enable_button_shop_loop'));
	if ( $enable_button === 'yes' ) {
	global $product;
	global $post;
	// WA Number from Setting: Check if number is set
	$wanumberpage = get_option( 'wa_order_selected_wa_number_shop' );
	$postid = get_page_by_path( $wanumberpage, '', 'wa-order-numbers');
	if( empty( $postid) ) {
		$pid = 0;
	} else {
		$pid = $postid->ID;
	}
	$phonenumb = get_post_meta($pid, 'wa_order_phone_number_input', true);
	
	//Set Default Button Text
	$button_text = get_option(sanitize_text_field('wa_order_option_button_text_shop_loop'));
	if ( $button_text == '' ){
		$button_txt = "Buy via WhatsApp";
		$button_text = $button_txt;
	} else {
		$button_text = $button_text;
	}
	//Set Default Custom Message
	$custom_message = get_option(sanitize_text_field('wa_order_option_custom_message_shop_loop'));
	if ($custom_message== '') $custom_msg= "Hello, I want to purchase:";
	else $custom_msg= "$custom_message";

	$product_url = $product->get_permalink();
	$text  = __( ''.$button_text.'', 'oneclick-wa-order' );
	$product_title = $product->get_name();
	$link_title = sprintf( __( 'Complete order on WhatsApp to buy %s', 'oneclick-wa-order' ), $product_title );
	$class = sprintf( 'button add_to_cart_button wa-shop-button product_type_%s', $product->get_type() );
	$currency = get_woocommerce_currency_symbol();
	// $price = wc_get_price_including_tax( $product );
	$price = wc_price(wc_get_price_including_tax( $product ));
	$format_price = wp_strip_all_tags($price); // fixed price format
	
	// Labels
	$price_label = get_option( 'wa_order_option_price_label');
	$url_label = get_option( 'wa_order_option_url_label');
	$thanks_label = get_option( 'wa_order_option_thank_you_label');

	// URL Encoding
	$encode_custom_message = urlencode($custom_msg);
	$encode_title = urlencode($product_title);
	$encode_product_url = urlencode($product_url);
	$encode_thanks = urlencode($thanks_label);
	$encode_url_label = urlencode($url_label);
	$encode_price = urlencode($format_price);
	$encode_price_label = urlencode($price_label);

    $final_message ="$encode_custom_message%0D%0A%0D%0A*$encode_title*";

    // Exclude Price
    $excludeprice = get_option(sanitize_text_field('wa_order_option_shop_loop_exclude_price'));
    if ($excludeprice === 'yes') {
    	$final_message .= "";
    } else {
    	// $final_message .= "%0A*$encode_price_label:*%20$currency$encode_price";
    	$final_message .= "%0A*$encode_price_label:*%20$format_price"; // new price format
    }

    // Remove product URL
    $removeproductURL = get_option(sanitize_text_field('wa_order_option_shop_loop_hide_product_url'));
    if ($removeproductURL === 'yes') {
    	$final_message .= "";
    } else {
    	$final_message .= "%0A*$encode_url_label:*%20$encode_product_url";
    }

    $final_message.= "%0D%0A%0D%0A$encode_thanks";

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
    $button_url = "https://$wa_base.whatsapp.com/send?phone=$phonenumb&text=$final_message";
	$target = get_option(sanitize_text_field('wa_order_option_shop_loop_open_new_tab'));

	$format = '<a id="sendbtn" href="%1$s" target="'.$target.'" title="%2$s" class="$class">%4$s</a>';
		?>
		    <a id="sendbtn" href="<?php echo $button_url ?>" title="<?php echo $link_title ?>" target="<?php echo $target ?>" class="<?php echo $class ?>">
		    	<?php echo $button_text ?>
		    </a>
	    <?php
	}
}
add_action( 'woocommerce_after_shop_loop_item', 'wa_order_display_button_shop_page', 20);

// Option to remove Add to Cart on Shop page product loop
if ( get_option(sanitize_text_field('wa_order_option_hide_atc_shop_loop')) === 'yes' ) {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}
// Alternative way to force hide the Add to Cart button on shop loop page
add_action('wp_head', 'wa_order_alternative_way_hide_shop_loop');
function wa_order_alternative_way_hide_shop_loop(){
if ( get_option(sanitize_text_field('wa_order_option_hide_atc_shop_loop')) === 'yes' ) {
		?>
		<style>
			.add_to_cart_button, .ajax_add_to_cart {
				display: none!important;
			}
			.wa-shop-button { 
				display: inline-block!important;
			}
		</style>
	    <?php
	}
}

// Hide WhatsApp button under products based on taxonomies
function wa_order_hide_shop_taxonomies() {
	global $product, $post; 
	$option_shop_cats = get_option('wa_order_option_exlude_shop_product_cats');
	$option_shop_cats_array = (array) $option_shop_cats;
	$option_shop_tags = get_option('wa_order_option_exlude_shop_product_tags');
	$option_shop_tags_array = (array) $option_shop_tags;

	$cats_archive = get_option('wa_order_exlude_shop_product_cats_archive');
	$tags_archive = get_option('wa_order_exlude_shop_product_tags_archive');

	// Get all ids of products in categories
	$cat_ids = get_posts( array(
	   'post_type' => 'product',
	   'numberposts' => -1,
	   'post_status' => 'publish',
	   'fields' => 'ids',
	   'tax_query' => array(
	      array(
	         'taxonomy' => 'product_cat',
	         'field' => 'term_id',
	         'terms' => $option_shop_cats_array,
	         'operator' => 'IN',
	      )
	   ),
	) );

	// Get all ids of products in tags
	$tag_ids = get_posts( array(
	   'post_type' => 'product',
	   'numberposts' => -1,
	   'post_status' => 'publish',
	   'fields' => 'ids',
	   'tax_query' => array(
	      array(
	         'taxonomy' => 'product_tag',
	         'field' => 'term_id',
	         'terms' => $option_shop_tags_array,
	         'operator' => 'IN',
	      )
	   ),
	) );

	// Hide WA button conditionally on Shop page
	if ( is_shop() ) {
		foreach ( $cat_ids as $cat_id ) {
		     echo '<style>
		     .products .post-'.$cat_id.' #sendbtn {
		     	display: none!important;
		     }
		     </style>';
		}
		foreach ( $tag_ids as $tag_id ) {
		     echo '<style>
		     .products .post-'.$tag_id.' #sendbtn {
		     	display: none!important;
		     }
		     </style>';
		}
	}

	// Hide WA button conditionally on category archive page
	if ( $cats_archive === 'yes') {
		if ( is_product_category($option_shop_cats_array) ) {
			foreach ( $cat_ids as $cat_id ) {
			     echo '<style>
			     .products .post-'.$cat_id.' #sendbtn {
			     	display: none!important;
			     }
			     </style>';
			}
		}
	}

	// Hide WA button conditionally on tag archive page
	if ( $tags_archive === 'yes') {
		if ( is_product_tag($option_shop_tags_array) ) {
			foreach ( $tag_ids as $tag_id ) {
			     echo '<style>
			     .products .post-'.$tag_id.' #sendbtn {
			     	display: none!important;
			     }
			     </style>';
			}
		}
	}
}
add_action( 'wp_head', 'wa_order_hide_shop_taxonomies', 20 );