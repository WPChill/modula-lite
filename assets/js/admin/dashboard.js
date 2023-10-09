(function ($) {
	function activatePlugin(url) {
		$.ajax({
			async: true,
			type: 'GET',
			dataType: 'html',
			url: url,
			success: function () {
				location.reload();
			},
		});
	}

	// Install plugins actions
	$('.wpchill_install_partener_addon').on('click', (event) => {
		event.preventDefault();

		var current = $(event.currentTarget),
			plugin_slug = current.data('slug'),
			plugin_action = current.data('action'),
			activate_url = current.data('activation_url');

		if ('install' === plugin_action) {
			current.html(dashboardStrings.installing_plugin);

			let args = {
				slug: plugin_slug,
				success: (response) => {
					current.html(dashboardStrings.activating_plugin);

					activatePlugin(response.activateUrl);
				},
				error: (response) => {
					current.removeClass('updating-message');
				},
			};

			wp.updates.installPlugin(args);
		} else if ('activate' === plugin_action) {
			current.html(dashboardStrings.activating_plugin);

			activatePlugin(activate_url);
		}
	});

	/* When document is ready, do */
	$(document).ready(function ($) {});
})(jQuery);
