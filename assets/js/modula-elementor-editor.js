jQuery(function ($) {

    elementor.hooks.addAction('panel/open_editor/widget/modula_elementor_gallery', function (panel, model, view) {

        // Get search input
        search_input = panel.$el.find('select[data-setting="modula_gallery_select"]');

        var search_input_val = search_input.val();

        console.log(search_input_val);


        var search_val, timer, selective_input;

        // Initialize the selectize
        search_input.selectize({
            create: false,
            labelField: 'title',
            valueField: 'id',
            maxItems: 1,
            closeAfterSelect: true,
            render: {
                item: function (item, escape) {
                    return "<option id='" + item.id + "'>" + escape(item.title) + "</option>";
                },
                option: function (item, escape) {
                    return "<option id='" + item.id + "'>" + escape(item.title) + "</option>";
                }
            }
        });

        // Add active item
        search_input[0].selectize.addOption({'id' : search_input_val,'title':'test'});
        search_input[0].selectize.addItem({'id' : search_input_val});
        search_input[0].selectize.refreshOptions();

        // Get selectize search input
        selective_input = search_input.next().find('input');


        jQuery.post(modula_elementor_ajax.ajax_url, {
            action: 'modula_elementor_ajax_search',
            search_value: selective_input.val()
        }, function (data) {

            // unfocus the input so that we could refresh the options
            selective_input.blur().focus();

            var e = jQuery.parseJSON(data);

            jQuery.each(e, function (key, value) {

                var selOpt = {
                    'id': value.value,
                    'title': value.text
                };

                // Add new options and refresh them
                search_input[0].selectize.addOption(selOpt);
                search_input[0].selectize.refreshOptions();
                //search_input[0].selectize.$control.find('input').val(search_val);
            });

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
                        search_value: selective_input.val()
                    }, function (data) {

                        // unfocus the input so that we could refresh the options
                        selective_input.blur().focus();

                        var e = jQuery.parseJSON(data);

                        jQuery.each(e, function (key, value) {

                            var selOpt = {
                                'id': value.value,
                                'title': value.text
                            };

                            // Add new options and refresh them
                            search_input[0].selectize.addOption(selOpt);
                            search_input[0].selectize.refreshOptions();
                            //search_input[0].selectize.$control.find('input').val(search_val);
                        });

                    });

                }, 1200);
                search_val = jQuery(this).val();
                //search_input.val(search_val);
                //search_input[0].selectize.$control.find('input').val(search_val);
            }

        });

    });

});