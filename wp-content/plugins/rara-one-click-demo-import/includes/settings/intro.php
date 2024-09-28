<?php
echo '<div class="rddi-import-intro">';
echo '<p>Demo Import works very well under normal circumstances. However, sometimes issues are seen which can be due to different reasons, mostly due to hosting issues. If you are using shared hosting plan, then there is high chance that demo import might not work on your server because your server might have some limitation.</p>';

echo '<p>For the demo import to work properly, the <b>PHP configuration</b> on your server should be:</p>';
echo '<ul>
<li>Maximum Execution Time <span>360</span></li>
<li>Memory Limit <span>256M</span></li>
<li>Post Max Size <span>32M</span></li>
<li>Upload Max Filesize <span>32M</span></li>
</ul>';

$link = '<a href="https://rarathemes.com/blog/best-wordpress-hosting/" target="_blank">10 best WordPress Hosting</a>';

echo '<p>' . sprintf( __( 'Please request your hosting to give you the above configuration and then try the demo import again. If you are constantly having an issue with the hosting, you may want to consider to move to better WordPress hosting. We have reviewed %1$s. If the issue is not fixed after the above configuration, please let us know for the further assistance.', 'rara-one-click-demo-import' ), esc_url( $link ) ) . '</p>';

$snapshot = '<a href="https://wordpress.org/plugins/wp-serverinfo/" target="_blank">WP Server Info</a>';
?>
<p><h4><?php echo sprintf( __( 'You can check the PHP configuartion of your site by using any plugins like %1$s.', 'rara-one-click-demo-import' ), esc_url( $snapshot ) ); ?></h4></p>
<?php
$wpreset = '<a href="https://wordpress.org/plugins/wp-reset" target="_blank">WP Reset</a>';
?>
<p><h4><?php echo sprintf( __( 'Note: We highly recommend to import the demo content on a fresh WordPress installation. You can reset your website to a fresh WordPress installation using a reset plugin like %1$s.', 'rara-one-click-demo-import' ), esc_url( $wpreset ) ); ?></h4></p>
</div>
