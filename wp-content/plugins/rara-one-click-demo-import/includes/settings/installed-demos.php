<div class="RRDI__intro-notice notice notice-warning is-dismissible">
	<p><?php
	echo apply_filters( 'rrdi_before_import_msg', esc_html__( 'Before you begin, make sure all the required plugins are activated.', 'rara-one-click-demo-import' ) ); ?>
	</p>
</div>
<div class="rrdi wrap about-wrap">
	<?php

	// Display warrning if PHP safe mode is enabled, since we wont be able to change the max_execution_time.
	if ( ini_get( 'safe_mode' ) ) {
		printf(
			esc_html__( '%1$sWarning: your server is using %2$sPHP safe mode%3$s. This means that you might experience server timeout errors.%4$s', 'rara-one-click-demo-import' ),
			'<div class="notice notice-warning is-dismissible"><p>',
			'<strong>',
			'</strong>',
			'</p></div>'
		);
	}

	// Start output buffer for displaying the plugin intro text.
	ob_start();
	?>

	<div class="RRDI__intro-text">

		<p class="about-description">
			<?php
			$link      = '<a href="https://rarathemes.com/">Rara Theme</a>';
			$doc       = '<a href="https://rarathemes.com/documentation/" target="_blank">documentation</a>';
			$bold      = '<b>';
			$boldclose = '</b>';
			$wpreset   = '<a href="https://wordpress.org/plugins/wp-reset" target="_blank">WP Reset</a>';

			$msg = sprintf( __( 'If you are using premium themes by %1$s, just click Import Now button below. Alternatively, you can download zip files from the %2$s page of your theme and upload it as mentioned in Demo Import tab. As simple as that.', 'rara-one-click-demo-import' ), $link, $doc );
			echo wp_kses(
				apply_filters( 'rrdi_import_instruction', $msg ),
				array(
					'a' => array(
						'href'   => array(),
						'target' => array(),
					),
					'b' => array(),
				)
			);
			?>
		</p>

		<h3><?php esc_html_e( 'The following data will be imported:', 'rara-one-click-demo-import' ); ?></h3>

		<ul>
			<li><?php esc_html_e( 'Posts', 'rara-one-click-demo-import' ); ?></li>
			<li><?php esc_html_e( 'Pages', 'rara-one-click-demo-import' ); ?></li>
			<li><?php esc_html_e( 'Images', 'rara-one-click-demo-import' ); ?></li>
			<li><?php esc_html_e( 'Widgets', 'rara-one-click-demo-import' ); ?></li>
			<li><?php esc_html_e( 'Menus', 'rara-one-click-demo-import' ); ?></li>
			<li><?php esc_html_e( 'Settings', 'rara-one-click-demo-import' ); ?></li>
		</ul>
		<?php
		$wpreset = '<a href="https://wordpress.org/plugins/wp-reset" target="_blank">WP Reset</a>';
		?>
		<p><h4>
		<?php
		$msg = sprintf( __( 'Note: To import demo content for the free themes, please follow the step-by-step instructions mentioned in the %1$s Demo Import %2$s tab.', 'rara-one-click-demo-import' ), $bold, $boldclose );
		echo wp_kses( apply_filters( 'rrdi_fresh_install_instruction', $msg ), array( 'b' => array() ) );
		?>
		</h4></p>
		<p><h4>
		<?php
		echo wp_kses(
			sprintf(
				__( 'Note: We highly recommend to import the demo content on a fresh WordPress installation. You can reset your website to a fresh WordPress installation using a reset plugin like %1$s.', 'rara-one-click-demo-import' ),
				$wpreset
			),
			array(
				'a' => array(
					'href'   => array(),
					'target' => array(),
				),
			)
		);
		?>
		</h4></p>
		<hr>

	</div>

	<?php
	$plugin_intro_text = ob_get_clean();

	// Display the plugin intro text (can be replaced with custom text through the filter below).
	echo wp_kses_post( apply_filters( 'rrdi/plugin_intro_text', $plugin_intro_text ) );

	$my_theme = wp_get_theme();
	$td       = $my_theme->get( 'TextDomain' );

	if ( strpos( $td, 'pro' ) === false && ! empty( $this->import_files ) ) {
		?>

	<div class="RRDI__file-upload-container">
		<?php
		$bold      = '<b>';
		$boldclose = '</b>';
		?>
		<br><h4 style="color:red">
		<?php
		echo wp_kses(
			sprintf( __( 'Note: For free themes, always upload the appropriate demo zip file from %1$s Demo Import %2$s tab and import demo data as mentioned there.', 'rara-one-click-demo-import' ), $bold, $boldclose ),
			array(
				'a' => array(
					'href'   => array(),
					'target' => array(),
				),
				'b' => array(),
			)
		);
		?>
		</h4>
	</div>
		<?php
	}

	// Check the folder contains at least 1 valid demo config.
	$upload_dir  = wp_upload_dir();
	$path        = $upload_dir['basedir'] . '/rara-demo-pack/';
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

	$my_theme = wp_get_theme();
	$td       = $my_theme->get( 'TextDomain' );

	$sr = explode( '/', $ret_val );
	$sr = end( $sr );

	if ( empty( $this->import_files ) ) :
		?>

	<?php elseif ( 1 < count( $this->import_files ) ) : ?>

		<div class="RRDI__multi-select-import">

			<h2><?php esc_html_e( 'Choose which demo you want to import:', 'rara-one-click-demo-import' ); ?></h2>

			<select id="RRDI__demo-import-files" class="RRDI__demo-import-files">
				<?php foreach ( $this->import_files as $index => $import_file ) : ?>
					<option value="<?php echo esc_attr( $index ); ?>">
						<?php echo esc_html( $import_file['import_file_name'] ); ?>
					</option>
				<?php endforeach; ?>
			</select>

			<?php
			// Check if at least one preview image is defined, so we can prepare the structure for display.
			$preview_image_is_defined = false;
			foreach ( $this->import_files as $import_file ) {
				if ( isset( $import_file['import_preview_image_url'] ) ) {
					$preview_image_is_defined = true;
					break;
				}
			}

			if ( $preview_image_is_defined ) :
				?>

			<div class="RRDI__demo-import-preview-container">

				<p><?php esc_html_e( 'Import preview:', 'rara-one-click-demo-import' ); ?></p>

				<p class="RRDI__demo-import-preview-image-message  js-rrdi-preview-image-message">
				<?php
				if ( ! isset( $this->import_files[0]['import_preview_image_url'] ) ) {
					esc_html_e( 'No preview image defined for this import.', 'rara-one-click-demo-import' );
				}
					// Leave the img tag below and the p tag above available for later changes via JS.
				?>
				</p>

				<img id="RRDI__demo-import-preview-image" class="js-rrdi-preview-image" src="<?php echo ! empty( $this->import_files[0]['import_preview_image_url'] ) ? esc_url( $this->import_files[0]['import_preview_image_url'] ) : ''; ?>">

			</div>

			<?php endif; ?>

		</div>

		<?php
	endif;

	$upload_dir = wp_upload_dir();

	$directory = $upload_dir['basedir'] . '/rara-demo-pack/';

	// get all files in specified directory
	$files = glob( $directory . '*', GLOB_ONLYDIR );

	// print each file name
	foreach ( $files as $file ) {
		// check to see if the file is a folder/directory
		if ( is_dir( $file ) ) {
			$arr[] = basename( $file );
		}
	}

	$my_theme = wp_get_theme();

	if ( is_array( $this->import_files ) && ! empty( $this->import_files[0]['import_notice'] ) ) {
		?>
		<div class="RRDI__demo-import-notice  js-rrdi-demo-import-notice">
			<?php echo wp_kses_post( $this->import_files[0]['import_notice'] ); ?>
		</div>
		<?php
	}
	?>

	<p class="RRDI__button-container">
		<button class="RRDI__button  button  button-hero  button-primary  js-rrdi-import-data"><?php esc_html_e( 'Import Now', 'rara-one-click-demo-import' ); ?></button>
		<span><?php esc_html_e( 'Click the button to begin the importing process. Please be patient, the process might take a few minutes.', 'rara-one-click-demo-import' ); ?></span>
	</p>

	<p class="RRDI__ajax-loader  js-rrdi-ajax-loader">
		<span class="spinner"></span> <?php esc_html_e( 'Importing now, please wait!', 'rara-one-click-demo-import' ); ?>
	</p>

	<div class="RRDI__response  js-rrdi-ajax-response"></div>
</div>
