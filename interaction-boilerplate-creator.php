<?php
/**
 * @link              https://github.com/lejonu/interaction-boilerplate-creator
 * @since             1.0.0
 * @author            Leonardo José Nunes <leonardo.ferax@gmail.com>
 * @copyright         2025 Leonardo José Nunes
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Interaction Boilerplate Creator
 * Plugin URI:        https://github.com/lejonu/interaction-boilerplate-creator
 * Description:       Create interactive WordPress boilerplates.
 * Version:           1.0.1
 * Requires at least: 6.5
 * Requires PHP:      8.0
 * Author:            Leonardo José Nunes
 * Author URI:        https://lejonu.github.io/
 * Text Domain:       interaction-boilerplate-creator
 * Domain Path:       /languages
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Avoiding Direct File Access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Defines the path to the plugin directory.
 *
 * @since    1.0.0
 * @var      string INTERACTION_BOILERPLATE_CREATOR_DIR
 */
if ( ! defined( 'INTERACTION_BOILERPLATE_CREATOR_DIR' ) ) {
	define( 'INTERACTION_BOILERPLATE_CREATOR_DIR', plugin_dir_path( __FILE__ ) );
}

// Requires the plugin's main class
require INTERACTION_BOILERPLATE_CREATOR_DIR . 'class-interaction-boilerplatecreator-main.php';

if ( ! function_exists( 'interaction_boilerplate_creator_instantiate' ) ) {
	/**
	 * Instantiates the plugin's main class.
	 *
	 * @since   1.0.0
	 */
	function interaction_boilerplate_creator_instantiate() {
		$plugin = new Interaction_Boilerplate_Creator_Main();
	}

	interaction_boilerplate_creator_instantiate();
}
