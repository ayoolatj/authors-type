<?php

/**
 * Provides the markup for the Gallery field
 *
 * @link       http://vedno.de
 * @since      1.0.0
 *
 * @package    Authors_type
 * @subpackage Authors_type/admin/partials
 */

global $post;
$meta_value        = get_post_meta( $post->ID, $args['id'], true );
$attachment_ids    = ! empty( $meta_value ) ? $meta_value : '';
$attachment_array  = maybe_unserialize( $attachment_ids );
if ( is_array( $attachment_array ) ) {
    $attachment_string = implode( ",", $attachment_array );
} else {
    $attachment_string = $attachment_array;
}
?>
<div class="apt-row apt-type-file-list" data-fieldtype="file_list">
    <div class="apt-th">
        <label for="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( $args['name'], 'authors_type' ); ?></label>
    </div>
    <div class="apt-td">
        <input type="hidden" class="apt2-upload-file apt2-upload-list" name="<?php echo esc_attr( $args['id'] ); ?>" id="<?php echo esc_attr( $args['id'] ); ?>" value="" size="45" data-previewsize="[50,50]" data-queryargs="">
        <input type="button" class="apt2-upload-button button apt2-upload-list" name="" id="" value="Add or Upload Files">
        <p class="apt2-metabox-description"><?php echo esc_html( $args['description'] ); ?></p>
        <input type="hidden" class="apt2-upload-file-id" name="<?php echo esc_attr( $args['id'] ); ?>_id" id="<?php echo esc_attr( $args['id'] ); ?>_id" value="<?php echo esc_attr( $attachment_string ); ?>">
        <ul id="<?php echo esc_attr( $args['id'] ); ?>-status" class="apt2-media-status apt-attach-list ui-sortable">
            <?php
            if ( is_array( $attachment_array ) ):
                foreach ( $attachment_array as $attachment_id ):
                    $attachment_attr = wp_get_attachment_image_src( $attachment_id );
                    $attachment_url  = $attachment_attr[0]; ?>
                    <li class="img-status"><img width="50" height="50" src="<?php echo esc_url( $attachment_url ); ?>" class="attachment-50px50px" alt="3.png">
                        <p><a href="#" class="apt2-remove-file-button" rel="apt_image_gallery[<?php echo esc_attr( $attachment_id ); ?>]">Remove Image</a></p>
                        <input type="hidden" id="filelist-67" data-id="67" name="apt_image_gallery[<?php echo esc_attr( $attachment_id ); ?>]" value="<?php echo esc_url( $attachment_url ); ?>">
                    </li>
                <?php   endforeach;
            endif;
            ?>
        </ul>
    </div>
</div>