<?php
/**
 * Twitter Feeds widget
 *
 * @package Rttk_Pro
 */
 
 // register Rtc_Pro_Twitter_Feeds_Widget widget.
function rtc_pro_register_twitter_feeds_widget(){
    register_widget( 'Rtc_Pro_Twitter_Feeds_Widget' );
}
add_action('widgets_init', 'rtc_pro_register_twitter_feeds_widget');

/**
 * Adds Rtc_Pro_Twitter_Feeds_Widget widget.
 */
class Rtc_Pro_Twitter_Feeds_Widget extends WP_Widget {
    
    /**
    * Get themes for widget
    *
    * @return array of themes
    */
    public function rtc_get_theme_options() {

        $themes = array(
            'light' => __('Light', 'raratheme-companion'),
            'dark'  => __('Dark', 'raratheme-companion'),
            );
        $themes = apply_filters( 'rtc_get_theme_options', $themes );
        return $themes;
    }

    public function __construct() {
        add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );
        add_action( 'load-widgets.php', array( $this, 'rtc_load_colorpicker' ) );
        parent::__construct(
            'rtc_pro_twitter_feeds_widget', // Base ID
            __( 'RARA: Latest Tweets', 'raratheme-companion' ), // Name
            array( 'description' => __( 'A widget that shows latest tweets', 'raratheme-companion' ), ) // Args          
        );
    }

    //load wp color picker
    function rtc_load_colorpicker() {    
        wp_enqueue_style( 'wp-color-picker' );        
        wp_enqueue_script( 'wp-color-picker' );    
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
		
        extract( $args );
        if( !empty( $instance['title'] ) ) $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
          
		echo $before_widget;
        ob_start();
          				
		if ( ! empty( $title ) ) echo $before_title . $title . $after_title;

        if(! empty($instance['username'])): ?>

            <div class="rttk-tw-feed">
            <a class="twitter-timeline" href="https://twitter.com/<?php echo esc_attr($instance['username']);?>" data-theme="<?php echo esc_attr($instance['theme']);?>" data-link-color="<?php echo esc_attr( $instance['widget-link'] ); ?>" data-border-color="<?php echo esc_attr( $instance['widget-bg'] ); ?>" border-radius="1" data-chrome="footer borders" data-screen-name="<?php echo esc_attr($instance['username']);?>" data-show-replies="True" data-tweet-limit="<?php echo esc_attr( $instance['tweetstoshow'] ); ?>" width="<?php echo esc_attr( $instance['width'] ); ?>">@Twitter Feed</a>
            <?php
            echo '<script>
            jQuery(document).ready(function($) {
                ! function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0],
                        p = "https";
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = p + "://platform.twitter.com/widgets.js";
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, "script", "twitter-wjs");
            });
            </script>';
            ?>
            </div>						
	   <?php
       endif;
       $html = ob_get_clean();
        echo apply_filters( 'raratheme_companion_twitter_feeds_widget_filter', $html, $args, $instance );	
		echo $after_widget;
    }
    
    public function print_scripts() {
        ?>
        <script>
            ( function( $ ){

                function initColorPicker( widget ) {
                    widget.find( '.rtc-widget-color-field' ).wpColorPicker( {
                        change: _.throttle( function() { // For Customizer
                            $(this).trigger( 'change' );
                        }, 3000 )
                    });
                }

                function onFormUpdate( event, widget ) {
                    initColorPicker( widget );
                }

                $( document ).on( 'widget-added widget-updated', onFormUpdate );

                $( document ).ready( function() {
                    $( '#widgets-right .widget:has(.rtc-widget-color-field)' ).each( function () {
                        initColorPicker( $( this ) );
                    } );
                } );

            }( jQuery ) );

        </script>
        <?php
    }
    
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ){
		$html = '';
        $defaults = array( 
            'title'             => '', 
            'widget-bg'         => '#ccc00333', 
            'widget-link'       => '#00000000', 
            'username'          => '', 
            'tweetstoshow'      => 3,
            'theme'             => 'light',
            'width'             => 400 
        );
		
        $instance = wp_parse_args( (array) $instance, $defaults );
    ?>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'raratheme-companion' ); ?></label>
        <input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
    </p>
    <p>    
        <label for="<?php echo esc_attr( $this->get_field_id( 'theme' ) ); ?>"><?php esc_html_e( 'Theme', 'raratheme-companion' ); ?></label>
        <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'theme' ) ); ?>" data-placeholder="<?php esc_attr_e( 'Choose a theme&hellip;', 'raratheme-companion' ); ?>">
            <option value=""><?php _e( 'Choose a theme&hellip;', 'raratheme-companion' ); ?></option>
            <?php
            $themes = $this->rtc_get_theme_options();
            $selected_theme = $instance['theme'];
            foreach ( $themes as $key => $val ) {
                echo '<option value="' .( !empty($key)?esc_attr( $key ):"Please select" ). '" ' . selected( $selected_theme, $key, false ) . '>' . esc_html($val) . '</option>';
            }
            ?>
        </select>
    </p>
    <div class="twitter-widget-color-fields">
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Twitter Username', 'raratheme-companion' ); ?></label>
            <input type="text" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" value="<?php echo esc_attr( $instance['username'] ); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'widget-bg' ) ); ?>"><?php esc_html_e( 'Border Color', 'raratheme-companion' ); ?></label>
            <input type="text" class="rtc-widget-color-field" name="<?php echo esc_attr( $this->get_field_name( 'widget-bg' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'widget-bg' ) ); ?>" value="<?php echo esc_attr( $instance['widget-bg'] ); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'widget-link' ) ); ?>"><?php esc_html_e( 'Link Color', 'raratheme-companion' ); ?></label>
            <input type="text" class="rtc-widget-color-field" name="<?php echo esc_attr( $this->get_field_name( 'widget-link' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'widget-link' ) ); ?>" value="<?php echo esc_attr( $instance['widget-link'] ); ?>" class="widefat" />
        </p>
    </div>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php esc_html_e( 'Widget Width', 'raratheme-companion' ); ?></label>
        <input type="text" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" value="<?php echo esc_attr( $instance['width'] ); ?>" class="widefat" />
    </p>
    
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'tweetstoshow' ) ); ?>"><?php esc_html_e( 'Number of tweets', 'raratheme-companion' ); ?></label>
        <input type="number" min="1" step="1" name="<?php echo esc_attr( $this->get_field_name( 'tweetstoshow' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" value="<?php echo esc_attr( $instance['tweetstoshow'] ); ?>" class="widefat" />
    </p>
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
		$instance['title']            = strip_tags( $new_instance['title'] );
        $instance['username']         = strip_tags( $new_instance['username'] );
		$instance['widget-bg']        = isset($new_instance['widget-bg']) ? esc_attr($new_instance['widget-bg']):'#ccc00333';
        $instance['widget-link']      = isset($new_instance['widget-link']) ? esc_attr($new_instance['widget-link']):'#00000000';
        $instance['width']            = ! empty( $new_instance['width'] ) ? absint( $new_instance['width'] ) : 400;
		$instance['tweetstoshow']     = ! empty( $new_instance['tweetstoshow'] ) ? absint( $new_instance['tweetstoshow'] ) : 3;
        $instance['theme']            =  isset($new_instance['theme']) ? esc_attr($new_instance['theme']):'light';
		
        return $instance;
	}	
} // class Rtc_Pro_Twitter_Feeds_Widget/ class Rtc_Pro_Twitter_Feeds_Widget/ class Rtc_Pro_Twitter_Feeds_Widget/ class Rtc_Pro_Twitter_Feeds_Widget