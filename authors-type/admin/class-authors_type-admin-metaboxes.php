<?php

/**
 * The metabox-specific functionality of the plugin.
 *
 * @link       http://vedno.de
 * @since      1.0.0
 *
 * @package    Authors_type
 * @subpackage Authors_type/admin
 */

/**
 * The metabox-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Authors_type
 * @subpackage Authors_type/admin
 * @author     Tunji Ayoola <ayoolatj@gmail.com>
 */
class Authors_Type_Admin_Metaboxes {

    /**
     * The post meta data
     *
     * @since     1.0.0
     * @access 	  private
     * @var 	  string    $meta    The post meta data.
     */
    private $meta;

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Registers metaboxes with WordPress
     *
     * @since 	1.0.0
     * @access 	public
     */
    public function add_metaboxes() {

        // add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );

        add_meta_box(
            $this->plugin_name . '-profile',
            __( 'Profile', 'authors_type' ),
            array( $this, 'render_metabox' ),
            'authors',
            'normal',
            'default',
            array(
                'file' => 'profile'
            )
        );

    }

    /**
     * Calls a metabox file specified in the add_meta_box args.
     *
     * @since 	1.0.0
     * @access 	public
     * @return 	void
     */
    public function render_metabox( $post, $params ) {

        if ( ! is_admin() ) return;
        if ( 'authors' !== $post->post_type ) return;

        include( plugin_dir_path( __FILE__ ) . 'partials/authors_type-admin-metabox-' . $params['args']['file'] . '.php' );

    }

    /**
     * Set Authors post's name and title
     *
     * @since 	1.0.0
     * @access 	public
     * @param 	int 		$post_id 		The post ID
     * @param 	object 		$post 		    The post object
     * @return 	void
     */
    public function set_title( $post_id, $post ) {

        // This temporarily removes action to prevent infinite loops
        remove_action( 'save_post', array( $this, 'authors_type_save_meta' ) );

        if ( isset( $post->post_type ) && 'authors' !== $post->post_type ) {
            return;
        }

        // get authors first and last name
        $first = get_post_meta( $post_id, 'apt_first_name', true ); //meta for first name
        $last  = get_post_meta( $post_id, 'apt_last_name', true );   //meta for last name

        $full_name = $first . ' ' . $last;

        // update the post, which calls save_post again
        wp_update_post( array(
            'ID'         => $post_id,
            'post_title' => $full_name,
            'post_name'  => $full_name,
        ) );

        // re-hook this function
        add_action( 'save_post', array( $this, 'authors_type_save_meta' ), 10, 3 );
    }

    /**
     * Returns default Authors Type meta fields.
     *
     * @since 1.0.0
     * @return array $fields Array of fields.
     */
    public function get_metabox_fields() {

        $fields = array(
            array(
                'id'          => 'apt_first_name',
                'name'        => '*First name',
                'type'        => 'text',
                'description' => 'Enter Author\'s First Name. Eg: John',
            ),
            array(
                'id'          => 'apt_last_name',
                'name'        => '*Last name',
                'type'        => 'text',
                'description' => 'Enter Author\'s Last Name. Eg: Smith.',
            ),
            array(
                'id'          => 'apt_biography',
                'name'        => 'Biography',
                'type'        => 'wysiwyg',
                'description' => 'Enter Author\'s Biography.',
            ),
            array(
                'id'          => 'apt_facebook_url',
                'name'        => 'Facebook URL',
                'type'        => 'url',
                'description' => 'Enter Author\'s Facebook URL. Eg: https://www.facebook.com/username',
            ),
            array(
                'id'          => 'apt_linkedin_url',
                'name'        => 'Linkedin URL',
                'type'        => 'url',
                'description' => 'Enter Author\'s Linkedin URL. Eg: https://www.linkedin.com/in/username/',
            ),
            array(
                'id'          => 'apt_google_plus_url',
                'name'        => 'Google+ URL',
                'type'        => 'url',
                'description' => 'Enter Author\'s Google+ URL. Eg: https://profiles.google.com/Unique_Google_profile_ID',
            ),
            array(
                'id'          => 'apt_existing_user',
                'name'        => 'Attach Exisiting User',
                'type'        => 'users-select',
                'description' => 'Link Author to an Existing Wordpress User',
            ),
            array(
                'id'          => 'apt_authors_image',
                'name'        => 'Authors Image',
                'type'        => 'image',
                'description' => 'Upload an Image for the Author',
            ),
            array(
                'id'          => 'apt_image_gallery',
                'name'        => 'Image Gallery',
                'type'        => 'gallery',
                'description' => 'Author\'s Image Gallery',
            ),
        );

        return $fields;
    }

    /**
     * Renders individual fields
     *
     * @since 	1.0.0
     * @access 	public
     * @param 	array 		$args 		Field arguments
     * @return 	void
     */
    public function render_metabox_field( $args ) {

        include( plugin_dir_path( __FILE__ ) . 'partials/authors_type-admin-field-' . $args['type'] . '.php' );

    }

    /**
     * Saves metabox data
     *
     * @since 	1.0.0
     * @access 	public
     * @param 	int 		$post_id 		The post ID
     * @param 	object 		$post 		    The post object
     * @return 	void
     */
    public function authors_type_save_meta( $post_id, $post ) {

        if ( ! isset( $_POST['profiles_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['profiles_meta_box_nonce'], $this->plugin_name . '-profile' ) ) {
            return;
        }

        if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX') && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) {
            return;
        }

        if ( isset( $post->post_type ) && 'revision' == $post->post_type ) {
            return;
        }

        $fields = $this->get_metabox_fields();

        foreach ( $fields as $key => $field ) {
            if ( "text" == $field['type'] ) {
                $field_value = sanitize_text_field( $_POST[ $field['id'] ] );
                update_post_meta( $post_id, $field['id'], $field_value );
            } elseif ( "url" == $field['type'] ) {
                $field_value = esc_url( $_POST[ $field['id'] ] );
                update_post_meta( $post_id, $field['id'], $field_value );
            } elseif ( "wysiwyg" == $field['type'] ) {
                $field_value = wp_kses_post( $_POST[ $field['id'] ] );
                update_post_meta( $post_id, $field['id'], $field_value );
            } elseif ( "users-select" == $field['type'] ) {
                $field_value = ( ! empty( $_POST[ $field['id'] ] ) && is_numeric( $_POST[ $field['id'] ] ) ) ? (int) $_POST[ $field['id'] ] : -1;
                update_post_meta( $post_id, $field['id'], $field_value );
            } elseif ( "image" == $field['type'] ) {
                $field_id = $field['id'];
                $image_id = $_POST[ "{$field_id}_id" ];
                $field_value = ( ! empty( $image_id ) && is_numeric( $image_id ) ) ? (int) $image_id : -1;
                update_post_meta( $post_id, $field['id'], $field_value );
            } elseif ( "gallery" == $field['type'] ) {
                $field_id = $field['id'];
                $image_id = $_POST[ "{$field_id}_id" ];

                $image_id_array = explode(',', $image_id);
                $image_id_array = array_map('intval', array_filter( $image_id_array, 'is_numeric' ));

                $field_value = serialize( $image_id_array );

                update_post_meta( $post_id, $field['id'], $field_value );
            }
        }

        $this->set_title( $post_id, $post );

    }

}