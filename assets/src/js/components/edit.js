/**
 * Internal dependencies
 */
import Inspector from './inspector';
import ModulaGallery from './ModulaGallery';
import ModulaGallerySearch from './ModulaGallerySearch';
import icons from '../utils/icons';
/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Fragment, useEffect, useState } = wp.element;
const { withSelect } = wp.data;
const { Button, Spinner, ToolbarGroup, ToolbarItem } = wp.components;
const { BlockControls } = wp.blockEditor;
const { compose } = wp.compose;

export const ModulaEdit = (props) => {
	const { attributes, galleries, setAttributes } = props;
	const {
		id,
		images,
		status,
		settings,
		jsConfig,
		galleryId,
		currentGallery,
		currentSelectize,
	} = attributes;

	// Check when the alignmnent is changed so we can resize the instance
	const [alignmentCheck, setAlignment] = useState(props.attributes.align);

	// Check when id is changed and it is not a component rerender . Saves unnecessary fetch requests
	const [idCheck, setIdCheck] = useState(id);

	useEffect(() => {
		if (id !== 0) {
			onIdChange(id);
		}
	}, []);

	useEffect(() => {
		//Grab the instance and set it as atribute to access it when we want
		jQuery(document).on('modula_api_after_init', function (event, inst) {
			props.setAttributes({ instance: inst });
		});

		if (
			props.attributes.instance != undefined &&
			settings != undefined &&
			settings.type == 'grid'
		) {
			props.attributes.instance.reset(props.attributes.instance);
		}
	});

	const onIdChange = (id) => {
		if (isNaN(id) || '' == id) {
			return;
		}
		id = parseInt(id);

		wp.apiFetch({ path: `wp/v2/modula-gallery/${id}` }).then((res) => {
			setAttributes({ currentGallery: res });
			setAttributes({
				currentSelectize: [
					{
						value: id,
						label:
							'' === res.title.rendered
								? `Unnamed`
								: escapeHtml( res.title.rendered ),
					},
				],
			});

			jQuery.ajax({
				type: 'POST',
				data: {
					action: 'modula_get_gallery_meta',
					id: id,
					nonce: modulaVars.nonce,
				},
				url: modulaVars.ajaxURL,
				success: (result) => onGalleryLoaded(id, result),
			});
		});
	};
	function escapeHtml(text) {
		return text
			.replace("&#8217;", "'" )
			.replace("&#8220;", '"' )
			.replace("&#8216;", "'" );
	  }
	  
		  const onGalleryLoaded = (id, result) => {
		if (result.success === false) {
			setAttributes({ id: id, status: 'ready' });
			return;
		}
		if (idCheck != id || undefined == settings) {
			getSettings(id);
		}
		setAttributes({ id: id, images: result, status: 'ready' });
	};
	const getSettings = (id) => {
		fetch(`${modulaVars.restURL}wp/v2/modula-gallery/${id}`)
			.then((res) => res.json())
			.then((result) => {
				let settings = result;
				setAttributes({ status: 'loading' });
				jQuery.ajax({
					type: 'POST',
					data: {
						action: 'modula_get_jsconfig',
						nonce: modulaVars.nonce,
						settings: settings.modulaSettings,
					},
					url: modulaVars.ajaxURL,
					success: (result) => {
						let galleryId = Math.floor(Math.random() * 999);

						setAttributes({
							galleryId: galleryId,
							settings: settings.modulaSettings,
							jsConfig: result,
							status: 'ready',
						});
					},
				});
			});
	};

	const modulaRun = (checker) => {
		if (checker != undefined) {
			setAttributes({ status: 'ready' });
			var modulaGalleries = jQuery('.modula.modula-gallery');

			jQuery.each(modulaGalleries, function () {
				var modulaID = jQuery(this).attr('id'),
					modulaSettings = jQuery(this).data('config');
				modulaSettings.lazyLoad = 0;

				jQuery(this).modulaGallery(modulaSettings);
			});
		}
	};

	const modulaSlickRun = (id) => {
		id = `jtg-${id}`;
		setAttributes({ status: 'ready' });
		const modulaSliders = jQuery('.modula-slider');
		if (modulaSliders.length > 0 && 'undefined' != typeof jQuery.fn.slick) {

			let config = jQuery( `#${id}` ).data('config'),
				nav = jQuery(`#${id}`).find('.modula-slider-nav'),
				main = jQuery(`#${id}`).find('.modula-items');

			main.slick(config.slider_settings);

			if (nav.length) {
				let navConfig = nav.data('config'),
					currentSlide = main.slick('slickCurrentSlide');

				nav.on('init', function (event, slick) {
					nav.find(
						'.slick-slide[data-slick-index="' + currentSlide + '"]'
					).addClass('is-active');
				});

				nav.slick(navConfig);

				main.on('afterChange', function (event, slick, currentSlide) {
					nav.slick('slickGoTo', currentSlide);
					let currrentNavSlideElem =
						'.slick-slide[data-slick-index="' + currentSlide + '"]';
					nav.find('.slick-slide.is-active').removeClass('is-active');
					nav.find(currrentNavSlideElem).addClass('is-active');
				});

				nav.on('click', '.slick-slide', function (event) {
					event.preventDefault();
					let goToSingleSlide = jQuery(this).data('slick-index');
					main.slick('slickGoTo', goToSingleSlide);
				});
			}
		}
	};

	const checkHoverEffect = (effect) => {
		jQuery.ajax({
			type: 'POST',
			data: {
				action: 'modula_check_hover_effect',
				nonce: modulaVars.nonce,
				effect: effect,
			},
			url: modulaVars.ajaxURL,
			success: (result) => {
				setAttributes({ effectCheck: result });
			},
		});
	};

	const selectOptions = () => {
		let options = [
			{
				value: 0,
				label: __('select a gallery', 'modula-best-grid-gallery'),
			},
		];

		galleries.forEach(function ({ title, id }) {
			if (title.rendered.length == 0) {
				options.push({
					value: id,
					label:
						__('Unnamed Gallery', 'modula-best-grid-gallery') + id,
				});
			} else {
				options.push({ value: id, label: title.rendered });
			}
		});

		return options;
	};

	const blockControls = (
		<BlockControls>
			{images && images.length > 0 && (
				<ToolbarGroup>
					<ToolbarItem>
						<Button
							label={__(
								'Edit gallery',
								'modula-best-grid-gallery'
							)}
							icon="edit"
							href={
								modulaVars.adminURL +
								'post.php?post=' +
								id +
								'&action=edit'
							}
							target="_blank"
						/>
					</ToolbarItem>
				</ToolbarGroup>
			)}
		</BlockControls>
	);

	if (id == 0 && 'none' === attributes.galleryType) {
		return (
			<Fragment>
				<div className="modula-block-preview">
					<div className="modula-block-preview__content">
						<div className="modula-block-preview__logo" />
						<div className="modula-button-group">
							{galleries.length == 0 && (
								<p>
									{' '}
									{__(
										'Sorry no galleries found',
										'modula-best-grid-gallery'
									)}{' '}
								</p>
							)}
							{galleries.length > 0 && (
								<Button
									className="modula-button"
									target="_blank"
									onClick={(e) => {
										setAttributes({
											status: 'ready',
											id: 0,
											galleryType: 'gallery',
										});
									}}
								>
									{__(
										'Display An Existing Gallery',
										'modula-best-grid-gallery'
									)}
									{icons.chevronRightFancy}
								</Button>
							)}
							{undefined == props.attributes.proInstalled &&
								galleries.length > 0 && (
									<Button
										href="https://wp-modula.com/pricing/?utm_source=modula-lite&utm_campaign=upsell"
										className="modula-button-upsell"
										isSecondary
										target="_blank"
									>
										{__(
											'Upgrade to PRO to create galleries using a preset ( fastest way )',
											'modula-best-grid-gallery'
										)}
									</Button>
								)}
						</div>
					</div>
				</div>
			</Fragment>
		)
	}

	if (status === 'loading') {
		return (
				<div className="modula-block-preview">
					<div className="modula-block-preview__content">
						<div className="modula-block-preview__logo" />
						<Spinner />
					</div>
				</div>
		);
	}

	if (id == 0 || images.length === 0) {
		return (
			<Fragment key="233">
				<Inspector
					onIdChange={(id) => onIdChange(id)}
					selectOptions={selectOptions}
					{...props}
				/>

				<div className="modula-block-preview">
					<div className="modula-block-preview__content">
						<div className="modula-block-preview__logo" />
						{galleries.length > 0 && (
							<Fragment>
								<ModulaGallerySearch
									id={id}
									key={id}
									value={id}
									options={currentSelectize}
									onIdChange={onIdChange}
									galleries={galleries}
								/>

								{id != 0 && (
									<Button
										target="_blank"
										href={
											modulaVars.adminURL +
											'post.php?post=' +
											id +
											'&action=edit'
										}
										isPrimary
									>
										{__('Edit Gallery')}
									</Button>
								)}
							</Fragment>
						)}
					</div>
				</div>
			</Fragment>
		);
	}
	if (settings) {
		return (
			<Fragment key="1">
				{blockControls}
				<Inspector
					onIdChange={(id) => {
						onIdChange(id);
					}}
					{...props}
				/>
				<ModulaGallery
					{...props}
					settings={settings}
					jsConfig={jsConfig}
					modulaRun={modulaRun}
					modulaSlickRun={modulaSlickRun}
					checkHoverEffect={checkHoverEffect}
					galleryId={galleryId}
				/>
			</Fragment>
		);
	}

	return null;
};

const applyWithSelect = withSelect((select, props) => {
	const { getEntityRecords } = select('core');
	const query = {
		post_status: 'publish',
		per_page: 5,
	};

	return {
		galleries: getEntityRecords('postType', 'modula-gallery', query) || [],
	};
});

const applyWithFilters = wp.components.withFilters('modula.ModulaEdit');

export default compose(applyWithSelect, applyWithFilters)(ModulaEdit);
