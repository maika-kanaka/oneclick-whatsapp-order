<?php
/**
 * Inspired by: Jean Livino (jeanlivino)
 * Source: https://github.com/jeanlivino/whatsapp-redirect-wordpress-plugin
 */
// Create a Custom Post Type for WhatsApp Numbers
function wa_order_multiple_numbers() {
  register_post_type( 'wa-order-numbers',
      array(
          'labels' => array(
              'name' => __( 'WhatsApp Numbers' ),
              'singular_name' => __( 'WhatsApp Number' ),
              'add_new_item' => __( 'Add WhatsApp Number' ),
              'add_new' => __( 'Add WhatsApp Number' )
          ),              
          'show_in_menu' => false,
          'public' => true,
          'publicly_queryable' => false,
          'has_archive' => false,
          'rewrite' => array('slug' => 'waon', 'with_front' => false),
          'supports' => array('title')
      )
  );
}
add_action( 'init', 'wa_order_multiple_numbers' );

/**
 * Create the metabox to save number
 * @link https://developer.wordpress.org/reference/functions/add_meta_box/
 */
    function wa_order_multiple_numbers_create_metabox() {
        add_meta_box(
            'wa_order_phonenumbers_metabox', // Metabox ID
            'Set a Number', // Title to display
            'wa_order_phonenumbers_render_metabox', // Function to call that contains the metabox content
            'wa-order-numbers', // Post type to display metabox on
            'normal', // Where to put it (normal = main colum, side = sidebar, etc.)
            'default' // Priority relative to other metaboxes
        );
    }
    add_action( 'add_meta_boxes', 'wa_order_multiple_numbers_create_metabox' );
    function wa_order_phonenumbers_render_metabox() {
        // Variables
        global $post; // Get the current post data
        $phone = get_post_meta( $post->ID, 'wa_order_phone_number_input', true ); // Get the saved values
        ?>

        <table class="form-table">
            <tbody>
                <tr class="wa_order_number">
                    <th scope="row">
                        <label class="wa_order_number_label" for="phone_number"><b><?php _e( 'WhatsApp Number', 'oneclick-wa-order' ); ?></b></label>
                    </th>
                    <td>
                        <input type="number" name="wa_order_phone_number_input" class="wa_order_input" id="phone-required" value="<?php echo esc_attr( $phone ); ?>" placeholder="<?php _e( 'e.g. 6281234567890', 'oneclick-wa-order' ); ?>">
                        <p class="description">
                            <?php _e( 'Enter number including country code, e.g. <code><b>62</b>81234567890</code>', 'oneclick-wa-order' ); ?></p>
                    </td>
                </tr>
                    </tbody>
                </table>
                <div class="wa-return-to-setting">
                  <p>
                    <a href="admin.php?page=wa-order&tab=welcome"><?php _e( 'Click here to return to <strong>Global Settings</strong> page.', 'oneclick-wa-order' ); ?></a>
                  </p>
                </div>
        <?php
        wp_nonce_field( 'wa_order_phonenumbers_metabox_nonce', 'wa_order_phonenumbers_metabox_process' );
    }
    //
    // Save the phone data
    //
    function wa_order_multiple_numbers_save_metabox( $post_id, $post ) {
        // Verify that our security field exists. If not, bail.
        if ( !isset( $_POST['wa_order_phonenumbers_metabox_process'] ) ) return;
        // Verify data came from edit/dashboard screen
        if ( !wp_verify_nonce( $_POST['wa_order_phonenumbers_metabox_process'], 'wa_order_phonenumbers_metabox_nonce' ) ) {
            return $post->ID;
        }
        // Verify user has permission to edit post
        if ( !current_user_can( 'edit_post', $post->ID )) {
            return $post->ID;
        }
        // Check that our custom fields are being passed along
        // This is the `name` value array. We can grab all
        // of the fields and their values at once.
        if ( !isset( $_POST['wa_order_phone_number_input'] ) ) {
            return $post->ID;
        }
        /**
         * Sanitize the submitted data
         * This keeps malicious code out of our database.
         * `wp_filter_post_kses` strips our dangerous server values
         * and allows through anything you can include a post.
         */
        $sanitized_phone = wp_filter_post_kses( $_POST['wa_order_phone_number_input'] );
        // Save our submissions to the database
        update_post_meta( $post->ID, 'wa_order_phone_number_input', $sanitized_phone );
    }
    add_action( 'save_post', 'wa_order_multiple_numbers_save_metabox', 1, 2 );

/**
 * Customize the CPT WhatsApp Number Notices
 * Original code by Welcher
 * @link https://wordpress.stackexchange.com/questions/268379/how-to-customize-post-edit-notices
 */
    add_filter( 'post_updated_messages', 'wa_order_multiple_numbers_updated_messages' );
    function wa_order_multiple_numbers_updated_messages( $messages ) {
    $post             = get_post();
    $post_type        = get_post_type( $post );
    $post_type_object = get_post_type_object( $post_type );
    $messages['wa-order-numbers'] = array(
        0  => '', // Unused. Messages start at index 1.
        1  => __( 'WhatsApp Number updated.' ),
        2  => __( 'WhatsApp Number updated.' ),
        3  => __( 'WhatsApp Number deleted.'),
        4  => __( 'WhatsApp Number updated.' ),
        /* translators: %s: date and time of the revision */
        5  => isset( $_GET['revision'] ) ? sprintf( __( 'WhatsApp Number restored to revision from %s' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6  => __( 'WhatsApp Number successfully added.' ),
        7  => __( 'WhatsApp Number saved.' ),
        8  => __( 'WhatsApp Number submitted.' ),
        9  => sprintf(
            __( 'WhatsApp Number scheduled for: <strong>%1$s</strong>.' ),
            // translators: Publish box date format, see http://php.net/date
            date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) )
        ),
        10 => __( 'WhatsApp Number draft updated.' )
    );
    return $messages;
    }    

/**
 * Validate the Phone Number Metabox Before Publishing
 * Original code by englebip
 * @link https://wordpress.stackexchange.com/questions/42013/prevent-post-from-being-published-if-custom-fields-not-filled
 */
// Check, Validate and Show Error Notice
add_action('save_post', 'wa_order_number_save_number_field', 10, 2);
add_action('save_post', 'wa_order_completion_validator', 20, 2);

function wa_order_number_save_number_field($pid, $post) {
    // don't do on autosave or when new posts are first created
    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || $post->post_status == 'auto-draft' ) return $pid;
    // abort if not my custom type
    if ( $post->post_type != 'wa-order-numbers' ) return $pid;
    // save post_meta with contents of custom field
    update_post_meta($pid, 'wa_order_phone_number_input', $_POST['wa_order_phone_number_input']);
}

// Validate
function wa_order_completion_validator($pid, $post) {
    // don't do on autosave or when new posts are first created
    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || $post->post_status == 'auto-draft' ) return $pid;
    // abort if not my custom type
    if ( $post->post_type != 'wa-order-numbers' ) return $pid;

    // init completion marker (add more as needed)
    $phone_empty = false;
    // retrieve meta to be validated
    $wa_number = get_post_meta( $pid, 'wa_order_phone_number_input', true );
    // just checking it's not empty
    if ( empty( $wa_number ) ) {
        $phone_empty = true;
        $error = __( '<p><strong>OneClick Chat to Order</strong> requires <strong> WhatsApp Number to be set!</strong></p>', 'oneclick-wa-order' );
            printf( __( '<div class="error">%s</div>', 'oneclick-wa-order' ), $error );
    }
// Update post status if ==
    // on attempting to publish - check for completion and intervene if necessary
    if ( ( isset( $_POST['publish'] ) || isset( $_POST['save'] ) ) && $_POST['post_status'] == 'publish' ) {
        //  don't allow publishing while any of these are incomplete
        if ( $phone_empty ) {
            global $wpdb;
            $wpdb->update( $wpdb->posts, array( 'post_status' => 'pending' ), array( 'ID' => $pid ) );
            // filter the query URL to change the published message
            add_filter( 'redirect_post_location', create_function( '$location','return add_query_arg("message", "4", $location);' ) );
        }
    }
}

// If the WhatsApp number is empty, show notice
add_action('admin_notices','wa_order_check_if_number_empty');
function wa_order_check_if_number_empty(){
    global $typenow,$pagenow;
    $wa_number = get_post_meta( get_the_ID(), 'wa_order_phone_number_input', true );
    if  (in_array( $pagenow, array( 'post.php', 'post-new.php' ))  && "wa-order-numbers" == $typenow ) {
        $error = __( '<p><strong>OneClick Chat to Order</strong> requires <strong style="color:red;"> WhatsApp number to be set!</strong> Please add a valid and active WhatsApp number.</p>', 'oneclick-wa-order' );
               $wa_number = get_post_meta( get_the_ID(), 'wa_order_phone_number_input', true );
               if ( empty( $wa_number ) ) {
                   printf( __( '<div class="error">%s</div>', 'oneclick-wa-order' ), $error );
               }
    }
}

// WA Number Selection
if ( ! function_exists( 'wa_order_phone_numbers_dropdown' ) ) {
  function wa_order_phone_numbers_dropdown( $args ) {
    global $wpdb;
    $query    = $wpdb->get_results( "SELECT post_name, post_title FROM {$wpdb->posts} WHERE post_type = 'wa-order-numbers' AND `post_status` = 'publish'", ARRAY_A );
    $name     = ( $args['name'] ) ? 'name="' . $args['name'] . '" ' : '';
    $multiple = ( isset( $args['multiple'] ) ) ? 'multiple' : '';
    echo '<select '.$name .' id="" class="wa_order-admin-select2 regular-text" '. $multiple .' >';    
      foreach ( $query as $key => $value ) {
        global $post;
        $wanumberpage = $value['post_name'];
        $postid = get_page_by_path( $wanumberpage, '', 'wa-order-numbers');
        $phonenumb = get_post_meta($postid->ID, 'wa_order_phone_number_input', true);
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
        echo '<option value="'.$value['post_name'].'" '. $selected .'>'.$value['post_title'].' - '.$phonenumb.'</option>';   
      }
    echo '</select>';
  }
}

// WA Number Selection for Shortcode generator
if ( ! function_exists( 'wa_order_phone_numbers_dropdown_shortcode_generator' ) ) {
  function wa_order_phone_numbers_dropdown_shortcode_generator( $args ) {
    global $wpdb;
    $query    = $wpdb->get_results( "SELECT post_name, post_title FROM {$wpdb->posts} WHERE post_type = 'wa-order-numbers' AND `post_status` = 'publish'", ARRAY_A );
    $name     = ( $args['name'] ) ? 'name="' . $args['name'] . '" ' : '';
    $multiple = ( isset( $args['multiple'] ) ) ? 'multiple' : '';
    echo '<select '.$name .' onChange="generateWAshortcode();" id="selected_wa_number" class="wa_order-admin-select2 regular-text" '. $multiple .' >';    
      foreach ( $query as $key => $value ) {
        global $post;
        $wanumberpage = $value['post_name'];
        $postid = get_page_by_path( $wanumberpage, '', 'wa-order-numbers');
        $phonenumb = get_post_meta($postid->ID, 'wa_order_phone_number_input', true);
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
        echo '<option value="'.$phonenumb.'" '. $selected .'>'.$value['post_title'].' - '.$phonenumb.'</option>';   
      }
    echo '</select>';
  }
}