import { getContext, store } from '@wordpress/interactivity';

export const { state, callbacks } = store('interaction-boilerplate-creator', {
	state: {
		darkTheme: false,
		isCreatingBoilerplate: false,
		hasCreatedBoilerplate: false,
		showMessage: false,
	},
	actions: {
		setContextProperty: (e) => {
			state.showMessage = false;

			const context = getContext();

			context[e.target.name] = e.target.value;

			if (e.target.name === 'project_name') {
				context.plugin_name = callbacks.normalizeName(e.target.value);
			}

			if (e.target.name === 'block_name') {
				context.plugin_block_name = callbacks.normalizeName(
					e.target.value
				);
			}
		},
		submitForm: async (e) => {
			e.preventDefault();

			const context = getContext();

			if (
				context.project_name.trim().length >= 5 &&
				callbacks.validateEmail(context.plugin_author_email)
			) {
				const { blogName, apiEndpoint, ...params } = context;

				state.showMessage = false;
				state.isCreatingBoilerplate = true;

				const response = await fetch(`${apiEndpoint}`, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-WP-Nonce': params.nonce,
					},
					body: JSON.stringify({
						...params,
					}),
				});

				const result = await response.json();

				context.message =
					result.message + ' Logged: ' + result.logged_user;

				if (result.status !== 200) {
					context.message = result.message + ' ' + result.logged_user;
					state.showMessage = true;
					state.isCreatingBoilerplate = false;
					return;
				}

				const delay = context.delayCreation * 1000;

				setTimeout(() => {
					state.isCreatingBoilerplate = false;
					state.hasCreatedBoilerplate = true;

					context.plugin_file_name = `${result.plugin_file_name}.zip`;
					context.downloadLink = result.download_link;
				}, delay);
			} else {
				context.message =
					'Insufficient information. Please enter a valid project name and email address.';
				state.showMessage = true;
				state.isCreatingBoilerplate = false;
			}
		},
	},
	callbacks: {
		hideBlockType: () => {
			const context = getContext();
			return (
				!context.plugin_type || context.plugin_type === 'without_block'
			);
		},
		hideForm: () => {
			return state.isCreatingBoilerplate || state.hasCreatedBoilerplate;
		},
		hideFormSubmittedCreating: () => {
			return !state.isCreatingBoilerplate || state.hasCreatedBoilerplate;
		},
		hideMessage: () => {
			return !state.showMessage;
		},
		normalizeName: (name) => {
			return name
				.normalize('NFD') // Decompose "á" into "a" + accent.
				.replace(/[\u0300-\u036f]/g, '') // Remove the diacritical accents.
				.replace(/[^a-zA-Z0-9 ]/g, '') // Remove special characters
				.replace(/\s+/g, ' ') // Remove multiple spaces
				.trim();
		},
		validateEmail: (email) => {
			const emailPattern =
				/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
			return emailPattern.test(email);
		},
	},
});
