<?php

/**
 * Provides the markup for the text field
 *
 * @link       http://vedno.de
 * @since      1.0.0
 *
 * @package    Authors_type
 * @subpackage Authors_type/admin/partials
 */

global $post;
$meta_value = get_post_meta( $post->ID, $args['id'], true );
$required = ! in_array( $args['id'], array( 'apt_first_name', 'apt_last_name'), TRUE ) ? '' : 'data-parsley-required="true"';
// global $current_screen;
// print_r( $current_screen );
?>
<div class="apt-row apt-type-text table-layout" data-fieldtype="text">
    <div class="apt-th">
        <label for="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( $args['name'], 'authors_type' ); ?></label>
    </div>
    <div class="apt-td">
        <input type="text" class="regular-text" name="<?php echo esc_attr( $args['id'] ); ?>" id="<?php echo esc_attr( $args['id'] ); ?>" value="<?php echo esc_attr( $meta_value ); ?>" <?php echo $required; ?>>
        <p class="apt2-metabox-description"><?php echo esc_html( $args['description'] ); ?></p>

    </div>
</div>