<?php
/**
 * Widget Social Links
 *
 * @package Rttk
 */

// register Rtc_Social_Links widget 
function rtc_register_social_links_widget() {
    register_widget( 'Rtc_Social_Links' );
}
add_action( 'widgets_init', 'rtc_register_social_links_widget' );


//load wp sortable
function rtc_load_sortable() {    
    wp_enqueue_script( 'jquery-ui-core' );    
    wp_enqueue_script( 'jquery-ui-sortable' );    
}
add_action( 'load-widgets.php', 'rtc_load_sortable' );

//allow skype
function rtc_allowed_social_protocols( $protocols ) {
    $social_protocols = array(
        'skype'
    );
    return array_merge( $protocols, $social_protocols );    
}
add_filter( 'kses_allowed_protocols' ,'rtc_allowed_social_protocols' );

 /**
 * Adds Rtc_Social_Links widget.
 */
class Rtc_Social_Links extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        add_action( 'admin_print_footer_scripts', array( $this,'rtc_social_template' ) );
        
        parent::__construct(
            'rtc_social_links', // Base ID
            esc_html__( 'Rara: Social Media', 'raratheme-companion' ), // Name
            array( 'description' => esc_html__( 'A Social Links Widget', 'raratheme-companion' ), ) // Args
        );
    }

    /**
    * 
    * Social icon template.
    *
    * @since 1.0.0
    */
    function rtc_social_template() { ?>
        <div class="rtc-social-template">
            <li class="rtc-social-icon-wrap" data-id="{{indexes}}">
                <span class="btab-social-links-sortable-handle"></span>
                <span class="rtc-social-links-field-handle"><i class="fas fa-plus"></i></span>
                <label for="<?php echo esc_attr( $this->get_field_id( 'social_profile[{{indexes}}]' ) ); ?>"><?php esc_html_e( 'Social Icon', 'raratheme-companion' ); ?></label>
                <span class="example-text">Example: facebook</span>
                <input class="user-social-profile" placeholder="<?php _e('Search Social Icons','raratheme-companion');?>" id="<?php echo esc_attr( $this->get_field_id( 'social_profile[{{indexes}}]' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_profile[{{indexes}}]' ) ); ?>" type="text" value="" />
                <label class="link-label" for="<?php echo esc_attr( $this->get_field_id( 'social[{{indexes}}]' ) ); ?>"><?php esc_html_e( 'Link', 'raratheme-companion' ); ?></label>
                <span class="example-text">Example: http://facebook.com</span>
                <input class="rtc-social-length" name="<?php echo esc_attr( $this->get_field_name( 'social[{{indexes}}]' ) ); ?>" type="text" value="" />
                <span class="del-rtc-icon"><i class="fas fa-times"></i></span>
            </li>
        </div>
    <?php
    echo '<style>
        .rtc-social-template{
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
        if ( ! isset( $instance['social'] ) ) {
            // Display nothing if called in backend.
            return;
        }
        $title  = ! empty( $instance['title'] ) ? $instance['title'] : ''; 
        // $allowed_socicon = $this->rtc_allowed_socicons();
        echo $args['before_widget'];
        ob_start();
        if( $title ) echo $args['before_title'] . '<span>'.apply_filters( 'widget_title', $title, $instance, $this->id_base ) .'</span>'. $args['after_title'];
        if( isset( $instance['social'] ) && !empty($instance['social']) )
        { 
            $icons = $instance['social'];
            ?>
            <ul class="social-networks">
                <?php
                $arr_keys  = array_keys( $icons );
                foreach ($arr_keys as $key => $value)
                { 
                        if ( array_key_exists( $value,$instance['social'] ) )
                        { 
                            if(isset($instance['social'][$value]) && !empty($instance['social'][$value]))
                            {
                                if(!isset($instance['social_profile'][$value]) || (isset($instance['social_profile'][$value]) && $instance['social_profile'][$value] == ''))
                                {
                                    $icon = $this->rtc_get_social_icon_name( $instance['social'][$value] );
                                    $class = ($icon == 'rss') ? 'fas fa-'.$icon : 'fab fa-'.$icon;
                                }
                                elseif(isset($instance['social_profile'][$value]) && !empty($instance['social_profile'][$value]))
                                {
                                    $icon = $instance['social_profile'][$value] ;
                                    $class = ($icon == 'rss') ? 'fas fa-'.$icon : 'fab fa-'.$icon;
                                }
                                ?>
                                <li class="rtc-social-icon-wrap">
                                    <a title="<?php echo esc_attr($icon);?>" <?php if(isset($instance['target']) && $instance['target']=='1'){ echo "rel=noopener target=_blank"; } ?> href="<?php echo esc_url($instance['social'][$value]);?>">
                                        <span class="rtc-social-links-field-handle"> <i class="<?php echo esc_attr($class);?>"></i></span>
                                    </a>
                                </li>
                            <?php
                            }
                        }
                    }
                ?>
            </ul>
        <?php
        $html = ob_get_clean();
        echo apply_filters( 'raratheme_companion_sociallinks_widget_filter', $html, $args, $instance );
        echo $args['after_widget'];
        }
    }
        // /**
    //  * Get the allowed socicon lists.
    //  * @return array
    //  */
    function rtc_allowed_socicons() {
        return apply_filters( 'rtc_social_icons_allowed_socicon', array( 'modelmayhem', 'mixcloud', 'drupal', 'swarm', 'istock', 'yammer', 'ello', 'stackoverflow', 'persona', 'triplej', 'houzz', 'rss', 'paypal', 'odnoklassniki', 'airbnb', 'periscope', 'outlook', 'coderwall', 'tripadvisor', 'appnet', 'goodreads', 'tripit', 'lanyrd', 'slideshare', 'buffer', 'disqus', 'vk', 'whatsapp', 'patreon', 'storehouse', 'pocket', 'mail', 'blogger', 'technorati', 'reddit', 'dribbble', 'stumbleupon', 'digg', 'envato', 'behance', 'delicious', 'deviantart', 'forrst', 'play', 'zerply', 'wikipedia', 'apple', 'flattr', 'github', 'renren', 'friendfeed', 'newsvine', 'identica', 'bebo', 'zynga', 'steam', 'xbox', 'windows', 'qq', 'douban', 'meetup', 'playstation', 'android', 'snapchat', 'twitter', 'facebook', 'google-plus', 'pinterest', 'foursquare', 'yahoo', 'skype', 'yelp', 'feedburner', 'linkedin', 'viadeo', 'xing', 'myspace', 'soundcloud', 'spotify', 'grooveshark', 'lastfm', 'youtube', 'vimeo', 'dailymotion', 'vine', 'flickr', '500px', 'instagram', 'wordpress', 'tumblr', 'twitch', '8tracks', 'amazon', 'icq', 'smugmug', 'ravelry', 'weibo', 'baidu', 'angellist', 'ebay', 'imdb', 'stayfriends', 'residentadvisor', 'google', 'yandex', 'sharethis', 'bandcamp', 'itunes', 'deezer', 'medium', 'telegram', 'openid', 'amplement', 'viber', 'zomato', 'quora', 'draugiem', 'endomodo', 'filmweb', 'stackexchange', 'wykop', 'teamspeak', 'teamviewer', 'ventrilo', 'younow', 'raidcall', 'mumble', 'bebee', 'hitbox', 'reverbnation', 'formulr', 'battlenet', 'chrome', 'diablo', 'discord', 'issuu', 'macos', 'firefox', 'heroes', 'hearthstone', 'overwatch', 'opera', 'warcraft', 'starcraft', 'keybase', 'alliance', 'livejournal', 'googlephotos', 'horde', 'etsy', 'zapier', 'google-scholar', 'researchgate' ) );
    }

    /**
     * Get the icon from supported URL lists.
     * @return array
     */
    function rtc_get_supported_url_icon() {
        return apply_filters( 'rtc_social_icons_get_supported_url_icon', array(
            'feed'                  => 'rss',
            'ok.ru'                 => 'odnoklassniki',
            'vk.com'                => 'vk',
            'last.fm'               => 'lastfm',
            'youtu.be'              => 'youtube',
            'battle.net'            => 'battlenet',
            'blogspot.com'          => 'blogger',
            'play.google.com'       => 'play',
            'plus.google.com'       => 'google-plus',
            'photos.google.com'     => 'googlephotos',
            'chrome.google.com'     => 'chrome',
            'scholar.google.com'    => 'google-scholar',
            'feedburner.google.com' => 'mail',
        ) );
    }

    /**
     * Get the social icon name for given website url.
     *
     * @param  string $url Social site link.
     * @return string
     */
    function rtc_get_social_icon_name( $url ) {
        $icon = '';
        $obj = new RaraTheme_Companion_Functions;
        if ( $url = strtolower( $url ) ) {
            foreach ( $this->rtc_get_supported_url_icon() as $link => $icon_name ) {
                if ( strstr( $url, $link ) ) {
                    $icon = $icon_name;
                }
            }

            if ( ! $icon ) {
                foreach ( $obj->rtc_icon_list() as $icon_name ) {
                    if ( strstr( $url, $icon_name ) ) {
                        $icon = $icon_name;
                    }
                }
            }
        }

        return apply_filters( 'rtc_social_icons_get_icon_name', $icon, $url);
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        if( isset( $instance['title'] ) )
        {
            $title  = $instance['title'];       
        } 
        else{
            $title = __('Subscribe and Follow','raratheme-companion');
        }
        ?>
        <script type='text/javascript'>
            jQuery(document).ready(function($) {
                $('.rtc-sortable-links').sortable({
                    cursor: 'move',
                    update: function (event, ui) {
                        $('ul.rtc-sortable-links input').trigger('change');
                    }
                });
                $("body").on("click", ".del-rtc-icon", function() {
                    $(this).trigger("change");
                });
            });
        </script>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'raratheme-companion' ); ?></label> 
                <input class="widefat rtc-social-title-test" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Open in New Tab', 'raratheme-companion' ); ?></label> 
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" 
                <?php $j = ! empty( $instance['target'] ) ? $instance['target'] : ''; ?> value="1" <?php checked( $j, true ); ?> name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" type="checkbox" />
            </p>

        <ul class="rtc-sortable-links" id="<?php echo esc_attr( $this->get_field_id( 'rtc-social-links' ) ); ?>">
        <?php
        if(isset($instance['social']))
        {
            $icons  = $instance['social'];
            $arr_keys  = array_keys( $icons );

            if(isset($arr_keys)){
                foreach ($arr_keys as $key => $value)
                { 
                    if ( array_key_exists( $value, $instance['social'] ) )
                    { 
                        if(isset($instance['social'][$value]) && !empty($instance['social'][$value]))
                        {
                            if(!isset($instance['social_profile'][$value]) || (isset($instance['social_profile'][$value]) && $instance['social_profile'][$value] == ''))
                            {
                                $icon = $this->rtc_get_social_icon_name( $instance['social'][$value] );
                                $class = ($icon == 'rss') ? 'fas fa-'.$icon : 'fab fa-'.$icon;
                            }
                            elseif(isset($instance['social_profile'][$value]) && !empty($instance['social_profile'][$value]))
                            {
                                $icon = $instance['social_profile'][$value] ;
                                $class = ($icon == 'rss') ? 'fas fa-'.$icon : 'fab fa-'.$icon;
                            }
                            ?>
                                <li class="rtc-social-icon-wrap" data-id="<?php echo $value;?>">
                                        <span class="btab-social-links-sortable-handle"></span>
                                        <span class="rtc-social-links-field-handle"> <i class="<?php echo esc_attr($class);?>"></i></span>
                                        <label for="<?php echo esc_attr( $this->get_field_id( 'social_profile['.$value.']' ) ); ?>"><?php esc_html_e( 'Social Icon', 'raratheme-companion' ); ?></label>
                                        <span class="example-text">Example: facebook</span>
                                        <input class="user-social-profile" id="<?php echo esc_attr( $this->get_field_id( 'social_profile['.$value.']' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_profile['.$value.']' ) ); ?>" type="text" value="<?php echo esc_attr($icon);?>" />
                                        <label class="link-label" for="<?php echo esc_attr( $this->get_field_name( 'social['.$value.']' ) ) ?>"><?php esc_html_e( 'Link', 'raratheme-companion' ); ?></label>
                                        <span class="example-text">Example: http://facebook.com</span>
                                        <input class="rtc-social-length" id="<?php echo esc_attr( $this->get_field_name( 'social['.$value.']' ) ) ?>" name="<?php echo esc_attr( $this->get_field_name( 'social['.$value.']' ) ) ?>" type="text" value="<?php echo esc_url($instance['social'][$value]);?>" />
                                        <span class="del-rtc-icon"><i class="fas fa-times"></i></span>
                                    </p>
                                </li>
                            <?php
                        }
                    }
                }
            }
        }
        ?>
            <div class="rtc-social-icon-holder"></div>
        </ul>
        <input class="rtc-social-add button button-primary" type="button" value="<?php _e('Add Social Icon','raratheme-companion');?>"><br>
        <span class="rtc-option-side-note" class="example-text"><?php _e('Click on the above button to add social media icons. You can also change the order of the social icons.','raratheme-companion');?></span>
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
        $instance['title'] = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['target'] = ! empty( $new_instance['target'] ) ? esc_attr( $new_instance['target'] ) : '';
       
        if(isset($new_instance['social']) && !empty($new_instance['social']))
        {
            $arr_keys  = array_keys( $new_instance['social'] );
                    
            foreach ($arr_keys as $key => $value)
            { 
                if ( array_key_exists( $value,$new_instance['social'] ) )
                { 
                    
                    $instance['social'][$value] =  $new_instance['social'][$value];
                    
                }
            }
        }

        if(isset($new_instance['social_profile']) && !empty($new_instance['social_profile']))
        {
            $arr_keys  = array_keys( $new_instance['social_profile'] );
                    
            foreach ($arr_keys as $key => $value)
            { 
                if ( array_key_exists( $value,$new_instance['social_profile'] ) )
                { 
                    
                    $instance['social_profile'][$value] =  $new_instance['social_profile'][$value];
                    
                }
            }
        }
        // print_r($instance);
        // die;
        return $instance;            
    }
} 