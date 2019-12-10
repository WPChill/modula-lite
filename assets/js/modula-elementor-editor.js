jQuery(function ($) {

    elementor.hooks.addAction('panel/open_editor/widget/modula_elementor_gallery', function (panel, model, view) {

        // Get search input
        search_input = panel.$el.find('select[data-setting="modula_gallery_select"]');

        var search_input_active = model.attributes.settings.attributes.modula_gallery_select;

        var search_val, timer, selective_input;

        // Initialize the selectize
        search_input.selectize({
            create: false,
            maxItems: 1,
            closeAfterSelect: true,
        });

        // Get selectize search input
        selective_input = search_input.next().find('input');


        jQuery.post(modula_elementor_ajax.ajax_url, {
            action: 'modula_elementor_ajax_search',
            search_value: ('none' != search_input_active) ? search_input_active : '',
            search_title: ('none' != search_input_active) ? false : true
        }, function (data) {

            // unfocus the input so that we could refresh the options
            selective_input.blur().focus();

            var e = jQuery.parseJSON(data);

            jQuery.each(e, function (key, value) {

                var selOpt = {
                    value: value.value,
                    text: value.text
                };

                // Add new options and refresh them
                search_input[0].selectize.addOption(selOpt);
                search_input[0].selectize.refreshOptions();
            });

            if (search_input_active) {
                search_input[0].selectize.addItem(search_input_active);
            }

        });

        selective_input.on('keyup', function () {

            clearTimeout(timer);

            if (search_val !== jQuery(this).val()) {

                timer = setTimeout(function () {

                    // Clear existing options from the selection
                    if (search_input[0].selectize) {
                        search_input[0].selectize.clearOptions();
                        search_input[0].selectize.refreshOptions();

                    }

                    jQuery.post(modula_elementor_ajax.ajax_url, {
                        action: 'modula_elementor_ajax_search',
                        search_value: selective_input.val(),
                        search_title: true
                    }, function (data) {

                        // unfocus the input so that we could refresh the options
                        selective_input.blur().focus();

                        var e = jQuery.parseJSON(data);

                        jQuery.each(e, function (key, value) {

                            var selOpt = {
                                value: value.value,
                                text: value.text
                            };

                            // Add new options and refresh them
                            search_input[0].selectize.addOption(selOpt);
                            search_input[0].selectize.refreshOptions();
                            //search_input[0].selectize.$control.find('input').val(search_val);
                        });

                    });

                }, 1200);
                search_val = jQuery(this).val();
            }

        });

    });

});