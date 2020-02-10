jQuery(document).ready(function ($) {
    var uninstall = $("a.uninstall-modula"),
        formContainer = $('#modula-uninstall-form');

    formContainer.on('click', '#delete_all', function () {
        if ( $('#delete_all').is(':checked') ) {
            $('#delete_options').prop('checked', true);
            $('#delete_transients').prop('checked', true);
            $('#delete_cpt').prop('checked', true);
            $('#delete_old_tables').prop('checked', true);
        } else {
            $('#delete_options').prop('checked', false);
            $('#delete_transients').prop('checked', false);
            $('#delete_cpt').prop('checked', false);
            $('#delete_old_tables').prop('checked', false);
        }
    });

    $(uninstall).on("click", function () {

        $('body').toggleClass('modula-uninstall-form-active');
        formContainer.fadeIn();

        formContainer.on('click', '#modula-uninstall-submit-form', function (e) {
            formContainer.addClass('toggle-spinner');
            var selectedOptions = {
                delete_options: ($('#delete_options').is(':checked')) ? 1 : 0,
                delete_transients: ($('#delete_transients').is(':checked')) ? 1 : 0,
                delete_cpt: ($('#delete_cpt').is(':checked')) ? 1 : 0,
                delete_old_tables: ($('#delete_old_tables').is(':checked')) ? 1 : 0,
            };

            var data = {
                'action': 'modula_uninstall_plugin',
                'security': wpModulaUninstall.nonce,
                'dataType': "json",
                'options': selectedOptions
            };

            $.post(
                ajaxurl,
                data,
                function (response) {
                    // Redirect to plugins page
                    window.location.href = wpModulaUninstall.redirect_url;
                }
            );
        });

        // If we click outside the form, the form will close
        // Stop propagation from form
        formContainer.on('click', function (e) {
            e.stopPropagation();
        });

        $('.modula-uninstall-form-wrapper, .close-uninstall-form').on('click', function (e) {
            e.stopPropagation();
            formContainer.fadeOut();
            $('body').removeClass('modula-uninstall-form-active');
        });

        $(document).on("keyup", function (e) {
            if ( e.key === "Escape" ) {
                formContainer.fadeOut();
                $('body').removeClass('modula-uninstall-form-active');
            }
        });
    });
});