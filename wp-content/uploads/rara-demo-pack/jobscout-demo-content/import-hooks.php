<?php
/**
 * JobScout Import Hooks.
 *
 * @package JobScout 
 */

/** Import content data*/
if ( ! function_exists( 'jobscout_import_files' ) ) :
function jobscout_import_files() {
  $upload_dir = wp_upload_dir();
    return array(
        array(
            'import_file_name'             => 'JobScout Demo',
            'local_import_file'            => $upload_dir['basedir'] . '/rara-demo-pack/jobscout-demo-content/content/jobscout.xml',
            'local_import_widget_file'     => $upload_dir['basedir'] . '/rara-demo-pack/jobscout-demo-content/content/jobscout.wie',
            'local_import_customizer_file' => $upload_dir['basedir'] . '/rara-demo-pack/jobscout-demo-content/content/jobscout.dat',
            'import_preview_image_url'     => get_template_directory() .'/screenshot.png',
            'import_notice'                => __( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'jobscout' ),
        ),
    );       
}
add_filter( 'rrdi/import_files', 'jobscout_import_files' );
endif;

/** Programmatically set the front page and menu */
if ( ! function_exists( 'jobscout_after_import' ) ) :
function jobscout_after_import( $selected_import ) {
 
    //Set Menu
    $primary   = get_term_by('name', 'Primary', 'nav_menu');
    $secondary   = get_term_by('name', 'Secondary', 'nav_menu');
    set_theme_mod( 'nav_menu_locations' , array( 
        'primary'   => $primary->term_id,
        'secondary' => $secondary->term_id 
       ) 
    );
   
    /** Set Front page */
    $page = get_page_by_path('home'); /** This need to be slug of the page that is assigned as Front page */
        if ( isset( $page->ID ) ) {
        update_option( 'page_on_front', $page->ID );
        update_option( 'show_on_front', 'page' );
    }
    
    /** Blog Page */
    $postpage = get_page_by_path('blog'); /** This need to be slug of the page that is assigned as Posts page */
    if( $postpage ){
        $post_pgid = $postpage->ID;
        update_option( 'page_for_posts', $post_pgid );
    }

    /** For Job Listing Taxonomy Images */
    $array = array(
        '12' => '28',
        '13' => '35',
        '14' => '36',   
        '15' => '27',
        '17' => '37',
        '18' => '29',        
        '20' => '26',
        '25' => '25',
    );
    foreach( $array as $k => $v ){
        add_term_meta( $k, 'category-image-id', $v );        
    }
    
}
add_action( 'rrdi/after_import', 'jobscout_after_import' );
endif;

function jobscout_import_msg(){
    return __( 'Before you begin, make sure all recommended plugins are activated.', 'jobscout' );
}
add_filter( 'rrdi_before_import_msg', 'jobscout_import_msg' );