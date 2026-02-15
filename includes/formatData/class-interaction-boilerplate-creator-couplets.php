<?php
if ( ! class_exists( 'Interaction_Boilerplate_Creator_Couplets' ) ) {
	/**
	 * This class formats couplets used to replace texts surrounded by '&&&' in source files.
	 *
	 * @since   1.0.0
	 * @author  Leonardo José Nunes <leonardo.ferax@gmail.com>
	 * @package InteractionBoilerplateCreator\includes\formatData
	 */
	class Interaction_Boilerplate_Creator_Couplets {

		/**
		 * Formats couplets used to replace texts surrounded by '&&&'.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  array $form_data - Data from interaction block form
		 * @return array $couplets
		 */
		public static function FORMAT( $form_data ): array {
			$interaction_boilerplate_creator_couplets = new self();

			$plugin_name       = $interaction_boilerplate_creator_couplets->normalize_name( $form_data['plugin_name'] );
			$plugin_block_name = $interaction_boilerplate_creator_couplets->normalize_name( $form_data['plugin_block_name'] );

			$couplets = array(
				'plugin_file_name'     => $interaction_boilerplate_creator_couplets->format_name( $plugin_name ),
				'plugin_function_name' => $interaction_boilerplate_creator_couplets->format_plugin_function_name( $plugin_name ),
				'plugin_constant_name' => $interaction_boilerplate_creator_couplets->format_plugin_constant_name( $plugin_name ),
				'plugin_package_name'  => $interaction_boilerplate_creator_couplets->format_plugin_package_name( $plugin_name ),
				'plugin_class_name'    => $interaction_boilerplate_creator_couplets->format_plugin_class_name( $plugin_name ),
				'plugin_camel_name'    => $interaction_boilerplate_creator_couplets->format_plugin_camel_name( $plugin_name ),
				'plugin_block_name'    => $interaction_boilerplate_creator_couplets->format_name( $plugin_block_name ),
				'plugin_block_icon'    => $interaction_boilerplate_creator_couplets->format_block_icon( $form_data['plugin_block_icon'] ),
			);

			return $couplets;
		}

		/**
		 * Normalizes plugin and block names.
		 *
		 *    1. Removes special characters, multiple spaces and surrounding spaces;
		 *    2. Capitalizes the first letter of each word.
		 *
		 * @since  1.0.0
		 * @access private
		 * @param  string $name - plugin and block names
		 * @return string $normalized_name
		 */
		private function normalize_name( $name ): string {
			// This pattern keeps only alphanumeric characters and spaces
			$normalized_name = preg_replace( '/[^A-Za-z0-9 ]/', '', $name );

			// This pattern reduce multiple spaces to one space
			// The replacement string is ' ' (a single space)
			$normalized_name = preg_replace( '/\s+/', ' ', $normalized_name );

			$normalized_name = trim( $normalized_name );

			$normalized_name = ucwords( $normalized_name );

			return $normalized_name;
		}

		/**
		 * Formats plugin and block names:
		 *
		 *    1. Replaces spaces with dashes;
		 *    2. convert name to lowercase.
		 *
		 * @since  1.0.0
		 * @access private
		 * @param  string $normalized_name - normalized plugin and block names
		 * @return string $formatted_name
		 */
		private function format_name( $normalized_name ): string {
			$formatted_name = str_replace( ' ', '-', $normalized_name );
			$formatted_name = strtolower( $formatted_name );

			return $formatted_name;
		}

		/**
		 * Formats plugin function name:
		 *
		 *    1. Replaces the spaces with underlines;
		 *    2. Converts name to lowercase.
		 *
		 * @since  1.0.0
		 * @access private
		 * @param  string $normalized_name - normalized plugin name
		 * @return string $formatted_function_name
		 */
		private function format_plugin_function_name( $normalized_name ): string {
			$formatted_function_name = str_replace( ' ', '_', $normalized_name );
			$formatted_function_name = strtolower( $formatted_function_name );

			return $formatted_function_name;
		}

		/**
		 * Formats plugin constant name.
		 *
		 *    1. Replaces the spaces with underlines;
		 *    2. Converts name to uppercase.
		 *
		 * @since  1.0.0
		 * @access private
		 * @param  string $normalized_name - normalized plugin name
		 * @return string $formatted_constant_name
		 */
		private function format_plugin_constant_name( $normalized_name ): string {
			$formatted_constant_name = str_replace( ' ', '_', $normalized_name );
			$formatted_constant_name = strtoupper( $formatted_constant_name );

			return $formatted_constant_name;
		}

		/**
		 * Formats plugin package name.
		 *
		 *    1. Converts the first letters to uppercase;
		 *    2. Removes spaces.
		 *
		 * @since  1.0.0
		 * @access private
		 * @param  string $normalized_name - normalized plugin name
		 * @return string $formatted_package_name
		 */
		private function format_plugin_package_name( $normalized_name ): string {
			$formatted_package_name = ucfirst( $normalized_name );
			$formatted_package_name = str_replace( ' ', '', $formatted_package_name );

			return $formatted_package_name;
		}

		/**
		 * Formats plugin class name.
		 *
		 *    1. Converts the first letters to uppercase;
		 *    2. Replaces spaces with underline.
		 *
		 * @since  1.0.0
		 * @access private
		 * @param  string $normalized_name - normalized plugin name
		 * @return string $formatted_class_name
		 */
		private function format_plugin_class_name( $normalized_name ): string {
			$formatted_class_name = ucfirst( $normalized_name );
			$formatted_class_name = str_replace( ' ', '_', $formatted_class_name );

			return $formatted_class_name;
		}

		/**
		 * Formats plugin camel name.
		 *
		 *    1. Splits project name by space;
		 *    2. Converts the first word to lowercase
		 *    3. Joins again without spaces
		 *
		 * @since  1.0.0
		 * @access private
		 * @param  string $normalized_name - normalized plugin name
		 * @return string $formatted_plugin_camel_name
		 */
		private function format_plugin_camel_name( $normalized_name ): string {
			$formatted_plugin_camel_name    = explode( ' ', $normalized_name );
			$formatted_plugin_camel_name[0] = strtolower( $formatted_plugin_camel_name[0] );
			$formatted_plugin_camel_name    = implode( $formatted_plugin_camel_name );

			return $formatted_plugin_camel_name;
		}

		/**
		 * Formats plugin block icon
		 *
		 *    1. Remove 'dashicons-' from string if it exists.
		 *
		 * @since  1.0.0
		 * @access private
		 * @param  string $plugin_block_icon - plugin block icon name
		 * @return string $formatted_plugin_block_icon
		 */
		private function format_block_icon( $plugin_block_icon ): string {
			$formatted_plugin_block_icon = str_replace( 'dashicons-', '', $plugin_block_icon );

			return $formatted_plugin_block_icon;
		}
	}
}
