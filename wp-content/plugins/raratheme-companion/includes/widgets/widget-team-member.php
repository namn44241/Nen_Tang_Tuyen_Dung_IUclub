<?php
/**
 * Team Member Widget
 *
 * @package Rara_Theme_Companion
 */

// register Rara_Theme_Companion_Team_Member_Widget widget
function rrtc_register_team_member_widget(){
    register_widget( 'Rara_Theme_Companion_Team_Member_Widget' );
}
add_action('widgets_init', 'rrtc_register_team_member_widget');
 
 /**
 * Adds Rara_Theme_Companion_Team_Member_Widget widget.
 */
class Rara_Theme_Companion_Team_Member_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'rrtc_description_widget', // Base ID
            __( 'Rara: Team Member', 'raratheme-companion' ), // Name
            array( 'description' => __( 'A Team Member Widget.', 'raratheme-companion' ), ) // Args
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
        
        $obj            = new RaraTheme_Companion_Functions();
        $name           = ! empty( $instance['name'] ) ? $instance['name'] : '' ;        
        $designation    = ! empty( $instance['designation'] ) ? $instance['designation'] : '' ;        
        $description    = ! empty( $instance['description'] ) ? $instance['description'] : '';
        $linkedin       = ! empty( $instance['linkedin'] ) ? $instance['linkedin'] : '';
        $twitter        = ! empty( $instance['twitter'] ) ? $instance['twitter'] : '';
        $facebook       = ! empty( $instance['facebook'] ) ? $instance['facebook'] : '';
        $instagram      = ! empty( $instance['instagram'] ) ? $instance['instagram'] : '';
        $youtube        = ! empty( $instance['youtube'] ) ? $instance['youtube'] : '';
        $dribbble       = ! empty( $instance['dribbble'] ) ? $instance['dribbble'] : '';
        $behence        = ! empty( $instance['behence'] ) ? $instance['behence'] : '';
        $mypublicinbox  = ! empty( $instance['mypublicinbox'] ) ? $instance['mypublicinbox'] : '';
        $image          = ! empty( $instance['image'] ) ? $instance['image'] : '';

        $target = 'rel="noopener noexternal" target="_blank"';
        if( isset($instance['target']) && $instance['target']=='1' )
        {
            $target = 'target="_self"';
        }

        echo $args['before_widget'];
        ob_start(); 
        ?>
            <div class="rtc-team-holder">
                <div class="rtc-team-inner-holder">
                    <?php
                    if( $image ){
                        $attachment_id = $image;
                        $icon_img_size = apply_filters('tmw_icon_img_size','full');
                    }
                    ?>
                    <?php if( $image ){ ?>
                        <div class="image-holder">
                            <?php echo wp_get_attachment_image( $attachment_id, $icon_img_size ) ;?>
                        </div>
                    <?php } ?>

                    <div class="text-holder">
                    <?php 
                        if( $name ) { echo '<span class="name">'.$name.'</span>'; }
                        if( isset( $designation ) && $designation !='' ){
                            echo '<span class="designation">'.esc_attr($designation).'</span>';
                        }
                        if( $description ) echo '<div class="description">'.wpautop( wp_kses_post( $description ) ).'</div>';
                    ?>                              
                    </div>
                    <ul class="social-profile">
                        <?php if( isset( $linkedin ) && $linkedin!='' ) { echo '<li><a '.$target.' href="'.esc_url($linkedin).'"><i class="fab fa-linkedin"></i></a></li>'; }?>
                        <?php if( isset( $twitter ) && $twitter!='' ) { echo '<li><a '.$target.' href="'.esc_url($twitter).'"><i class="fab fa-twitter"></i></a></li>'; }?>
                        <?php if( isset( $facebook ) && $facebook!='' ) { echo '<li><a '.$target.' href="'.esc_url($facebook).'"><i class="fab fa-facebook"></i></a></li>'; }?>
                        <?php if( isset( $instagram ) && $instagram!='' ) { echo '<li><a '.$target.' href="'.esc_url($instagram).'"><i class="fab fa-instagram"></i></a></li>'; }?>
                        <?php if( isset( $youtube ) && $youtube!='' ) { echo '<li><a '.$target.' href="'.esc_url($youtube).'"><i class="fab fa-youtube"></i></a></li>'; }?>
                        <?php if( isset( $dribbble ) && $dribbble!='' ) { echo '<li><a '.$target.' href="'.esc_url($dribbble).'"><i class="fab fa-dribbble"></i></a></li>'; }?>
                        <?php if( isset( $behence ) && $behence!='' ) { echo '<li><a '.$target.' href="'.esc_url($behence).'"><i class="fab fa-behance"></i></a></li>'; }?>
                        <?php if( isset( $mypublicinbox ) && $mypublicinbox!='' ) { echo '<li><a '.$target.' href="'.esc_url($mypublicinbox).'"><svg width="61" height="40" viewBox="0 0 61 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M60.9555 8.27135C60.9555 4.12178 57.5648 0.757815 53.3819 0.757815C52.2947 0.757815 51.262 0.986786 50.3274 1.39614L50.326 1.3951L50.2882 1.41373C50.0932 1.50044 49.9022 1.59428 49.7164 1.69649L4.42543 24.0873C-2.49209 27.4032 -0.35845 39.214 7.0776 39.3649H54.0523C57.8649 39.3649 60.9557 35.7945 60.9557 31.3902V8.64431C60.9557 8.58876 60.9538 8.53392 60.9503 8.4796C60.952 8.41012 60.9555 8.34117 60.9555 8.27135Z" fill="url(#paint0_linear_1_12)"/><path d="M57.4931 27.1872L57.4932 27.1862L56.5243 26.6382C56.4778 26.6098 11.9592 1.99761 11.9592 1.99761C11.6312 1.78066 11.2847 1.58949 10.9234 1.4246L10.9089 1.41659L10.9068 1.41728C9.9492 0.983205 8.8855 0.739265 7.7639 0.739265C3.5812 0.739265 0.19043 4.10322 0.19043 8.25279C0.19043 8.31234 0.19356 8.37102 0.19496 8.43004C0.19269 8.50091 0.19043 8.57177 0.19043 8.6442V31.3901C0.19043 31.4733 0.19374 31.5555 0.19583 31.638C0.19374 31.709 0.19043 31.7797 0.19043 31.8511C0.19043 33.4537 0.69781 34.938 1.55969 36.1577C2.81839 38.1044 4.82875 39.3646 7.0938 39.3646H53.6839C53.6994 39.3646 53.7147 39.3622 53.7302 39.3612C53.7769 39.362 53.8234 39.3646 53.8702 39.3646C57.5554 39.3646 60.5429 36.4008 60.5429 32.7449C60.5426 30.4145 59.3277 28.3667 57.4931 27.1872Z" fill="url(#paint1_linear_1_12)"/><path d="M33.8135 9.55861L29.4905 11.6957L57.2887 27.0611L33.8135 9.55861Z" fill="url(#paint2_linear_1_12)"/><path d="M2.82788 37.9351C2.82788 37.9351 4.36987 39.3647 7.0713 39.3647H53.8477C53.8477 39.3647 60.5204 38.5283 60.5204 32.745C60.5204 26.9616 51.7208 23.9814 51.7208 23.9814L2.82788 37.9351Z" fill="url(#paint3_linear_1_12)"/><defs><linearGradient id="paint0_linear_1_12" x1="20.8082" y1="48.2405" x2="50.0304" y2="-2.37517" gradientUnits="userSpaceOnUse"><stop offset="0.4081" stop-color="#E6E6E6"/><stop offset="0.9988" stop-color="#EFEFEF"/></linearGradient><linearGradient id="paint1_linear_1_12" x1="16.0269" y1="45.4031" x2="34.2461" y2="13.6309" gradientUnits="userSpaceOnUse"><stop stop-color="#DADADA"/><stop offset="0.2009" stop-color="#E6E6E6"/><stop offset="1" stop-color="#D8D8D8"/></linearGradient><linearGradient id="paint2_linear_1_12" x1="0.19043" y1="20.0518" x2="60.9557" y2="20.0518" gradientUnits="userSpaceOnUse"><stop offset="0.3109" stop-color="#E5E5E5"/><stop offset="0.9253" stop-color="#DEDEDE"/></linearGradient><linearGradient id="paint3_linear_1_12" x1="2.82788" y1="31.6731" x2="60.5204" y2="31.6731" gradientUnits="userSpaceOnUse"><stop offset="7.88513e-07" stop-color="white"/><stop offset="0.3517" stop-color="#EFEFEF"/><stop offset="1" stop-color="#D9D9D9"/></linearGradient></defs></svg></a></li>'; }?>
                    </ul>
                </div>
            </div>

            <div class="rtc-team-holder-modal">
                <div class="rtc-team-inner-holder-modal">
                    <?php
                    $obj            = new RaraTheme_Companion_Functions();
                    $name           = ! empty( $instance['name'] ) ? $instance['name'] : '' ;        
                    $designation    = ! empty( $instance['designation'] ) ? $instance['designation'] : '' ;        
                    $description    = ! empty( $instance['description'] ) ? $instance['description'] : '';
                    $linkedin       = ! empty( $instance['linkedin'] ) ? $instance['linkedin'] : '';
                    $twitter        = ! empty( $instance['twitter'] ) ? $instance['twitter'] : '';
                    $facebook       = ! empty( $instance['facebook'] ) ? $instance['facebook'] : '';
                    $instagram      = ! empty( $instance['instagram'] ) ? $instance['instagram'] : '';
                    $youtube        = ! empty( $instance['youtube'] ) ? $instance['youtube'] : '';
                    $dribbble       = ! empty( $instance['dribbble'] ) ? $instance['dribbble'] : '';
                    $behence        = ! empty( $instance['behence'] ) ? $instance['behence'] : '';
                    $mypublicinbox  = ! empty( $instance['mypublicinbox'] ) ? $instance['mypublicinbox'] : '';
                    $image          = ! empty( $instance['image'] ) ? $instance['image'] : '';

                    if( $image ){
                        /** Added to work for demo content compatible */
                        $theme_slug = apply_filters('theme_slug','raratheme-companion');
                        $cta_img_size = apply_filters('rrtc_cl_img_size','full');
                    }
                    ?>
                    <?php if( $image ){ ?>
                        <div class="image-holder">
                            <?php echo wp_get_attachment_image( $image, $cta_img_size ) ;?>
                        </div>
                    <?php } ?>

                    <div class="text-holder">
                    <?php 
                        if( $name ) { echo '<span class="name">'.$name.'</span>'; }
                        if( isset( $designation ) && $designation!='' ){
                            echo '<span class="designation">'.esc_attr($designation).'</span>';
                        }
                        if( $description ) echo '<div class="description">'.wpautop( wp_kses_post( $description ) ).'</div>';
                    ?>                              
                    </div>
                    <ul class="social-profile">
                        <?php if( isset( $linkedin ) && $linkedin!='' ) { echo '<li><a '.$target.' href="'.esc_url($linkedin).'"><i class="fab fa-linkedin"></i></a></li>'; }?>
                        <?php if( isset( $twitter ) && $twitter!='' ) { echo '<li><a '.$target.' href="'.esc_url($twitter).'"><i class="fab fa-twitter"></i></a></li>'; }?>
                        <?php if( isset( $facebook ) && $facebook!='' ) { echo '<li><a '.$target.' href="'.esc_url($facebook).'"><i class="fab fa-facebook"></i></a></li>'; }?>
                        <?php if( isset( $instagram ) && $instagram!='' ) { echo '<li><a '.$target.' href="'.esc_url($instagram).'"><i class="fab fa-instagram"></i></a></li>'; }?>
                        <?php if( isset( $youtube ) && $youtube!='' ) { echo '<li><a '.$target.' href="'.esc_url($youtube).'"><i class="fab fa-youtube"></i></a></li>'; }?>
                        <?php if( isset( $dribbble ) && $dribbble!='' ) { echo '<li><a '.$target.' href="'.esc_url($dribbble).'"><i class="fab fa-dribbble"></i></a></li>'; }?>
                        <?php if( isset( $behence ) && $behence!='' ) { echo '<li><a '.$target.' href="'.esc_url($behence).'"><i class="fab fa-behance"></i></a></li>'; }?>
                        <?php if( isset( $mypublicinbox ) && $mypublicinbox!='' ) { echo '<li><a '.$target.' href="'.esc_url($mypublicinbox).'"><svg width="1em" height="1em" style="vertical-align:top" viewBox="0 0 61 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M60.9555 8.27135C60.9555 4.12178 57.5648 0.757815 53.3819 0.757815C52.2947 0.757815 51.262 0.986786 50.3274 1.39614L50.326 1.3951L50.2882 1.41373C50.0932 1.50044 49.9022 1.59428 49.7164 1.69649L4.42543 24.0873C-2.49209 27.4032 -0.35845 39.214 7.0776 39.3649H54.0523C57.8649 39.3649 60.9557 35.7945 60.9557 31.3902V8.64431C60.9557 8.58876 60.9538 8.53392 60.9503 8.4796C60.952 8.41012 60.9555 8.34117 60.9555 8.27135Z" fill="url(#custom-1)"/><path d="M57.4931 27.1872L57.4932 27.1862L56.5243 26.6382C56.4778 26.6098 11.9592 1.99761 11.9592 1.99761C11.6312 1.78066 11.2847 1.58949 10.9234 1.4246L10.9089 1.41659L10.9068 1.41728C9.9492 0.983205 8.8855 0.739265 7.7639 0.739265C3.5812 0.739265 0.19043 4.10322 0.19043 8.25279C0.19043 8.31234 0.19356 8.37102 0.19496 8.43004C0.19269 8.50091 0.19043 8.57177 0.19043 8.6442V31.3901C0.19043 31.4733 0.19374 31.5555 0.19583 31.638C0.19374 31.709 0.19043 31.7797 0.19043 31.8511C0.19043 33.4537 0.69781 34.938 1.55969 36.1577C2.81839 38.1044 4.82875 39.3646 7.0938 39.3646H53.6839C53.6994 39.3646 53.7147 39.3622 53.7302 39.3612C53.7769 39.362 53.8234 39.3646 53.8702 39.3646C57.5554 39.3646 60.5429 36.4008 60.5429 32.7449C60.5426 30.4145 59.3277 28.3667 57.4931 27.1872Z" fill="url(#custom-2)"/><path d="M33.8135 9.55861L29.4905 11.6957L57.2887 27.0611L33.8135 9.55861Z" fill="url(#custom-3)"/><path d="M2.82788 37.9351C2.82788 37.9351 4.36987 39.3647 7.0713 39.3647H53.8477C53.8477 39.3647 60.5204 38.5283 60.5204 32.745C60.5204 26.9616 51.7208 23.9814 51.7208 23.9814L2.82788 37.9351Z" fill="url(#custom-4)"/><defs><linearGradient id="custom-1" x1="20.8082" y1="48.2405" x2="50.0304" y2="-2.37517" gradientUnits="userSpaceOnUse"><stop offset="0.4081" stop-color="#E6E6E6"/><stop offset="0.9988" stop-color="#EFEFEF"/></linearGradient><linearGradient id="custom-2" x1="16.0269" y1="45.4031" x2="34.2461" y2="13.6309" gradientUnits="userSpaceOnUse"><stop stop-color="#DADADA"/><stop offset="0.2009" stop-color="#E6E6E6"/><stop offset="1" stop-color="#D8D8D8"/></linearGradient><linearGradient id="custom-3" x1="0.19043" y1="20.0518" x2="60.9557" y2="20.0518" gradientUnits="userSpaceOnUse"><stop offset="0.3109" stop-color="#E5E5E5"/><stop offset="0.9253" stop-color="#DEDEDE"/></linearGradient><linearGradient id="custom-4" x1="2.82788" y1="31.6731" x2="60.5204" y2="31.6731" gradientUnits="userSpaceOnUse"><stop offset="7.88513e-07" stop-color="white"/><stop offset="0.3517" stop-color="#EFEFEF"/><stop offset="1" stop-color="#D9D9D9"/></linearGradient></defs></svg></a></li>'; }?>
                    </ul>
                </div>
                <a href="#" class="close_popup"><?php _e('closepopup','raratheme-companion');?></a>
            </div>
        <?php
        echo 
        "
        <style>
            .rtc-team-holder-modal{
                display: none;
            }
        </style>
        <script>
            jQuery(document).ready(function($) {
              $('.rtc-team-holder').on('click', function(){
                $(this).siblings('.rtc-team-holder-modal').addClass('show');
                $(this).siblings('.rtc-team-holder-modal').css('display', 'block');
              });

              $('.close_popup').on('click', function(){
                $(this).parent('.rtc-team-holder-modal').removeClass('show');
                $(this).parent().css('display', 'none');
                return false;
              }); 
            });
        </script>";
        $html = ob_get_clean();
        echo apply_filters( 'raratheme_companion_team_member_widget_filter', $html, $args, $instance );    
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
        
        $obj            = new RaraTheme_Companion_Functions();
        $name           = ! empty( $instance['name'] ) ? $instance['name'] : '' ;        
        $description    = ! empty( $instance['description'] ) ? $instance['description'] : '';
        $target         = ! empty( $instance['target'] ) ? $instance['target'] : '';
        $linkedin       = ! empty( $instance['linkedin'] ) ? $instance['linkedin'] : '';
        $twitter        = ! empty( $instance['twitter'] ) ? $instance['twitter'] : '';
        $facebook       = ! empty( $instance['facebook'] ) ? $instance['facebook'] : '';
        $instagram      = ! empty( $instance['instagram'] ) ? $instance['instagram'] : '';
        $youtube        = ! empty( $instance['youtube'] ) ? $instance['youtube'] : '';
        $dribbble       = ! empty( $instance['dribbble'] ) ? $instance['dribbble'] : '';
        $behence        = ! empty( $instance['behence'] ) ? $instance['behence'] : '';
        $mypublicinbox  = ! empty( $instance['mypublicinbox'] ) ? $instance['mypublicinbox'] : '';
        $designation    = ! empty( $instance['designation'] ) ? $instance['designation'] : '';
        $image          = ! empty( $instance['image'] ) ? $instance['image'] : '';
        ?>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php esc_html_e( 'Name', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>" />            
        </p>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'designation' ) ); ?>"><?php esc_html_e( 'Designation', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'designation' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'designation' ) ); ?>" type="text" value="<?php echo esc_attr( $designation ); ?>" />            
        </p>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description', 'raratheme-companion' ); ?></label>
            <textarea name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" rows="5" cols="50"><?php print $description; ?></textarea>
        </p>
        
        <?php $obj->raratheme_companion_get_image_field( $this->get_field_id( 'image' ), $this->get_field_name( 'image' ), $image, __( 'Upload Photo', 'raratheme-companion' ) ); ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Open in Same Tab', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" type="checkbox" value="1" <?php echo checked($target,1);?> /> 
        </p>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>"><?php esc_html_e( 'LinkedIn Profile', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'linkedin' ) ); ?>" type="text" value="<?php echo esc_url( $linkedin ); ?>" />            
        </p>
        
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>"><?php esc_html_e( 'Twitter Profile', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" type="text" value="<?php echo esc_url( $twitter ); ?>" />            
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>"><?php esc_html_e( 'Facebook Profile', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" type="text" value="<?php echo esc_url( $facebook ); ?>" />            
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>"><?php esc_html_e( 'Instagram Profile', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" type="text" value="<?php echo esc_url( $instagram ); ?>" />            
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>"><?php esc_html_e( 'YouTube Profile', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" type="text" value="<?php echo esc_url( $youtube ); ?>" />            
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'dribbble' ) ); ?>"><?php esc_html_e( 'Dribbble Profile', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'dribbble' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dribbble' ) ); ?>" type="text" value="<?php echo esc_url( $dribbble ); ?>" />            
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'behence' ) ); ?>"><?php esc_html_e( 'Behance Profile', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'behence' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'behence' ) ); ?>" type="text" value="<?php echo esc_url( $behence ); ?>" />            
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'mypublicinbox' ) ); ?>"><?php esc_html_e( 'MyPublicInbox Profile', 'raratheme-companion' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'mypublicinbox' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'mypublicinbox' ) ); ?>" type="text" value="<?php echo esc_url( $mypublicinbox ); ?>" />            
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
        $instance                   = array();        
        $instance['name']           = ! empty( $new_instance['name'] ) ? sanitize_text_field( $new_instance['name'] ) : '' ;
        $instance['description']    = ! empty( $new_instance['description'] ) ? wp_kses_post( $new_instance['description'] ) : '';
        $instance['designation']    = ! empty( $new_instance['designation'] ) ? esc_attr( $new_instance['designation'] ) : '';
        $instance['target']         = ! empty( $new_instance['target'] ) ? esc_attr( $new_instance['target'] ) : '';
        $instance['linkedin']       = ! empty( $new_instance['linkedin'] ) ? $new_instance['linkedin'] : '';
        $instance['twitter']        = ! empty( $new_instance['twitter'] ) ? $new_instance['twitter'] : '';
        $instance['facebook']       = ! empty( $new_instance['facebook'] ) ? $new_instance['facebook'] : '';
        $instance['instagram']      = ! empty( $new_instance['instagram'] ) ? $new_instance['instagram'] : '';
        $instance['youtube']        = ! empty( $new_instance['youtube'] ) ? $new_instance['youtube'] : '';
        $instance['dribbble']       = ! empty( $new_instance['dribbble'] ) ? $new_instance['dribbble'] : '';
        $instance['behence']        = ! empty( $new_instance['behence'] ) ? $new_instance['behence'] : '';
        $instance['mypublicinbox']  = ! empty( $new_instance['mypublicinbox'] ) ? $new_instance['mypublicinbox'] : '';
        $instance['image']          = ! empty( $new_instance['image'] ) ? esc_attr( $new_instance['image'] ) : '';

        return $instance;
    }
    
}  // class Rara_Theme_Companion_Team_Member_Widget / class Rara_Theme_Companion_Team_Member_Widget 