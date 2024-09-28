<?php
/**
 * Include files.
 *
 * @package rara-one-click-demo-import
 */

/**
 * Rara One Click Demo Import class, so we don't have to worry about namespaces.
 */
class RRDI_Theme_Demo_Include_Files {

	function __construct()
	{
		// Include files.
		require RRDI_PATH . 'includes/class-rrdi-helpers.php';
		require RRDI_PATH . 'includes/class-rrdi-importer.php';
		require RRDI_PATH . 'includes/vendor/class-rrdi-widget-importer.php';
		require RRDI_PATH . 'includes/vendor/class-rrdi-customizer-importer.php';
		require RRDI_PATH . 'includes/class-rrdi-logger.php';
	}
}
new RRDI_Theme_Demo_Include_Files;