<?php

/**
 * Provides the markup for the users select field
 *
 * @link       http://vedno.de
 * @since      1.0.0
 *
 * @package    Authors_type
 * @subpackage Authors_type/admin/partials
 */

global $post;
$meta_value = get_post_meta( $post->ID, $args['id'], true );
$select_args = array(
    'show_option_none'        => 'Select Option', // string
    'orderby'                 => 'display_name',
    'order'                   => 'ASC',
    'multi'                   => false,
    'show'                    => 'display_name',
    'selected'                => esc_html( $meta_value ),
    'include_selected'        => true,
    'name'                    => esc_attr( $args['id'] ), // string
);
?>
<div class="apt-row apt-type-select" data-fieldtype="select">
    <div class="apt-th">
        <label for="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( $args['name'], 'authors_type' ); ?></label>
    </div>
    <div class="apt-td">
        <?php wp_dropdown_users( $select_args ); ?>
        <p class="apt2-metabox-description"><?php echo esc_html( $args['description'] ); ?></p>

    </div>
</div>
