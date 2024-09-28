<?php
/**
 * JobScout Theme Customizer
 *
 * @package jobscout
 */

/**
 * Requiring customizer panels & sections
*/
$jobscout_panels       = array( 'appearance', 'layout', 'home', 'general');
$jobscout_sections     = array( 'info','site', 'footer', 'breadcrumbs' );
$jobscout_sub_sections = array(
    'layout'     => array( 'general' ),
    'home'       => array( 'banner', 'jobposting', 'cta', 'blog', 'testimonial', 'client' ),
    'general'    => array(  'header', 'seo', 'post-page' ),    
);

foreach( $jobscout_sections as $y ){
    require get_template_directory() . '/inc/customizer/sections/' . $y . '.php';
}

foreach( $jobscout_panels as $p ){
   require get_template_directory() . '/inc/customizer/panels/' . $p . '.php';
}

foreach( $jobscout_sub_sections as $k => $v ){
    foreach( $v as $w ){        
        require get_template_directory() . '/inc/customizer/panels/' . $k . '/' . $w . '.php';
    }
}

/**
 * Sanitization Functions
*/
require get_template_directory() . '/inc/customizer/sanitization-functions.php';

/**
 * Active Callbacks
*/
require get_template_directory() . '/inc/customizer/active-callback.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function jobscout_customize_preview_js() {
	wp_enqueue_script( 'jobscout-pro-customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), JOBSCOUT_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'jobscout_customize_preview_js' );

function jobscout_customize_script(){
    $array = array(
        'home'    => get_home_url(),
        'ajax_url'   => admin_url( 'admin-ajax.php' ),
        'flushit'    => __( 'Successfully Flushed!','jobscout' ),
        'nonce'      => wp_create_nonce('ajax-nonce'),
    );
    wp_enqueue_style( 'jobscout-pro-customize', get_template_directory_uri() . '/inc/css/customize.css', array(), JOBSCOUT_THEME_VERSION );
    wp_enqueue_script( 'jobscout-pro-customize', get_template_directory_uri() . '/inc/js/customize.js', array( 'jquery', 'customize-controls' ), JOBSCOUT_THEME_VERSION, true );
    wp_localize_script( 'jobscout-pro-customize', 'jobscout_cdata', $array );
}
add_action( 'customize_controls_enqueue_scripts', 'jobscout_customize_script' );

/*
 * Notifications in customizer
 */
require get_template_directory() . '/inc/customizer-plugin-recommend/customizer-notice/class-customizer-notice.php';

require get_template_directory() . '/inc/customizer-plugin-recommend/plugin-install/class-plugin-install-helper.php';

require get_template_directory() . '/inc/customizer-plugin-recommend/plugin-install/class-plugin-recommend.php';

$config_customizer = array(
    'recommended_plugins' => array(
        //change the slug for respective plugin recomendation
        'raratheme-companion' => array(
            'recommended' => true,
            'description' => sprintf(
                /* translators: %s: plugin name */
                esc_html__( 'If you want to take full advantage of the features this theme has to offer, please install and activate %s plugin.', 'jobscout' ), '<strong>RaraTheme Companion</strong>'
            ),
        ),
    ),
    'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'jobscout' ),
    'install_button_label'      => esc_html__( 'Install and Activate', 'jobscout' ),
    'activate_button_label'     => esc_html__( 'Activate', 'jobscout' ),
    'deactivate_button_label'   => esc_html__( 'Deactivate', 'jobscout' ),
);
jobscout_Customizer_Notice::init( apply_filters( 'jobscout_customizer_notice_array', $config_customizer ) );