<?php
/**
 * Upgrader API: Plugin_Upgrader_Skin class
 *
 * Demo Installer Skin for the WordPress Demo Importer.
 *
 * @class    RDDI_Demo_Installer_Skin
 * @extends  WP_Upgrader_Skin
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * RDDI_Demo_Installer_Skin Class.
 */
class RDDI_Demo_Installer_Skin extends WP_Upgrader_Skin {
	public $type;

	/**
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {
		$defaults = array( 'type' => 'web', 'url' => '', 'demo' => '', 'nonce' => '', 'title' => '' );
		$args = wp_parse_args( $args, $defaults );

		$this->type = $args['type'];

		parent::__construct( $args );
	}

	/**
	 * @access public
	 */
	public function after() {
		$install_actions = array();

		$from = isset( $_GET['from'] ) ? wp_unslash( $_GET['from'] ) : 'demos';

		if ( 'web' == $this->type ) {
			$install_actions['demos_page'] = '<a class="demo-importer" href="' . admin_url( 'themes.php?page=rara-demo-import&browse=uploads' ) . '" target="_parent">' . __( 'Return to Demo Importer', 'rara-one-click-demo-import' ) . '</a>';
		} elseif ( 'upload' == $this->type && 'demos' == $from ) {
			$install_actions['demos_page'] = '<a class="demo-importer" href="' . admin_url( 'themes.php?page=rara-demo-import&browse=uploads' ) . '">' . __( 'Return to Demo Importer', 'rara-one-click-demo-import' ) . '</a>';
		} else {
			$install_actions['demos_page'] = '<a class="demo-importer" href="' . admin_url( 'themes.php?page=rara-demo-import&browse=uploads' ) . '" target="_parent">' . __( 'Return to Demos page', 'rara-one-click-demo-import' ) . '</a>';
		}

		/**
		 * Filters the list of action links available following a single demo installation.
		 * @param array $install_actions Array of demo action links.
		 */
		$install_actions = apply_filters_deprecated( 'themegrill_demo_install_complete_actions', array( $install_actions ), '1.3.1', 'rrdi_demo_install_complete_actions' );

		if ( ! empty( $install_actions ) ) {
			$this->feedback( implode( ' | ', (array) $install_actions ) );
		}
	}
}
