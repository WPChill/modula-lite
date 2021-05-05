const { __ } = wp.i18n;
const { Component, Fragment, useEffect, useState } = wp.element;
const { withSelect } = wp.data;
const { SelectControl, Button, Spinner, Toolbar, IconButton } = wp.components;
const { BlockControls } = wp.editor;
const { compose } = wp.compose;
const { __experimentalInputControl } = wp.components;

export const ModulaGallerySearch = (props) => {
	const { onIdChange, id, options } = props;

	useEffect(() => {
		jQuery('.modula-gallery-input').selectize({
			valueField: 'value',
			labelField: 'label',
			searchField: [ 'label', 'value' ],
			create: false,
			maxItems: 1,
			placeholder: 'Search for a gallery...',
			preload: true,
			allowEmptyOptions: true,
			closeAfterSelect: true,
			options: options,
			render: {
				option: function(item, escape) {
					return (
						'<div>' +
						'<span class="title">' +
						escape(item.label) +
						'<span class="name">( #' +
						escape(item.value) +
						' )</span>' +
						'</div>'
					);
				}
			},
			load: function(query, callback) {
				if (!query.length) {
					return callback();
				}

				jQuery.ajax({
					url: modulaVars.ajaxURL,
					type: 'GET',
					data: {
						action: 'modula_get_gallery',
						nonce: modulaVars.nonce,
						term: query
					},
					success: (res) => {
						callback(res);
					}
				});
			},
			onChange: (value) => {
				onIdChange(value);
			}
		});
	}, []);

	return <input className="modula-gallery-input" value={'0' == id ? '' : id} />;
};

export default ModulaGallerySearch;
