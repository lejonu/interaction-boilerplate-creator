<?php
if ( ! class_exists( 'Interaction_Boilerplate_Creator_Zip' ) ) :
	/**
	 * This class loads the format data classes, the creator log class
	 * and writes final boilerplate zip file.
	 *
	 * @since   1.0.0
	 * @author  Leonardo José Nunes <leonardo.ferax@gmail.com>
	 * @package InteractionBoilerplateCreator\includes
	 */
	class Interaction_Boilerplate_Creator_Zip {

		/**
		 * Loads formatData and log dependencies and writes final boilerplate zip file.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  array $form_data - Data from interaction block form.
		 * @return array $creator_zip - Response data about the created zip file.
		 */
		public static function CREATE( $form_data ): array {

			$interaction_Boilerplate_creator_zip = new self();

			require_once INTERACTION_BOILERPLATE_CREATOR_DIR . 'includes/formatData/class-interaction-boilerplate-creator-couplets.php';
			require_once INTERACTION_BOILERPLATE_CREATOR_DIR . 'includes/formatData/class-interaction-boilerplate-creator-dirs.php';
			require_once INTERACTION_BOILERPLATE_CREATOR_DIR . 'includes/formatData/class-interaction-boilerplate-creator-replace.php';

			require_once INTERACTION_BOILERPLATE_CREATOR_DIR . 'includes/log/class-interaction-boilerplate-creator-log.php';

			$couplets = Interaction_Boilerplate_Creator_Couplets::FORMAT( $form_data );

			$directories = Interaction_Boilerplate_Creator_Dirs::CREATE( $form_data );

			Interaction_Boilerplate_Creator_Log::CREATE( $directories['upload_boilerplates_dir'], $form_data, $couplets['plugin_file_name'] );

			$zip = new ZipArchive();

			$file_basename = $couplets['plugin_file_name'] . '.zip';

			// full path to zip file
			$filename = $directories['upload_boilerplates_dir'] . $file_basename;

			// DEVELOPMENT
			if ( is_file( $filename ) ) {
				wp_delete_file( $filename );
			}

			$source_files = scandir( $directories['source_dir'] );
			$source_files = array_diff(
				$source_files,
				array( '.', '..' )
			);

			// Root directory files
			foreach ( $source_files as $source_file ) {
				$file_path = $directories['source_dir'] . $source_file;

				if ( is_dir( $file_path ) ) {
					continue;
				}

				if ( $form_data['plugin_type'] === 'without_block'
						&& (
							$source_file === 'plugin-name_without_version.txt'
							||
							$source_file === 'class-plugin-name-only-block-main.txt'
							||
							$source_file === 'class-plugin-name-full-main.txt' )
						) {
					continue;
				}

				if ( $form_data['plugin_type'] === 'only_block'
						&& (
							$source_file === 'plugin-name_with_version.txt'
							||
							$source_file === 'class-plugin-name-without-block-main.txt'
							||
							$source_file === 'class-plugin-name-full-main.txt'
							)
						) {
					continue;
				}

				if ( $form_data['plugin_type'] === 'full'
						&& (
							$source_file === 'plugin-name_without_version.txt'
							||
							$source_file === 'class-plugin-name-without-block-main.txt'
							||
							$source_file === 'class-plugin-name-only-block-main.txt'
							)
						) {
					continue;
				}

				$file_string = file_get_contents( $file_path );
				$file_string = Interaction_Boilerplate_Creator_Replace::REPLACE_STRINGS( $file_string, $form_data, $couplets );

				$file_string_basename = Interaction_Boilerplate_Creator_Replace::REPLACE_NAMES( $source_file, $couplets['plugin_file_name'] );

				$interaction_Boilerplate_creator_zip->zip_files( $zip, $filename, $file_string_basename, $file_string, $couplets['plugin_file_name'] );
			}

			// Sub directories files
			foreach ( $directories['plugin_directories'] as $source_sub_dir ) {
				$source_path = $directories['source_dir'] . $source_sub_dir;

				$source_files = scandir( $source_path );
				$source_files = array_diff(
					$source_files,
					array( '.', '..' )
				);

				if ( count( $source_files ) ) {
					foreach ( $source_files as $source_file ) {
						$file_path = $source_path . $source_file;

						if ( is_dir( $file_path ) ) {
							continue;
						}

						$file_string = file_get_contents( $file_path );
						$file_string = Interaction_Boilerplate_Creator_Replace::REPLACE_STRINGS( $file_string, $form_data, $couplets );

						$file_string_basename = Interaction_Boilerplate_Creator_Replace::REPLACE_NAMES( $source_file, $couplets['plugin_file_name'] );

						// $source_sub_dir will be used to scan other files on source, so it will change here when needed
						if ( $source_sub_dir === 'interaction/blocks/src-render/' || $source_sub_dir === 'interaction/blocks/src-save/' ) {
							$src_output_folder = 'interaction/blocks/src/';
							$output_filename   = $src_output_folder . $file_string_basename;
						} else {
							$output_filename = $source_sub_dir . $file_string_basename;
						}

						$interaction_Boilerplate_creator_zip->zip_files( $zip, $filename, $output_filename, $file_string, $couplets['plugin_file_name'] );
					}
				}
			}

			if ( ! is_file( $filename ) ) {
				return array(
					'message' => 'There was a problem creating the file. Check your permissions in the uploads folder. ',
					'status'  => 403,
				);
			}

			$download_link = $directories['upload_boilerplates_url'] . $file_basename;

			$creat_zip = array(
				'message'          => 'Boilerplate created successfully!',
				'project_name'     => $form_data['project_name'],
				'plugin_file_name' => $couplets['plugin_file_name'],
				'download_link'    => $download_link,
				'status'           => 200,
			);

			return $creat_zip;
		}

		/**
		 * Writes formatted source file strings into boilerplate zip file.
		 *
		 * @since  1.0.0
		 * @access private
		 * @param  object $zip - ZipArchive instance
		 * @param  string $filename - Full path to zip file
		 * @param  string $output_filename - File name to be added to zipped file
		 * @param  string $file_string - The contents of the file to be zipped
		 * @param  string $plugin_name - Formatted plugin project name
		 */
		private function zip_files( $zip, $filename, $output_filename, $file_string, $plugin_name ): void {
			$output_zip_file = trailingslashit( $plugin_name ) . $output_filename;

			// Opens the zip file using the CREATE option to create it, if it doesn't already exist.
			if ( $zip->open( $filename, ZipArchive::CREATE ) === true ) {
				// Add the string's contents to a new file inside the zip archive.
				$zip->addFromString( $output_zip_file, $file_string );
			}

			$zip->close();
		}
	}
endif;
