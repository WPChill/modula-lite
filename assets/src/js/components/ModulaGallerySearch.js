const { useEffect } = wp.element;

export const ModulaGallerySearch = (props) => {
	const { onIdChange, id, options, galleries } = props;

	useEffect(() => {
		let galleriesArray = [];
		if (galleries != undefined && 0 == galleriesArray.length) {
			galleries.forEach((gallery) => {
				galleriesArray.push({
					value: gallery.id,
					label: gallery.title.rendered,
				});
			});
		}
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
			options: options.concat(galleriesArray),
			render: {
				option: function(item, escape) {
					return (
						'<div>' +
						'<span className="title">' +
						item.label+
						'<span className="name">( #' +
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

	return <input className="modula-gallery-input" defaultValue={'0' == id ? '' : id} />;
};

export default ModulaGallerySearch;
