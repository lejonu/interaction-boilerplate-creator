<?php
/**
 * Interaction form block. A form where users enter data to create the boilerplate.
 * The fields project_name (minlength="6") and plugin_author_email (valid email) are required;
 * the others are optional.
 *
 * It has three presentation phases:
 *
 *    1. The form itself: User enters the data and clicks the "Submit" button;
 *    2. A message is displayed asking the user to wait while the boilerplate is created. The time delay attribute can be defined on backend part of the form;
 *    3. A button is provided to download the boilerplate.
 *
 * @package InteractionBoilerplateCreator\interaction\blocks
 * @author  Leonardo José Nunes <leonardo.ferax@gmail.com>
 */

// Avoiding Direct File Access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
	* WP Rest Nonce
	*
	* @since    1.0.0
	* @var      string $interaction_boilerplate_creator_nonce - WordPress default nonce
	*/
$interaction_boilerplate_creator_nonce = wp_create_nonce( 'wp_rest' );

/**
	* Send Form Nonce
 *
	* @since    1.0.0
	* @var      string $interaction_boilerplate_creator_send_form_nonce - Specific nonce of the form
	*/
$interaction_boilerplate_creator_form_nonce = wp_create_nonce( 'send_form_nonce' );

/**
	* Merged attributes and plugin informations into an array that will be used as context.
	*
	* @since    1.0.0
	* @var      array $interaction_boilerplate_creator
	*/
$interaction_boilerplate_creator = array_merge(
	$attributes,
	array(
		'nonce'       => $interaction_boilerplate_creator_nonce,
		'form_nonce'  => $interaction_boilerplate_creator_form_nonce,
		'apiEndpoint' => rest_url( '/interaction-boilerplate-creator/v1/submit-form' ),
	)
);
?>
   
<div
data-wp-interactive='interaction-boilerplate-creator' 
<?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>
<?php echo wp_kses_data( wp_interactivity_data_wp_context( $interaction_boilerplate_creator ) ); ?>
> 
	<div data-wp-bind--hidden="!state.showMessage"> 
		<p class="creator-message" data-wp-text="context.message"></p> 
	</div>

	<div data-wp-bind--hidden="callbacks.hideForm">  
		<form class="creator-form" data-wp-on--submit="actions.submitForm" method="POST">
			<div class="creator-form__field"> 
				<label class="creator-form__label" for="project_name">
					<?php esc_html_e( 'Project name:', 'interaction-boilerplate-creator' ); ?>
				</label>  
				<input class="creator-form__input" placeholder="<?php esc_html_e( 'My Plugin Name', 'interaction-boilerplate-creator' ); ?>" type="text" minlength="6" id="project_name" name="project_name" required data-wp-on--input="actions.setContextProperty" data-wp-bind--value="context.project_name" />
			</div>
 
			<div class="creator-form__field">
				<label class="creator-form__label" for="plugin_description">
					<?php esc_html_e( 'Description:', 'interaction-boilerplate-creator' ); ?>
				</label>
				<input class="creator-form__input" type="text" id="plugin_description" name="plugin_description" data-wp-on--input="actions.setContextProperty" data-wp-bind--value="context.plugin_description" />
			</div>

			<div class="creator-form__field">
				<label class="creator-form__label" for="plugin_author_name">
					<?php esc_html_e( 'Author name:', 'interaction-boilerplate-creator' ); ?>
				</label>
				<input class="creator-form__input" type="text" id="plugin_author_name" name="plugin_author_name" data-wp-on--input="actions.setContextProperty" data-wp-bind--value="context.plugin_author_name" />
			</div>

			<div class="creator-form__field">
				<label class="creator-form__label" for="plugin_author_email">
					<?php esc_html_e( 'Author email:', 'interaction-boilerplate-creator' ); ?>
				</label>
				<input class="creator-form__input" type="email" required id="plugin_author_email" name="plugin_author_email" data-wp-on--input="actions.setContextProperty" data-wp-bind--value="context.plugin_author_email" />
			</div>
 
			<div class="creator-form__field">
				<label class="creator-form__label" for="plugin_link">
					<?php esc_html_e( 'Link:', 'interaction-boilerplate-creator' ); ?>
				</label> 
				<input class="creator-form__input" type="url" id="plugin_link" name="plugin_link" data-wp-on--input="actions.setContextProperty" data-wp-bind--value="context.plugin_link" />
			</div>

			<div class="creator-form__field">
				<div class="creator-form__field--selection">
					<label class="creator-form__label" for="plugin_type">
						<?php esc_html_e( 'Plugin type:', 'interaction-boilerplate-creator' ); ?>
					</label> 
 
					<select id="plugin_type" name="plugin_type" data-wp-on--change="actions.setContextProperty" data-wp-bind--value="context.plugin_type">
						<option value="" hidden="true" disabled="true" selected="true">
							<?php esc_html_e( 'Select Plugin type', 'interaction-boilerplate-creator' ); ?>
						</option>

						<option value="without_block">
							<?php esc_html_e( 'Without Block', 'interaction-boilerplate-creator' ); ?>
						</option>

						<option value="only_block">
							<?php esc_html_e( 'Only Block', 'interaction-boilerplate-creator' ); ?>
						</option>

						<option value="full">
							<?php esc_html_e( 'Full', 'interaction-boilerplate-creator' ); ?>
						</option>
					</select>
				</div>
			</div> 

			<div class="creator-form__block-type" data-wp-bind--hidden="callbacks.hideBlockType">
				<div class="creator-form__field"> 
					<label class="creator-form__label" for="block_name"> 
						<?php esc_html_e( 'Block Name:', 'interaction-boilerplate-creator' ); ?> 
					</label>   
					<input class="creator-form__input" type="text" id="block_name" name="block_name" data-wp-bind--required="!callbacks.hideBlockType" data-wp-on--input="actions.setContextProperty" data-wp-bind--value="context.block_name" />
				</div>

				<div class="creator-form__field">
					<label class="creator-form__label" for="plugin_block_title"> 
						<?php esc_html_e( 'Block Title:', 'interaction-boilerplate-creator' ); ?> 
					</label>

					<input class="creator-form__input" type="text" id="plugin_block_title" name="plugin_block_title" data-wp-bind--required="!callbacks.hideBlockType" data-wp-on--input="actions.setContextProperty" data-wp-bind--value="context.plugin_block_title" />
				</div>
			 
				<div class="creator-form__field">
					<label class="creator-form__label" for="plugin_block_description">
						<?php esc_html_e( 'Block Description:', 'interaction-boilerplate-creator' ); ?>
					</label>

					<input class="creator-form__input" type="text" id="plugin_block_description" name="plugin_block_description" data-wp-on--input="actions.setContextProperty" data-wp-bind--value="context.plugin_block_description" />
				</div>

				<div class="creator-form__field">
					<div class="creator-form__field--selection">
						<label class="creator-form__label"  for="plugin_block_type">
							<?php esc_html_e( 'Block type:', 'interaction-boilerplate-creator' ); ?>
						</label>

						<select id="plugin_block_type" name="plugin_block_type" data-wp-on--change="actions.setContextProperty" data-wp-bind--value="context.plugin_block_type">
							<option value="" hidden="true" disabled="true" selected="true">
								<?php esc_html_e( 'Select Block type', 'interaction-boilerplate-creator' ); ?>
							</option>

							<option value="render">
								<?php esc_html_e( 'render.php', 'interaction-boilerplate-creator' ); ?>
							</option>

							<option value="save">
								<?php esc_html_e( 'save.js', 'interaction-boilerplate-creator' ); ?>
							</option> 
						</select> 
					</div>
				</div>

				<div class="creator-form__field">
					<div class="creator-form__field--selection">	
						<label class="creator-form__label" for="plugin_block_icon">
							<?php esc_html_e( 'Block Icon:', 'interaction-boilerplate-creator' ); ?> 
						</label>
						<a href="https://developer.wordpress.org/resource/dashicons" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'Choose on the WordPress dashboard.', 'interaction-boilerplate-creator' ); ?>
						</a>
					</div>
				</div>
 
				<div class="creator-form__field"> 
					<input class="creator-form__input" type="text" id="plugin_block_icon" name="plugin_block_icon" data-wp-on--input="actions.setContextProperty" data-wp-bind--value="context.plugin_block_icon" placeholder="welcome-learn-more"/>	
				</div>
			</div>
	
			<div class="button__field">	
				<button class="button__field--button" type="submit">
					<?php esc_html_e( 'Create Boilerplate', 'interaction-boilerplate-creator' ); ?>
				</button>
			</div>
		</form>
	</div>
 
	<div data-wp-bind--hidden="callbacks.hideFormSubmittedCreating">
		<div class="form-submitted">
			<div class="form-submitted__text">
				<p><?php esc_html_e( 'Please wait while your boilerplate is created....', 'interaction-boilerplate-creator' ); ?></p>
			</div>
			<div class="form-submitted__spinner"> 
			</div>
		</div>
	</div>

	<div data-wp-bind--hidden="!state.hasCreatedBoilerplate">
		<div class="form-submitted" data-wp-class--hidden="!hasCreatedBoilerplate"> 
			<div class="form-submitted__text">	
				<p><?php esc_html_e( 'Download:', 'interaction-boilerplate-creator' ); ?></p>
				
				<div class="button__field">	 
					<a class="button__field--button" data-wp-bind--href="context.downloadLink" data-wp-text="context.plugin_file_name"></a> 
				</div>
			</div>
		</div>
	</div>

</div>
