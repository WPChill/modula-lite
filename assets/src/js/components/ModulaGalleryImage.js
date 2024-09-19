import ModulaGalleryImageInner from './ModulaGalleryImageInner';

const ModulaGalleryImage = (props) => {
	const { settings, effectCheck } = props.attributes;
	const { img, index } = props;
	
	let itemClassNames = `modula-item effect-${settings.effect}`;
	if (settings.type === 'slider') {
		itemClassNames = 'modula-item f-carousel__slide';
	}

	const renderMedia = () => {
		if (!img.video_template || img.video_template !== '1' || !img.video_type) {
			// Return image element if video_template is not defined or is not '1'
			return (
				<img
					className="modula-image pic"
					data-id={img.id}
					data-full={img.src}
					data-src={img.src}
					data-valign="middle"
					data-halign="center"
					src={img.src}
				/>
			);
		} else if (img.video_template == '1' && 'undefined' != typeof img.video_thumbnail && '' != img.video_thumbnail ) {
			// Return image thumbnail of video
			return (
				<img
					className="modula-image pic"
					data-id={img.id}
					data-full={img.src}
					data-src={img.video_thumbnail}
					data-valign="middle"
					data-halign="center"
					src={img.video_thumbnail}
				/>
			);
		} else if (img.video_type === 'hosted') {
			// Return video element if video_type is 'hosted'
			return (
				<div className="video-sizer">
					<video controls>
						<source src={img.src} type="video/mp4" />
						Your browser does not support the video tag.
					</video>
				</div>
			);
		} else if (img.video_type === 'iframe') {
			// Return iframe element if video_type is 'iframe'
			return (
				<div className="video-sizer">
					<iframe
						src={img.src}
						frameBorder="0"
						allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
						allowFullScreen
					></iframe>
				</div>
			);
		}
	};

	return (
		<div
			className={itemClassNames}
			data-width={img['data-width'] ? img['data-width'] : '2'}
			data-height={img['data-height'] ? img['data-height'] : '2'}
		>
			<div className="modula-item-overlay" />
			<div className="modula-item-content">
				{renderMedia()}
				{settings.type !== 'slider' && (
					<ModulaGalleryImageInner
						settings={settings}
						img={img}
						index={index}
						key={index}
						hideTitle={
							effectCheck && effectCheck.title ? false : true
						}
						hideDescription={
							effectCheck && effectCheck.description ? false : true
						}
						hideSocial={
							effectCheck && effectCheck.social ? false : true
						}
						effectCheck={effectCheck}
					/>
				)}
			</div>
		</div>
	);
};


export default wp.components.withFilters('modula.ModulaGalleryImage')(
	ModulaGalleryImage
);
