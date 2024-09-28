<?php
/**
 * Icon Text Widget
 *
 * @package Rttk
 */

// register RaraTheme_Image_Text_Widget widget
function raratheme_register_image_text_widget(){
    register_widget( 'RaraTheme_Image_Text_Widget' );
}
add_action('widgets_init', 'raratheme_register_image_text_widget');
 
 /**
 * Adds RaraTheme_Image_Text_Widget widget.
 */
class RaraTheme_Image_Text_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        add_action( 'admin_print_footer_scripts', array( $this,'image_text_widget_template' ) );
        parent::__construct(
			'raratheme_image_text_widget', // Base ID
			__( 'Rara: Image Text', 'raratheme-companion' ), // Name
			array( 'description' => __( 'An Image Text Widget.', 'raratheme-companion' ), ) // Args
		);
    }

    function image_text_widget_template(){ 
        $obj = new RaraTheme_Companion_Functions();
        $image = '';
        ?>
        <div class="raratheme-itw-template">
            <div class="image-text-widget-wrap" data-id="1"><a href="#" class="image-text-cancel"><span class="dashicons dashicons-no"></span></a>
                <?php $obj->raratheme_companion_get_image_field( $this->get_field_id( 'image[]' ), $this->get_field_name( 'image[]' ), $image, __( 'Upload Image', 'raratheme-companion' ) ); 
                ?>
                <p class="text">
                    <label for="<?php echo esc_attr( $this->get_field_id( 'link_text[]' ) ); ?>"><?php esc_html_e( 'Link Text', 'raratheme-companion' ); ?></label> 
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link_text[]' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_text[]' ) ); ?>" type="text" />            
                </p>
                <p class="link">
                    <label for="<?php echo esc_attr( $this->get_field_id( 'link[]' ) ); ?>"><?php esc_html_e( 'Featured Link', 'raratheme-companion' ); ?></label> 
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link[]' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link[]' ) ); ?>" type="text" />            
                </p>
            </div>
        </div>
    <?php
        echo 
        '<style>
            .raratheme-itw-template{
                display: none;
            }
        </style>';
    }
    
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        
        $obj = new RaraTheme_Companion_Functions();
        $it_img_size = apply_filters( 'raratheme_it_img_size', 'post-slider-thumb-size' );
        $title   = ! empty( $instance['title'] ) ? $instance['title'] : '' ;	

        $target = 'target="_self"';
        if( isset( $instance['target'] ) && $instance['target']!='' ){
            $target = 'rel="noopener noexternal" target="_blank"';
        }	
        
        echo $args['before_widget'];
        ob_start();
        if ( $title ) echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $args['after_title']; 
        ?>
            <ul class="raratheme-itw-holder">
                <?php
                if( isset( $instance['link'] ) )
                {
                    $size = sizeof( $instance['link'] );
                    $max = max( array_keys( $instance['link'] ) );
                    for ( $i=0; $i <= $max; $i++ ) {

                        if ( isset( $instance['link'][$i] ) && $instance['link'][$i] != '' ){
                            echo '<li>';
                            ?>
                            <a href="<?php echo esc_url( $instance['link'][$i] );?>" <?php echo $target;?>>
                                <?php
                                if( isset( $instance['image'][$i] ) && $instance['image'][$i] !='' ){ 
                                    $image_id = $instance['image'][$i];
                                    echo wp_get_attachment_image( $image_id, $it_img_size );
                                }
                                if( $instance['image'][$i] == '' ){
                                    //fallback svg
                                    $obj->raratheme_get_fallback_svg( $it_img_size );
                                }
                                ?>
                            </a>
                            <?php 

                            if( isset( $instance['link_text'][$i] ) && $instance['link_text'][$i] !='' && isset( $instance['link'][$i] ) && $instance['link'][$i] !='' )
                            { 
                                echo '<a class="btn-readmore" href="'.esc_url( $instance['link'][$i] ).'" '.$target.'>'.esc_attr( $instance['link_text'][$i] ).'</a>'; ?>								
                            <?php 
                            }
                            echo '</li>'; 
                        }
                    }
                } 
                ?>
			</ul>
        <?php 
        $html = ob_get_clean();
        echo apply_filters( 'rara_imagetext_widget_filter', $html, $args, $instance );   
        echo $args['after_widget'];
    }

    /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
        $title      = ! empty( $instance['title'] ) ? $instance['title'] : '' ;
        $target    = ! empty( $instance['target'] ) ? $instance['target'] : '';
        ?>
        <script type='text/javascript'>
            jQuery(document).ready(function($) {
                $('.raratheme-img-text-outer').sortable({
                    cursor: 'move',
                    update: function (event, ui) {
                        $('.raratheme-img-text-outer .image-text-widget-wrap input').trigger('change');
                    }
                });
            });
        </script>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr($title);?>" type="text" />            
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>">
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" type="checkbox" value="1" <?php echo checked( $target, 1 );?> /><?php esc_html_e( 'Open in New Tab', 'raratheme-companion' ); ?> </label>
        </p>
        <div class="raratheme-img-text-outer" id="<?php echo esc_attr( $this->get_field_id( 'raratheme-img-text-outer' ) ); ?>">
            <?php
            $obj = new RaraTheme_Companion_Functions();
            if( isset( $instance['link'] ) )
            {
                $size = sizeof( $instance['link']);
                $max = max( array_keys( $instance['link'] ) );
                for ( $i=0; $i <= $max; $i++ ) { 
                    if ( isset($instance['link'][$i]) && $instance['link'][$i] != '' ) {
                        ?> 
                        <div class="image-text-widget-wrap" data-id="<?php echo $i;?>"><a href="#" class="image-text-cancel"><span class="dashicons dashicons-no"></span></a>
                            <p>
                                <?php 
                                $obj->raratheme_companion_get_image_field( $this->get_field_id( 'image[]' ), $this->get_field_name( 'image[]' ), !empty( $instance['image'][$i] ) ? esc_attr( $instance['image'][$i] ) : '', __( 'Upload Image', 'raratheme-companion' ) ); ?>
                            </p>
                            <p class="text">
                                <label for="<?php echo esc_attr( $this->get_field_id( 'link_text[]' ) ); ?>"><?php esc_html_e( 'Link Text', 'raratheme-companion' ); ?></label> 
                                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link_text[]' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_text[]' ) ); ?>" value="<?php echo !empty( $instance['link_text'][$i] ) ? esc_attr( $instance['link_text'][$i] ) : '';?>" type="text" />            
                            </p>
                            <p class="link">
                                <label for="<?php echo esc_attr( $this->get_field_id( 'link[]' ) ); ?>"><?php esc_html_e( 'Featured Link', 'raratheme-companion' ); ?></label> 
                                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link[]' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link[]' ) ); ?>" value="<?php echo !empty( $instance['link'][$i] ) ? esc_url( $instance['link'][$i] ) : '';?>" type="text" />
                            </p>

                        </div>
                <?php 
                    }   
                }
            }
            ?>
            <span class="itw-holder"></span>
        </div>
        <input class="raratheme-itw-add button-secondary" type="button" value="<?php _e('Add Image Text','raratheme-companion');?>"><br>
        <?php
	}
    
    /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
        $instance['title']        = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '' ;
        $instance['target']         = ! empty( $new_instance['target'] ) ? esc_attr( $new_instance['target'] ) : '';
        if( isset( $new_instance['link'] ) )
        {
            $size = sizeof($new_instance['link']);
            for ($i=0; $i < $size; $i++) { 
                $instance['image'][$i]        = ! empty( $new_instance['image'][$i] ) ? esc_attr( $new_instance['image'][$i] ) : '';
                $instance['link'][$i]         = ! empty( $new_instance['link'][$i] ) ? esc_url( $new_instance['link'][$i] ) : '';
                $instance['link_text'][$i]    = ! empty( $new_instance['link_text'][$i] ) ? esc_attr( $new_instance['link_text'][$i] ) : '';
            }
        }
        return $instance;
	}
}