( function() {
	const { __ } = wp.i18n;

	function activatePlugin( pluginPath, button ) {
		button.classList.add( 'updating-message' );
		wp.apiFetch( {
			path: '/wpchill/v1/activate-plugin',
			method: 'POST',
			data: {
				plugin: pluginPath,
			},
		} )
			.then( ( response ) => {
				if ( response.success ) {
					button.textContent = __( 'Active', 'modula-best-grid-gallery' );
					button.setAttribute( 'disabled', 'true' );
					button.classList.remove( 'updating-message' );
				} else {
					button.textContent = __( 'Activate', 'modula-best-grid-gallery' );
					console.error( 'Error activating plugin:', response );
					button.classList.remove( 'updating-message' );
				}
			} )
			.catch( ( error ) => {
				console.error( 'API Fetch error:', error );
			} );
	}

	// Install plugins actions
	document.querySelectorAll( '.wpchill_install_partener_addon' ).forEach( ( button ) => {
		button.addEventListener( 'click', ( event ) => {
			event.preventDefault();

			const current = event.currentTarget;
			const pluginSlug = current.dataset.slug;
			const pluginAction = current.dataset.action;
			const pluginPath = current.dataset.plugin;

			current.classList.add( 'updating-message' );

			if ( pluginAction === 'install' ) {
				current.textContent = __( 'Installing plugin…', 'modula-best-grid-gallery' );

				const args = {
					slug: pluginSlug,
					success: () => {
						current.textContent = __( 'Activating plugin…', 'modula-best-grid-gallery' );
						current.classList.remove( 'updating-message' );
						activatePlugin( pluginPath, current );
					},
					error: ( response ) => {
						current.textContent = __( 'Install', 'modula-best-grid-gallery' );
						current.classList.remove( 'updating-message' );
						console.error( 'Error installing plugin:', response );
					},
				};

				wp.updates.installPlugin( args );
			} else if ( pluginAction === 'activate' ) {
				current.textContent = __( 'Activating plugin…', 'modula-best-grid-gallery' );

				activatePlugin( pluginPath, current );
			}
		} );
	} );
}() );
