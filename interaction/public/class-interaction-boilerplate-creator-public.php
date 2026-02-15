<?php
// Avoiding Direct File Access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Interaction_Boilerplate_Creator_Public' ) ) {
	/**
	 * This class creates the REST API interaction-boilerplate-creator/v1/submit-form
	 * and handles form submissions.
	 *
	 * @since  1.0.0
	 * @package InteractionBoilerplateCreator\interaction\public
	 * @author  Leonardo José Nunes<leonardo.ferax@gmail.com>
	 */
	class Interaction_Boilerplate_Creator_Public {

		/**
		 * Loads dependencies and executes actions.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function __construct() {
			$this->load_dependencies();
			$this->actions();
		}

		/**
		 * Loads dependency to create the zip file.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		private function load_dependencies(): void {
			/** Creates boilerplate zip file  */
			require_once INTERACTION_BOILERPLATE_CREATOR_DIR . 'includes/class-interaction-boilerplate-creator-zip.php';
		}

		/**
		 * Adds action to create the rest api.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function actions(): void {
			add_action( 'rest_api_init', array( $this, 'register_interaction_boilerplate_creator_route' ) );
		}

		/**
		 * Registers route to receive the form data.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function register_interaction_boilerplate_creator_route() {
			register_rest_route(
				'interaction-boilerplate-creator/v1',
				'/submit-form',
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'handle_form_submission' ),
					'args'                => array(
						'nonce' => array(
							'type'              => 'string',
							'required'          => true,
							'sanitize_callback' => 'sanitize_text_field',
							'validate_callback' => function ( $value, $request, $param ) {
								return in_array(
									wp_verify_nonce( $value, 'wp_rest' ),
									array( 1, 2 ),
									true
								);
							},
						),
					),
					'permission_callback' => '__return_true',
				)
			);
		}

		/**
		 * Handles form submission.
		 *
		 * @since  1.0.0
		 * @param  object $request - Data submitted via form
		 * @access public
		 */
		public function handle_form_submission( $request ): object {
			if ( ! isset( $request['form_nonce'] ) ) {
				return new WP_REST_Response(
					array(
						'message' => 'Security verification failed! ',
						'status'  => 500,
					)
				);
			}

			if ( ! wp_verify_nonce( $request['form_nonce'], 'send_form_nonce' ) ) {
				return new WP_REST_Response(
					array(
						'message' => 'Security verification failed! ',
						'status'  => 403,
					)
				);
			}

			if ( ! isset( $request['project_name'] ) || strlen( trim( $request['project_name'] ) ) <= 5 ) {
				return new WP_REST_Response(
					array(
						'message' => 'Please, insert a valid project name.',
						'status'  => 204,
					)
				);
			}

			if ( ! isset( $request['plugin_author_email'] ) || ! filter_var( $request['plugin_author_email'], FILTER_VALIDATE_EMAIL ) ) {
				return new WP_REST_Response(
					array(
						'message' => 'Please, insert a valid email.',
						'status'  => 204,
					)
				);
			}

			$form_data = array(
				'project_name'             => sanitize_text_field( $request['project_name'] ),
				'plugin_name'              => sanitize_text_field( $request['plugin_name'] ),
				'plugin_description'       => isset( $request['plugin_description'] ) ? sanitize_text_field( $request['plugin_description'] ) : 'Plugin Description',
				'plugin_author_name'       => isset( $request['plugin_author_name'] ) ? sanitize_text_field( $request['plugin_author_name'] ) : 'Author Name',
				'plugin_author_email'      => sanitize_text_field( $request['plugin_author_email'] ),
				'plugin_link'              => isset( $request['plugin_link'] ) ? sanitize_text_field( $request['plugin_link'] ) : 'www.example.com',
				'plugin_type'              => isset( $request['plugin_type'] ) ? sanitize_text_field( $request['plugin_type'] ) : 'without_block',
				'plugin_block_name'        => isset( $request['plugin_block_name'] ) ? sanitize_text_field( $request['plugin_block_name'] ) : 'without block',
				'plugin_block_title'       => isset( $request['plugin_block_title'] ) ? sanitize_text_field( $request['plugin_block_title'] ) : 'without block title',
				'plugin_block_description' => isset( $request['plugin_block_description'] ) ? sanitize_text_field( $request['plugin_block_description'] ) : 'Block Description',
				'plugin_block_type'        => isset( $request['plugin_block_type'] ) ? sanitize_text_field( $request['plugin_block_type'] ) : 'render',
				'plugin_block_icon'        => isset( $request['plugin_block_icon'] ) ? sanitize_text_field( $request['plugin_block_icon'] ) : 'welcome-learn-more',
			);

			$creat_zip = Interaction_Boilerplate_Creator_Zip::CREATE( $form_data );

			if ( $creat_zip['status'] === 403 ) {
				return new WP_REST_Response(
					array(
						'message'          => 'Error creating zip file. Check your permissions on the uploads folder.',
						'logged_user'      => is_user_logged_in(),
						'project_name'     => $creat_zip['project_name'],
						'plugin_file_name' => $creat_zip['plugin_file_name'],
						'download_link'    => 'Error creating zip file.',
						'status'           => 403,
					)
				);
			}

			return new WP_REST_Response(
				array(
					'message'          => 'Boilerplate created successfully!',
					'logged_user'      => is_user_logged_in(),
					'project_name'     => $creat_zip['project_name'],
					'plugin_file_name' => $creat_zip['plugin_file_name'],
					'download_link'    => $creat_zip['download_link'],
					'status'           => 200,
				)
			);
		}
	}
}
