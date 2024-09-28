<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://raratheme.com/
 * @since      1.0.0
 *
 * @package    Raratheme_Companion
 * @subpackage Raratheme_Companion/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Raratheme_Companion
 * @subpackage Raratheme_Companion/admin
 * @author     Rara Theme <raratheme@gmail.com>
 */
class Raratheme_Companion_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = RARATC_PLUGIN_VERSION;

	}

	/**
	 * Get the allowed socicon lists.
	 * @return array
	 */
	function raratheme_get_allowed_socicons() {
		return apply_filters( 'raratheme_social_icons_allowed_socicon', array( 'modelmayhem', 'mixcloud', 'drupal', 'swarm', 'istock', 'yammer', 'ello', 'stackoverflow', 'persona', 'triplej', 'houzz', 'rss', 'paypal', 'odnoklassniki', 'airbnb', 'periscope', 'outlook', 'coderwall', 'tripadvisor', 'appnet', 'goodreads', 'tripit', 'lanyrd', 'slideshare', 'buffer', 'disqus', 'vk', 'whatsapp', 'patreon', 'storehouse', 'pocket', 'mail', 'blogger', 'technorati', 'reddit', 'dribbble', 'stumbleupon', 'digg', 'envato', 'behance', 'delicious', 'deviantart', 'forrst', 'play', 'zerply', 'wikipedia', 'apple', 'flattr', 'github', 'renren', 'friendfeed', 'newsvine', 'identica', 'bebo', 'zynga', 'steam', 'xbox', 'windows', 'qq', 'douban', 'meetup', 'playstation', 'android', 'snapchat', 'twitter', 'facebook', 'google-plus', 'pinterest', 'foursquare', 'yahoo', 'skype', 'yelp', 'feedburner', 'linkedin', 'viadeo', 'xing', 'myspace', 'soundcloud', 'spotify', 'grooveshark', 'lastfm', 'youtube', 'vimeo', 'dailymotion', 'vine', 'flickr', '500px', 'instagram', 'wordpress', 'tumblr', 'twitch', '8tracks', 'amazon', 'icq', 'smugmug', 'ravelry', 'weibo', 'baidu', 'angellist', 'ebay', 'imdb', 'stayfriends', 'residentadvisor', 'google', 'yandex', 'sharethis', 'bandcamp', 'itunes', 'deezer', 'medium', 'telegram', 'openid', 'amplement', 'viber', 'zomato', 'quora', 'draugiem', 'endomodo', 'filmweb', 'stackexchange', 'wykop', 'teamspeak', 'teamviewer', 'ventrilo', 'younow', 'raidcall', 'mumble', 'bebee', 'hitbox', 'reverbnation', 'formulr', 'battlenet', 'chrome', 'diablo', 'discord', 'issuu', 'macos', 'firefox', 'heroes', 'hearthstone', 'overwatch', 'opera', 'warcraft', 'starcraft', 'keybase', 'alliance', 'livejournal', 'googlephotos', 'horde', 'etsy', 'zapier', 'google-scholar', 'researchgate' ) );
	}

	/**
	 * Get the icon from supported URL lists.
	 * @return array
	 */
	function raratheme_get_supported_url_icon() {
		return apply_filters( 'raratheme_social_icons_get_supported_url_icon', array(
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

	public function rtc_icon_list_enqueue(){
		$obj = new RaraTheme_Companion_Functions;
		$socicons = $obj->rtc_icon_list();
		echo '<div class="rtc-icons-wrap-template"><div class="rtc-icons-wrap"><ul class="rtc-icons-list">';
		foreach ($socicons as $socicon) {
			if($socicon == 'rss'){
				echo '<li><i class="fas fa-'.$socicon.'"></i></li>';
			}
			else{
				echo '<li><i class="fab fa-'.$socicon.'"></i></li>';
			}
		}
		echo'</ul></div></div>';
		echo '<style>
		.rtc-icons-wrap{
			display:none;
		}
		</style>';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Raratheme_Companion_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Raratheme_Companion_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$screen = get_current_screen();

		$post_types = array( 'rara-portfolio', 'post', 'page' );
		$page_ids   = array( 'widgets', 'customize' );

		if ( in_array( $screen->post_type, $post_types ) || in_array( $screen->id, $page_ids ) ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/raratheme-companion-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'chosen', plugin_dir_url( __FILE__ ) . 'css/chosen.min.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Raratheme_Companion_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Raratheme_Companion_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */	
		$screen = get_current_screen();

		$post_types = array( 'rara-portfolio', 'post', 'page' );
		$page_ids   = array( 'widgets', 'customize' );

		if ( in_array( $screen->post_type, $post_types ) || in_array( $screen->id, $page_ids ) ) {

			wp_enqueue_media();

			wp_enqueue_script( 'font-awesome', plugin_dir_url( __FILE__ ) . 'js/fontawesome/all.js', array( 'jquery'), '6.1.1', true );
			wp_enqueue_script( 'v4-shims', plugin_dir_url( __FILE__ ) . 'js/fontawesome/v4-shims.js', array( 'jquery'), '6.1.1', true );

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/raratheme-companion-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );

			wp_localize_script( $this->plugin_name, 'raratheme_companion_uploader', array(
				'upload' => __( 'Upload', 'raratheme-companion' ),
				'change' => __( 'Change', 'raratheme-companion' ),
				'msg'    => __( 'Please upload a valid image file.', 'raratheme-companion' )
			));
			$socicons_params = array(
				'allowed_socicons'   => $this->raratheme_get_allowed_socicons(),
				'supported_url_icon' => $this->raratheme_get_supported_url_icon(),
			);
			$confirming = array( 
						'are_you_sure'       => __( 'Are you sure?', 'raratheme-companion' ),
						);
			wp_localize_script( $this->plugin_name, 'rara_theme_toolkit_pro_uploader', array(
				'upload' => __( 'Upload', 'raratheme-companion' ),
				'change' => __( 'Change', 'raratheme-companion' ),
				'msg'    => __( 'Please upload valid image file.', 'raratheme-companion' )
			));
			wp_localize_script( $this->plugin_name, 'social_icons_admin_widgets', $socicons_params );
			wp_localize_script( $this->plugin_name, 'confirming', $confirming );
					
			wp_localize_script( $this->plugin_name, 'sociconsmsg', array(
					'msg' => __( 'Are you sure you want to delete this Social Media?', 'raratheme-companion' )));

			wp_enqueue_script( 'chosen', plugin_dir_url( __FILE__ ) . 'js/chosen.jquery.min.js', array( 'jquery' ), $this->version, true );
		}
	}

	function rrtc_client_logo_template()
	{ ?>
		<div class="rrtc-client-logo-template">
			<div class="link-image-repeat" data-id=""><span class="cross"><i class="fas fa-times"></i></span>
	            <div class="widget-upload">
	            	<label for="widget-raratheme_client_logo_widget-2-image">Upload Image</label><br>
	            	<input id="widget-raratheme_client_logo_widget-2-image" class="rara-upload link" type="hidden" name="widget-raratheme_client_logo_widget[2][image][]" value="" placeholder="No file chosen">
					<input id="upload-widget-raratheme_client_logo_widget-2-image" class="rara-upload-button button" type="button" value="Upload">
					<div class="rara-screenshot" id="widget-raratheme_client_logo_widget-2-image-image"></div>
				</div>
	                <label for="widget-raratheme_client_logo_widget-2-link">Featured Link</label> 
	                <input class="widefat featured-link" id="widget-raratheme_client_logo_widget-2-link" name="widget-raratheme_client_logo_widget[2][link][]" type="text" value="">            
        	</div>
	    </div>
	<?php
	echo '<style>.rrtc-client-logo-template{display:none;}</style>';
	}

	function rrtc_faq_template()
	{?> 
		<div class="rrtc-faq-template">
			<div class="faqs-repeat" data-id=""><span class="cross"><i class="fas fa-times"></i></span>
	            <label for="widget-raratheme_companion_faqs_widget-2-question-1"><?php _e('Question','raratheme-companion');?></label> 
	            <input class="widefat question" id="widget-raratheme_companion_faqs_widget-2-question-1" name="widget-raratheme_companion_faqs_widget[2][question][1]" type="text" value="">   
	            <label for="widget-raratheme_companion_faqs_widget-2-answer-1"><?php _e('Answer','raratheme-companion');?></label> 
	            <textarea class="answer" id="widget-raratheme_companion_faqs_widget-2-answer-1" name="widget-raratheme_companion_faqs_widget[2][answer][1]"></textarea>         
	        </div>
	    </div>
        <?php
		echo '<style>.rrtc-faq-template{display:none;}</style>';
    }

    	  /**
	* Get post types for templates
	*
	* @return array of default settings
	*/
	public function rc_get_posttype_array(){           
		$posts = array(
			'rara-portfolio' => array( 
				'singular_name'		  => __( 'Portfolio', 'raratheme-companion' ),
				'general_name'		  => __( 'Portfolios', 'raratheme-companion' ),
				'dashicon'			  => 'dashicons-portfolio',
				'taxonomy'			  => 'rara_portfolio_categories',
				'taxonomy_slug'		  => 'portfolio-category',
				'has_archive'         => false,		
				'exclude_from_search' => false,
				'show_in_nav_menus'	  => true,
				'show_in_rest'   	  => true,
				'supports' 			  => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
				'rewrite' 			  => array( 'slug' => 'portfolio' ),
				'hierarchical'		  => true
			),
		);
        // Parse incoming $args into an array and merge it with $defaults
        $posts  = apply_filters( 'rc_get_posttype_array', $posts );
        return $posts;
	}

	/**
	 * Register post types.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	function rc_register_post_types() {
		$myarray = $this->rc_get_posttype_array();
		foreach ($myarray as $key => $value) {
			$labels = array(
				'name'                  => $value['general_name'],
				'singular_name'         => $value['singular_name'],
				'menu_name'             => $value['general_name'],
				'name_admin_bar'        => $value['singular_name'],
				'archives'              => sprintf(__('%s Archives', 'raratheme-companion'), $value['singular_name']),
				'attributes'            => sprintf(__('%s Attributes', 'raratheme-companion'), $value['singular_name']),
				'parent_item_colon'     => sprintf(__('%s Parent', 'raratheme-companion'), $value['singular_name']),
				'all_items'             => sprintf(__('All %s', 'raratheme-companion'), $value['general_name']),
				'add_new_item'          => sprintf(__('Add New %s', 'raratheme-companion'), $value['singular_name']),
				'add_new'               => __( 'Add New', 'raratheme-companion' ),
				'new_item'              => sprintf(__('New %s', 'raratheme-companion'), $value['singular_name']),
				'edit_item'             => sprintf(__('Edit %s', 'raratheme-companion'), $value['singular_name']),
				'update_item'           => sprintf(__('Update %s', 'raratheme-companion'), $value['singular_name']),
				'view_item'             => sprintf(__('View %s', 'raratheme-companion'), $value['singular_name']),
				'view_items'            => sprintf(__('View %s', 'raratheme-companion'), $value['singular_name']),
				'search_items'          => sprintf(__('Search %s', 'raratheme-companion'), $value['singular_name']),
				'not_found'             => __( 'Not found', 'raratheme-companion' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'raratheme-companion' ),
				'featured_image'        => __( 'Featured Image', 'raratheme-companion' ),
				'set_featured_image'    => __( 'Set featured image', 'raratheme-companion' ),
				'remove_featured_image' => __( 'Remove featured image', 'raratheme-companion' ),
				'use_featured_image'    => __( 'Use as featured image', 'raratheme-companion' ),
				'insert_into_item'      => sprintf(__('Insert into %s', 'raratheme-companion'), $value['singular_name']),
				'uploaded_to_this_item' => sprintf(__('Uploaded to this %s', 'raratheme-companion'), $value['singular_name']),
				'items_list'            => sprintf(__('%s list', 'raratheme-companion'), $value['singular_name']),
				'items_list_navigation' => sprintf(__('%s list navigation', 'raratheme-companion'), $value['singular_name']),
				'filter_items_list'     => sprintf(__('Filter %s list', 'raratheme-companion'), $value['singular_name']),
			);
			$args = array(
				'label'                 => $value['singular_name'],
				'description'           => sprintf(__('%s Post Type', 'raratheme-companion'), $value['singular_name']),
				'labels'                => $labels,
				'supports'              => $value['supports'],
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'show_in_rest'          => $value['show_in_rest'],
				'menu_icon'             => $value['dashicon'],
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => $value['show_in_nav_menus'],
				'can_export'            => true,
				'has_archive'           => $value['has_archive'],		
				'exclude_from_search'   => $value['exclude_from_search'],
				'publicly_queryable'    => true,
				'capability_type'       => 'post',
				'rewrite'               => $value['rewrite'],
			);
			register_post_type( $key, $args );
			if ( 'yes' === get_option( 'rtc_queue_flush_rewrite_rules' ) ) {
				update_option( 'rtc_queue_flush_rewrite_rules', 'no' );
				flush_rewrite_rules();
			}
		}
	}

	/**
	 * Register a taxonomy, post_types_categories for the post types.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	function rc_create_post_type_taxonomies() {
		// Add new taxonomy, make it hierarchical
		$myarray = $this->rc_get_posttype_array();
		foreach ($myarray as $key => $value) {
			if(isset($value['taxonomy']))
			{
				$labels = array(
					'name'              => sprintf(__('%s Categories', 'raratheme-companion'), $value['singular_name']),
					'singular_name'     => sprintf(__('%s Categories', 'raratheme-companion'), $value['singular_name']),
					'search_items'      => __( 'Search Categories', 'raratheme-companion' ),
					'all_items'         => __( 'All Categories', 'raratheme-companion' ),
					'parent_item'       => __( 'Parent Categories', 'raratheme-companion' ),
					'parent_item_colon' => __( 'Parent Categories:', 'raratheme-companion' ),
					'edit_item'         => __( 'Edit Categories', 'raratheme-companion' ),
					'update_item'       => __( 'Update Categories', 'raratheme-companion' ),
					'add_new_item'      => __( 'Add New Categories', 'raratheme-companion' ),
					'new_item_name'     => __( 'New Categories Name', 'raratheme-companion' ),
					'menu_name'         => sprintf(__('%s Categories', 'raratheme-companion'), $value['singular_name']),
				);

				$args = array(
					'hierarchical'      => isset( $value['hierarchical'] ) ? $value['hierarchical']:true,
					'labels'            => $labels,
					'show_ui'           => true,
					'show_admin_column' => true,
					'show_in_nav_menus' => true,
					'show_in_rest'      => true,
					'rewrite'           => array( 'slug' => $value['taxonomy_slug'], 'hierarchical' => isset( $value['hierarchical'] ) ? $value['hierarchical']:true ),
				);
				register_taxonomy( $value['taxonomy'], array( $key ), $args );
			}
		}
	}

	/*
	  * Add a form field in the new category page
	  * @since 1.0.0
	 */
	public function add_category_image ( $taxonomy ) { ?>
		<div class="form-field term-group">
			<label for="category-image-id"><?php _e('Image', 'raratheme-companion'); ?></label>
			<input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
			<div id="category-image-wrapper"></div>
			<p>
				<input type="button" class="button button-secondary rtc_tax_media_button" id="rtc_tax_media_button" name="rtc_tax_media_button" value="<?php _e( 'Add Image', 'raratheme-companion' ); ?>" />
				<input type="button" class="button button-secondary rtc_tax_media_remove" id="rtc_tax_media_remove" name="rtc_tax_media_remove" value="<?php _e( 'Remove Image', 'raratheme-companion' ); ?>" />
			</p>
		</div>
	<?php
	}

	/*
	  * Save the form field
	  * @since 1.0.0
	 */
	public function save_category_image ( $term_id ) {
		if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
			$image = $_POST['category-image-id'];
			add_term_meta( $term_id, 'category-image-id', $image, true );
		}
	}

	/*
	  * Edit the form field
	  * @since 1.0.0
	 */
	public function update_category_image ( $term, $taxonomy='' ) { ?>
		<tr class="form-field term-group-wrap">
			<th scope="row">
				<label for="category-image-id"><?php _e( 'Image', 'raratheme-companion' ); ?></label>
			</th>
			<td>
			<?php $image_id = get_term_meta ( $term -> term_id, 'category-image-id', true ); ?>
			<input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo $image_id; ?>">
			<div id="category-image-wrapper">
				<?php if ( isset( $image_id ) && $image_id!='' ) { ?>
				<?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
				<?php } ?>
			</div>
			<p>
				<input type="button" class="button button-secondary rtc_tax_media_button" id="rtc_tax_media_button" name="rtc_tax_media_button" value="<?php _e( 'Add Image', 'raratheme-companion' ); ?>" />
				<input type="button" class="button button-secondary rtc_tax_media_remove" id="rtc_tax_media_remove" name="rtc_tax_media_remove" value="<?php _e( 'Remove Image', 'raratheme-companion' ); ?>" />
			</p>
			</td>
		</tr>
		<?php
	}

	/*
	  * Update the form field value
	  * @since 1.0.0
	  */
	public function updated_category_image ( $term_id ) {
		if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
			$image = $_POST['category-image-id'];
			update_term_meta ( $term_id, 'category-image-id', $image );
		} else {
			update_term_meta ( $term_id, 'category-image-id', '' );
		}
	}

	function custom_column_header( $columns ){
		$columns['header_name'] = 'Thumbnail'; 
		return $columns;
	}


	// To show the column value
	function custom_column_content( $value, $column_name, $tax_id ){
		$img = get_term_meta( $tax_id, 'category-image-id', false );
		$ret = '';
		if( isset( $img[0] ) && $img[0] != '' ) {
			$url = wp_get_attachment_image_url( $img[0],'thumbnail' );
			$ret = '<img src="'.esc_url( $url ).'" class="tax-img">';
		}
		return $ret;
	}

}
