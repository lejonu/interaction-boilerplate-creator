<?php
// Avoiding Direct File Access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Interaction_Boilerplate_Creator_Blocks' ) ) :
	/**
	 * This class registers the form block where the user enters data to create the boilerplate.
	 *
	 * @since   1.0.0
	 * @package InteractionBoilerplateCreator\interaction\blocks
	 * @author  Leonardo José Nunes <leonardo.ferax@gmail.com>
	 */
	class Interaction_Boilerplate_Creator_Blocks {

		function __construct() {
			$this->actions();
		}

		/**
		 * Adds action to register the plugin block on init.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function actions(): void {
				add_action( 'init', array( $this, 'interaction_boilerplate_creator_init' ) );
		}

		/**
		 * Registers the plugin block.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function interaction_boilerplate_creator_init() {
			register_block_type_from_metadata( plugin_dir_path( __FILE__ ) . 'build' );
		}
	}
endif;
