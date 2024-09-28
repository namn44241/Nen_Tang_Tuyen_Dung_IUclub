<?php
/**
 * Active Callback
 * 
 * @package jobscout
*/

/**
 * Active Callback for Blog View All Button
*/
function jobscout_blog_view_all_ac(){
    $blog = get_option( 'page_for_posts' );
    if( $blog ) return true;
    
    return false; 
}

/**
 * Active Callback for post/page
*/
function jobscout_post_page_ac( $control ){
    
    $ed_author = $control->manager->get_setting( 'ed_author' )->value();
    $control_id = $control->id;
    
    if ( $control_id == 'author_title' && $ed_author == false ) return true;
    if ( $control_id == 'ed_featured_image' ) return true;
    
    return false;
}