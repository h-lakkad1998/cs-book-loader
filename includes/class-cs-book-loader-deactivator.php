<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://https://profiles.wordpress.org/hlakkad1998/
 * @since      1.0.0
 *
 * @package    Cs_Book_Loader
 * @subpackage Cs_Book_Loader/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Cs_Book_Loader
 * @subpackage Cs_Book_Loader/includes
 * @author     Hardik Patel <hardiklakkad2@gmail.com>
 */
class Cs_Book_Loader_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
		$like1 = $wpdb->esc_like( '_transient_cs_books_' ) . '%';
		$like2 = $wpdb->esc_like( '_transient_timeout_cs_books_' ) . '%';

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$count = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s", $like1, $like2 ) );

		$count = ( $count >= 2 ) ? $count / 2 : 0; 
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s", $like1, $like2 ) );

	}

}
