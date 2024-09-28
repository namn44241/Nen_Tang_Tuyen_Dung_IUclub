<?php
// Register and load the widget
function rara_posts_category_slider_load_widget() {
    register_widget( 'rara_posts_category_slider_widget' );
}
add_action( 'widgets_init', 'rara_posts_category_slider_load_widget' );
 
// Creating the widget 
class rara_posts_category_slider_widget extends WP_Widget {
 
	function __construct() {
		parent::__construct(
	 
		// Base ID of your widget
		'rara_posts_category_slider_widget', 
		 
		// Widget name will appear in UI
		__('Rara: Posts Category Slider', 'raratheme-companion'), 
		 
		// Widget description
		array( 'description' => __( 'Simple posts slider from category.', 'raratheme-companion' ), ) 
		);
	}
 
	// Creating widget front-end
	public function widget( $args, $instance ) {

		if ( is_active_widget( false, false, $this->id_base, true ) ) {

            wp_enqueue_style( 'owl-carousel', RARATC_FILE_URL . '/public/css/owl.carousel.min.css', array(), '2.2.1', 'all' );
			wp_enqueue_style( 'owl-theme-default', RARATC_FILE_URL . '/public/css/owl.theme.default.min.css', array(), '2.2.1', 'all' );
			wp_enqueue_script( 'owl-carousel', RARATC_FILE_URL . '/public/js/owl.carousel.min.js', array( 'jquery' ), '2.2.1', false );

        }
        
		$instance['title'] = ( ! empty( $instance['title'] ) ) ? strip_tags( $instance['title'] ) : '';
		$title             = apply_filters( 'widget_title', $instance['title'] );
		 
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		ob_start();
		if ( ! empty( $title ) )
		echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		$slides          = ! empty( $instance['slides'] ) ? $instance['slides'] : '1';
		$category        = ! empty( $instance['category'] ) ? $instance['category'] : '1';
		$show_arrow      = '0';
		$show_pagination = '0';
		$direction       = '0';

		if( isset( $instance['show_arrow'] ) && $instance['show_arrow']!='' )
		{
			$show_arrow = $instance['show_arrow'];
		}
		if( isset( $instance['show_pagination'] ) && $instance['show_pagination']!='' )
		{
			$show_pagination = $instance['show_pagination'];
		}
		if( isset( $instance['direction'] ) && $instance['direction']!='' )
		{
			$direction = $instance['direction'];
		}
		$ran = rand(1,100); $ran++;
		if( $direction == '1' )
		{
			$direction = 'true';
		}
		else{
			$direction = 'false';
		}

		$target = 'target="_self"';
        if( isset($instance['target']) && $instance['target']!='' )
        {
            $target = 'rel="noopener noexternal" target="_blank"';
        }
		// This is where you run the code and display the output
		echo '<div id="sync1-'.esc_attr($ran).'" class="owl-carousel owl-theme">';
				global $post;
		    	$catquery = new WP_Query( 'cat='.$category.'&posts_per_page='.$slides ); ?>
				<?php while($catquery->have_posts()) : $catquery->the_post(); 
					$category_img_size = apply_filters('category_img_size','post-slider-thumb-size');
					$feat_image_url = wp_get_attachment_image_url( get_post_thumbnail_id($post->ID), $category_img_size ); 
					if( empty( $feat_image_url ) )
					{
						$feat_image_url = esc_url(RARATC_FILE_URL).'/public/css/image/no-featured-img.png';
					}
					?>
					<div class="item">
						<a <?php echo $target; ?> href="<?php the_permalink();?>" class="post-thumbnail">
							<img class="carousel-thumb" src="<?php echo esc_url($feat_image_url);?>">
						</a>
						<div class="carousel-title">
                                <?php
                                $category_detail = get_the_category($post->ID);
                                echo '<span class="cat-links">';
                                foreach($category_detail as $cd){
                                echo '<a '.$target.' href="' . esc_url( get_category_link( $cd->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'raratheme-companion' ), $cd->name ) ) . '">' . esc_html( $cd->name ) . '</a>';
                                }
                                echo '</span>';
                                ?>
							<h3 class="title"><a <?php echo $target; ?> href="<?php the_permalink();?>"><?php the_title();?></a></h3>
						</div>
                        </div>
				<?php endwhile;
				    wp_reset_postdata();
				echo '</div>';
				$obj = new RaraTheme_Companion_Functions;
				echo $obj->rrtc_minify_css('<style>
				#sync1-'.esc_attr($ran).' {
				  .item {
				    background: #0c83e7;
				    padding: 80px 0px;
				    margin: 5px;
				    color: #FFF;
				    -webkit-border-radius: 3px;
				    -moz-border-radius: 3px;
				    border-radius: 3px;
				    text-align: center;
				  }
				}
				.owl-theme {
					.owl-nav {
					    /*default owl-theme theme reset .disabled:hover links */
					    [class*="owl-"] {
					      transition: all .3s ease;
					      &.disabled:hover {
					       background-color: #D6D6D6;
					      }   
					    }
					    
					  }
					}

					//arrows on first carousel
					#sync1-'.esc_attr($ran).'.owl-theme {
					  position: relative;
					  .owl-next, .owl-prev {
					    width: 22px;
					    height: 40px;
					    margin-top: -20px;
					    position: absolute;
					    top: 50%;
					  }
					  .owl-prev {
					    left: 10px;
					  }
					  .owl-next {
					    right: 10px;
					  }
					}
				</style>');
				echo '<script>
					jQuery(document).ready(function($) {
					  var sync1 = $("#sync1-'.esc_attr($ran).'");
					  var slidesPerPage = 1;
					  var syncedSecondary = true;
					  sync1.owlCarousel({
					    items : 1,
					    slideSpeed : '.apply_filters('posts_category_slider_speed', '5000').',
					    nav: '.$show_arrow.',
					    dots: '.$show_pagination.',
					    rtl : '.$direction.',
					    autoplay: true,
					    loop: true,
					    responsiveRefreshRate : 200,
					  }); });</script>';
				$html = ob_get_clean();
        		echo apply_filters( 'raratheme_companion_pcs_widget_filter', $html, $args, $instance );
				echo $args['after_widget'];
	}
         
// Widget Backend 
	public function form( $instance ) {
		$target    = ! empty( $instance['target'] ) ? $instance['target'] : '';
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'raratheme-companion' );
		}
		if ( isset( $instance[ 'category' ] ) ) {
			$category = $instance[ 'category' ];
		}
		else {
			$category = '1';
		}
		if ( isset( $instance[ 'show_arrow' ] ) ) {
			$show_arrow = $instance[ 'show_arrow' ];
		}
		else {
			$show_arrow = '';
		}
		if ( isset( $instance[ 'show_pagination' ] ) ) {
			$show_pagination = $instance[ 'show_pagination' ];
		}
		else {
			$show_pagination = '';
		}
		if ( isset( $instance[ 'slides' ] ) ) {
			$slides = $instance[ 'slides' ];
		}
		else {
			$slides = '1';
		}
		if ( isset( $instance[ 'direction' ] ) ) {
			$direction = $instance[ 'direction' ];
		}
		else {
			$direction = '';
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'raratheme-companion' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category:', 'raratheme-companion' ); ?></label> 
	        <select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="widefat" style="width:100%;">
	            <?php foreach(get_terms('category','parent=0&hide_empty=0') as $term) { ?>
	            <option <?php selected( $category, $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
	            <?php } ?>      
	        </select>
	    </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'slides' ) ); ?>"><?php esc_html_e( 'Number of Slides:', 'raratheme-companion' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'slides' ) ); ?>" min="1" name="<?php echo esc_attr( $this->get_field_name( 'slides' ) ); ?>" type="number" max="100" value="<?php echo esc_attr( $slides ); ?>"/>
            <div class="example-text"><?php _e('Total number of posts available in the selected category will be the maximum number of slides.','raratheme-companion');?></div>
        </p>

	    <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'show_arrow' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_arrow' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $show_arrow ); ?>/>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_arrow' ) ); ?>"><?php esc_html_e( 'Show Slider Arrows', 'raratheme-companion' ); ?></label>
        </p>

       	<p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'show_pagination' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_pagination' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $show_pagination ); ?>/>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_pagination' ) ); ?>"><?php esc_html_e( 'Show Slider Pagination', 'raratheme-companion' ); ?></label>
        </p>

        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'direction' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'direction' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $direction ); ?>/>
            <label for="<?php echo esc_attr( $this->get_field_id( 'direction' ) ); ?>"><?php esc_html_e( 'Change Direction', 'raratheme-companion' ); ?></label>
            <div class="example-text"><?php _e( "Enabling this will change slider direction from 'right to left' to 'left to right'.","raratheme-companion" );?></div>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>">
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" type="checkbox" value="1" <?php echo checked($target,1);?> /><?php esc_html_e( 'Open Posts in New Tab', 'raratheme-companion' ); ?> </label>
        </p>

		<?php 
	}
     
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance                    = array();
		$instance['title']           = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['category']        = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
		$instance['show_arrow']      = ( ! empty( $new_instance['show_arrow'] ) ) ? strip_tags( $new_instance['show_arrow'] ) : '';
		$instance['show_pagination'] = ( ! empty( $new_instance['show_pagination'] ) ) ? strip_tags( $new_instance['show_pagination'] ) : '';
		$instance['slides']          = ( ! empty( $new_instance['slides'] ) ) ? strip_tags( $new_instance['slides'] ) : '1';
		$instance['direction']       = ( ! empty( $new_instance['direction'] ) ) ? strip_tags( $new_instance['direction'] ) : '';
		$instance['target']          = ! empty( $new_instance['target'] ) ? esc_attr( $new_instance['target'] ) : '';
		return $instance;
	}
} // Class rara_posts_category_slider_widget ends here