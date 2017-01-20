<?php

/**
 * Provide the view for the profile metabox
 *
 * @link       http://vedno.de
 * @since      1.0.0
 *
 * @package    Authors_type
 * @subpackage Authors_type/admin/partials
 */

wp_nonce_field( $this->plugin_name . '-profile', 'profiles_meta_box_nonce' );

?>
<div class='apt2-wrap form-table'>
    <div class="apt2-metabox apt-field-list" id="<?php echo $this->plugin_name . '-profile'; ?>">
        <?php  $fields = $this->get_metabox_fields();

        foreach ( $fields as $key => $field ) {
            $this->render_metabox_field( $field );
        }

        ?>
    </div>
</div>