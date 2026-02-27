import { PanelBody, PanelRow, TextControl } from '@wordpress/components';

import { useBlockProps, InspectorControls } from '@wordpress/block-editor';

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();

	function updateDelayCreation(value) {
		setAttributes({ delayCreation: Number(value) });
	}

	return (
		<div {...blockProps}>
			<InspectorControls>
				<PanelBody
					title={__(
						'Delay time when creating boilerplate.',
						'interaction-boilerplate-creator'
					)}
					initialOpen={true}
				>
					<PanelRow>
						<TextControl
							label={__(
								'Time to delay in seconds:',
								'interaction-boilerplate-creator'
							)}
							value={attributes.delayCreation}
							style={{ fontSize: '16px' }}
							onChange={updateDelayCreation}
							type="number"
							min={0}
							max={10}
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>
			<p
				style={{
					textAlign: 'center',
					fontSize: 14,
					fontWeight: 'bold',
					color: '#cc0000',
				}}
			>
				{__(
					'This form only works on the Front End.',
					'interaction-boilerplate-creator'
				)}
			</p>
			<form className="creator-form">
				<div className="creator-form__field">
					<label
						className="creator-form__label"
						htmlFor="project_name"
					>
						{__('Project name:', 'interaction-boilerplate-creator')}
					</label>
					<input
						className="creator-form__input"
						placeholder={__(
							'My Plugin Name',
							'interaction-boilerplate-creator'
						)}
						type="text"
						minLength="6"
						id="project_name"
						name="project_name"
						required
					/>
				</div>

				<div className="creator-form__field">
					<label
						className="creator-form__label"
						htmlFor="plugin_description"
					>
						{__('Description:', 'interaction-boilerplate-creator')}
					</label>
					<input
						className="creator-form__input"
						type="text"
						id="plugin_description"
						name="plugin_description"
					/>
				</div>

				<div className="creator-form__field">
					<label
						className="creator-form__label"
						htmlFor="plugin_author_name"
					>
						{__('Author name:', 'interaction-boilerplate-creator')}
					</label>
					<input
						className="creator-form__input"
						type="text"
						id="plugin_author_name"
						name="plugin_author_name"
					/>
				</div>

				<div className="creator-form__field">
					<label
						className="creator-form__label"
						htmlFor="plugin_author_email"
					>
						{__('Author email:', 'interaction-boilerplate-creator')}
					</label>
					<input
						className="creator-form__input"
						type="email"
						required
						id="plugin_author_email"
						name="plugin_author_email"
					/>
				</div>

				<div className="creator-form__field">
					<label
						className="creator-form__label"
						htmlFor="plugin_link"
					>
						{__('Link:', 'interaction-boilerplate-creator')}
					</label>
					<input
						className="creator-form__input"
						type="url"
						id="plugin_link"
						name="plugin_link"
					/>
				</div>

				<div className="creator-form__field">
					<div className="creator-form__field--selection">
						<label
							className="creator-form__label"
							htmlFor="plugin_type"
						>
							{__(
								'Plugin type:',
								'interaction-boilerplate-creator'
							)}
						</label>

						<select
							id="plugin_type"
							name="plugin_type"
							data-wp-on--change="actions.setContextProperty"
						>
							<option
								value=""
								hidden="true"
								disabled="true"
								selected="true"
							>
								{__(
									'Select Plugin type',
									'interaction-boilerplate-creator'
								)}
							</option>

							<option value="without_block">
								{__(
									'Without Block',
									'interaction-boilerplate-creator'
								)}
							</option>

							<option value="only_block">
								{__(
									'Only Block',
									'interaction-boilerplate-creator'
								)}
							</option>

							<option value="full">
								{__('Full', 'interaction-boilerplate-creator')}
							</option>
						</select>
					</div>
				</div>

				<div className="creator-form__block-type">
					<div className="creator-form__field">
						<label
							className="creator-form__label"
							htmlFor="block_name"
						>
							{__(
								'Block Name:',
								'interaction-boilerplate-creator'
							)}
						</label>
						<input
							className="creator-form__input"
							type="text"
							id="block_name"
							name="block_name"
						/>
					</div>

					<div className="creator-form__field">
						<label
							className="creator-form__label"
							htmlFor="plugin_block_title"
						>
							{__(
								'Block Title:',
								'interaction-boilerplate-creator'
							)}
						</label>

						<input
							className="creator-form__input"
							type="text"
							id="plugin_block_title"
							name="plugin_block_title"
						/>
					</div>

					<div className="creator-form__field">
						<label
							className="creator-form__label"
							htmlFor="plugin_block_description"
						>
							{__(
								'Block Description:',
								'interaction-boilerplate-creator'
							)}
						</label>

						<input
							className="creator-form__input"
							type="text"
							id="plugin_block_description"
							name="plugin_block_description"
						/>
					</div>

					<div className="creator-form__field">
						<div className="creator-form__field--selection">
							<label
								className="creator-form__label"
								htmlFor="plugin_block_type"
							>
								{__(
									'Block type:',
									'interaction-boilerplate-creator'
								)}
							</label>

							<select
								id="plugin_block_type"
								name="plugin_block_type"
							>
								<option
									value=""
									hidden="true"
									disabled="true"
									selected="true"
								>
									{__(
										'Select Block type',
										'interaction-boilerplate-creator'
									)}
								</option>

								<option value="render">
									{__(
										'render.php',
										'interaction-boilerplate-creator'
									)}
								</option>

								<option value="save">
									{__(
										'save.js',
										'interaction-boilerplate-creator'
									)}
								</option>
							</select>
						</div>
					</div>

					<div className="creator-form__field">
						<div className="creator-form__field--selection">
							<label
								className="creator-form__label"
								htmlFor="plugin_block_icon"
							>
								{__(
									'Block Icon:',
									'interaction-boilerplate-creator'
								)}
							</label>
							<a
								href="https://developer.wordpress.org/resource/dashicons"
								target="_blank"
								rel="noopener noreferrer"
							>
								{__(
									'Choose on the WordPress dashboard.',
									'interaction-boilerplate-creator'
								)}
							</a>
						</div>
					</div>

					<div className="creator-form__field">
						<input
							className="creator-form__input"
							type="text"
							id="plugin_block_icon"
							name="plugin_block_icon"
							placeholder="welcome-learn-more"
						/>
					</div>
				</div>

				<div className="button__field">
					<button className="button__field--button" type="submit">
						{__(
							'Create Boilerplate',
							'interaction-boilerplate-creator'
						)}
					</button>
				</div>
			</form>
		</div>
	);
}
