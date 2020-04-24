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

            valueField: 'ID',
            labelField: 'post_title',
            searchField:'post_title',

            load: function(query, callback) {
                if (!query.length) return callback();
                    
                jQuery.ajax({
                    url: modula_elementor_ajax.ajax_url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'modula_elementor_ajax_search',
                        s: query,
                    },
                    error: function() {
                        callback();
                    },
                    success: function( response ) {
                        callback( response.data );
                    }
                });
            }
        });

    });

});