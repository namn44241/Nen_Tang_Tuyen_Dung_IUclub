<?php
/**
 * Main Rara One Click Demo Import plugin class/file.
 *
 * @package rara-one-click-demo-import
 */
/**
 * Rara One Click Demo Import class, so we don't have to worry about namespaces.
 */
class RRDI_Theme_Demo_Import {

	public $demo_config;

	/**
	 * Demo packages.
	 *
	 * @var array
	 */
	public $demo_packages;

	/**
	 * Demo installer.
	 *
	 * @var bool
	 */
	public $demo_installer = true;

	/**
	 * Define allowed authors for theme demo import.
	 *
	 * @var array
	 */
	public $rrdi_allowed_authors_uris = array( 'https://raratheme.com/', 'https://rarathemes.com/', 'https://wptravelengine.com' );

	/**
	 * @var $instance the reference to *Singleton* instance of this class
	 */
	private static $instance;

	/**
	 * Private variables used throughout the plugin.
	 */
	private $importer, $plugin_page, $import_files, $logger, $log_file_path, $selected_index, $selected_import_files, $microtime, $frontend_error_messages, $ajax_call_number;


	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return Theme_Demo_Import the *Singleton* instance.
	 */
	public static function Instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}


	/**
	 * Class construct function, to initiate the plugin.
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct() {
		require RRDI_PATH . 'includes/class-rrdi-include-files.php';
		// Actions.

		$this->includes();

		add_action( 'init', array( $this, 'setup' ), 5 );
		$get_theme = wp_get_theme();

		if ( $this->is_valid_theme_author() ) {

			add_action( 'admin_menu', array( $this, 'create_plugin_page' ) );

		}
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'wp_ajax_rrdi_import_demo_data', array( $this, 'rrdi_import_demo_data_ajax_callback' ) );
		add_action( 'init', array( $this, 'setup_plugin_with_filter_data' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		// AJAX Events to import demo and dismiss notice.
		add_action( 'wp_ajax_dismiss-notice', array( $this, 'ajax_dismiss_notice' ) );
	}

	/**
	 * Check if theme author is valid to use demo importer.
	 *
	 * @return boolean
	 */
	public function is_valid_theme_author() {

		$allowed_authors = apply_filters( 'rrdi_valid_theme_author_uris', $this->rrdi_allowed_authors_uris );
		$theme_data      = wp_get_theme();

		$allowed_urls     = array_map( 'parse_url', $allowed_authors );
		$allowed_hosts    = array_column( $allowed_urls, 'host' );
		$theme_author_url = parse_url( $theme_data->get( 'AuthorURI' ) );

		return in_array( $theme_author_url['host'], $allowed_hosts );

	}

	/**
	 * Demo importer setup.
	 */
	public function setup() {
		$this->demo_config    = apply_filters( 'rara_demo_importer_config', array() );
		$this->demo_packages  = apply_filters( 'rara_demo_importer_packages', array() );
		$this->demo_installer = apply_filters( 'rara_demo_importer_installer', true );
	}


	function getNewestDir( $path ) {
		$working_dir = getcwd();
		chdir( $path ); // chdir to requested dir
		$ret_val = false;
		if ( $p = opendir( $path ) ) {
			while ( false !== ( $file = readdir( $p ) ) ) {
				if ( $file[0] != '.' && is_dir( $file ) ) {
					$list[] = date( 'YmdHis', filemtime( $path . '/' . $file ) ) . $path . '/' . $file;
				}
			}
			if ( isset( $list ) ) {
				rsort( $list );
				$ret_val = $list[0];
			}
		}
		chdir( $working_dir ); // chdir back to script's dir
		return $ret_val;
	}

	/**
	 * Includes.
	 */
	private function includes() {

		$get_theme = wp_get_theme();

		if ( $this->is_valid_theme_author() ) {

			$td = $get_theme->get( 'TextDomain' ) . '-demo-content';
			if ( strpos( $td, 'pro' ) === false ) {
				$upload_dir = wp_upload_dir();
				// Check the folder contains at least 1 valid demo config.
				$path  = $upload_dir['basedir'] . '/rara-demo-pack/';
				$files = $path . $td . '/import-hooks.php';
				if ( file_exists( $files ) && is_readable( $files ) ) {
					include $files;
				}
			}
		}
	}

	/**
	 * Private clone method to prevent cloning of the instance of the *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone() {}


	/**
	 * Private unserialize method to prevent unserializing of the *Singleton* instance.
	 *
	 * @return void
	 */
	public function __wakeup() {}


	/**
	 * Creates the plugin page and a submenu item in WP Appearance menu.
	 */
	public function create_plugin_page() {
		$plugin_page_setup = apply_filters(
			'rrdi/plugin_page_setup',
			array(
				'parent_slug' => 'themes.php',
				'page_title'  => esc_html__( 'Rara One Click Demo Import', 'rara-one-click-demo-import' ),
				'menu_title'  => esc_html__( 'Rara Demo Import', 'rara-one-click-demo-import' ),
				'capability'  => 'import',
				'menu_slug'   => 'rara-demo-import',
			)
		);

		$this->plugin_page = add_submenu_page( $plugin_page_setup['parent_slug'], $plugin_page_setup['page_title'], $plugin_page_setup['menu_title'], $plugin_page_setup['capability'], $plugin_page_setup['menu_slug'], array( $this, 'display_plugin_page' ) );
	}

	/**
	 * Settings Tabs.
	 *
	 * @since    1.0.4
	 */
	function rrdi_settings_option_tabs() {

		$options = array(
			'Before_You_Begin'      => 'intro.php',
			'Demo_Import'           => 'welcome.php',
			'Pro_Theme_Demo_Import' => 'installed-demos.php',
		);
		$options = apply_filters( 'rrdi_settings_option_tabs', $options );
		return $options;
	}

	private function rddi_upload_demo_pack() {
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

		if ( ! current_user_can( 'upload_files' ) ) {
			wp_die( __( 'Sorry, you are not allowed to install demo on this site.', 'rara-one-click-demo-import' ) );
		}

		check_admin_referer( 'demo-upload' );

		$file_upload = new File_Upload_Upgrader( 'demozip', 'package' );

		$title = sprintf( __( 'Installing Demo from uploaded file: %s', 'rara-one-click-demo-import' ), esc_html( basename( $file_upload->filename ) ) );
		$nonce = 'demo-upload';
		$url   = add_query_arg( array( 'package' => $file_upload->id ), 'themes.php?page=demo-importer&action=upload-demo' );
		$type  = 'upload'; // Install demo type, From Web or an Upload.

		// Demo Upgrader Class.
		include_once dirname( __FILE__ ) . '/vendor/class-demo-upgrader.php';
		include_once dirname( __FILE__ ) . '/vendor/class-demo-installer-skin.php';

		$upgrader = new RDDI_Demo_Upgrader( new RDDI_Demo_Installer_Skin( compact( 'type', 'title', 'nonce', 'url' ) ) );
		$result   = $upgrader->install( $file_upload->package );

		if ( $result || is_wp_error( $result ) ) {
			$file_upload->cleanup();
		}
	}

	/**
	 * Plugin page display.
	 */
	public function display_plugin_page() {
		if ( isset( $_GET['action'] ) && 'upload-demo' === $_GET['action'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$this->rddi_upload_demo_pack();
		} else { ?>
		<div class="wrap">
			<h1>
			<?php
				esc_html_e( 'RARA Demo Import', 'rara-one-click-demo-import' );
			if ( current_user_can( 'upload_files' ) ) {
				echo ' <button type="button" class="upload-view-toggle page-title-action hide-if-no-js tg-demo-upload" aria-expanded="false">' . __( 'Upload Demo File', 'rara-one-click-demo-import' ) . '</button>';
			}
			?>
			</h1>
			<div id="tabs-container">
				<div class="tab">
					<ul class="tabs-menu">
						<?php
						$settings_tab = $this->rrdi_settings_option_tabs();
							$count    = 0;
						foreach ( $settings_tab as $key => $value ) {
							$tab_label = preg_replace( '/_/', ' ', $key );
							?>
								<li
								<?php
								if ( $count == 0 ) {
									?>
									class="current"<?php } ?>><a href="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $tab_label ); ?></a></li>
							<?php
							$count++;
						}
						?>
					</ul>
					<?php
					$counter = 0;
					foreach ( $settings_tab as $key => $value ) {
						?>
					<div id="<?php echo esc_attr( $key ); ?>" class="tab-content"
										<?php
										if ( $counter == 0 ) {
											?>
						 style="display: block;" <?php } ?>>
						<?php
							include_once RRDI_PATH . '/includes/settings/' . strtolower( $value );
						?>
					</div>
					<?php $counter++; } ?>
				</div>
			</div>
		</div>
			<?php
		}
	}

	private function prepare_demos_for_js( $demos = null ) {
		$prepared_demos   = array();
		$current_template = get_option( 'template' );
		$demo_imported_id = get_option( 'rara_demo_imported_id' );

		/**
		 * Filters demo data before it is prepared for JavaScript.
		 *
		 * @param array      $prepared_demos   An associative array of demo data. Default empty array.
		 * @param null|array $demos            An array of demo config to prepare, if any.
		 * @param string     $demo_imported_id The current demo imported id.
		 */
		$prepared_demos = (array) apply_filters( 'rara_demo_importer_pre_prepare_demos_for_js', array(), $demos, $demo_imported_id );

		if ( ! empty( $prepared_demos ) ) {
			return $prepared_demos;
		}

		// Make sure the imported demo is listed first.
		if ( isset( $demos[ $demo_imported_id ] ) ) {
			$prepared_demos[ $demo_imported_id ] = array();
		}

		if ( ! empty( $demos ) ) {
			foreach ( $demos as $demo_id => $demo_data ) {
				$demo_notices = array();
				$encoded_slug = urlencode( $demo_id );
				$demo_package = isset( $demo_data['demo_pack'] ) ? $demo_data['demo_pack'] : false;
				$plugins_list = isset( $demo_data['plugins_list'] ) ? $demo_data['plugins_list'] : array();

				// Plugins status.
				foreach ( $plugins_list as $plugin => $plugin_data ) {
					$plugins_list[ $plugin ]['is_active'] = is_plugin_active( $plugin_data['slug'] );
				}

				// Add demo notices.
				if ( isset( $demo_data['template'] ) && $current_template !== $demo_data['template'] ) {
					$demo_notices['required_theme'] = true;
				} elseif ( wp_list_filter(
					$plugins_list,
					array(
						'required'  => true,
						'is_active' => false,
					)
				) ) {
					$demo_notices['required_plugins'] = true;
				}

				// Prepare all demos.
				$prepared_demos[ $demo_id ] = array(
					'id'           => $demo_id,
					'name'         => $demo_data['name'],
					'theme'        => $demo_data['theme'],
					'package'      => $demo_package,
					'screenshot'   => $this->import_file_url( $demo_id, 'screenshot.jpg' ),
					'description'  => isset( $demo_data['description'] ) ? $demo_data['description'] : '',
					'author'       => isset( $demo_data['author'] ) ? $demo_data['author'] : __( 'rara', 'rara-one-click-demo-import' ),
					'authorAndUri' => '<a href="http://rara.com" target="_blank">rara</a>',
					'version'      => isset( $demo_data['version'] ) ? $demo_data['version'] : '1.1.0',
					'active'       => $demo_id === $demo_imported_id,
					'hasNotice'    => $demo_notices,
					'plugins'      => $plugins_list,
					'actions'      => array(
						'preview'  => home_url( '/' ),
						'demo_url' => $demo_data['demo_url'],
						'delete'   => current_user_can( 'upload_files' ) ? wp_nonce_url( admin_url( 'themes.php?page=demo-importer&browse=uploads&action=delete&amp;demo_pack=' . urlencode( $demo_id ) ), 'delete-demo_' . $demo_id ) : null,
					),
				);
			}
		}

		/**
		 * Filters the demos prepared for JavaScript.
		 *
		 * Could be useful for changing the order, which is by name by default.
		 *
		 * @param array $prepared_demos Array of demos.
		 */
		$prepared_demos = apply_filters( 'rara_demo_importer_prepare_demos_for_js', $prepared_demos );
		$prepared_demos = array_values( $prepared_demos );
		return array_filter( $prepared_demos );
	}
	/**
	 * Enqueue admin scripts (JS and CSS)
	 *
	 * @param string $hook holds info on which admin page you are currently loading.
	 */
	public function admin_enqueue_scripts( $hook ) {

		// Enqueue the scripts only on the plugin page.
		if ( $this->plugin_page === $hook ) {
			wp_enqueue_script( 'rrdi-main-js', RRDI_URL . 'assets/js/script.js', array( 'jquery', 'jquery-form' ), RRDI_VERSION );

			wp_localize_script(
				'rrdi-main-js',
				'rrdi',
				array(
					'ajax_url'     => admin_url( 'admin-ajax.php' ),
					'ajax_nonce'   => wp_create_nonce( 'rrdi-ajax-verification' ),
					'import_files' => $this->import_files,
					'texts'        => array(
						'missing_preview_image' => esc_html__( 'No preview image defined for this import.', 'rara-one-click-demo-import' ),
					),
				)
			);
			wp_enqueue_style( 'rrdi-main-css', RRDI_URL . 'assets/css/style.css', array(), RRDI_VERSION );
		}
	}


	/**
	 * Main AJAX callback function for:
	 * 1. prepare import files (uploaded or predefined via filters)
	 * 2. import content
	 * 3. before widgets import setup (optional)
	 * 4. import widgets (optional)
	 * 5. import customizer options (optional)
	 * 6. after import setup (optional)
	 */
	public function rrdi_import_demo_data_ajax_callback() {

		// Try to update PHP memory limit (so that it does not run out of it).
		ini_set( 'memory_limit', apply_filters( 'rrdi/import_memory_limit', '350M' ) );

		// Verify if the AJAX call is valid (checks nonce and current_user_can).
		RRDI_Helpers::verify_ajax_call();

		// Is this a new AJAX call to continue the previous import?
		$use_existing_importer_data = $this->get_importer_data();

		if ( ! $use_existing_importer_data ) {

			// Set the AJAX call number.
			$this->ajax_call_number = empty( $this->ajax_call_number ) ? 0 : $this->ajax_call_number;

			// Error messages displayed on front page.
			$this->frontend_error_messages = '';

			// Create a date and time string to use for demo and log file names.
			$demo_import_start_time = date( apply_filters( 'rrdi/date_format_for_file_names', 'Y-m-d__H-i-s' ) );

			// Define log file path.
			$this->log_file_path = RRDI_Helpers::get_log_path( $demo_import_start_time );

			// Get selected file index or set it to 0.
			$this->selected_index = empty( $_POST['selected'] ) ? 0 : absint( $_POST['selected'] );

			/**
			 * 1. Prepare import files.
			 * Manually uploaded import files or predefined import files via filter: rrdi/import_files
			 */
			if ( ! empty( $_FILES ) ) { // Using manual file uploads?

				// Get paths for the uploaded files.
				$this->selected_import_files = RRDI_Helpers::process_uploaded_files( $_FILES, $this->log_file_path );

				// Set the name of the import files, because we used the uploaded files.
				$this->import_files[ $this->selected_index ]['import_file_name'] = esc_html__( 'Manually uploaded files', 'rara-one-click-demo-import' );
			} elseif ( ! empty( $this->import_files[ $this->selected_index ] ) ) { // Use predefined import files from wp filter: rrdi/import_files.

				// Download the import files (content and widgets files) and save it to variable for later use.
				$this->selected_import_files = RRDI_Helpers::download_import_files(
					$this->import_files[ $this->selected_index ],
					$demo_import_start_time
				);

				// Check Errors.
				if ( is_wp_error( $this->selected_import_files ) ) {

					// Write error to log file and send an AJAX response with the error.
					RRDI_Helpers::log_error_and_send_ajax_response(
						$this->selected_import_files->get_error_message(),
						$this->log_file_path,
						esc_html__( 'Downloaded files', 'rara-one-click-demo-import' )
					);
				}

				// Add this message to log file.
				$log_added = RRDI_Helpers::append_to_file(
					sprintf(
						__( 'The import files for: %s were successfully downloaded!', 'rara-one-click-demo-import' ),
						$this->import_files[ $this->selected_index ]['import_file_name']
					) . RRDI_Helpers::import_file_info( $this->selected_import_files ),
					$this->log_file_path,
					esc_html__( 'Downloaded files', 'rara-one-click-demo-import' )
				);
			} else {

				// Send JSON Error response to the AJAX call.
				wp_send_json( esc_html__( 'No import files specified!', 'rara-one-click-demo-import' ) );
			}
		}

		/**
		 * 2. Import content.
		 * Returns any errors greater then the "error" logger level, that will be displayed on front page.
		 */
		$this->frontend_error_messages .= $this->import_content( $this->selected_import_files['content'] );

		/**
		 * 3. Before widgets import setup.
		 */
		$action = 'rrdi/before_widgets_import';
		if ( ( false !== has_action( $action ) ) && empty( $this->frontend_error_messages ) ) {

			// Run the before_widgets_import action to setup other settings.
			$this->do_import_action( $action, $this->import_files[ $this->selected_index ] );
		}

		/**
		 * 4. Import widgets.
		 */
		if ( ! empty( $this->selected_import_files['widgets'] ) && empty( $this->frontend_error_messages ) ) {
			$this->import_widgets( $this->selected_import_files['widgets'] );
		}

		/**
		 * 5. Import customize options.
		 */
		if ( ! empty( $this->selected_import_files['customizer'] ) && empty( $this->frontend_error_messages ) ) {
			$this->import_customizer( $this->selected_import_files['customizer'] );
		}

		/**
		 * 6. After import setup.
		 */
		$action = 'rrdi/after_import';
		if ( ( false !== has_action( $action ) ) && empty( $this->frontend_error_messages ) ) {

			// Run the after_import action to setup other settings.
			$this->do_import_action( $action, $this->import_files[ $this->selected_index ] );
		}

		// Display final messages (success or error messages).
		if ( empty( $this->frontend_error_messages ) ) {
			$response['message'] = sprintf(
				__( '%1$s%3$sCompleted Successfully!%4$s%2$sThe process has finished. Please check your page and make sure that everything has been imported correctly. If you want, you can now deactivate the %3$sRara One Click Demo Import%4$s plugin.%5$s', 'rara-one-click-demo-import' ),
				'<div class="notice  notice-success"><p>',
				'<br>',
				'<strong>',
				'</strong>',
				'</p></div>'
			);
		} else {
			$response['message']  = $this->frontend_error_messages . '<br>';
			$response['message'] .= sprintf(
				__( '%1$sUnfortunately, demo import has finished with some errors.%2$sMore details about the errors can be found in this %3$s%5$slog file%6$s%4$s%7$s', 'rara-one-click-demo-import' ),
				'<div class="notice  notice-error"><p>',
				'<br>',
				'<strong>',
				'</strong>',
				'<a href="' . RRDI_Helpers::get_log_url( $this->log_file_path ) . '" target="_blank">',
				'</a>',
				'</p></div>'
			);
		}

		wp_send_json( $response );
	}


	/**
	 * Import content from an WP XML file.
	 *
	 * @param string $import_file_path path to the import file.
	 */
	private function import_content( $import_file_path ) {

		$this->microtime = microtime( true );

		// This should be replaced with multiple AJAX calls (import in smaller chunks)
		// so that it would not come to the Internal Error, because of the PHP script timeout.
		// Also this function has no effect when PHP is running in safe mode
		// http://php.net/manual/en/function.set-time-limit.php.
		// Increase PHP max execution time. Just in case, even though the AJAX calls are only 25 sec long.
		if ( strpos( ini_get( 'disable_functions' ), 'set_time_limit' ) === false ) {
			set_time_limit( apply_filters( 'rrdi/set_time_limit_for_demo_data_import', 300 ) );
		}

		// Disable import of authors.
		add_filter( 'wxr_importer.pre_process.user', '__return_false' );

		// Check, if we need to send another AJAX request and set the importing author to the current user.
		add_filter( 'wxr_importer.pre_process.post', array( $this, 'new_ajax_request_maybe' ) );

		// Disables generation of multiple image sizes (thumbnails) in the content import step.
		if ( ! apply_filters( 'rrdi/regenerate_thumbnails_in_content_import', true ) ) {
			add_filter(
				'intermediate_image_sizes_advanced',
				function() {
					return null;
				}
			);
		}

		// Import content.
		if ( ! empty( $import_file_path ) ) {
			ob_start();
				$this->importer->import( $import_file_path );
			$message = ob_get_clean();

			// Add this message to log file.
			$log_added = RRDI_Helpers::append_to_file(
				$message . PHP_EOL . esc_html__( 'Max execution time after content import = ', 'rara-one-click-demo-import' ) . ini_get( 'max_execution_time' ),
				$this->log_file_path,
				esc_html__( 'Importing content', 'rara-one-click-demo-import' )
			);
		}

		// Delete content importer data for current import from DB.
		delete_transient( 'RRDI_importer_data' );

		// Return any error messages for the front page output (errors, critical, alert and emergency level messages only).
		return $this->logger->error_output;
	}


	/**
	 * Import widgets from WIE or JSON file.
	 *
	 * @param string $widget_import_file_path path to the widget import file.
	 */
	private function import_widgets( $widget_import_file_path ) {

		// Widget import results.
		$results = array();

		// Create an instance of the Widget Importer.
		$widget_importer = new RRDI_Widget_Importer();

		// Import widgets.
		if ( ! empty( $widget_import_file_path ) ) {

			// Import widgets and return result.
			$results = $widget_importer->import_widgets( $widget_import_file_path );
		}

		// Check for errors.
		if ( is_wp_error( $results ) ) {

			// Write error to log file and send an AJAX response with the error.
			RRDI_Helpers::log_error_and_send_ajax_response(
				$results->get_error_message(),
				$this->log_file_path,
				esc_html__( 'Importing widgets', 'rara-one-click-demo-import' )
			);
		}

		ob_start();
			$widget_importer->format_results_for_log( $results );
		$message = ob_get_clean();

		// Add this message to log file.
		$log_added = RRDI_Helpers::append_to_file(
			$message,
			$this->log_file_path,
			esc_html__( 'Importing widgets', 'rara-one-click-demo-import' )
		);
	}


	/**
	 * Import customizer from a DAT file, generated by the Customizer Export/Import plugin.
	 *
	 * @param string $customizer_import_file_path path to the customizer import file.
	 */
	private function import_customizer( $customizer_import_file_path ) {

		// Try to import the customizer settings.
		$results = RRDI_Customizer_Importer::import_customizer_options( $customizer_import_file_path );

		// Check for errors.
		if ( is_wp_error( $results ) ) {

			// Write error to log file and send an AJAX response with the error.
			RRDI_Helpers::log_error_and_send_ajax_response(
				$results->get_error_message(),
				$this->log_file_path,
				esc_html__( 'Importing customizer settings', 'rara-one-click-demo-import' )
			);
		}

		// Add this message to log file.
		$log_added = RRDI_Helpers::append_to_file(
			esc_html__( 'Customizer settings import finished!', 'rara-one-click-demo-import' ),
			$this->log_file_path,
			esc_html__( 'Importing customizer settings', 'rara-one-click-demo-import' )
		);
	}


	/**
	 * Setup other things in the passed wp action.
	 *
	 * @param string $action the action name to be executed.
	 * @param array  $selected_import with information about the selected import.
	 */
	private function do_import_action( $action, $selected_import ) {

		ob_start();
			do_action( $action, $selected_import );
		$message = ob_get_clean();

		// Add this message to log file.
		$log_added = RRDI_Helpers::append_to_file(
			$message,
			$this->log_file_path,
			$action
		);
	}


	/**
	 * Check if we need to create a new AJAX request, so that server does not timeout.
	 *
	 * @param array $data current post data.
	 * @return array
	 */
	public function new_ajax_request_maybe( $data ) {
		$time = microtime( true ) - $this->microtime;

		// We should make a new ajax call, if the time is right.
		if ( $time > apply_filters( 'rrdi/time_for_one_ajax_call', 25 ) ) {
			$this->ajax_call_number++;
			$this->set_importer_data();

			$response = array(
				'status'  => 'newAJAX',
				'message' => 'New AJAX request!: ' . $time,
			);

			// Add any output to the log file and clear the buffers.
			$message = ob_get_clean();

			// Add message to log file.
			$log_added = RRDI_Helpers::append_to_file(
				__( 'Completed AJAX call number: ', 'rara-one-click-demo-import' ) . $this->ajax_call_number . PHP_EOL . $message,
				$this->log_file_path,
				''
			);

			wp_send_json( $response );
		}

		// Set importing author to the current user.
		// Fixes the [WARNING] Could not find the author for ... log warning messages.
		$current_user_obj    = wp_get_current_user();
		$data['post_author'] = $current_user_obj->user_login;

		return $data;
	}

	/**
	 * Set current state of the content importer, so we can continue the import with new AJAX request.
	 */
	private function set_importer_data() {
		$data = array(
			'frontend_error_messages' => $this->frontend_error_messages,
			'ajax_call_number'        => $this->ajax_call_number,
			'log_file_path'           => $this->log_file_path,
			'selected_index'          => $this->selected_index,
			'selected_import_files'   => $this->selected_import_files,
		);

		$data = array_merge( $data, $this->importer->get_importer_data() );

		set_transient( 'RRDI_importer_data', $data, 0.5 * HOUR_IN_SECONDS );
	}

	/**
	 * Get content importer data, so we can continue the import with this new AJAX request.
	 */
	private function get_importer_data() {
		if ( $data = get_transient( 'RRDI_importer_data' ) ) {
			$this->frontend_error_messages = empty( $data['frontend_error_messages'] ) ? '' : $data['frontend_error_messages'];
			$this->ajax_call_number        = empty( $data['ajax_call_number'] ) ? 1 : $data['ajax_call_number'];
			$this->log_file_path           = empty( $data['log_file_path'] ) ? '' : $data['log_file_path'];
			$this->selected_index          = empty( $data['selected_index'] ) ? 0 : $data['selected_index'];
			$this->selected_import_files   = empty( $data['selected_import_files'] ) ? array() : $data['selected_import_files'];
			$this->importer->set_importer_data( $data );

			return true;
		}
		return false;
	}

	/**
	 * Load the plugin textdomain, so that translations can be made.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'rara-one-click-demo-import', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}


	/**
	 * Get data from filters, after the theme has loaded and instantiate the importer.
	 */
	public function setup_plugin_with_filter_data() {

		// Get info of import data files and filter it.
		$this->import_files = RRDI_Helpers::validate_import_file_info( apply_filters( 'rrdi/import_files', array() ) );

		// Importer options array.
		$importer_options = apply_filters(
			'rrdi/importer_options',
			array(
				'fetch_attachments' => true,
			)
		);

		// Logger options for the logger used in the importer.
		$logger_options = apply_filters(
			'rrdi/logger_options',
			array(
				'logger_min_level' => 'warning',
			)
		);

		// Configure logger instance and set it to the importer.
		$this->logger            = new RRDI_Logger();
		$this->logger->min_level = $logger_options['logger_min_level'];

		// Create importer instance with proper parameters.
		$this->importer = new RRDI_Importer( $importer_options, $this->logger );
	}
}
