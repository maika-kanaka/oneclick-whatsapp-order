<?php

// Display Floating Button
function display_floating_button() {
	global $wp;
	$floating = get_option(sanitize_text_field('wa_order_floating_button'));
	if ( $floating === 'yes' ) {
	$floating_position = get_option(sanitize_text_field('wa_order_floating_button_position'));
	$custom_message = get_option(sanitize_text_field('wa_order_floating_message'));
	$floating_target = get_option(sanitize_text_field('wa_order_floating_target'));
	$button_text = get_option(sanitize_text_field('wa_order_option_text_button'));
	$target = get_option(sanitize_text_field('wa_order_option_target'));
	global $post;
	// WA Number from Setting
	$wanumberpage = get_option( 'wa_order_selected_wa_number_floating' );
	$postid = get_page_by_path( $wanumberpage, '', 'wa-order-numbers');
	if( empty( $postid) ) {
	    $pid = 0;
	} else {
	    $pid = $postid->ID;
	}
	$phonenumb = get_post_meta($pid, 'wa_order_phone_number_input', true);
	
	$tooltip_enable = get_option(sanitize_text_field('wa_order_floating_tooltip_enable'));
	$floating_mobile = get_option(sanitize_text_field('wa_order_floating_hide_mobile'));
	$floating_desktop = get_option(sanitize_text_field('wa_order_floating_hide_desktop'));

	// Include source page URL
	$include_source = get_option(sanitize_text_field('wa_order_floating_source_url'));
	$src_label = get_option(sanitize_text_field('wa_order_floating_source_url_label'));
	if ($src_label== '') $source_label= "From URL:";
		else $source_label= "$src_label";
	if ( $include_source === 'yes') {
		$source_url = home_url(add_query_arg(array(), $wp->request));
		$floating_message = urlencode(" ".$custom_message."\r\n\r\n*".$source_label."* ".$source_url." ");
	} else {
		$floating_message = $custom_message;
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
	$floating_link = "https://$wa_base.whatsapp.com/send?phone=$phonenumb&text=$floating_message";

	    if ( $floating_position === 'left' ) { ?>
			<a id="sendbtn" class="floating_button" href="<?php echo $floating_link ?>" role="button" target="<?php echo $floating_target ?>">
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

	 	<?php  } elseif ( $floating_position === 'right' ) { ?>
		<a id="sendbtn" class="floating_button" href="<?php echo $floating_link ?>" role="button" target="<?php echo $floating_target ?>">
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
}
add_action('wp_head', 'display_floating_button');

// Display Floating Button with Tooltip
function display_floating_tooltip() {
	global $wp;
	$floating = get_option(sanitize_text_field('wa_order_floating_button'));
	$floating_position = get_option(sanitize_text_field('wa_order_floating_button_position'));
	$custom_message = get_option(sanitize_text_field('wa_order_floating_message'));
	$floating_target = get_option(sanitize_text_field('wa_order_floating_target'));
	$button_text = get_option(sanitize_text_field('wa_order_option_text_button'));
	$target = get_option(sanitize_text_field('wa_order_option_target'));
	global $post;
	// WA Number from Setting
	$wanumberpage = get_option( 'wa_order_selected_wa_number_floating' );
	$postid = get_page_by_path( $wanumberpage, '', 'wa-order-numbers');
	if( empty( $postid) ) {
	    $pid = 0;
	} else {
	    $pid = $postid->ID;
	}
	$phonenumb = get_post_meta($pid, 'wa_order_phone_number_input', true);

	$tooltip_enable = get_option(sanitize_text_field('wa_order_floating_tooltip_enable'));
	$tool_tip = get_option(sanitize_text_field('wa_order_floating_tooltip'));
	if ($tool_tip== '') $tooltip = "Let's Chat";
	else $tooltip= "$tool_tip";

	$floating_mobile = get_option(sanitize_text_field('wa_order_floating_hide_mobile'));
	$floating_desktop = get_option(sanitize_text_field('wa_order_floating_hide_desktop'));

	// Include source page URL
	$include_source = get_option(sanitize_text_field('wa_order_floating_source_url'));
	$src_label = get_option(sanitize_text_field('wa_order_floating_source_url_label'));
	if ($src_label== '') $source_label= "From URL:";
	else $source_label= "$src_label";

	if ( $include_source === 'yes') {
		$source_url = home_url(add_query_arg(array(), $wp->request));
		$floating_message = urlencode(" ".$custom_message."\r\n\r\n*".$source_label."* ".$source_url." ");
	} else {
		$floating_message = $custom_message;
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
	$floating_link = "https://$wa_base.whatsapp.com/send?phone=$phonenumb&text=$floating_message";
		if ( $floating === 'yes' && $floating_position === 'left' && $tooltip_enable === 'yes' ) { ?>
			<a id="sendbtn" href="<?php echo $floating_link ?>" role="button" target="<?php echo $floating_target ?>" class="floating_button">
			    <div class="label-container">
			    	<div class="label-text"><?php echo $tooltip ?></div>
			    </div>
			</a>
			<style>
			.floating_button {
				left: 20px;
			}
				.label-container {
  					left: 85px;
				}		
			</style>
		<?php  } elseif ( $floating === 'yes' && $floating_position === 'right' && $tooltip_enable === 'yes' ) { ?>
			<a id="sendbtn" href="<?php echo $floating_link ?>" role="button" target="<?php echo $floating_target ?>" class="floating_button">
			    <div class="label-container">
			    	<div class="label-text"><?php echo $tooltip ?></div>
			    </div>
			</a>
			<style>
				.floating_button {
					right: 20px;
				}
				.label-container {
  					right: 85px;
				}				
			</style>	
     <?php
    }
}
add_action('wp_head', 'display_floating_tooltip');

// Hide Floating Button on Mobile
function hide_floating_button_mobile() {
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
add_action('wp_head', 'hide_floating_button_mobile');

// Hide Floating Button on Desktop
function hide_floating_button_desktop() {
	$floating_desktop = get_option(sanitize_text_field('wa_order_floating_hide_desktop'));
	if ( $floating_desktop === 'yes' ) { ?>
			<style>
			@media (min-width: 601px) {
				.floating_button {
					display: none !important;
				}
			}		
			</style>
     <?php
    }     
}
add_action('wp_head', 'hide_floating_button_desktop');

// Conditionally Hide Floating Button on selected queries
function wa_order_hide_floating_button_conditionally() {
	global $product, $post; 
	$posts		 = get_option(sanitize_text_field('wa_order_floating_hide_specific_posts'));
	$posts_array = (array) $posts;
	$pages		 = get_option(sanitize_text_field('wa_order_floating_hide_specific_pages'));
	$pages_array = (array) $pages;
	$prod_cats	 = get_option(sanitize_text_field('wa_order_floating_hide_product_cats'));
	$cats_array  = (array) $prod_cats;
	$prod_tags	 = get_option(sanitize_text_field('wa_order_floating_hide_product_tags'));
	$tags_array  = (array) $prod_tags;

	if ( empty($posts) && empty($pages) && empty($prod_cats) && empty($prod_tags)) {
		return;
	}

	// Hide floating button on products with selected categories
	if ( !is_null($product) || !empty($cats_array) && is_product() ) {
		if ( has_term( array_values($cats_array)[0], 'product_cat', $post->ID ) ) {
			?>
				<style>
					.floating_button {
						display: none !important;
					}
				</style>
	     <?php
		}
	}
	// Hide floating button on products with selected tags
	if ( !is_null($product) || !empty($tags_array) && is_product() ) {
		if ( has_term( array_values($tags_array)[0], 'product_tag', $post->ID ) ) {
			?>
				<style>
					.floating_button {
						display: none !important;
					}
				</style>
	     <?php
		}
	}


	// Hide floating button based on posts & pages
	if ( isset($pages) && !is_null($pages) ) {
		// Hide floating button on selected page(s)
		if ( is_page(array_values($pages_array)) && 'page' == get_post_type() ) { ?>
				<style>
					.floating_button {
						display: none !important;
					}
				</style>
	     <?php
		}
	}
	if ( isset($posts) && !is_null($posts) ) {
		// Hide floating button based on selected post(s)
		if ( is_single(array_values($posts_array)) && 'post' == get_post_type() ) { ?>
				<style>
					.floating_button {
						display: none !important;
					}
				</style>
	     <?php
		}
	}
}
add_action('wp_head', 'wa_order_hide_floating_button_conditionally');

// Hide floating button on all posts & pages
function wa_order_hide_floating_button_posts_pages() {
	//  Hide floating button on all posts
	if ( get_option(sanitize_text_field('wa_order_floating_hide_all_single_posts')) === 'yes' ) {
		if ( is_single() && 'post' == get_post_type() ) { ?>
				<style>
					.floating_button {
						display: none !important;
					}
				</style>
	     <?php
		}
	}

	//  Hide floating button on all pages
	if ( get_option(sanitize_text_field('wa_order_floating_hide_all_single_pages')) === 'yes' ) {
		if ( is_page() && 'page' == get_post_type() ) { ?>
				<style>
					.floating_button {
						display: none !important;
					}
				</style>
	     <?php
		}
	}
}	
add_action('wp_head', 'wa_order_hide_floating_button_posts_pages');	