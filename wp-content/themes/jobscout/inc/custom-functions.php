<?php
/**
 * JobScout Custom functions and definitions
 *
 * @package JobScout
 */

if ( ! function_exists( 'jobscout_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function jobscout_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on JobScout, use a find and replace
	 * to change 'jobscout' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'jobscout', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary', 'jobscout' ),
        'secondary' => esc_html__( 'Secondary', 'jobscout' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-list',
		'gallery',
		'caption',
	) );
    
    // Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'jobscout_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
    
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 
        'custom-logo', 
        array( 
            'height'      => 70, 
            'width'       => 70,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => array( 'site-title', 'site-description' ) 
        ) 
    );
    
    /**
     * Add support for custom header.
    */
    add_theme_support( 'custom-header', apply_filters( 'jobscout_custom_header_args', array(
		'default-image' => get_template_directory_uri().'/images/banner-image.jpg',
        'video'         => true,
		'width'         => 1920,
		'height'        => 704, 
		'header-text'   => false
	) ) );

    // Register default headers.
    register_default_headers( array(
        'default-banner' => array(
            'url'           => '%s/images/banner-image.jpg',
            'thumbnail_url' => '%s/images/banner-image.jpg',
            'description'   => esc_html_x( 'Default Banner', 'header image description', 'jobscout' ),
        ),
    ) );
 
    /**
     * Add Custom Images sizes.
    */    
    add_image_size( 'jobscout-schema', 600, 60 ); 
    add_image_size( 'jobscout-blog', 600, 450, true );
    add_image_size( 'jobscout-single', 838, 471, true );
    add_image_size( 'jobscout-single-fullwidth', 1170, 471, true );
    
    /** Starter Content */
    $starter_content = array(
        // Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array( 
            'home', 
            'blog'
        ),
		
        // Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),
        
        // Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'primary' => array(
				'name' => __( 'Primary', 'jobscout' ),
				'items' => array(
					'page_home',
					'page_blog'
				)
			)
		),
    );
    
    $starter_content = apply_filters( 'jobscout_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
    
    // Add theme support for Responsive Videos.
    add_theme_support( 'jetpack-responsive-videos' );

    // Add excerpt support for pages
    add_post_type_support( 'page', 'excerpt' );

    // Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for block editor styles.
	add_theme_support( 'wp-block-styles' );

}
endif;
add_action( 'after_setup_theme', 'jobscout_setup' );

if( ! function_exists( 'jobscout_content_width' ) ) :
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function jobscout_content_width() {
	/** 
     * Content width.
    */
    $GLOBALS['content_width'] = apply_filters( 'jobscout_content_width', 840 );
}
endif;
add_action( 'after_setup_theme', 'jobscout_content_width', 0 );

if( ! function_exists( 'jobscout_template_redirect_content_width' ) ) :
/**
* Adjust content_width value according to template.
*
* @return void
*/
function jobscout_template_redirect_content_width(){
	$sidebar = jobscout_sidebar_layout( true );
    if( $sidebar ){	   
        $GLOBALS['content_width'] = 840;     
	}else{
        $GLOBALS['content_width'] = 1170;
	}
}
endif;
add_action( 'template_redirect', 'jobscout_template_redirect_content_width' );

if( ! function_exists( 'jobscout_scripts' ) ) :
/**
 * Enqueue scripts and styles.
 */
function jobscout_scripts() {
	// Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    
    if( jobscout_is_woocommerce_activated() )
    wp_enqueue_style( 'jobscout-woocommerce', get_template_directory_uri(). '/css' . $build . '/woocommerce' . $suffix . '.css', array(), JOBSCOUT_THEME_VERSION );
    
    if( get_theme_mod( 'ed_localgoogle_fonts',false ) && ! is_customize_preview() && ! is_admin() ){
        if ( get_theme_mod( 'ed_preload_local_fonts',false ) ) {
			jobscout_load_preload_local_fonts( jobscout_get_webfont_url( jobscout_fonts_url() ) );
        }
        wp_enqueue_style( 'jobscout-google-fonts', jobscout_get_webfont_url( jobscout_fonts_url() ) );
    }else{
    wp_enqueue_style( 'jobscout-google-fonts', jobscout_fonts_url(), array(), null );
    }

    wp_enqueue_style( 'owl-carousel', get_template_directory_uri(). '/css' . $build . '/owl.carousel' . $suffix . '.css', array(), '2.3.4' );
    wp_enqueue_style( 'jobscout', get_stylesheet_uri(), array(), JOBSCOUT_THEME_VERSION );
    
    wp_enqueue_script( 'all', get_template_directory_uri() . '/js' . $build . '/all' . $suffix . '.js', array( 'jquery' ), '5.6.3', true );
    wp_enqueue_script( 'v4-shims', get_template_directory_uri() . '/js' . $build . '/v4-shims' . $suffix . '.js', array( 'jquery', 'all' ), '5.6.3', true );
    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js' . $build . '/owl.carousel' . $suffix . '.js', array( 'jquery' ), '2.3.4', true );
    wp_enqueue_script( 'owlcarousel2-a11ylayer', get_template_directory_uri() . '/js' . $build . '/owlcarousel2-a11ylayer' . $suffix . '.js', array('owl-carousel'), '0.2.1', true );
    wp_enqueue_script( 'jobscout-modal-accessibility', get_template_directory_uri() . '/js' . $build . '/modal-accessibility' . $suffix . '.js', array( 'jquery' ), JOBSCOUT_THEME_VERSION, true );
	wp_enqueue_script( 'jobscout', get_template_directory_uri() . '/js' . $build . '/custom' . $suffix . '.js', array( 'jquery' ), JOBSCOUT_THEME_VERSION, true );
    
    $array = array( 
        'rtl'      => is_rtl(),
        'singular' => is_singular(),
    );
    
    wp_localize_script( 'jobscout', 'jobscout_data', $array );   
    
    if ( jobscout_is_jetpack_activated( true ) ) {
        wp_enqueue_style( 'tiled-gallery', plugins_url() . '/jetpack/modules/tiled-gallery/tiled-gallery/tiled-gallery.css' );            
    }
    
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'jobscout_scripts' );

if( ! function_exists( 'jobscout_admin_scripts' ) ) :
/**
 * Enqueue admin scripts and styles.
*/
function jobscout_admin_scripts( $hook ){    
    if( $hook == 'post-new.php' || $hook == 'post.php' || $hook == 'themes.php' ){
        wp_enqueue_style( 'jobscout-pro-admin', get_template_directory_uri() . '/inc/css/admin.css', '', JOBSCOUT_THEME_VERSION );
    }
}
endif; 
add_action( 'admin_enqueue_scripts', 'jobscout_admin_scripts' );

if( ! function_exists( 'jobscout_block_editor_styles' ) ) :
    /**
     * Enqueue editor styles for Gutenberg
     */
    function jobscout_block_editor_styles() {
    // Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    
    // Block styles.
    wp_enqueue_style( 'jobscout-block-editor-style', get_template_directory_uri() . '/css' . $build . '/editor-block' . $suffix . '.css' );

    // Add custom fonts.
    wp_enqueue_style( 'jobscout-google-fonts', jobscout_fonts_url(), array(), null );

}
endif;
add_action( 'enqueue_block_editor_assets', 'jobscout_block_editor_styles' );

if( ! function_exists( 'jobscout_body_classes' ) ) :
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function jobscout_body_classes( $classes ) {
    $banner_control      = get_theme_mod( 'ed_banner_section', 'static_banner' );
    $custom_header_image = get_header_image_tag(); // get custom header image tag
    
    // Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
    if( is_front_page() && ! is_home() && 'no_banner' != $banner_control && ( has_header_video() ||  ! empty( $custom_header_image ) ) ){
        $classes[] = 'banner-enabled';
    }
    
    if( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if( get_background_color() != 'ffffff' ) {
		$classes[] = 'custom-background-color';
	}
    
    $classes[] = jobscout_sidebar_layout( true );
    
    if( is_home() || is_archive() || is_search() ){
        $classes[] = 'list-view';
    }

    if( is_singular( 'job_listing' ) ){
        $classes[] = 'single-job';
    }
    
	return $classes;
}
endif;
add_filter( 'body_class', 'jobscout_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function jobscout_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'jobscout_pingback_header' );

if( ! function_exists( 'jobscout_change_comment_form_default_fields' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function jobscout_change_comment_form_default_fields( $fields ){    
    // get the current commenter if available
    $commenter = wp_get_current_commenter();
 
    // core functionality
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $required = ( $req ? " required" : '' );
    $author   = ( $req ? __( 'Name*', 'jobscout' ) : __( 'Name', 'jobscout' ) );
    $email    = ( $req ? __( 'Email*', 'jobscout' ) : __( 'Email', 'jobscout' ) );
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><label class="screen-reader-text" for="author">' . esc_html__( 'Name', 'jobscout' ) . '<span class="required">*</span></label><input id="author" name="author" placeholder="' . esc_attr( $author ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $required . ' /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><label class="screen-reader-text" for="email">' . esc_html__( 'Email', 'jobscout' ) . '<span class="required">*</span></label><input id="email" name="email" placeholder="' . esc_attr( $email ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . $required. ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><label class="screen-reader-text" for="url">' . esc_html__( 'Website', 'jobscout' ) . '</label><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'jobscout' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'; 
    
    return $fields;    
}
endif;
add_filter( 'comment_form_default_fields', 'jobscout_change_comment_form_default_fields' );

if( ! function_exists( 'jobscout_change_comment_form_defaults' ) ) :
/**
 * Change Comment Form defaults
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function jobscout_change_comment_form_defaults( $defaults ){    
    $defaults['comment_field'] = '<p class="comment-form-comment"><label class="screen-reader-text" for="comment">' . esc_html__( 'Comment', 'jobscout' ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'jobscout' ) . '" cols="45" rows="8" aria-required="true" required></textarea></p>';
    
    return $defaults;    
}
endif;
add_filter( 'comment_form_defaults', 'jobscout_change_comment_form_defaults' );

if ( ! function_exists( 'jobscout_excerpt_more' ) ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function jobscout_excerpt_more( $more ) {
	return is_admin() ? $more : ' &hellip; ';
}
endif;
add_filter( 'excerpt_more', 'jobscout_excerpt_more' );

if ( ! function_exists( 'jobscout_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt 
*/
function jobscout_excerpt_length( $length ) {
	$excerpt_length = get_theme_mod( 'excerpt_length', 25 );
    return is_admin() ? $length : absint( $excerpt_length );    
}
endif;
add_filter( 'excerpt_length', 'jobscout_excerpt_length', 999 );

if( ! function_exists( 'jobscout_get_the_archive_title' ) ) :
/**
 * Filter Archive Title
*/
function jobscout_get_the_archive_title( $title ){
    $ed_prefix = get_theme_mod( 'ed_prefix_archive', false );
    if( is_post_type_archive( 'product' ) ){
        $title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
    }else{
        if( $ed_prefix ){
            if( is_category() ){
                $title = single_cat_title( '', false );
            }elseif ( is_tag() ){
                $title = single_tag_title( '', false );
            }elseif( is_author() ){
                $title = '<span class="vcard">' . get_the_author() . '</span>';
            }elseif ( is_year() ) {
                $title = get_the_date( __( 'Y', 'jobscout' ) );
            }elseif ( is_month() ) {
                $title = get_the_date( __( 'F Y', 'jobscout' ) );
            }elseif ( is_day() ) {
                $title = get_the_date( __( 'F j, Y', 'jobscout' ) );
            }elseif ( is_post_type_archive() ) {
                $title = post_type_archive_title( '', false );
            }elseif ( is_tax() ) {
                $tax = get_taxonomy( get_queried_object()->taxonomy );
                $title = single_term_title( '', false );
            }
        }
    }    
    return $title;
}
endif;
add_filter( 'get_the_archive_title', 'jobscout_get_the_archive_title' );


if( ! function_exists( 'jobscout_get_comment_author_link' ) ) :
/**
 * Filter to modify comment author link
 * @link https://developer.wordpress.org/reference/functions/get_comment_author_link/
 */
function jobscout_get_comment_author_link( $return, $author, $comment_ID ){
    $comment = get_comment( $comment_ID );
    $url     = get_comment_author_url( $comment );
    $author  = get_comment_author( $comment );
 
    if ( empty( $url ) || 'http://' == $url )
        $return = '<span itemprop="name">'. esc_html( $author ) .'</span>';
    else
        $return = '<span itemprop="name"><a href=' . esc_url( $url ) . ' rel="external nofollow noopener" class="url" itemprop="url">' . esc_html( $author ) . '</a></span>';

    return $return;
}
endif;
add_filter( 'get_comment_author_link', 'jobscout_get_comment_author_link', 10, 3 );

if( ! function_exists( 'jobscout_exclude_expired_jobs_from_archive' ) ) :
/**
 * Exclude Expired Jobs From Archive
 *
 */
function jobscout_exclude_expired_jobs_from_archive( $query ){
    if (  $query->is_tax( 'job_listing_type' ) && $query->is_main_query() ) {
        $query->set( 'post_status', 'publish' );
    }
}
endif;
add_action( 'pre_get_posts','jobscout_exclude_expired_jobs_from_archive' );

if( ! function_exists( 'jobscout_admin_notice' ) ) :
/**
 * Addmin notice for getting started page
*/
function jobscout_admin_notice(){
    global $pagenow;
    $theme_args     = wp_get_theme();
    $meta           = get_option( 'jobscout_admin_notice' );
    $name           = $theme_args->__get( 'Name' );
    $current_screen = get_current_screen();
    $dismissnonce   = wp_create_nonce( 'jobscout_admin_notice' );

    if( 'themes.php' == $pagenow && !$meta ){
        
        if( $current_screen->id !== 'dashboard' && $current_screen->id !== 'themes' ){
            return;
        }

        if( is_network_admin() ){
            return;
        }

        if( ! current_user_can( 'manage_options' ) ){
            return;
        } ?>

        <div class="welcome-message notice notice-info">
            <div class="notice-wrapper">
                <div class="notice-text">
                    <h3><?php esc_html_e( 'Congratulations!', 'jobscout' ); ?></h3>
                    <p><?php printf( __( '%1$s is now installed and ready to use. Click below to see theme documentation, plugins to install and other details to get started.', 'jobscout' ), esc_html( $name ) ); ?></p>
                    <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=jobscout-dashboard' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Go to the dashboard.', 'jobscout' ); ?></a></p>
                    <p class="dismiss-link"><strong><a href="?jobscout_admin_notice=1&_wpnonce=<?php echo esc_attr( $dismissnonce ); ?>"><?php esc_html_e( 'Dismiss', 'jobscout' ); ?></a></strong></p>
                </div>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'admin_notices', 'jobscout_admin_notice' );

if( ! function_exists( 'jobscout_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function jobscout_update_admin_notice(){

    if (!current_user_can('manage_options')) {
        return;
    }

    // Bail if the nonce doesn't check out
    if ( isset( $_GET['jobscout_admin_notice'] ) && $_GET['jobscout_admin_notice'] = '1' && wp_verify_nonce( $_GET['_wpnonce'], 'jobscout_admin_notice' ) ) {
        update_option( 'jobscout_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'jobscout_update_admin_notice' );

if( ! function_exists( 'jobscout_get_page_id_by_template' ) ) :
/**
 * Returns Page ID by Page Template
*/
function jobscout_get_page_id_by_template( $template_name ){
    $args = array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => $template_name
    );
    return get_pages( $args );    
}
endif;