<?php
/**
 * Stat Counter Widget
 *
 * @package Rara_Theme_Companion
 */

// register Rara_Theme_Companion_FAQs_Widget widget
function rara_theme_faqs_widget(){
    register_widget( 'Rara_Theme_Companion_FAQs_Widget' );
}
add_action('widgets_init', 'rara_theme_faqs_widget');
 
 /**
 * Adds Rara_Theme_Companion_FAQs_Widget widget.
 */
class Rara_Theme_Companion_FAQs_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'raratheme_companion_faqs_widget', // Base ID
            __( 'Rara: FAQs', 'raratheme-companion' ), // Name
            array( 'description' => __( 'A Widget for FAQs.', 'raratheme-companion' ), ) // Args
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
        
        $toggle   = ! empty( $instance['toggle'] ) ? $instance['toggle'] : '' ;     

        echo $args['before_widget']; 
        ob_start();
        ?>
        <div class="col">
            <div class="raratheme-faq-holder">
                <ul class="accordion">
                    <?php 
                    if( $toggle ) { ?>
                        <a href="javascript:void(0);" class="expand-faq">
                            <i class="fas fa-toggle-off" aria-hidden="true"></i>
                            <?php
                                _e('Expand/Close', 'raratheme-companion'); ?>
                        </a>
                    <?php
                    }
                    if(isset($instance['question']))
                    {
                        foreach ($instance['question'] as $key => $value) { ?>
                             <li><a class="toggle" href="javascript:void(0);"><?php echo html_entity_decode($value);?></a> 
                                <div class="inner">
                                    <?php echo wpautop ( wp_kses_post ($instance['answer'][$key] ) );?>         
                                </div>
                            </li>
                        <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <?php
        $html = ob_get_clean();
        echo apply_filters( 'raratheme_companion_faqs_widget_filter', $html, $args, $instance );
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
        $toggle   = ! empty( $instance['toggle'] ) ? $instance['toggle'] : '' ;        
        $question   = ! empty( $instance['question'] ) ? $instance['question'] : '' ;        
        $answer   = ! empty( $instance['answer'] ) ? $instance['answer'] : '' ;

        ?>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'toggle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'toggle' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $toggle ); ?>/>
            <label for="<?php echo esc_attr( $this->get_field_id( 'toggle' ) ); ?>"><?php esc_html_e( 'Enable FAQs Toggle', 'raratheme-companion' ); ?></label>
        </p>
        <div class="widget-client-faq-repeater" id="<?php echo esc_attr( $this->get_field_id( 'rarathemecompanion-faq-repeater' ) ); ?>">
            <?php 
            if( !isset( $question ) || $question=='' )
            { ?>
                <div class="faqs-repeat" data-id="1"><span class="cross"><i class="fas fa-times"></i></span>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'question[1]' ) ); ?>"><?php esc_html_e( 'Question', 'raratheme-companion' ); ?></label> 
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'question[1]' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'question[1]' ) ); ?>" type="text" value="" />   
                    <label for="<?php echo esc_attr( $this->get_field_id( 'answer[1]' ) ); ?>"><?php esc_html_e( 'Answer', 'raratheme-companion' ); ?></label> 
                    <textarea id="<?php echo esc_attr( $this->get_field_id( 'answer[1]' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'answer[1]' ) ); ?>"></textarea>         
                </div>
            <?php
            }
            if( isset( $instance['question'] ) && $instance['question']!='' )
            {
                $arr = $instance['question'];
                $max = max(array_keys($arr)); 
                for ($i=1; $i <= $max; $i++) { 
                    if( array_key_exists($i, $arr) )
                    { ?>
                        <div class="faqs-repeat" data-id="<?php echo $i; ?>"><span class="cross"><i class="fas fa-times"></i></span>
                        <label for="<?php echo esc_attr( $this->get_field_id( 'question['.$i.']' ) ); ?>"><?php esc_html_e( 'Question', 'raratheme-companion' ); ?></label> 
                        <input class="widefat demo" id="<?php echo esc_attr( $this->get_field_id( 'question['.$i.']' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'question['.$i.']' ) ); ?>" type="text" value="<?php echo esc_attr($instance['question'][$i]);?>" />   
                        <label for="<?php echo esc_attr( $this->get_field_id( 'answer['.$i.']' ) ); ?>"><?php esc_html_e( 'Answer', 'raratheme-companion' ); ?></label> 
                        <textarea class="answer" id="<?php echo esc_attr( $this->get_field_id( 'answer['.$i.']' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'answer['.$i.']' ) ); ?>"><?php echo esc_attr($instance['answer'][$i]) ?></textarea>         
                        </div>
                <?php
                    }
                }
            }
            ?>
        <span class="cl-faq-holder"></span>
        </div>
        <button id="add-faq" class="button"><?php _e('Add FAQs','raratheme-companion');?></button>
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
        $instance['toggle']   = ! empty( $new_instance['toggle'] ) ? sanitize_text_field( $new_instance['toggle'] ) : '' ;
        if(isset($new_instance['question']))
        {
            foreach ( $new_instance['question'] as $key => $value ) {
                $instance['question'][$key]   = $value;
            }
        }

        if(isset($new_instance['answer']))
        {
            foreach ( $new_instance['answer'] as $key => $value ) {
                $instance['answer'][$key]    = $value;
            }
        }

        return $instance;
    }
    
}  // class Rara_Theme_Companion_FAQs_Widget