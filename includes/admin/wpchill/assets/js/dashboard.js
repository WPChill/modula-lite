/* eslint-disable no-undef */
document.addEventListener( 'DOMContentLoaded', () => {
	async function activatePlugin( url ) {
		try {
			const response = await fetch( url, {
				method: 'GET',
				headers: { 'Content-Type': 'text/html' },
			} );

			if ( ! response.ok ) {
				throw new Error( `HTTP error! status: ${ response.status }` );
			}
		} catch ( error ) {
			console.error( 'Plugin activation error:', error );
		}
	}

	// Handle single install/activate buttons
	document.querySelectorAll( '.wpchill_install_partener_addon' ).forEach( ( button ) => {
		button.addEventListener( 'click', async ( event ) => {
			event.preventDefault();

			const pluginSlug = button.dataset.slug;
			const pluginAction = button.dataset.action;
			const activateUrl = button.dataset.activation_url;

			if ( pluginAction === 'install' ) {
				button.textContent = dashboardStrings.installing_plugin;

				wp.updates.installPlugin( {
					slug: pluginSlug,
					success: async ( response ) => {
						button.textContent = dashboardStrings.activating_plugin;
						await activatePlugin( response.activateUrl );
					},
					error: () => {
						button.classList.remove( 'updating-message' );
					},
				} );
			} else if ( pluginAction === 'activate' ) {
				button.textContent = dashboardStrings.activating_plugin;
				await activatePlugin( activateUrl );
			}
		} );
	} );

	// Handle toggle switches
	document.querySelectorAll( '.wpchill_our_products .wpchill-toggle__input' ).forEach( ( input ) => {
		input.addEventListener( 'change', async ( e ) => {
			e.preventDefault();
			input.disabled = true;

			const activateUrl = input.dataset.activateurl;
			const deactivateUrl = input.dataset.deactivateurl;
			const action = input.dataset.action;
			const slug = input.dataset.slug;

			const textWrapper = input
				.closest( '.wpchill_product_actions' )
				.querySelector( 'span.wpchill_action_status' );

			if ( action === 'install' ) {
				textWrapper.textContent = dashboardStrings.installing_text;

				wp.updates.installPlugin( {
					slug,
					success: async () => {
						textWrapper.textContent = dashboardStrings.activating_text;
						await activatePlugin( activateUrl );
						textWrapper.textContent = dashboardStrings.activated_status;
						input.dataset.action = 'installed';
						setTimeout( () => {
							textWrapper.textContent = '';
						}, 2000 );
						input.disabled = false;
					},
				} );
			} else if ( action === 'activate' ) {
				textWrapper.textContent = dashboardStrings.activating_text;
				await activatePlugin( activateUrl );
				textWrapper.textContent = dashboardStrings.activated_status;
				input.dataset.action = 'installed';
				setTimeout( () => {
					textWrapper.textContent = '';
				}, 2000 );
				input.disabled = false;
			} else if ( action === 'installed' ) {
				textWrapper.textContent = dashboardStrings.deactivating_text;
				await activatePlugin( deactivateUrl );
				textWrapper.textContent = dashboardStrings.deactivate_status;
				input.dataset.action = 'activate';
				setTimeout( () => {
					textWrapper.textContent = '';
				}, 2000 );
				input.disabled = false;
			}
		} );
	} );
	document.querySelectorAll( '.wpchill_product_learn_more' ).forEach( ( button ) => {
		button.addEventListener( 'click', ( event ) => {
			const parent = button.closest( '.wpchill_product' );
			const isOpen = parent.classList.contains( 'is_extended' );

			// Închide toate și setează textul "close"
			document.querySelectorAll( '.wpchill_product' ).forEach( ( el ) => {
				el.classList.remove( 'is_extended' );
			} );
			document.querySelectorAll( '.wpchill_product_learn_more' ).forEach( ( btn ) => {
				btn.textContent = dashboardStrings.openText;
			} );

			// Dacă nu era deschis, îl deschidem și setăm textul "open"
			if ( ! isOpen ) {
				parent.classList.add( 'is_extended' );
				button.textContent = dashboardStrings.closeText;
			}
		} );
	} );
} );
