<?php
// Avoiding Direct File Access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Interaction_Boilerplate_Creator_Main' ) ) {
	/**
	 * Plugin's main class. Instantiates the public and block interaction classes.
	 *
	 * @since   1.0.0
	 * @package InteractionBoilerplateCreator
	 * @author  Leonardo José Nunes <leonardo.ferax@gmail.com>
	 */
	class Interaction_Boilerplate_Creator_Main {

		public function __construct() {
			$this->load_dependencies();
			$this->run();
		}

		private function load_dependencies(): void {
			/** public interaction */
			require INTERACTION_BOILERPLATE_CREATOR_DIR . 'interaction/public/class-interaction-boilerplate-creator-public.php';

			/** blocks interaction */
			require INTERACTION_BOILERPLATE_CREATOR_DIR . 'interaction/blocks/class-interaction-boilerplate-creator-blocks.php';
		}

		/**
		 * Runs the plugin
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function run(): void {
			new Interaction_Boilerplate_Creator_Public();
			new Interaction_Boilerplate_Creator_Blocks();
		}
	}
}
