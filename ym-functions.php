<?php

function yukam_enqueue_scripts() {  
   wp_enqueue_style( 'yukam-style', plugins_url('css/yukam_style.css', __FILE__) );
}
add_action( 'wp_enqueue_scripts', 'yukam_enqueue_scripts' );

/*
 * Add my new menu to the Admin Control Panel
 */
add_action('admin_menu', 'yukam_addAdminLink');
function yukam_addAdminLink() {

   add_menu_page(
      'Yuka Meter',
      'Yuka Meter',
      'manage_options',
      'yuka_meter_plugin_settings_page',
      'yuka_meter_plugin_settings_page',
      plugins_url('/images/icon-yuka-20x20.png', __FILE__)
   );

   //call register settings function
   add_action( 'admin_init', 'register_yuka_meter_plugin_settings' );
}

// Register options for plugin
function register_yuka_meter_plugin_settings() {
   //register our settings
   register_setting( 'yuka-meter-plugin-settings-group', 'yukam_enable', array(
      'type'        => 'boolean',
      'description' => __('Activate Yuka Meter'),
      'default'     => true
   ));
   register_setting( 'yuka-meter-plugin-settings-group', 'yukam_show_icon', array(
      'type'        => 'boolean',
      'description' => __('Show Yuka icon'),
      'default'     => true
   ));
   register_setting( 'yuka-meter-plugin-settings-group', 'yukam_display_in_color', array(
      'type'        => 'boolean',
      'description' => __('Display Yuka note in color'),
      'default'     => true
   ));
}

if(!function_exists('yukam_WCproductPage_hook')){
   function yukam_WCproductPage_hook(){
      return 'woocommerce_before_add_to_cart_form';
   }
}

function yukam_show_note_WCproductPage( $post_id )
{
   $bln_ym_active = (boolean) esc_attr( get_option('yukam_enable') );
   $bln_ym_icon   = (boolean) esc_attr( get_option('yukam_show_icon') );
   $bln_ym_color  = (boolean) esc_attr( get_option('yukam_display_in_color') );
   $yukam_class   = 'yukam_note';
   $yukam_text    = '';
   if( $bln_ym_active ){
      $yukam_note = get_post_meta( get_the_ID(), 'yuka_note', true);

      if( !empty($yukam_note) ){
         $yukam_class .= ($bln_ym_icon) ? ' yukam_icon' : '';
         if($bln_ym_color){
            switch (true) {
               case ($yukam_note <= 25):
                  $yukam_class .= ' yukam_mauvais';
                  $yukam_text  = 'mauvais';
                  break;
               case ($yukam_note <= 50):
                  $yukam_class .= ' yukam_mediocre';
                  $yukam_text  = 'mediocre';
                  break;
               case ($yukam_note <= 75):
                  $yukam_class .= ' yukam_bon';
                  $yukam_text  = 'bon';
                  break;
               default:
                  $yukam_class .= ' yukam_excellent';
                  $yukam_text  = 'excellent';
                  break;
            }
         }
         echo '<strong class="'. $yukam_class .'"><span>'.$yukam_note.'</span>/100</strong>';
      }
   }
}
add_action( yukam_WCproductPage_hook(), "yukam_show_note_WCproductPage");