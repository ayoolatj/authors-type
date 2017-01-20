<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://vedno.de
 * @since      1.0.0
 *
 * @package    Authors_type
 * @subpackage Authors_type/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Authors_type
 * @subpackage Authors_type/includes
 * @author     Tunji Ayoola <ayoolatj@gmail.com>
 */
class Authors_type_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        flush_rewrite_rules();
	}

}
