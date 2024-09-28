<?php

/**
 * Fired during plugin activation
 *
 * @link       https://raratheme.com/
 * @since      1.0.0
 *
 * @package    Raratheme_Companion
 * @subpackage Raratheme_Companion/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Raratheme_Companion
 * @subpackage Raratheme_Companion/includes
 * @author     Rara Theme <raratheme@gmail.com>
 */
class Raratheme_Companion_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		update_option( 'rtc_queue_flush_rewrite_rules', 'yes' );
	}

}
