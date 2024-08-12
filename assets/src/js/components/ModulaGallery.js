const { Fragment, useEffect, useRef } = wp.element;

import ModulaGalleryImage from './ModulaGalleryImage';
import ModulaStyle from './ModulaStyle';
import ModulaItemsExtraComponent from './ModulaItemsExtraComponent';

export const ModulaGallery = (props) => {
	const { images, jsConfig, id } = props.attributes;
	const { settings, checkHoverEffect, modulaRun, modulaCarouselRun } = props;
	const galleryRef = useRef(null);

	useEffect(() => {
		if (galleryRef.current) {
			galleryRef.current = true;
			return;
		}
		if (settings !== undefined) {
			checkHoverEffect(settings.effect);
		}
		if ('slider' !== settings.type) {
			modulaRun(jsConfig);
		} else {
			modulaCarouselRun(id);
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
	} else if (settings.type == 'bnb') {
		galleryClassNames += 'modula-gallery-bnb';
	} else {
		galleryClassNames += 'modula-columns';
		itemsClassNames += ' grid-gallery';
		if (settings.grid_type == 'automatic') {
			itemsClassNames += ' justified-gallery';
		}
	}

	return (
		<Fragment>
			<ModulaStyle id={id} settings={settings} />
			<div
				id={`jtg-${id}`}
				className={`${galleryClassNames} ${
					props.attributes.modulaDivClassName != undefined
						? props.attributes.modulaDivClassName
						: ''
				}`}
				data-config={JSON.stringify(jsConfig)}
			>
				{settings.type == 'grid' &&
					'automatic' != settings.grid_type && (
						<div className="modula-grid-sizer"> </div>
					)}
				<ModulaItemsExtraComponent {...props} position={'top'} />
				<div className={itemsClassNames}>
					{images.length > 0 && (
						<Fragment>
							{settings.type === 'bnb' ? (
								<Fragment>
									<div className="modula_bnb_main_wrapper">
										<ModulaGalleryImage
											{...props}
											img={images[0]}
											key={images[0].id}
											index={0}
										/>
									</div>
									<div className="modula_bnb_items_wrapper">
										{images.slice(1).map((img, index) => (
											<ModulaGalleryImage
												{...props}
												img={img}
												key={img.id}
												index={index + 1}
											/>
										))}
									</div>
								</Fragment>
							) : (
								images.map((img, index) =>
									img.id ? (
										<ModulaGalleryImage
											{...props}
											img={img}
											key={img.id}
											index={index}
										/>
									) : null
								)
							)}
						</Fragment>
					)}
				</div>
				<ModulaItemsExtraComponent {...props} position={'bottom'} />
			</div>
		</Fragment>
	);
};

export default wp.components.withFilters('modula.modulaGallery')(ModulaGallery);
