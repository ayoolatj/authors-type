<?php

/**
 * Fired during plugin activation
 *
 * @link       http://vedno.de
 * @since      1.0.0
 *
 * @package    Authors_type
 * @subpackage Authors_type/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Authors_type
 * @subpackage Authors_type/includes
 * @author     Tunji Ayoola <ayoolatj@gmail.com>
 */
class Authors_type_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-authors_type-admin.php';

        Authors_type_Admin::setup_post_types();

        flush_rewrite_rules();
	}

}
