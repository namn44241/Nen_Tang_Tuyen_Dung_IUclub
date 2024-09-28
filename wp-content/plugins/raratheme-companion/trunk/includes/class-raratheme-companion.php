<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://raratheme.com/
 * @since      1.0.0
 *
 * @package    Raratheme_Companion
 * @subpackage Raratheme_Companion/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Raratheme_Companion
 * @subpackage Raratheme_Companion/includes
 * @author     Rara Theme <raratheme@gmail.com>
 */
class Raratheme_Companion {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Raratheme_Companion_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'raratheme-companion';
		$this->version = RARATC_PLUGIN_VERSION;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Raratheme_Companion_Loader. Orchestrates the hooks of the plugin.
	 * - Raratheme_Companion_i18n. Defines internationalization functionality.
	 * - Raratheme_Companion_Admin. Defines all hooks for the admin area.
	 * - Raratheme_Companion_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-raratheme-companion-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-raratheme-companion-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-raratheme-companion-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-raratheme-companion-public.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-raratheme-companion-templates.php';

		/**
		 * The class responsible for defining all the required functions.
		 */
		include RARATC_BASE_PATH . '/includes/class-raratheme-companion-functions.php';

		/**
		 * Call-to-action widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-cta.php';

		/**
		 * Contact widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-contact.php';

		/**
		 * Featured widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-featured.php';

		/**
		 * Icon text widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-icon-text.php';

		/**
		 * Image widget
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-image.php';

		/**
		 * Stat-counter widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-stat-counter.php';

		/**
		 * Popular post widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-popular-post.php';

		/**
		 * Recent post widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-recent-post.php';

		/**
		 * Social Icon widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-social-links.php';

		/**
		 * Social Icon widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-testimonial.php';

		/**
		 * Social Icon widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-team-member.php';

		/**
		 * Social Icon widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-client-logo.php';

		/**
		 * Social Icon widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-faqs.php';

		/**
		 * Featured Page widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-featured-page.php';

		/**
		 * Twitter feeds widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-twitter-feeds.php';

		/**
		 * Twitter feeds widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-posts-category-slider.php';

		/**
		 * Advertisement widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-advertisement.php';

		/**
		 * Author Bio widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-author-bio.php';

		/**
		 * Custom Categories widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-custom-categories.php';

		/**
		 * Facebook Page widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-facebook-page.php';

		/**
		 * Snapchat widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-snapchat.php';

		/**
		 * Pinterest widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-pinterest.php';

		/**
		 * Image Text widget.
		 */
		require_once RARATC_BASE_PATH . '/includes/widgets/widget-image-text.php';
		
		$this->loader = new Raratheme_Companion_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Raratheme_Companion_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Raratheme_Companion_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Raratheme_Companion_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'elementor/editor/before_enqueue_scripts', $plugin_admin, 'enqueue_scripts' ); //hooked for elementor
		$this->loader->add_action( 'admin_print_footer_scripts', $plugin_admin, 'rrtc_client_logo_template' );
		$this->loader->add_action( 'admin_print_footer_scripts', $plugin_admin, 'rrtc_faq_template' );
		$this->loader->add_action( 'init',  $plugin_admin, 'rc_register_post_types' );
		$this->loader->add_action( 'init',  $plugin_admin,'rc_create_post_type_taxonomies', 0 );
		$this->loader->add_action( 'admin_footer',  $plugin_admin,'rrtc_client_logo_template', 0 );
		$this->loader->add_action( 'admin_print_footer_scripts', $plugin_admin, 'rtc_icon_list_enqueue' );
		$this->loader->add_action( 'category_add_form_fields', $plugin_admin, 'add_category_image' );
	    $this->loader->add_action( 'created_category', $plugin_admin, 'save_category_image' );
	    $this->loader->add_action( 'category_edit_form_fields', $plugin_admin, 'update_category_image' );
		$this->loader->add_action( 'edited_category', $plugin_admin, 'updated_category_image' );
		$this->loader->add_filter( 'manage_edit-category_columns', $plugin_admin, 'custom_column_header', 10);
		$this->loader->add_action( 'manage_category_custom_column', $plugin_admin, 'custom_column_content', 10, 3);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Raratheme_Companion_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter( 'script_loader_tag', $plugin_public, 'travel_booking_pro_js_defer_files', 10 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Raratheme_Companion_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
