<?php
/**
 * Stat Counter Widget
 *
 * @package Rttk_Pro
 */

// register RaraTheme_Companion_Stat_Counter_Widget widget
function raratheme_stat_counter_widget(){
    register_widget( 'RaraTheme_Companion_Stat_Counter_Widget' );
}
add_action('widgets_init', 'raratheme_stat_counter_widget');
 
 /**
 * Adds RaraTheme_Companion_Stat_Counter_Widget widget.
 */
class RaraTheme_Companion_Stat_Counter_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'raratheme_companion_stat_counter_widget', // Base ID
            __( 'Rara: Stat Counter Widget', 'raratheme-companion' ), // Name
            array( 'description' => __( 'Widget for stat counter.', 'raratheme-companion' ), ) // Args
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

        if ( is_active_widget( false, false, $this->id_base, true ) ) {

            wp_enqueue_script( 'odometer', RARATC_FILE_URL . '/public/js/odometer.min.js', array( 'jquery' ), '0.4.6', false );
            wp_enqueue_script( 'waypoint', RARATC_FILE_URL . '/public/js/waypoint.min.js', array( 'jquery' ), '2.0.3', false );
        }

        $obj     = new RaraTheme_Companion_Functions; 
        $title   = ! empty( $instance['title'] ) ? $instance['title'] : '' ;        
        $counter = ! empty( $instance['counter'] ) ? $instance['counter'] : '';
        $icon    = ! empty( $instance['icon'] ) ? $instance['icon'] : '';
        $comma   = ! empty( $instance['comma'] ) ? $instance['comma'] : '';
        $image   = ! empty( $instance['image'] ) ? $instance['image'] : '';
        
        if( $image ){
            
            $attachment_id = $image;
            $icon_img_size = apply_filters('scw_icon_img_size','full');
            
        }

        echo $args['before_widget'];
        ob_start(); 
        $ran = rand(1,1000); $ran++;
        ob_start();
        ?>
        <div class="col">
            <div class="raratheme-sc-holder">
                <?php 
                if( $title ) echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $args['after_title']; 
                if( $image ){ ?>
                        <div class="image-holder">
                            <?php echo wp_get_attachment_image( $attachment_id, $icon_img_size, false, 
                                        array( 'alt' => esc_html( $title ))) ;?>
                        </div>
                    <?php }elseif( $icon ){ ?>
                    <div class="icon-holder">
                        <?php do_action( 'widget_raratheme_stat_counter_before_icon' ); ?>
                        <i class="<?php echo esc_attr( $icon ); ?>"></i><?php do_action('widget_stat_counter_after_icon')?>
                    </div>
                    <?php 
                } 
                
                if( $counter ) { 
                    $delay = ($ran/1000)*100; ?>
                    <div class="hs-counter<?php echo $ran;?> hs-counter wow fadeInDown" data-wow-duration="<?php echo $delay/100; echo 's';?>">
                        <div class="hs-counter-count<?php echo $ran;?> odometer odometer<?php echo $ran;?>" data-count="<?php echo $counter; ?>">0</div>
                    </div>
                    <?php 
                } 
                ?>
            </div>
        </div>
        <?php
        $html = ob_get_clean();
        echo apply_filters( 'raratheme_companion_sc', $html, $args, $title, $icon, $counter, $ran );  
         
        echo '<script>
        jQuery( document ).ready(function($) {
            $(".odometer'.$ran.'").waypoint(function() {
               setTimeout(function() {
                  $(".odometer'.$ran.'").html($(".odometer'.$ran.'").data("count"));
                }, 500);
              }, {
                offset: 800,
                triggerOnce: true
            });
        });</script>';
        if(isset($comma) && $comma == 1)
        {
            echo 
            '<style>
               .odometer'.$ran.' .odometer-formatting-mark{
                display: none;
               }
            </style>';       
        }
        $html = ob_get_clean();
        echo apply_filters( 'raratheme_companion_stat_counter_widget_filter', $html, $args, $instance );
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
        $counter = ! empty( $instance['counter'] ) ? $instance['counter'] : '';
        $icon    = ! empty( $instance['icon'] ) ? $instance['icon'] : '';
        $comma   = ! empty( $instance['comma'] ) ? $instance['comma'] : '';
        $image   = ! empty( $instance['image'] ) ? $instance['image'] : '';

        ?>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />            
        </p>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'counter' ) ); ?>"><?php esc_html_e( 'Counter', 'raratheme-companion' ); ?></label>
            <input name="<?php echo esc_attr( $this->get_field_name( 'counter' ) ); ?>" type="text" id="<?php echo esc_attr( $this->get_field_id( 'counter' ) ); ?>" value="<?php echo absint( $counter ); ?>" class="small-text" />         
        </p>

        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'comma' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comma' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $comma ); ?>/>
            <label for="<?php echo esc_attr( $this->get_field_id( 'comma' ) ); ?>"><?php esc_html_e( 'Disable Comma(,) Separation', 'raratheme-companion' ); ?></label>
        </p>
        
        <p style="position: relative;">
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php esc_html_e( 'Icons', 'raratheme-companion' ); ?></label><br />
            <?php 
            $class = "";
            if( isset($icon) && $icon!='' )
            {
                $class = "yes";
            }
            ?>
            <span class="icon-receiver <?php echo $class;?>"><i class="<?php echo esc_attr( $icon ); ?>"></i></span>
            <input class="hidden-icon-input" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" type="hidden" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" value="<?php echo esc_attr( $icon ); ?>" />            
        </p>
        <?php $obj->raratheme_companion_get_icon_list(); ?>
        Or,
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
        $instance            = array();
        
        $instance['title']   = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '' ;
        $instance['counter'] = ! empty( $new_instance['counter'] ) ? absint( $new_instance['counter'] ) : '';
        $instance['icon']    = ! empty( $new_instance['icon'] ) ? esc_attr( $new_instance['icon'] ) : '';
        $instance['comma']   = ! empty( $new_instance['comma'] ) ? esc_attr( $new_instance['comma'] ) : '';
        $instance['image']   = ! empty( $new_instance['image'] ) ? esc_attr( $new_instance['image'] ) : '';

       
        return $instance;
    }
    
}  // class RaraTheme_Companion_Stat_Counter_Widget