<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://vedno.de
 * @since      1.0.0
 *
 * @package    Authors_type
 * @subpackage Authors_type/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Authors_type
 * @subpackage Authors_type/admin
 * @author     Tunji Ayoola <ayoolatj@gmail.com>
 */
class Authors_type_Admin {

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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Authors_type_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Authors_type_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/authors_type-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
     * @param    string    $hook    The suffix for the current admin page.
	 */
	public function enqueue_scripts( $hook ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Authors_type_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Authors_type_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $post;

        if ( in_array( $hook, array( 'post.php', 'post-new.php' ), TRUE ) ) {
            if ('authors' === $post->post_type) {

                wp_enqueue_media();

                wp_enqueue_script($this->plugin_name . '-parsley', plugin_dir_url(__FILE__) . 'js/parsley.js', array('jquery'), $this->version, false);

                wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/authors_type-admin.js', array('jquery'), $this->version, false);
            }
        }

	}

    /**
     * Registers and sets up the Authors custom post type
     *
     * @since 	1.0.0
     * @access 	public
     * @uses 	register_post_type()
     */
    public static function setup_post_types() {
        $labels = array(
            'name'                  => _x( 'Authors', 'Post type general name', 'authors_type' ),
            'singular_name'         => _x( 'Author', 'Post type singular name', 'authors_type' ),
            'menu_name'             => _x( 'Authors', 'Admin Menu text', 'authors_type' ),
            'name_admin_bar'        => _x( 'Author', 'Add New on Toolbar', 'authors_type' ),
            'add_new'               => __( 'Add New', 'authors_type' ),
            'add_new_item'          => __( 'Add New Author', 'authors_type' ),
            'new_item'              => __( 'New Author', 'authors_type' ),
            'edit_item'             => __( 'Edit Author', 'authors_type' ),
            'view_item'             => __( 'View Author', 'authors_type' ),
            'all_items'             => __( 'All Authors', 'authors_type' ),
            'search_items'          => __( 'Search Authors', 'authors_type' ),
            'parent_item_colon'     => __( 'Parent Authors:', 'authors_type' ),
            'not_found'             => __( 'No authors found.', 'authors_type' ),
            'not_found_in_trash'    => __( 'No authors found in Trash.', 'authors_type' ),
            'archives'              => _x( 'Author archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'authors_type' ),
            'insert_into_item'      => _x( 'Insert into author', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'authors_type' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this author', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'authors_type' ),
            'filter_items_list'     => _x( 'Filter authors list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'authors_type' ),
            'items_list_navigation' => _x( 'Authors list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'authors_type' ),
            'items_list'            => _x( 'Authors list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'authors_type' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'authors' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => false,
        );

        register_post_type( 'authors', $args );
    }

}
