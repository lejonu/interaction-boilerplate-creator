<?php
if ( ! class_exists( 'Interaction_Boilerplate_Creator_Dirs' ) ) {
	/**
	 * This class creates a directory for the boilerplates in uploads dir and return an array containing the directories used in creating the boilerplate.
	 *
	 * @since   1.0.0
	 * @author  Leonardo José Nunes <leonardo.ferax@gmail.com>
	 * @package InteractionBoilerplateCreator\includes\formatData
	 */
	class Interaction_Boilerplate_Creator_Dirs {

		/**
		 * Creates a directory for the boilerplates and returns an array with directories.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  array $form_data - Data from interaction block form
		 * @return array $directories - Directories used in creating the boilerplate
		 */
		public static function CREATE( $form_data ): array {
			// Source files directory
			$source_dir = trailingslashit( INTERACTION_BOILERPLATE_CREATOR_DIR . 'includes/boilerplate_source_files' );

			// Output boilerplates directory
			$boilerplates_dir = trailingslashit( gmdate( 'Y/m/' ) . 'interaction-boilerplates' );

			$upload_dir = wp_upload_dir();

			// Full path to uploads boilerplates directory
			$upload_boilerplates_dir = trailingslashit( $upload_dir['basedir'] ) . $boilerplates_dir;

			// URL to uploads boilerplates directory
			$upload_boilerplates_url = trailingslashit( $upload_dir['baseurl'] ) . $boilerplates_dir;

			// Creates boilerplates directory if it does not exist
			if ( ! is_dir( $upload_boilerplates_dir ) ) {
				// wp_mkdir_p() creates all necessary parent directories recursively
				wp_mkdir_p( $upload_boilerplates_dir );
			}

			// Directories used in all plugin types
			$plugin_directories = array(
				'interaction' => 'interaction/',
				'languages'   => 'languages/',
				'assets'      => 'assets/',
			);

			// Directories used in 'full' and 'without_block' plugin types
			if ( $form_data['plugin_type'] === 'full' || $form_data['plugin_type'] === 'without_block' ) {
					$plugin_directories['activation']      = 'activation/';
					$plugin_directories['includes']        = 'includes/';
					$plugin_directories['admin']           = 'interaction/admin/';
					$plugin_directories['admin_partials']  = 'interaction/admin/partials/';
					$plugin_directories['admin_js']        = 'interaction/admin/js/';
					$plugin_directories['admin_js']        = 'interaction/admin/js/';
					$plugin_directories['admin_css']       = 'interaction/admin/css/';
					$plugin_directories['public']          = 'interaction/public/';
					$plugin_directories['public_partials'] = 'interaction/public/partials/';
					$plugin_directories['public_js']       = 'interaction/public/js/';
					$plugin_directories['public_css']      = 'interaction/public/css/';
			}

			// Directories used in 'full' and 'only_block' plugin types
			if ( $form_data['plugin_type'] === 'full' || $form_data['plugin_type'] === 'only_block' ) {
				$plugin_directories['blocks'] = 'interaction/blocks/';

				// Block type render.php
				if ( $form_data['plugin_block_type'] === 'render' ) {
					$plugin_directories['blocks_source'] = 'interaction/blocks/src-render/';
				}

				// Block type save.js
				if ( $form_data['plugin_block_type'] === 'save' ) {
					$plugin_directories['blocks_source'] = 'interaction/blocks/src-save/';
				}
			}

			$directories = array(
				'source_dir'              => $source_dir,
				'upload_boilerplates_dir' => $upload_boilerplates_dir,
				'upload_boilerplates_url' => $upload_boilerplates_url,
				'plugin_directories'      => $plugin_directories,
			);

			return $directories;
		}
	}
}
