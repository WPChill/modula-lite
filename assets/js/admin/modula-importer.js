( function ( $ ) {
	"use strict";


	/**
	 * Modula Importer
	 *
	 * @type {{init: init, runAjaxs: runAjaxs, ajaxTimeout: null, counts: number, processAjax: processAjax, ajaxRequests: [], completed: number, updateImported: updateImported, ajaxStarted: number, source: string, attachments: [], importChunk: string, modulaGalleryIds: {}}}
	 */
	var modulaImporter = {
		counts:           0,
		completed:        0,
		ajaxRequests:     [],
		ajaxStarted:      1,
		ajaxTimeout:      null,
		source:           '',
		modulaGalleryIds: {},
		attachments:      [],
		importChunk:      5,


		init: function () {

			$( '.modula-importer-wrapper input[type="submit"]' ).click( function ( e ) {
				e.preventDefault();
				modulaImporter.source = $( this ).parents( '.modula-importer-wrapper' ).attr( 'source' );
				modulaImporter.completed = 0;
				modulaImporter.attachments = [];

				// Check if gallery was selected
				var galleries = $( '#modula_importer_' + modulaImporter.source + ' input[name=gallery]:checked' );
				if ( 0 == galleries.length ) {
					alert( modula_importer.empty_gallery_selection );
					return false;
				}

				// Disable input
				$( '#modula_importer_' + modulaImporter.source + ' :input' ).prop( 'disabled', true );

				// Get array of IDs
				var id_array = [];
				$( galleries ).each( function ( i ) {
					if ( 'wp_core' == modulaImporter.source ) {
						id_array[i] = $( this ).attr( 'data-id' );
					} else {
						id_array[i] = $( this ).val();
					}

				} );

				modulaImporter.processAjax( id_array );

			} );

		},

		processAjax: function ( galleries_ids ) {

			var delete_entries = 'keep';

			if ( $( '#delete-old-entries' ).prop( 'checked' ) ) {
				delete_entries = 'delete';
			}

			galleries_ids.forEach( function ( gallery_id ) {

				var status = $( '#modula_importer_' + modulaImporter.source + ' label[data-id=' + gallery_id + ']' );
				var id = gallery_id;
				var image_count = $( 'input[data-id="' + gallery_id + '"]' ).data( 'image-count' );
				var opts_chunks = {};
				var $gallery_title = false;
				var $i = 0;

				$( status ).removeClass().addClass( 'importing' );
				$( 'span', $( status ) ).not( '.importing-status' ).html( modula_importer.importing );
				// For WP core galleries in case we have multiple galleries in same page
				if ( 'wp_core' == modulaImporter.source ) {
					$gallery_title = $( 'input#wp_core-galleries-' + id ).next( 'a' ).text();
				}

				if ( 'wp_core' == modulaImporter.source ) {
					id = JSON.parse( $( '#modula_importer_wp_core input[data-id=' + gallery_id + ']' ).val() );
				}

				if ( !status.data( 'imported' ) ) {

					modulaImporter.counts += Math.floor( image_count / modulaImporter.importChunk ) + 1;

					// We make enough AJAX calls so we can import all the chunks
					for ( $i = 0; $i <= image_count; $i += modulaImporter.importChunk ) {

						opts_chunks = {
							url:      modula_importer.ajax,
							type:     'post',
							async:    true,
							cache:    false,
							dataType: 'json',
							data:     {
								action: 'modula_ajax_import_images',
								id:     id,
								nonce:  modula_importer.nonce,
								chunk:  $i,
								source: modulaImporter.source
							},
							success:  function ( response ) {

								modulaImporter.ajaxStarted = modulaImporter.ajaxStarted - 1;

								if ( response && 'undefined' != typeof response.attachments ) {
									$.merge( modulaImporter.attachments, response.attachments );
								}

								if ( $( 'span.importing-status', $( status ) ).length ) {
									$( 'span.importing-status', $( status ) ).html( 'Imported:' + modulaImporter.attachments.length + ' / ' + image_count );
								}

								modulaImporter.completed = modulaImporter.completed + 1;

								if ( 'end_of_array' == response.end_of_array ) {

									// Final AJAX call after we imported all chunks and reached the end of the array
									var opts = {
										url:      modula_importer.ajax,
										type:     'post',
										async:    true,
										cache:    false,
										dataType: 'json',
										data:     {
											action:        'modula_importer_' + modulaImporter.source + '_gallery_import',
											id:            id,
											nonce:         modula_importer.nonce,
											clean:         delete_entries,
											gallery_title: $gallery_title,
											attachments:   modulaImporter.attachments,
											source:        modulaImporter.source
										},
										success:  function ( response ) {

											if ( !response.success ) {
												status.find( 'span' ).not( '.importing-status' ).text( response.message );

												// don't need to updateImported for core galleries
												if ( modulaImporter.counts == modulaImporter.completed && 'wp_core' != modulaImporter.source ) {
													modulaImporter.updateImported( false, delete_entries );
												}
												return;
											}

											modulaImporter.modulaGalleryIds[id] = response.modula_gallery_id;

											// Display result from AJAX call
											status.find( 'span' ).not( '.importing-status' ).html( response.message );

											// don't need to updateImported for core galleries
											if ( modulaImporter.counts == modulaImporter.completed && 'wp_core' != modulaImporter.source ) {
												modulaImporter.updateImported( modulaImporter.modulaGalleryIds, delete_entries );
											}
										}
									};

									$.ajax( opts );
									modulaImporter.attachments = [];
								}

							}
						};

						modulaImporter.ajaxRequests.push( opts_chunks );
						opts_chunks = {};
					}
				} else {

					modulaImporter.counts += 1;

					var opts = {
						url:      modula_importer.ajax,
						type:     'post',
						async:    true,
						cache:    false,
						dataType: 'json',
						data:     {
							action:        'modula_importer_' + modulaImporter.source + '_gallery_import',
							id:            id,
							nonce:         modula_importer.nonce,
							clean:         delete_entries,
							source:        modulaImporter.source,
							imported:      true
						},
						success:  function ( response ) {

							modulaImporter.ajaxStarted = modulaImporter.ajaxStarted - 1;

							if ( !response.success ) {
								status.find( 'span' ).not( '.importing-status' ).text( response.message );

								modulaImporter.completed = modulaImporter.completed + 1;
								// don't need to updateImported for core galleries
								if ( modulaImporter.counts == modulaImporter.completed && 'wp_core' != modulaImporter.source ) {
									modulaImporter.updateImported( false, delete_entries );
								}
								return;
							}

							modulaImporter.modulaGalleryIds[id] = response.modula_gallery_id;

							// Display result from AJAX call
							status.find( 'span' ).not( '.importing-status' ).html( response.message );

							modulaImporter.completed = modulaImporter.completed + 1;

							// don't need to updateImported for core galleries
							if ( modulaImporter.counts == modulaImporter.completed && 'wp_core' != modulaImporter.source ) {
								modulaImporter.updateImported( modulaImporter.modulaGalleryIds, delete_entries );
							}
						}
					};

					modulaImporter.ajaxRequests.push( opts );
					modulaImporter.attachments = [];
				}

			} );

			modulaImporter.runAjaxs();

		},

		runAjaxs:       function () {
			var currentAjax;
			while ( modulaImporter.ajaxStarted < 2 && modulaImporter.ajaxRequests.length > 0 ) {
				modulaImporter.ajaxStarted = modulaImporter.ajaxStarted + 1;
				currentAjax = modulaImporter.ajaxRequests.shift();
				$.ajax( currentAjax );

			}

			if ( modulaImporter.ajaxRequests.length > 0 ) {

				modulaImporter.ajaxTimeout = setTimeout( function () {
					console.log( 'Delayed 1s' );
					modulaImporter.runAjaxs();
				}, 1000 );
			} else {
				$( '#modula_importer_' + modulaImporter.source + ' :input' ).prop( 'disabled', false );
			}

		},
		// Update imported galleries
		updateImported: function ( galleries_obj, delete_entries ) {

			var data = {
				action:    'modula_importer_' + modulaImporter.source + '_gallery_imported_update',
				galleries: galleries_obj,
				clean:     delete_entries,
				nonce:     modula_importer.nonce,
			};

			$.post( ajaxurl, data, function ( response ) {
				window.location.href = response;
			} );
		},
	};

	$( document ).ready( function () {

		// Get galleries from sources
		$( '#modula_select_gallery_source' ).on( 'change', function () {
			var targetID = $( this ).val();

			// Hide the response if user goes through sources again
			if ( $( 'body' ).find( '.update-complete' ).length ) {
				$( 'body' ).find( '.update-complete' ).hide();
			}

			var data = {
				action: 'modula_importer_get_galleries',
				nonce:  modula_importer.nonce,
				source: targetID
			};

			$.post( ajaxurl, data, function ( response ) {

				if ( !response ) {
					return;
				}

				$( '#modula-' + targetID + '-importer' ).removeClass( 'hide' );
				$( '#modula-' + targetID + '-importer' ).find( '.modula-found-galleries' ).html( response );
				$( '.modula-importer-row' ).not( $( '#modula-' + targetID + '-importer' ) ).addClass( 'hide' );
				if ( 'none' != targetID && $( '#modula-' + targetID + '-importer' ).find( 'input[type="checkbox"]' ).not( '#select-all-' + targetID ).length > 0 ) {
					$( '.select-all-wrapper' ).removeClass( 'hide' );
				} else {
					$( '#modula-' + targetID + '-importer .modula-importer-upsell-wrapper' ).addClass( 'hide' );
					$( '#modula-' + targetID + '-importer .select-all-checkbox,#modula-' + targetID + '-importer .select-all-checkbox-wrapper' ).addClass( 'hide' );
					$( '#modula-' + targetID + '-importer' ).find( 'input[type="submit"]' ).addClass( 'hide' );
					$( '.select-all-wrapper' ).addClass( 'hide' );
				}
			} );

		} );

		// Select all galleries from respective source
		$( 'body' ).on( 'click', '.modula-all-selection', function ( e ) {
			e.preventDefault();

			var checkboxes = $( this ).parents( 'td' ).find( 'input[type="checkbox"]' );
			if ( '#select_all' == $( this ).attr( 'href' ) ) {
				checkboxes.each( function () {
					if ( $( this ).is( ':visible' ) ) {
						checkboxes.prop( 'checked', true );
					}
				} );
			} else {
				checkboxes.each( function () {
					if ( $( this ).is( ':visible' ) ) {
						checkboxes.prop( 'checked', false );
					}
				} );
			}
		} );

		// Init importer
		modulaImporter.init();
	} );

} )( jQuery );