jQuery(function ($) {

    elementor.hooks.addAction('panel/open_editor/widget/modula_elementor_gallery', function (panel, model, view) {

        var search_input = panel.$el.find('input[data-setting="modula_gallery_ajax"]');
        var search_val = '';
        search_input.on('keyup', function () {
            if (search_val !== jQuery(this).val()) {

                jQuery.post(modula_elementor_ajax.ajax_url, {
                    action: 'modula_elementor_ajax_search',
                    search_value: jQuery(this).val()
                }, function (data) {

                });
                search_val = jQuery(this).val();
            }

        });

    });

});