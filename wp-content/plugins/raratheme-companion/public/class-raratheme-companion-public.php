<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://raratheme.com/
 * @since      1.0.0
 *
 * @package    Raratheme_Companion
 * @subpackage Raratheme_Companion/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Raratheme_Companion
 * @subpackage Raratheme_Companion/public
 * @author     Rara Theme <raratheme@gmail.com>
 */
class Raratheme_Companion_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = RARATC_PLUGIN_VERSION;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		$min_prefix    = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/raratheme-companion-public' . $min_prefix . '.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		$min_prefix    = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		
		$isotope = apply_filters('rrtc_isotope_enqueue',true);
		if($isotope == true)
		{
        	wp_enqueue_script( 'isotope-pkgd', plugin_dir_url( __FILE__ ) . 'js/isotope.pkgd.min.js', array( 'jquery' ), '3.0.5', true );
        }

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/raratheme-companion-public' . $min_prefix . '.js', array( 'jquery', 'masonry' ), $this->version, true );
		
		$all = apply_filters('rrtc_all_enqueue',true);
		if($all == true)
		{
			wp_enqueue_script( 'all', plugin_dir_url( __FILE__ ) . 'js/fontawesome/all.min.js', array( 'jquery' ), '6.1.1', true );
		}
		$shims = apply_filters('rrtc_shims_enqueue',true);
		if($shims == true)
		{
			wp_enqueue_script( 'v4-shims', plugin_dir_url( __FILE__ ) . 'js/fontawesome/v4-shims.min.js', array( 'jquery' ), '6.1.1', true );
		}
	}

	function travel_booking_pro_js_defer_files($tag)
	{
		$rrtc_assets = apply_filters('rrtc_public_assets_enqueue',true);

		if( is_admin() || $rrtc_assets == true ) return $tag;		

		$async_files = apply_filters( 'travel_booking_pro_js_async_files', array( 
			plugin_dir_url( __FILE__ ) . 'js/isotope.pkgd.min.js',
			plugin_dir_url( __FILE__ ) . 'js/owl.carousel.min.js',		
	        plugin_dir_url( __FILE__ ) . 'js/odometer.min.js',
	        plugin_dir_url( __FILE__ ) . 'js/waypoint.min.js',
	        plugin_dir_url( __FILE__ ) . 'js/raratheme-companion-public.min.js',
	        plugin_dir_url( __FILE__ ) . 'js/fontawesome/all.min.js',
	        plugin_dir_url( __FILE__ ) . 'js/fontawesome/v4-shims.min.js'	
		 ) );
		
		$add_async = false;
		foreach( $async_files as $file ){
			if( strpos( $tag, $file ) !== false ){
				$add_async = true;
				break;
			}
		}

		if( $add_async ) $tag = str_replace( ' src', ' defer="defer" src', $tag );

		return $tag;
	}
}
