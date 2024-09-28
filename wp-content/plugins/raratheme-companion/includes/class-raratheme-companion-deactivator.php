<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://raratheme.com/
 * @since      1.0.0
 *
 * @package    Raratheme_Companion
 * @subpackage Raratheme_Companion/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Raratheme_Companion
 * @subpackage Raratheme_Companion/includes
 * @author     Rara Theme <raratheme@gmail.com>
 */
class Raratheme_Companion_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		update_option( 'rtc_queue_flush_rewrite_rules', 'yes' );
	}

}
