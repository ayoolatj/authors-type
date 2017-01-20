<?php

/**
 * Provides the markup for the WYSIWYG field
 *
 * @link       http://vedno.de
 * @since      1.0.0
 *
 * @package    Authors_type
 * @subpackage Authors_type/admin/partials
 */
global $post;
$meta_value = get_post_meta( $post->ID, $args['id'], true );

$editor_args = array(
    'textarea_rows' => 10,
    'media_buttons' => false,
    'textarea_name' => esc_attr( $args['id'] ),
);
?>

<div class="apt-row apt-type-wysiwyg" data-fieldtype="wysiwyg">
    <div class="apt-th">
        <label for="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( $args['name'], 'authors_type' ); ?></label>
    </div>
    <div class="apt-td">
        <?php wp_editor( $meta_value, $args['id'], $editor_args); ?>

        <p class="apt2-metabox-description"><?php esc_attr( $args['description'] ); ?></p>

    </div>
</div>