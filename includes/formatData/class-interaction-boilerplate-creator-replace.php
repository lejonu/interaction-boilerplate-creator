<?php
if ( ! class_exists( 'Interaction_Boilerplate_Creator_Replace' ) ) {
	/**
	 * This class replaces strings received from the source files and replaces names to be used in final files.
	 *
	 * @since   1.0.0
	 * @author  Leonardo José Nunes <leonardo.ferax@gmail.com>
	 * @package InteractionBoilerplateCreator\includes\formatData
	 */
	class Interaction_Boilerplate_Creator_Replace {

		/**
		 * Replaces strings delimited by '&&&' received from source files.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  string $file_string - Source file content
		 * @param  array  $form_data - Data from interaction block form
		 * @param  array  $couplets - Formatted couplets to replace source file string fields surrounded by '&&&' marker
		 * @return string $replaced_file_string - File with strings replaced
		 */
		public static function REPLACE_STRINGS( $file_string, $form_data, $couplets ): string {
			$replaced_file_string = str_replace( '&&&project_name&&&', $form_data['project_name'], $file_string );
			$replaced_file_string = str_replace( '&&&plugin_description&&&', $form_data['plugin_description'], $replaced_file_string );
			$replaced_file_string = str_replace( '&&&plugin_author_name&&&', $form_data['plugin_author_name'], $replaced_file_string );
			$replaced_file_string = str_replace( '&&&plugin_author_email&&&', $form_data['plugin_author_email'], $replaced_file_string );
			$replaced_file_string = str_replace( '&&&plugin_block_title&&&', $form_data['plugin_block_title'], $replaced_file_string );
			$replaced_file_string = str_replace( '&&&plugin_block_description&&&', $form_data['plugin_block_description'], $replaced_file_string );
			$replaced_file_string = str_replace( '&&&plugin_current_date&&&', gmdate( 'Y-m-d' ), $replaced_file_string );
			$replaced_file_string = str_replace( '&&&plugin_current_year&&&', gmdate( 'Y' ), $replaced_file_string );
			$replaced_file_string = str_replace( '&&&plugin_link&&&', $form_data['plugin_link'], $replaced_file_string );

			$replaced_file_string = str_replace( '&&&plugin_file_name&&&', $couplets['plugin_file_name'], $replaced_file_string );
			$replaced_file_string = str_replace( '&&&plugin_block_name&&&', $couplets['plugin_block_name'], $replaced_file_string );
			$replaced_file_string = str_replace( '&&&plugin_package_name&&&', $couplets['plugin_package_name'], $replaced_file_string );
			$replaced_file_string = str_replace( '&&&plugin_class_name&&&', $couplets['plugin_class_name'], $replaced_file_string );
			$replaced_file_string = str_replace( '&&&plugin_constant_name&&&', $couplets['plugin_constant_name'], $replaced_file_string );
			$replaced_file_string = str_replace( '&&&plugin_function_name&&&', $couplets['plugin_function_name'], $replaced_file_string );
			$replaced_file_string = str_replace( '&&&plugin_block_icon&&&', $couplets['plugin_block_icon'], $replaced_file_string );

			return $replaced_file_string;
		}

		/**
		 * Replaces the file names to be used when creating boilerplate.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  string $source_file - File name from boilerplate source files
		 * @param  string $plugin_name - Formatted plugin name
		 * @return string $actual_file_name - Actual name of the file to be saved in the zip archive.
		 */
		public static function REPLACE_NAMES( $source_file, $plugin_name ): string {
			switch ( $source_file ) {
				case 'plugin-name_with_version.txt':
					$actual_file_name = $plugin_name . '.php';
					break;
				case 'plugin-name_without_version.txt':
					$actual_file_name = $plugin_name . '.php';
					break;
				case 'block.json.txt':
					$actual_file_name = 'block.json';
					break;
				case 'class-plugin-name-without-block-main.txt':
					$actual_file_name = 'class-' . $plugin_name . '-main.php';
					break;
				case 'class-plugin-name-only-block-main.txt':
					$actual_file_name = 'class-' . $plugin_name . '-main.php';
					break;
				case 'class-plugin-name-full-main.txt':
					$actual_file_name = 'class-' . $plugin_name . '-main.php';
					break;
				case 'class-plugin-name-activate.txt':
					$actual_file_name = 'class-' . $plugin_name . '-activate.php';
					break;
				case 'class-plugin-name-deactivate.txt':
					$actual_file_name = 'class-' . $plugin_name . '-deactivate.php';
					break;
				case 'class-plugin-name-admin.txt':
					$actual_file_name = 'class-' . $plugin_name . '-admin.php';
					break;
				case 'plugin-name-admin-display.txt':
					$actual_file_name = 'class-' . $plugin_name . '-admin-display.php';
					break;
				case 'class-plugin-name-public.txt':
					$actual_file_name = 'class-' . $plugin_name . '-public.php';
					break;
				case 'plugin-name-public-display.txt':
					$actual_file_name = 'class-' . $plugin_name . '-public-display.php';
					break;
				case 'class-plugin-name-blocks.txt':
					$actual_file_name = 'class-' . $plugin_name . '-blocks.php';
					break;
				case 'render.php.txt':
					$actual_file_name = 'render.php';
					break;
				case 'index.js.txt':
					$actual_file_name = 'index.js';
					break;
				case 'edit.js.txt':
					$actual_file_name = 'edit.js';
					break;
				case 'save.js.txt':
					$actual_file_name = 'save.js';
					break;
				case 'editor.scss.txt':
					$actual_file_name = 'editor.scss';
					break;
				case 'view.js.txt':
					$actual_file_name = 'view.js';
					break;
				case 'style.scss.txt':
					$actual_file_name = 'style.scss';
					break;

				default:
					$actual_file_name = $source_file;
					break;
			}

			return $actual_file_name;
		}
	}
}
