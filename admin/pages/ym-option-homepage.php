<?php

function yuka_meter_plugin_settings_page() {
?>
<div class="wrap">
<h1>Yuka Meter</h1>

<form method="POST" action="options.php">
   <?php settings_fields( 'yuka-meter-plugin-settings-group' ); ?>
   <?php do_settings_sections( 'yuka-meter-plugin-settings-group' ); ?>

   <?php 
      $bln_ym_active = (boolean) esc_attr( get_option('yukam_enable') );
      $bln_ym_icon   = (boolean) esc_attr( get_option('yukam_show_icon') );
      $bln_ym_color  = (boolean) esc_attr( get_option('yukam_display_in_color') );
   ?>

   <table class="form-table">
      <tr valign="top">
         <th scope="row"><?= __('Activate Yuka Meter'); ?></th>
         <td><input type="checkbox" name="yukam_enable" <?= ($bln_ym_active) ? 'checked' : ''; ?> value="1" /></td>
      </tr>

      <tr valign="top">
         <th scope="row"><?= __('Show Yuka icon'); ?></th>
         <td><input type="checkbox" name="yukam_show_icon" <?= ($bln_ym_icon) ? 'checked' : ''; ?> value="1" /></td>
      </tr>

      <tr valign="top">
         <th scope="row"><?= __('Display Yuka note in color'); ?></th>
         <td><input type="checkbox" name="yukam_display_in_color" <?= ($bln_ym_color) ? 'checked' : ''; ?> value="1" /></td>
      </tr>
   </table>

   <?php submit_button(); ?>

</form>
</div>
<?php }