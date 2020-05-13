(function ($) {
    "use strict";


    /**
     * Modula Importer
     *
     * @type {{init: init, runAjaxs: runAjaxs, ajaxTimeout: null, counts: number, processAjax: processAjax, ajaxRequests: [], completed: number, updateImported: updateImported, ajaxStarted: number, source: string}}
     */
    var modulaImporter = {
        counts: 0,
        completed: 0,
        ajaxRequests: [],
        ajaxStarted: 0,
        ajaxTimeout: null,
        source: '',
        modulaGalleryIds: {},


        init: function () {

            $('.modula-importer-wrapper input[type="submit"]').click(function (e) {
                e.preventDefault();
                modulaImporter.source    = $(this).parents('.modula-importer-wrapper').attr('source');
                modulaImporter.completed = 0;

                // Check if gallery was selected
                var galleries = $('#modula_importer_' + modulaImporter.source + ' input[name=gallery]:checked');
                if ( 0 == galleries.length ) {
                    alert(modula_importer.empty_gallery_selection);
                    return false;
                }

                // Disable input
                $('#modula_importer_' + modulaImporter.source + ' :input').prop('disabled', true);

                // Get array of IDs
                var id_array = [];
                $(galleries).each(function (i) {
                    if ( 'wp_core' == modulaImporter.source ) {
                        id_array[i] = $(this).attr('data-id');
                    } else {
                        id_array[i] = $(this).val();
                    }

                });

                modulaImporter.counts = id_array.length;
                modulaImporter.processAjax(id_array);

            });

        },

        processAjax: function (galleries_ids) {

            var delete_entries = 'keep';

            if ( $('#delete-old-entries').prop('checked') ) {
                delete_entries = 'delete';
            }

            galleries_ids.forEach(function (gallery_id) {

                var status = $('#modula_importer_' + modulaImporter.source + ' label[data-id=' + gallery_id + ']');
                var id     = gallery_id;
                var $gallery_title = false;
                $(status).removeClass().addClass('importing');
                $('span', $(status)).html(modula_importer.importing);
                // For WP core galleries in case we have multiple galleries in same page
                if('wp_core' == modulaImporter.source){
                    $gallery_title = $('input#wp_core-galleries-'+id).next('a').text();
                }

                if ( 'wp_core' == modulaImporter.source ) {
                    id = JSON.parse($('#modula_importer_wp_core input[data-id=' + gallery_id + ']').val());
                }

                var opts = {
                    url: modula_importer.ajax,
                    type: 'post',
                    async: true,
                    cache: false,
                    dataType: 'json',
                    data: {
                        action: 'modula_importer_' + modulaImporter.source + '_gallery_import',
                        id: id,
                        nonce: modula_importer.nonce,
                        clean: delete_entries,
                        gallery_title : $gallery_title
                    },
                    success: function (response) {

                        modulaImporter.completed = modulaImporter.completed + 1;

                        if ( !response.success ) {
                            status.find('span').text(response.message);

                            // don't need to updateImported for core galleries
                            if ( modulaImporter.counts == modulaImporter.completed && 'wp_core' != modulaImporter.source ) {
                                modulaImporter.updateImported(false, delete_entries);

                            }
                            return;
                        }

                        modulaImporter.modulaGalleryIds[gallery_id] = response.modula_gallery_id;

                        // Display result from AJAX call
                        status.find('span').html(response.message);

                        // Remove one ajax from queue
                        modulaImporter.ajaxStarted = modulaImporter.ajaxStarted - 1;

                        // don't need to updateImported for core galleries
                        if ( modulaImporter.counts == modulaImporter.completed && 'wp_core' != modulaImporter.source ) {
                            modulaImporter.updateImported(modulaImporter.modulaGalleryIds, delete_entries);
                        }
                    }
                };
                modulaImporter.ajaxRequests.push(opts);

            });
            modulaImporter.runAjaxs();

        },

        runAjaxs: function () {
            var currentAjax;

            while ( modulaImporter.ajaxStarted < 5 && modulaImporter.ajaxRequests.length > 0 ) {
                modulaImporter.ajaxStarted = modulaImporter.ajaxStarted + 1;
                currentAjax                = modulaImporter.ajaxRequests.shift();
                $.ajax(currentAjax);

            }

            if ( modulaImporter.ajaxRequests.length > 0 ) {
                modulaImporter.ajaxTimeout = setTimeout(function () {
                    console.log('Delayed 1s');
                    modulaImporter.runAjaxs();
                }, 1000);
            } else {
                $('#modula_importer_' + modulaImporter.source + ' :input').prop('disabled', false);
            }

        },
        // Update imported galleries
        updateImported: function (galleries_obj, delete_entries) {

            var data = {
                action: 'modula_importer_' + modulaImporter.source + '_gallery_imported_update',
                galleries: galleries_obj,
                clean: delete_entries,
                nonce: modula_importer.nonce,
            };

            $.post(ajaxurl, data, function (response) {
                window.location.href = response;
            });
        }

    };

    $(document).ready(function () {

        // Get galleries from sources
        $('#modula_select_gallery_source').on('change', function () {
            var targetID = $(this).val();

            // Hide the response if user goes through sources again
            if ( $('body').find('.update-complete').length ) {
                $('body').find('.update-complete').hide();
            }

            var data = {
                action: 'modula_importer_get_galleries',
                nonce: modula_importer.nonce,
                source: targetID
            };

            $.post(ajaxurl, data, function (response) {

                if ( !response ) {
                    return;
                }

                $('#modula-' + targetID + '-importer').removeClass('hide');
                $('#modula-' + targetID + '-importer').find('.modula-found-galleries').html(response);
                $('.modula-importer-row').not($('#modula-' + targetID + '-importer')).addClass('hide');
                if ( 'none' != targetID && $('#modula-' + targetID + '-importer').find('input[type="checkbox"]').not('#select-all-' + targetID).length > 0 ) {
                    $('.select-all-wrapper').removeClass('hide');
                } else {
                    $('#modula-' + targetID + '-importer .modula-importer-upsell-wrapper').addClass('hide');
                    $('#modula-' + targetID + '-importer .select-all-checkbox,#modula-' + targetID + '-importer .select-all-checkbox-wrapper').addClass('hide');
                    $('#modula-' + targetID + '-importer').find('input[type="submit"]').addClass('hide');
                    $('.select-all-wrapper').addClass('hide');
                }
            });

        });

        // Select all galleries from respective source
        $('body').on('click', '.modula-all-selection', function (e) {
            e.preventDefault();

            var checkboxes = $(this).parents('td').find('input[type="checkbox"]');
            if ( '#select_all' == $(this).attr('href') ) {
                checkboxes.each(function () {
                    if ( $(this).is(':visible') ) {
                        checkboxes.prop('checked', true);
                    }
                });
            } else {
                checkboxes.each(function () {
                    if ( $(this).is(':visible') ) {
                        checkboxes.prop('checked', false);
                    }
                });
            }
        });

        // Init importer
        modulaImporter.init();
    });

})(jQuery);