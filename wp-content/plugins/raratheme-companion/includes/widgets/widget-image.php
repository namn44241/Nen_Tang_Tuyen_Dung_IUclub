<?php
/**
 * Icon Text Widget
 *
 * @package Rttk_Pro
 */

// register RaraTheme_Image_Widget widget
function raratheme_register_image_widget(){
    register_widget( 'RaraTheme_Image_Widget' );
}
add_action('widgets_init', 'raratheme_register_image_widget');
 
 /**
 * Adds RaraTheme_Image_Widget widget.
 */
class RaraTheme_Image_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
			'raratheme_image_widget', // Base ID
			__( 'Rara: Image Widget', 'raratheme-companion' ), // Name
			array( 'description' => __( 'An Image Widget.', 'raratheme-companion' ), ) // Args
		);
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
        
        $obj     = new RaraTheme_Companion_Functions();
        $title   = ! empty( $instance['title'] ) ? $instance['title'] : '' ;
        $content = ! empty( $instance['content'] ) ? $instance['content'] : '';
        $image   = ! empty( $instance['image'] ) ? $instance['image'] : '';
        $label   = ! empty( $instance['label'] ) ? $instance['label'] : '';
        $link    = ! empty( $instance['link'] ) ? $instance['link'] : '';
        $size    = ! empty( $instance['size'] ) ? $instance['size'] : 'full';
        $target  = ! empty( $instance['target'] ) ? esc_url( $instance['target'] ) : '';
        
        if( !isset( $target ) || $target == '' )
        {
            $newtab = 'rel="noopener noexternal" target="_blank"';
        }
        else{
            $newtab = '';
        }
        
        if( $image ){
            $attachment_id = $image;
        }
        
        echo $args['before_widget'];
        ob_start();
        ?>
            <div class="raratheme-iw-holder">
                <div class="raratheme-iw-inner-holder">
                    <?php
                    if( $title ) { echo $args['before_title']; echo apply_filters( 'widget_title', $title, $instance, $this->id_base ); echo $args['after_title']; }
                    if( $content ) echo wpautop( wp_kses_post( $content ) );                
                        if( isset($image) && $image!='' ){ ?>
                            <div class="image-holder">
                                <?php
                                    echo '<a href="'.esc_url($link).'"  '.$newtab.'>';
                                    echo wp_get_attachment_image( $attachment_id, $size, false, 
                                        array( 'alt' => esc_html( $title ))) ;
                                    echo '</a>';
                                ?>
                            </div>
                        <?php
                        }
                        if( isset($link) && $link!='' && $label ) echo '<a href="'.esc_url($link).'"  '.$newtab.' class="readmore"> '. esc_html( $label ) . '</a>';
                    ?>								
                </div>
			</div>
        <?php
        $html = ob_get_clean();
        echo apply_filters( 'raratheme_companion_iw', $html, $args, $title, $content, $image, $link, $label );   
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
        
        $obj     = new RaraTheme_Companion_Functions();
        $title   = ! empty( $instance['title'] ) ? $instance['title'] : '' ;
        $content = ! empty( $instance['content'] ) ? $instance['content'] : '';
        $image   = ! empty( $instance['image'] ) ? $instance['image'] : '';
        $link    = ! empty( $instance['link'] ) ? $instance['link'] : '';
        $label   = ! empty( $instance['label'] ) ? $instance['label'] : '';
        $size    = ! empty( $instance['size'] ) ? $instance['size'] : 'full';
        $target  = ! empty( $instance['target'] ) ? $instance['target'] : '';

        $sizes   = $obj->raratheme_get_all_image_sizes();
        ?>
		
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />            
		</p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php esc_html_e( 'Content', 'raratheme-companion' ); ?></label>
            <textarea name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php print $content; ?></textarea>
        </p>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>"><?php esc_html_e( 'Button label', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'label' ) ); ?>" type="text" value="<?php echo esc_html( $label ); ?>" />            
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_html_e( 'Featured Link', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_url( $link ); ?>" />            
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Open in Same Tab', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" type="checkbox" value="1" <?php echo checked( $target, '1' );?> />            
        </p>

        <p>    
            <label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"><?php esc_html_e( 'Image Size', 'raratheme-companion' ); ?></label> 
        </p>
        <select id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>">
            <option value=""><?php _e('Select image size','raratheme-companion');?></option>
            <?php
            foreach ($sizes as $key => $value) { ?>
                <option value="<?php echo $key;?>" <?php selected( $size, $key ); ?>><?php if($key=='full'){ echo esc_attr($key); }else{ echo esc_attr($key).' ('.$value['width'].'x'.$value['height'].')'; }?></option>
            <?php
            }
            ?>
        </select>
        
        <?php $obj->raratheme_companion_get_image_field( $this->get_field_id( 'image' ), $this->get_field_name( 'image' ), $image, __( 'Upload Image', 'raratheme-companion' ) ); ?>
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
		
        $instance['title']   = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '' ;
        $instance['content'] = ! empty( $new_instance['content'] ) ? wp_kses_post( $new_instance['content'] ) : '';
        $instance['image']   = ! empty( $new_instance['image'] ) ? esc_attr( $new_instance['image'] ) : '';
        $instance['link']    = ! empty( $new_instance['link'] ) ? esc_url_raw( $new_instance['link'] ) : '';
        $instance['label']   = ! empty( $new_instance['label'] ) ? sanitize_text_field( $new_instance['label'] ) : '';
        $instance['size']    = ! empty( $new_instance['size'] ) ? sanitize_text_field( $new_instance['size'] ) : '';
        $instance['target']  = ! empty( $new_instance['target'] ) ? esc_attr( $new_instance['target'] ) : '';


        return $instance;
	}
    
}  // class RaraTheme_Image_Widget