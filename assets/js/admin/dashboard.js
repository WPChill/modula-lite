function activatePlugin(url) {
    jQuery.ajax({
        async: true,
        type: "GET",
        dataType: "html",
        url: url,
        success: function () {
            location.reload();
        },
    });
}

// Install plugins actions
jQuery(".wpchill_install_partener_addon").on("click", (event) => {
    event.preventDefault();
    const current = jQuery(event.currentTarget);
    //console.log( current.data("slug"));
    const plugin_slug = current.data("slug");
    const plugin_action = current.data("action");
    const activate_url = current.data("activation_url");

    // Now let's disable the button and show the action text
    //current.attr("disabled", true);


    if ("install" === plugin_action) {

        current.html(dashboardStrings.installing_plugin);

        const args = {
            slug: plugin_slug,
            success: (response) => {

                current.html(dashboardStrings.activating_plugin);

                activatePlugin(response.activateUrl);
            },
            error: (response) => {
                current.removeClass("updating-message");

            },
        };

        wp.updates.installPlugin(args);
    } else if ("activate" === plugin_action) {
        current.html(dashboardStrings.activating_plugin);

        activatePlugin(activate_url);
    }
});