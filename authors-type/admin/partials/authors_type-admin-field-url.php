<?php

/**
 * Provides the markup for the text field use for url
 *
 * @link       http://vedno.de
 * @since      1.0.0
 *
 * @package    Authors_type
 * @subpackage Authors_type/admin/partials
 */

global $post;
$meta_value = get_post_meta( $post->ID, $args['id'], true );
?>
<div class="apt-row apt-type-text table-layout" data-fieldtype="text">
    <div class="apt-th">
        <label for="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( $args['name'], 'authors_type' ); ?></label>
    </div>
    <div class="apt-td">
        <input type="url" class="regular-text" name="<?php echo esc_attr( $args['id'] ); ?>" id="<?php echo esc_attr( $args['id'] ); ?>" value="<?php echo esc_url( $meta_value ); ?>">
        <p class="apt2-metabox-description"><?php echo esc_html( $args['description'] ); ?></p>

    </div>
</div>