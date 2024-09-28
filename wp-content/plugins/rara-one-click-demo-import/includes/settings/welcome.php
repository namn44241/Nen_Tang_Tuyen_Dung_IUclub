	<div class="upload-theme">
		<p class="install-help"><?php _e( 'If you have a demo pack in a .zip format, you may install it by uploading it here.', 'rara-one-click-demo-import' ); ?></p>
		<form method="post" enctype="multipart/form-data" class="wp-upload-form" action="<?php echo esc_url( self_admin_url( 'themes.php?page=rara-demo-import&action=upload-demo' ) ); ?>">
			<?php wp_nonce_field( 'demo-upload' ); ?>
			<label class="screen-reader-text" for="demozip"><?php _e( 'Demo zip file', 'rara-one-click-demo-import' ); ?></label>
			<input type="file" id="demozip" name="demozip" />
			<?php submit_button( __( 'Install Now', 'rara-one-click-demo-import' ), 'button', 'install-demo-submit', false ); ?>
		</form>
	</div>
	<ol>
		<h3><?php _e( 'A Step-by-Step Guide to Import the Demo Content', 'rara-one-click-demo-import' ); ?></h3>
		<li>
		<?php
		$wpreset = '<a href="https://wordpress.org/plugins/wp-reset" target="_blank">WP Reset</a>';
		$doc     = '<a href="https://rarathemes.com/documentation/" target="_blank">documentation</a>';
		$support = '<a href="https://rarathemes.com/support-ticket/" target="_blank">contact our support team</a>';
		echo wp_kses(
			sprintf( __( 'Download the demo file from your theme %1$s page. If you are unable to download the demo file, please %2$s.', 'rara-one-click-demo-import' ), $doc, $support ),
			array(
				'a' => array(
					'href'   => array(),
					'target' => array(),
				),
			)
		);
		?>
		</li>
		<li>
			<?php
			$link      = '<a href="https://rarathemes.com/" target="_blank">Rara Theme</a>';
			$demos     = '<a href="https://rarathemes.com/" target="_blank">Theme Demos</a>';
			$bold      = '<b>';
			$boldclose = '</b>';
			echo wp_kses( sprintf( __( 'Click on the %1$sUpload Demo File%2$s button above.', 'rara-one-click-demo-import' ), $bold, $boldclose ), array( 'b' => array() ) );
			?>
		</li>
		<li><?php echo wp_kses( sprintf( __( 'Click on %1$sChoose File%2$s button and upload the demo file downloaded in step 1. Then, click on the %3$sInstall Now%4$s button.', 'rara-one-click-demo-import' ), $bold, $boldclose, $bold, $boldclose ), array( 'b' => array() ) ); ?></li>
		<li><?php echo wp_kses( sprintf( __( 'Click on the %1$sImport Demo Now!%2$s button to begin demo installation. It will take few minutes to successfully import the demo.', 'rara-one-click-demo-import' ), $bold, $boldclose ), array( 'b' => array() ) ); ?></li>
		<h4>
		<?php
		echo wp_kses(
			sprintf( __( 'Note: We highly recommend to import the demo content on a fresh WordPress installation. You can reset your website to a fresh WordPress installation using a reset plugin like %1$s.', 'rara-one-click-demo-import' ), $wpreset ),
			array(
				'a' => array(
					'href'   => array(),
					'target' => array(),
				),
			)
		);
		?>
		</h4>
	</ol>
