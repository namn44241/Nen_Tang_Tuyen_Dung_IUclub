<?php
/**
 * JobScout Template Functions which enhance the theme by hooking into WordPress
 *
 * @package JobScout
 */

if( ! function_exists( 'jobscout_doctype' ) ) :
/**
 * Doctype Declaration
*/
function jobscout_doctype(){ ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <?php
}
endif;
add_action( 'jobscout_doctype', 'jobscout_doctype' );

if( ! function_exists( 'jobscout_head' ) ) :
/**
 * Before wp_head 
*/
function jobscout_head(){ ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php
}
endif;
add_action( 'jobscout_before_wp_head', 'jobscout_head' );

if( ! function_exists( 'jobscout_responsive_header' ) ) :
/**
 * Responsive Header
*/
function jobscout_responsive_header(){ 
    $post_job_label  = get_theme_mod( 'post_job_label', __( 'Post Jobs', 'jobscout' ) );
    $post_job_url    = get_theme_mod( 'post_job_url', '#' );
    ?>
    <div class="responsive-nav">
        <div class="nav-top">
            <?php jobscout_site_branding( true ); ?>
        </div>


        <nav id="mobile-site-navigation" class="main-navigation mobile-navigation">        
            <div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
                <button class="close close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal"></button>
                <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'jobscout' ); ?>">
                    <?php
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'mobile-primary-menu',
                            'menu_class'     => 'nav-menu main-menu-modal',
                            'container'      => false,
                            'fallback_cb'    => 'jobscout_primary_menu_fallback',
                        ) );

                        wp_nav_menu( array(
                            'theme_location' => 'secondary',
                            'menu_class'     => 'nav-menu',
                            'menu_id'        => 'secondary-menu',
                            'container'      => false,
                            'fallback_cb'    => 'jobscout_secondary_menu_fallback',
                        ) );
                    ?>
                
                    <?php if( $post_job_label || $post_job_url ){ ?>
                        <div class="btn-wrap">
                            <a class="btn" href="<?php echo esc_url( $post_job_url ) ?>"><?php echo esc_html( $post_job_label ) ?></a>
                        </div>
                    <?php } ?>
               </div>
            </div>
        </nav><!-- #mobile-site-navigation -->
    </div> <!-- .responsive-nav -->
    <?php
}
endif;
add_action( 'jobscout_before_header', 'jobscout_responsive_header', 15 );

if( ! function_exists( 'jobscout_page_start' ) ) :
/**
 * Page Start
*/
function jobscout_page_start(){ ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#acc-content"><?php esc_html_e( 'Skip to content (Press Enter)', 'jobscout' ); ?></a>
    <?php
}
endif;
add_action( 'jobscout_before_header', 'jobscout_page_start', 20 );

if( ! function_exists( 'jobscout_header' ) ) :
/**
 * Header Start
*/
function jobscout_header(){ 
    ?>
    <header id="masthead" class="site-header header-one" itemscope itemtype="https://schema.org/WPHeader">
        <?php if( has_nav_menu( 'secondary' ) || current_user_can( 'manage_options' ) ) jobscout_secondary_navigation(); ?>
        <div class="header-main">
            <div class="container">
                <?php 
                    jobscout_site_branding( false );
                    echo '<div class="menu-wrap">';
                    jobscout_primary_nagivation();
                    echo '</div><!-- .menu-wrap -->';
                ?>
            </div>
        </div> <!-- .header-main -->
    </header> <!-- .site-header -->
    <?php
}
endif;
add_action( 'jobscout_header', 'jobscout_header', 20 );

if( ! function_exists( 'jobscout_breadcrumbs_bar' ) ) :
    /**
     * Breadcrumbs
    */
    function jobscout_breadcrumbs_bar(){
        $ed_breadcrumbs = get_theme_mod( 'ed_breadcrumbs', false );

        if( $ed_breadcrumbs && ! is_front_page() && ! is_404() ){ ?>
            <section class="breadcrumb-wrap">
                <div class="container">
                    <?php jobscout_breadcrumbs_cb(); //Breadcrumb ?>
                </div>
            </section>   
            <?php 
        }    
    }
endif;
add_action( 'jobscout_after_header', 'jobscout_breadcrumbs_bar', 30 );

if( ! function_exists( 'jobscout_content_start' ) ) :
/**
 * Content Start
 *  
*/
function jobscout_content_start(){       
    echo '<div id="acc-content"><!-- .site-header -->';
    $home_sections = jobscout_get_home_sections(); 
    if( ! ( is_front_page() && ! is_home() && $home_sections ) ){ //Make necessary adjust for pg template.
        echo is_404() ? '<div class="error-holder">' : '<div id="content" class="site-content">'; 

        if( is_archive() || is_search() || is_page_template( 'templates/portfolio.php' ) ) : ?>
            <header class="page-header">
                <?php
                    if( is_archive() ){ 
                        if( is_author() ) { 
                            $author_title = get_the_author(); ?>
                            <div class="author-bio">
                                <figure class="author-img"><?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?></figure>
                                <div class="author-content">
                                    <?php 
                                        echo '<span class="sub-title">' . esc_html__( 'All Posts by', 'jobscout' ) . '</span>';
                                        if( $author_title ) echo '<h1 class="author-title">' . esc_html( $author_title ) . '</h3>';
                                    ?>      
                                </div>
                            </div>
                        <?php }else{
                            the_archive_title( '<h1 class="page-title">', '</h1>' );
                            the_archive_description( '<div class="archive-description">', '</div>' );             
                        }
                    }
                    
                    if( is_search() ){ 
                        echo '<div class="container">';
                            echo '<h1 class="page-title">' . esc_html__( 'Search', 'jobscout' ) . '</h1>';
                            get_search_form();
                        echo '</div><!-- .container -->';
                    }

                    if( ! is_author() && ! is_search() ){
                        jobscout_posts_per_page_count();
                    }

                    if( is_page_template( 'templates/portfolio.php' ) ){
                        global $post;
                        echo '<div class="container">';
                            echo '<h1 class="page-title">' . esc_html( get_the_title( $post->ID ), 'jobscout' ) . '</h1>';
                            if( $post->post_content ) echo wpautop( wp_kses_post( $post->post_content ) );
                        echo '</div><!-- .container -->';
                    }
                ?>
            </header>
        <?php endif; 
            if( is_singular( 'job_listing' ) ){
                global $post;
                $banner_image   = get_header_image();
                $show_banner    = get_theme_mod( 'ed_job_banner', true );

                if( $banner_image && $show_banner ){
                    $banner_style = 'background-image: url(' . esc_url( $banner_image ) . '); background-size: cover;';
                    echo '<header class="entry-header" style="'. esc_attr( $banner_style ) .'"></header>';
                }
            } 
        ?>
        <div class="container">
        <?php 
    }
}
endif;
add_action( 'jobscout_content', 'jobscout_content_start' );

if ( ! function_exists( 'jobscout_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function jobscout_post_thumbnail() {
    $image_size  = 'thumbnail';
    $ed_featured = get_theme_mod( 'ed_featured_image', true );
    $sidebar     = jobscout_sidebar_layout();
    
    if( is_home() || is_archive() || is_search() ){        
        $image_size = 'jobscout-blog';    
        if( has_post_thumbnail() ){                        
            echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '">';
                the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
            echo '</a></figure>';
        }else{
            echo '<figure class="post-thumbnail">';
                jobscout_fallback_svg_image( $image_size );  
            echo '</figure>';  
        }        
    }elseif( is_singular() ){
        $image_size = ( $sidebar ) ? 'jobscout-single' : 'jobscout-single-fullwidth';
        if( is_single() ){
            if( $ed_featured && has_post_thumbnail() ){
                echo '<figure class="post-thumbnail">';
                the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                echo '</figure>';
            }
        }else{
            echo '<figure class="post-thumbnail">';
            the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
            echo '</figure>';
        }
    }
}
endif;
add_action( 'jobscout_before_post_entry_content', 'jobscout_post_thumbnail', 15 );
add_action( 'jobscout_before_page_entry_content', 'jobscout_post_thumbnail', 15 );
add_action( 'jobscout_before_single_post_entry_content', 'jobscout_post_thumbnail', 15 );

if( ! function_exists( 'jobscout_entry_header' ) ) :
/**
 * Entry Header
*/
function jobscout_entry_header(){ ?>
    <header class="entry-header">
        <?php 
            $ed_cat_single = get_theme_mod( 'ed_category', false );
            $hide_author   = get_theme_mod( 'ed_post_author', false );
            $hide_date     = get_theme_mod( 'ed_post_date', false );

            if( is_single() ){
                if( ! $ed_cat_single ) jobscout_category();
            }else{
                if( 'post' === get_post_type() ){
                    echo '<div class="entry-meta">';
                    if( ! $hide_author ) jobscout_posted_by();
                    if( ! $hide_date ) jobscout_posted_on();
                    echo '</div>';
                }
            }

            if ( is_singular() ) :
                the_title( '<h1 class="entry-title">', '</h1>' );
            else :
                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;        
        ?>
    </header>         
    <?php    
}
endif;
add_action( 'jobscout_post_entry_content', 'jobscout_entry_header', 10 );
add_action( 'jobscout_before_page_entry_content', 'jobscout_entry_header', 10 );
add_action( 'jobscout_before_single_post_entry_content', 'jobscout_entry_header', 10 );

if( ! function_exists( 'jobscout_entry_content' ) ) :
/**
 * Entry Content
*/
function jobscout_entry_content(){ 
    $ed_excerpt = get_theme_mod( 'ed_excerpt', true ); ?>
    <div class="entry-content" itemprop="text">
		<?php
			if( is_singular() || ! $ed_excerpt || ( get_post_format() != false ) ){
                the_content();    
    			wp_link_pages( array(
    				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jobscout' ),
    				'after'  => '</div>',
    			) );
            }else{
                the_excerpt();
            }
		?>
	</div><!-- .entry-content -->
    <?php
}
endif;
add_action( 'jobscout_post_entry_content', 'jobscout_entry_content', 15 );
add_action( 'jobscout_page_entry_content', 'jobscout_entry_content', 15 );
add_action( 'jobscout_single_post_entry_content', 'jobscout_entry_content', 15 );
add_action( 'jobscout_single_post_entry_content', 'jobscout_entry_content', 15 );
add_action( 'jobscout_before_single_job_content', 'jobscout_entry_content', 15 );

if( ! function_exists( 'jobscout_entry_footer' ) ) :
/**
 * Entry Footer
*/
function jobscout_entry_footer(){ 
    $readmore = get_theme_mod( 'read_more_text', __( 'Read More', 'jobscout' ) );
    $ed_post_date   = get_theme_mod( 'ed_post_date', false ); ?>
	<footer class="entry-footer">
		<?php
			if( is_single() ){
			    jobscout_tag();
			}
            
            if( is_front_page() || is_home() || is_search() || is_archive() ){
                echo '<a href="' . esc_url( get_the_permalink() ) . '" class="readmore-link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.207 8.58"><defs><style>.c{fill:none;stroke:#2ace5e;}</style></defs><g transform="translate(-701.5 -958.173)"><path class="c" d="M-9326.909-9204.917l-3.937,3.937,3.937,3.937" transform="translate(-8613.846 -8238.518) rotate(180)"/><line class="c" x2="15.154" transform="translate(701.5 962.426)"/></g></svg>' . esc_html( $readmore ) . '</a>';    
            }

            if( is_single() ) echo '<div class="entry-footer-right">';
            if( 'post' === get_post_type() && is_single() ){
                if( ! $ed_post_date ) jobscout_posted_on( true );
                jobscout_comment_count();
            }
            
            if( get_edit_post_link() ){
                edit_post_link(
                    sprintf(
                        wp_kses(
                            /* translators: %s: Name of current post. Only visible to screen readers */
                            __( 'Edit <span class="screen-reader-text">%s</span>', 'jobscout' ),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        get_the_title()
                    ),
                    '<span class="edit-link">',
                    '</span>'
                );
            }
            if( is_single() ) echo '</div>';
		?>
	</footer><!-- .entry-footer -->
	<?php 
}
endif;
add_action( 'jobscout_post_entry_content', 'jobscout_entry_footer', 20 );
add_action( 'jobscout_page_entry_content', 'jobscout_entry_footer', 20 );
add_action( 'jobscout_single_post_entry_content', 'jobscout_entry_footer', 20 );

if( ! function_exists( 'jobscout_get_single_job_title' ) ) :
/**
 * Before wp_head 
*/
function jobscout_get_single_job_title(){ 
    ?>
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php
            if ( get_option( 'job_manager_enable_types' ) ) { 
                echo '<div class="job-type">';
                    $types = wpjm_get_the_job_types(); 
                    if ( ! empty( $types ) ) : foreach ( $types as $type ) : ?>
                        <span class="btn <?php echo esc_attr( sanitize_title( $type->slug ) ); ?>"><?php echo esc_html( $type->name ); ?></span>
                    <?php endforeach; endif;
                echo '</div>';
            } 
        ?>
    </header>
    <?php
}
endif;
add_action( 'jobscout_before_single_job_content', 'jobscout_get_single_job_title' );

if( ! function_exists( 'jobscout_navigation' ) ) :
/**
 * Navigation
*/
function jobscout_navigation(){
    if( is_single() ){
        $previous = get_previous_post_link(
    		'<div class="nav-previous nav-holder">%link</div>',
    		'<span class="meta-nav">' . esc_html__( 'Previous Article', 'jobscout' ) . '</span><span class="post-title">%title</span>',
    		false,
    		'',
    		'category'
    	);
    
    	$next = get_next_post_link(
    		'<div class="nav-next nav-holder">%link</div>',
    		'<span class="meta-nav">' . esc_html__( 'Next Article', 'jobscout' ) . '</span><span class="post-title">%title</span>',
    		false,
    		'',
    		'category'
    	); 
        
        if( $previous || $next ){?>            
            <nav class="navigation post-navigation" role="navigation">
    			<h2 class="screen-reader-text"><?php esc_html_e( 'Post Navigation', 'jobscout' ); ?></h2>
    			<div class="nav-links">
    				<?php
                        if( $previous ) echo $previous;
                        if( $next ) echo $next;
                    ?>
    			</div>
    		</nav>        
            <?php
        }
    }else{
        the_posts_navigation();
    }
}
endif;
add_action( 'jobscout_after_post_content', 'jobscout_navigation', 10 );
add_action( 'jobscout_after_posts_content', 'jobscout_navigation' );

if( ! function_exists( 'jobscout_author' ) ) :
/**
 * Author Section
*/
function jobscout_author(){ 
    $ed_author    = get_theme_mod( 'ed_author', false );
    $author_title = get_theme_mod( 'author_title', __( 'About Author', 'jobscout' ) );
    if( ! $ed_author && get_the_author_meta( 'description' ) ){ ?>
    <div class="author-bio">
        <?php if( $author_title ) echo '<h3 class="title">' . esc_html( $author_title ) . '</h3>'; ?>
        <div class="author-bio-inner">
            <figure class="author-img"><?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?></figure>
            <div class="author-content">
                <?php echo '<div class="author-info">' . wpautop( wp_kses_post( get_the_author_meta( 'description' ) ) ) . '</div>';
                ?>		
            </div>
		</div>
	</div>
    <?php
    }
}
endif;
add_action( 'jobscout_after_post_content', 'jobscout_author', 20 );

if( ! function_exists( 'jobscout_comment' ) ) :
/**
 * Comments Template 
*/
function jobscout_comment(){
    // If comments are open or we have at least one comment, load up the comment template.
	if( get_theme_mod( 'ed_comments', true ) && ( comments_open() || get_comments_number() ) ) :
		comments_template();
	endif;
}
endif;
add_action( 'jobscout_after_post_content', 'jobscout_comment', 30 );
add_action( 'jobscout_after_page_content', 'jobscout_comment' );

if( ! function_exists( 'jobscout_content_end' ) ) :
/**
 * Content End
*/
function jobscout_content_end(){ 
    $home_sections = jobscout_get_home_sections(); 
    if( ! ( is_front_page() && ! is_home() && $home_sections ) ){ ?>            
        </div><!-- .container/ -->        
    </div><!-- .error-holder/site-content -->
    <?php
    }
}
endif;
add_action( 'jobscout_before_footer', 'jobscout_content_end', 20 );

if( ! function_exists( 'jobscout_footer_start' ) ) :
/**
 * Footer Start
*/
function jobscout_footer_start(){
    ?>
    <footer id="colophon" class="site-footer" itemscope itemtype="https://schema.org/WPFooter">
    <?php
}
endif;
add_action( 'jobscout_footer', 'jobscout_footer_start', 20 );

if( ! function_exists( 'jobscout_footer_top' ) ) :
/**
 * Footer Top
*/
function jobscout_footer_top(){    
    $footer_sidebars = array( 'footer-one', 'footer-two', 'footer-three', 'footer-four' );
    $active_sidebars = array();
    $sidebar_count   = 0;
    
    foreach ( $footer_sidebars as $sidebar ) {
        if( is_active_sidebar( $sidebar ) ){
            array_push( $active_sidebars, $sidebar );
            $sidebar_count++ ;
        }
    }
                 
    if( $active_sidebars ){ ?>
        <div class="footer-t">
    		<div class="container">
    			<div class="grid column-<?php echo esc_attr( $sidebar_count ); ?>">
                <?php foreach( $active_sidebars as $active ){ ?>
    				<div class="col">
    				   <?php dynamic_sidebar( $active ); ?>	
    				</div>
                <?php } ?>
                </div>
    		</div>
    	</div>
        <?php 
    }
}
endif;
add_action( 'jobscout_footer', 'jobscout_footer_top', 30 );

if( ! function_exists( 'jobscout_footer_bottom' ) ) :
/**
 * Footer Bottom
*/
function jobscout_footer_bottom(){ ?>
    <div class="footer-b">
		<div class="container">
            <?php 
                if ( function_exists( 'the_privacy_policy_link' )  )  the_privacy_policy_link( '<div class="privacy-block">', '</div>' );
            ?>
			<div class="copyright">            
            <?php
                jobscout_get_footer_copyright();
                jobscout_ed_author_link();
                jobscout_ed_wp_link();
            ?>               
            </div>
		</div>
	</div>
    <?php
}
endif;
add_action( 'jobscout_footer', 'jobscout_footer_bottom', 40 );

if( ! function_exists( 'jobscout_footer_end' ) ) :
/**
 * Footer End 
*/
function jobscout_footer_end(){ ?>
    </footer><!-- #colophon -->
    <?php
}
endif;
add_action( 'jobscout_footer', 'jobscout_footer_end', 50 );

if( ! function_exists( 'jobscout_page_end' ) ) :
/**
 * Page End
*/
function jobscout_page_end(){ ?>
    </div><!-- #acc-content -->
    </div><!-- #page -->
    <?php
}
endif;
add_action( 'jobscout_after_footer', 'jobscout_page_end', 20 );