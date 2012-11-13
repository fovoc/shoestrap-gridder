<?php

define( 'SHOESTRAP_EDD_STORE_URL', 'http://bootstrap-commerce.com/downloads' );
define( 'SHOESTRAP_EDD_ITEM_NAME', 'Shoestrap MP Addon' );

if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
  // load our custom updater
  include( dirname( __FILE__ ) . '/plugin_updater.php' );
}

// retrieve our license key from the DB
$license_key = trim( get_option( 'shoestrap_edd_license_key' ) );

// setup the updater
$edd_updater = new EDD_SL_Plugin_Updater( SHOESTRAP_EDD_STORE_URL, __FILE__, array( 
    'version'   => '1.00',         // current version number
    'license'   => $license_key,
    'item_name' => SHOESTRAP_EDD_ITEM_NAME,
    'author'    => 'Aristeides Stathopoulos'
  )
);

add_action( 'shoestrap_admin_content', 'shoestrap_edd_licensing' );
function shoestrap_edd_licensing() {
  $license  = get_option( 'shoestrap_edd_license_key' );
  $status   = get_option( 'shoestrap_edd_license_status' );
  $submit_text  = __( 'Save & activate licence', 'shoestrap' );
  ?>
  <div class="postbox">
    <h3 class="hndle" style="padding: 7px 10px;"><span><?php _e( 'Shoestrap Easy Digital Downloads Addon Licence', 'shoestrap' ); ?></span></h3>
    <div class="inside">
      <form method="post" action="options.php">
        <?php settings_fields('shoestrap_edd_license'); ?>
        <?php _e( 'License Key:', 'shoestrap' ); ?>
        <input id="shoestrap_edd_license_key" name="shoestrap_edd_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
        <label class="description" for="shoestrap_edd_license_key">
            <?php _e( 'Enter your license key', 'shoestrap' ); ?>
            (
            <?php if( false !== $license ) { ?>
              <?php if( $status !== false && $status == 'valid' ) { ?>
                <span style="color:green;"><?php _e( 'active', 'shoestrap' ); ?></span>
              <?php } else { ?>
                <span style="color:red;"><?php _e( 'inactive', 'shoestrap' ); ?></span>
              <?php } ?>
            <?php } ?>
            )
            
        </label>
        <?php submit_button( $submit_text ); ?>
      </form>
    </div>
  </div>
  <?php
}


add_action('admin_init', 'shoestrap_edd_register_option');
function shoestrap_edd_register_option() {
  // creates our settings in the options table
  register_setting('shoestrap_edd_license', 'shoestrap_edd_license_key', 'shoestrap_edd_sanitize_license' );
}

function shoestrap_edd_sanitize_license( $new ) {
  $old = get_option( 'shoestrap_edd_license_key' );
  if( $old && $old != $new ) {
    delete_option( 'shoestrap_edd_license_status' ); // new license has been entered, so must reactivate
  }
  return $new;
}

add_action( 'admin_init', 'shoestrap_edd_activate_license' );
function shoestrap_edd_activate_license() {
  $license_key = trim( get_option( 'shoestrap_edd_license_key' ) );
  if ( strlen( $license_key ) < 7 )
    return;

  if( get_option( 'shoestrap_edd_license_status' ) == 'active' )
    return;

  $license = trim( get_option( 'shoestrap_edd_license_key' ) );

  // data to send in our API request
  $api_params = array( 
    'edd_action'=> 'activate_license', 
    'license'   => $license, 
    'item_name' => urlencode( SHOESTRAP_EDD_ITEM_NAME ) 
  );
  
  // Call the custom API.
  $response = wp_remote_get( add_query_arg( $api_params, SHOESTRAP_EDD_STORE_URL ) );

  // make sure the response came back okay
  if ( is_wp_error( $response ) )
    return false;

  // decode the license data
  $license_data = json_decode( wp_remote_retrieve_body( $response ) );

  update_option( 'shoestrap_edd_license_status', $license_data->license );
}
