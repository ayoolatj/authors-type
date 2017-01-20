<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://vedno.de
 * @since      1.0.0
 *
 * @package    Authors_type
 * @subpackage Authors_type/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Authors_type
 * @subpackage Authors_type/public
 * @author     Tunji Ayoola <ayoolatj@gmail.com>
 */
class Authors_type_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/authors_type-public.css', array(), $this->version, 'all' );

        wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/authors_type-public.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Add biography to the_content on archives page
     *
     * @since    1.0.0
     * @param    string    $output       The content of the post.
     * @return   string    $output       The content of the post.
     */
    public function display_biography_on_archive( $output ) {
        global $post;
        if( is_front_page() || is_archive() || is_search() ) {
            if ( 'authors' == $post->post_type ) {
                $biography = get_post_meta($post->ID, 'apt_biography', true);
                $stripped_biography = esc_html( strip_tags( $biography ) );
                return wp_trim_words($stripped_biography, 40, '...');

            }
        }
        return $output;
    }

    /**
     * Adds authors custom fields to single page
     *
     * @since    1.0.0
     * @param    string    $output       The content of the post.
     * @return   string    $output       The content of the post.
     */
    public function display_authors_custom_fields_single( $output ) {
        if( is_singular('authors') ) {
            ob_start();
            /**
             * The class responsible for defining all actions relating to metaboxes.
             */
            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/authors_type-public-display.php';

            return ob_get_clean();
        }
        return $output;
    }

}
