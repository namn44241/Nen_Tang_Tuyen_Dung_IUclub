<?php
/**
 * JobScout Customizer Partials
 *
 * @package JobScout
 */

/**
 * Render the site title for the selective refresh partial.
 *
 */
function jobscout_customize_partial_blogname() {
	$blog_name = get_bloginfo( 'name' );

    if ( $blog_name ){
        return esc_html( $blog_name );
    } else {
        return false;
    }
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 */
function jobscout_customize_partial_blogdescription() {
	$blog_description = get_bloginfo( 'description' );

    if ( $blog_description ){
        return esc_html( $blog_description );
    } else {
        return false;
    }
}

/*
 * Header post job button
 */
function jobscout_get_header_post_job_label(){
    $btn_label = get_theme_mod( 'post_job_label', __( 'Post Jobs', 'jobscout' ) );

    if ( $btn_label ){
        return esc_html( $btn_label );
    } else {
        return false;
    }
}

/**
 * Banner Section Title
*/
function jobscout_get_banner_title(){
    $banner_title = get_theme_mod( 'banner_title', __( 'Aim Higher, Dream Bigger', 'jobscout' ) );

    if ( $banner_title ){
        return esc_html( $banner_title );
    } else {
        return false;
    }
}

/**
 * Banner Section Sub Title
*/
function jobscout_get_banner_sub_title(){
    $banner_subtitle = get_theme_mod( 'banner_subtitle', __( 'Each month, more than 7 million JobScout turn to website in their search for work, making over 160,000 applications every day.', 'jobscout' ) );

    if ( $banner_subtitle ){
        return wpautop( wp_kses_post( $banner_subtitle ) );
    } else {
        return false;
    }
}

/**
 * Popular Section Title
*/
function jobscout_get_popular_section_title(){
    $popular_section_title = get_theme_mod( 'popular_section_title', __( 'Popular Categories', 'jobscout' ) );

    if ( $popular_section_title ){
        return esc_html( $popular_section_title );
    } else {
        return false;
    }
}

/**
 * Job Posting Section Title
*/
function jobscout_get_job_posting_section_title(){
    $job_posting_section_title = get_theme_mod( 'job_posting_section_title', __( 'Job Posting', 'jobscout' ) );

    if ( $job_posting_section_title ){
        return esc_html( $job_posting_section_title );
    } else {
        return false;
    }
}

/**
 * Blog Section Title
*/
function jobscout_get_blog_section_title(){
    $blog_section_title = get_theme_mod( 'blog_section_title', __( 'Latest Articles', 'jobscout' ) );

    if ( $blog_section_title ){
        return esc_html( $blog_section_title );
    } else {
        return false;
    }
}

/**
 * Blog Section Description
*/
function jobscout_get_blog_section_description(){
    $blog_section_subtitle = get_theme_mod( 'blog_section_subtitle', __( 'We will help you find it. We are your first step to becoming everything you want to be.', 'jobscout' ) );

    if ( $blog_section_subtitle ){
        return wpautop( wp_kses_post( $blog_section_subtitle ) );
    } else {
        return false;
    }
}

/**
 * Blog View All Button
*/
function jobscout_get_blog_view_all_btn(){
    $view_all_btn = get_theme_mod( 'blog_view_all', __( 'Browse All', 'jobscout' ) );
    if ( $view_all_btn ){
        return esc_html( $view_all_btn );
    } else {
        return false;
    }
}


/**
 * Testimonial Section Title
*/
function jobscout_get_testimonial_section_title(){
    $testimonial_section_title = get_theme_mod( 'testimonial_section_title', __( 'Clients Testimonials', 'jobscout' ) );

    if ( $testimonial_section_title ){
        return esc_html( $testimonial_section_title );
    } else {
        return false;
    }
}

/**
 * Testimonial Section Description
*/
function jobscout_get_testimonial_section_description(){
    $testimonial_section_subtitle = get_theme_mod( 'testimonial_section_subtitle', __( 'We will help you find it. We are your first step to becoming everything you want to be.', 'jobscout' ) );

    if ( $testimonial_section_subtitle ){
        return wpautop( wp_kses_post( $testimonial_section_subtitle ) );
    } else {
        return false;
    }
}

/**
 * Display blog readmore button
*/
function jobscout_get_read_more(){
    $read_more_text = get_theme_mod( 'read_more_text', __( 'Read More', 'jobscout' ) ); 

    if( $read_more_text ){
        return esc_html( $read_more_text );
    } else {
        return false;
    }
}

/**
 * Display blog readmore button
*/
function jobscout_get_author_title(){
    $author_title = get_theme_mod( 'author_title', __( 'About Author', 'jobscout' ) );

    if( $author_title ){
        return esc_html( $author_title );
    } else {
        return false;
    }
}

if( ! function_exists( 'jobscout_get_footer_copyright' ) ) :
/**
 * Footer Copyright
*/
function jobscout_get_footer_copyright(){
    $copyright = get_theme_mod( 'footer_copyright' );
    echo '<span class="copyright-text">';
    if( $copyright ){
        echo wp_kses_post( $copyright );
    }else{
        esc_html_e( '&copy; Copyright ', 'jobscout' );
        echo date_i18n( esc_html__( 'Y', 'jobscout' ) );
        echo ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>. ';
        esc_html_e( 'All Rights Reserved. ', 'jobscout' );
    }
    echo '</span>';
}
endif;

if( ! function_exists( 'jobscout_ed_author_link' ) ) :
/**
 * Show/Hide Author link in footer
*/
function jobscout_ed_author_link(){
    echo esc_html__( 'JobScout | Developed By ', 'jobscout' ) . '<a class="author-link" href="' . esc_url( 'https://rarathemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Rara Theme', 'jobscout' ) . '</a>.';
}
endif;

if( ! function_exists( 'jobscout_ed_wp_link' ) ) :
/**
 * Show/Hide WordPress link in footer
*/
function jobscout_ed_wp_link(){
     printf( esc_html__( ' Powered by %s', 'jobscout' ), '<a class="wp-link" href="'. esc_url( __( 'https://wordpress.org/', 'jobscout' ) ) .'" target="_blank">WordPress</a>.' );
}
endif;