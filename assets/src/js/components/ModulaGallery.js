const { __ } = wp.i18n;
const { Component, Fragment, useEffect } = wp.element;

import ModulaGalleryImage from './ModulaGalleryImage';
import ModulaStyle from './ModulaStyle';

export const ModulaGallery = (props) => {
	const { images, jsConfig, id } = props.attributes;
	const { settings, galleryId, checkHoverEffect, modulaRun } = props;

	useEffect(() => {
		if (settings !== undefined) {
			checkHoverEffect(settings.effect);
		}
		if (jsConfig !== undefined) {
			modulaRun(jsConfig);
		}
	}, []);

	let galleryClassNames = 'modula modula-gallery ';
	let itemsClassNames = 'modula-items';
	if (settings.type == 'creative-gallery') {
		galleryClassNames += 'modula-creative-gallery';
	} else if (settings.type == 'custom-grid') {
		galleryClassNames += 'modula-custom-grid';
	} else if (settings.type == 'slider') {
		galleryClassNames = 'modula-slider';
	} else {
		galleryClassNames += 'modula-columns';
		itemsClassNames += ' grid-gallery';
		if (settings.grid_type == 'automatic') {
			itemsClassNames += ' justified-gallery';
		}
	}

	return [
		<Fragment>
			<ModulaStyle id={id} settings={settings} />
			<div id={`jtg-${id}`} className={galleryClassNames} data-config={jsConfig}>
				{settings.type == 'grid' && 'automatic' != settings.grid_type && <div class="modula-grid-sizer"> </div>}
				<div className={itemsClassNames}>
					{images.length > 0 && (
						<Fragment>
							<Fragment>
								{images.map((img, index) => {
									return [ <ModulaGalleryImage {...props} img={img} index={index} /> ];
								})}
							</Fragment>
						</Fragment>
					)}
				</div>
			</div>
		</Fragment>
	];
};

export default wp.components.withFilters('modula.modulaGallery')(ModulaGallery);
