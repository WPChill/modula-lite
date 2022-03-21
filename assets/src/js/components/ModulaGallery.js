const { Fragment, useEffect } = wp.element;

import ModulaGalleryImage from './ModulaGalleryImage';
import ModulaStyle from './ModulaStyle';
import ModulaItemsExtraComponent from './ModulaItemsExtraComponent';

export const ModulaGallery = (props) => {
	const { images, jsConfig, id } = props.attributes;
	const { settings, checkHoverEffect, modulaRun, modulaSlickRun } = props;

	useEffect(() => {
		if (settings !== undefined) {
			checkHoverEffect(settings.effect);
		}
		if ('slider' !== settings.type) {
			modulaRun(jsConfig);
		} else {
			modulaSlickRun(id);
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
			<div
				id={`jtg-${id}`}
				className={`${galleryClassNames} ${props.attributes.modulaDivClassName != undefined
					? props.attributes.modulaDivClassName
					: ''}`}
				data-config={JSON.stringify(jsConfig)}
			>
				{settings.type == 'grid' && 'automatic' != settings.grid_type && <div className="modula-grid-sizer"> </div>}
				<ModulaItemsExtraComponent {...props} position={'top'} />
				<div className={itemsClassNames}>
					{images.length > 0 && (
						<Fragment>
							<Fragment>
								{images.map((img, index) => {
									return [ <ModulaGalleryImage {...props} img={img} key={index} index={index} /> ];
								})}
							</Fragment>
						</Fragment>
					)}
				</div>
				<ModulaItemsExtraComponent {...props} position={'bottom'} />
			</div>
		</Fragment>
	];
};

export default wp.components.withFilters('modula.modulaGallery')(ModulaGallery);
