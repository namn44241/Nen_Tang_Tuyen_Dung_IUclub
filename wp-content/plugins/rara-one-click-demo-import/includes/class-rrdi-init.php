<?php
/**
 * Display admin error message if PHP version is older than 5.3.2.
 * Otherwise execute the main plugin class.
 */
class RDDI_init
{
	function __construct()
	{
		$this->rddi_init_version_check();
	}
	
	function rddi_init_version_check()
	{
		
		if ( version_compare( phpversion(), '5.3.2', '<' ) ) {

			/**
			 * Display an admin error notice when PHP is older the version 5.3.2.
			 * Hook it to the 'admin_notices' action.
			 */
			function rrdi_old_php_admin_error_notice() {
				$message = sprintf( esc_html__( 'The %2$sRara One Click Demo Import%3$s plugin requires %2$sPHP 5.3.2+%3$s to run properly. Please contact your hosting company and ask them to update the PHP version of your site to at least PHP 5.3.2.%4$s Your current version of PHP: %2$s%1$s%3$s', 'rara-one-click-demo-import' ), phpversion(), '<strong>', '</strong>', '<br>' );

				printf( '<div class="notice notice-error"><p>%1$s</p></div>', wp_kses_post( $message ) );
			}
			add_action( 'admin_notices', 'rrdi_old_php_admin_error_notice' );
		}
		else {
			$upload = wp_upload_dir();
			$upload_dir = $upload['basedir'];
			$upload_dir = $upload_dir . '/rara-demo-pack';
				if (! is_dir($upload_dir)) {
					mkdir( $upload_dir, 0755 );
				}
			
			// Require main plugin file.
			require RRDI_PATH . 'includes/class-rrdi-main.php';

			// Instantiate the main plugin class *Singleton*.
			$Theme_Demo_Import = RRDI_Theme_Demo_Import::Instance();
		}
	}
}
new RDDI_init;