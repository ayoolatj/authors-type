<?php

/**
 * Provides the markup for the image field
 *
 * @link       http://vedno.de
 * @since      1.0.0
 *
 * @package    Authors_type
 * @subpackage Authors_type/admin/partials
 */

global $post;
$meta_value     = get_post_meta( $post->ID, $args['id'], true );
$attachment_id  = ! empty( $meta_value ) ? $meta_value : 0;
$attachment_url = '';

if ( 0 !== $attachment_id ) {
    $attachment_attr = wp_get_attachment_image_src( $attachment_id );
    $attachment_url  = $attachment_attr[0];
}
?>
<div class="apt-row apt-type-file" data-fieldtype="file">
    <div class="apt-th">
        <label for="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( $args['name'], 'authors_type' ); ?></label>
    </div>
    <div class="apt-td">
        <input type="hidden" class="apt2-upload-file regular-text" name="<?php echo esc_attr( $args['id'] ); ?>" id="<?php echo esc_attr( $args['id'] ); ?>" value="<?php echo esc_url( $attachment_url ); ?>" size="45" data-previewsize="[150,150]" data-queryargs="">
        <input class="apt2-upload-button button" type="button" value="Add Media">
        <p class="apt2-metabox-description"><?php echo esc_html( $args['description'] ); ?></p>
        <input type="hidden" class="apt2-upload-file-id" name="<?php echo esc_attr( $args['id'] ); ?>_id" id="<?php echo esc_attr( $args['id'] ); ?>_id" value="<?php echo esc_attr( $attachment_id ); ?>">
        <div id="<?php echo esc_attr( $args['id'] ); ?>_id-status" class="apt2-media-status">
            <?php if ( ! empty( $attachment_url ) ): ?>
            <div class="img-status">
                <img width="150px" style="max-width: 150px; width: 100%; height: auto;" src="<?php echo esc_url( $attachment_url ); ?>">
                <p>
                    <a href="#" class="apt2-remove-file-button" rel="apt_authors_image">Remove Image</a>
                </p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
