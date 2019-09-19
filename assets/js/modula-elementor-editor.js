jQuery(function ($) {

    elementor.hooks.addAction('panel/open_editor/widget/modula_elementor_gallery', function (panel, model, view) {

        // Get search input
        search_input = panel.$el.find('input[data-setting="modula_gallery_ajax"]');

        var search_val, timer, selective_input;

        // Initialize the selectize
        search_input.selectize({
            create: false,
            labelField: 'title',
            valueField: 'id',
            render: {
                item: function (item, escape) {
                    return "<option id='" + item.id + "'>" + escape(item.title) + "</option>";
                },
                option: function (item, escape) {
                    return "<option id='" + item.id + "'>" + escape(item.title) + "</option>";
                }
            }
        });

        // Get selectize search input
        selective_input = search_input.next().find('input');

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
                        search_value: selective_input.val()
                    }, function (data) {

                        // unfocus the input so that we could refresh the options
                        selective_input.blur();

                        var e = jQuery.parseJSON(data);

                        jQuery.each(e, function (key, value) {

                            var selOpt = {
                                'id': key,
                                'title': value.text
                            };

                            // Add new options and refresh them
                            search_input[0].selectize.addOption(selOpt);
                            search_input[0].selectize.refreshOptions();
                        });

                    });

                }, 800);

                search_val = jQuery(this).val();
            }

        });

    });

});