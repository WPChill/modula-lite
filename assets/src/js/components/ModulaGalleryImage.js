import ModulaGalleryImageInner from './ModulaGalleryImageInner';

const ModulaGalleryImage = (props) => {
	const { settings, effectCheck } = props.attributes;

	const { img, index } = props;

	return [
		<div
			className={`modula-item effect-${settings.effect}`}
			data-width={img['data-width'] ? img['data-width'] : '2'}
			data-height={img['data-height'] ? img['data-height'] : '2'}
		>
			<div className="modula-item-overlay" />

			<div className="modula-item-content">
				<img
					className={`modula-image pic`}
					data-id={img.id}
					data-full={img.src}
					data-src={img.src}
					data-valign="middle"
					data-halign="center"
					src={img.src}
				/>
				{'slider' !== settings.type && (
					<ModulaGalleryImageInner
						settings={settings}
						img={img}
						index={index}
						hideTitle={undefined != effectCheck && effectCheck.title == true ? false : true}
						hideDescription={undefined != effectCheck && effectCheck.description == true ? false : true}
						hideSocial={undefined != effectCheck && effectCheck.social == true ? false : true}
						effectCheck={effectCheck}
					/>
				)}
			</div>
		</div>
	];
};

export default wp.components.withFilters('modula.ModulaGalleryImage')(ModulaGalleryImage);
