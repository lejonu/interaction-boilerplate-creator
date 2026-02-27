<?php
if ( ! class_exists( 'Interaction_Boilerplate_Creator_Log' ) ) {
	/**
	 * This class writes the creator-log.txt file for the created boilerplates.
	 *
	 * @since   1.0.0
	 * @package InteractionBoilerplateCreator\includes\log
	 */
	class Interaction_Boilerplate_Creator_Log {

		/**
		 * Writes the creator-log.txt file.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  string $upload_boilerplates_dir - full path to uploads boilerplates dir
		 * @param  array  $form_data - Formatted data of the created plugin
		 * @param  string $plugin_file_name - Formatted plugin file name
		 */
		public static function CREATE( $upload_boilerplates_dir, $form_data, $plugin_file_name ): void {
			$log_lines = array(
				'header '             => '[' . gmdate( 'M-d-Y H:i:s' ) . ' UTC ] ',
				'project_name'        => 'Project: ' . $form_data['project_name'],
				'plugin_name'         => 'Plugin Name: ' . $plugin_file_name,
				'plugin_type'         => 'Plugin Type: ' . $form_data['plugin_type'],
				'plugin_desc'         => 'Plugin Desc: ' . $form_data['plugin_description'],
				'plugin_block_type'   => $form_data['plugin_block_type'] === 'without_block' ? '' : 'Block Type: ' . $form_data['plugin_block_type'],
				'plugin_block_name'   => $form_data['plugin_block_name'] === 'without_block' ? '' : 'Block Name: ' . $form_data['plugin_block_name'],
				'plugin_block_title'  => $form_data['plugin_block_title'] === 'without_block' ? '' : 'Block Title: ' . $form_data['plugin_block_title'],
				'plugin_author_name'  => 'Author Name: ' . $form_data['plugin_author_name'],
				'plugin_author_email' => 'Author Email: ' . $form_data['plugin_author_email'],
			);

			$log_file = fopen( $upload_boilerplates_dir . 'creator-log.txt', 'a+' );

			foreach ( $log_lines as $log_line ) {
				if ( $log_line ) {
					fwrite( $log_file, $log_line . "\n" );
				}
			}

			fwrite( $log_file, '---------------------------------------------' . "\n" );

			fclose( $log_file );
		}
	}
}
