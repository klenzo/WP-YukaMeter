<?php

/**
 * Register meta box(es).
 */
function yukam_register_meta_boxes() {
   if( get_option('yukam_enable') ){
      add_meta_box( 'yukam-meta-box', __( 'Yuka Meter', 'textdomain' ), 'yukam_display_callback', 'product' );
   }
}
add_action( 'add_meta_boxes', 'yukam_register_meta_boxes' );

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function yukam_display_callback( $post ) {
   $ym_note = get_post_meta($post->ID, 'yuka_note', true);
?>
   <label for="ym-note-product">Note Yuka du produit : 
   <input type="number" min="0" max="100" name="ym-note-product" value="<?= $ym_note; ?>" id="ym-note-product">/100</label>
<?php
}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function yukam_save_meta_box( $post_id ) {
    if (array_key_exists('ym-note-product', $_POST)) {
        update_post_meta(
            $post_id,
            'yuka_note',
            $_POST['ym-note-product']
        );
    }
}
add_action( 'save_post', 'yukam_save_meta_box' );