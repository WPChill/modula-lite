jQuery(function ($) {

    elementor.hooks.addAction('panel/open_editor/widget/modula_elementor_gallery', function (panel, model, view) {

        search_input = panel.$el.find('select[data-setting="modula_gallery_ajax"]');

        var search_val, timer;

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

        selective_input = search_input.next('.selectize-control').find('input');

        selective_input.on('keyup', function () {

            console.log(search_val,jQuery(this).val());

            clearTimeout(timer);

            if (search_val !== jQuery(this).val()) {

                timer = setTimeout(function () {

                    console.log(search_input[0].selectize);

                    if (search_input[0].selectize) {
                        search_input[0].selectize.destroy();
                    }

                    jQuery.post(modula_elementor_ajax.ajax_url, {
                        action: 'modula_elementor_ajax_search',
                        search_value: search_input.val()
                    }, function (data) {

                        var e = jQuery.parseJSON(data);
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

                        jQuery.each(e, function (key, value) {
                            var selOpt = {
                                'id': key,
                                'title': value
                            };

                            search_input[0].selectize.addOption(selOpt);
                            search_input[0].selectize.refreshOptions();
                        });
                    });
                }, 1500);

                search_val = jQuery(this).val();
            }

        });

    });

});