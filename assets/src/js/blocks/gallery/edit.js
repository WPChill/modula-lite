import { __ } from '@wordpress/i18n';
import { useBlockProps, BlockControls } from '@wordpress/block-editor';
import Inspector from './lib/inspector';
import ModulaGallery from '../../components/ModulaGallery';
import { Fragment, useEffect, useState } from '@wordpress/element';
import ModulaGallerySearch from '../../components/ModulaGallerySearch';
import { useEntityRecords } from '@wordpress/core-data';
import { SelectControl, Spinner, Button, withFilters, ToolbarGroup, ToolbarItem } from '@wordpress/components';
import { getImagesMeta, getGalleryCptData, getJsConfig } from '../../utils/network';
import { generateSelectOptions, galleryIdUpdated } from '../../utils/utility';
const equal = require('fast-deep-equal');
import './editor.scss';

export const ModulaEdit = (props) => {
	const postType = 'modula-gallery';
	const { attributes: { id, galleryId, images, status, settings, jsConfig, currentGallery, currentSelectize }, attributes, setAttributes } = props;
	const { records: galleries, hasResolved } = useEntityRecords('postType', postType);
	
	const blockProps = useBlockProps();

	// Check when the alignment is changed so we can resize the instance
	const [alignmentCheck, setAlignment] = useState(props.attributes.align);

	// Check when id is changed and it is not a component rerender . Saves unnecessary fetch requests
	const [idCheck, setIdCheck] = useState(id);

	// Set a unique gallery id if not set.
	useEffect(() => {
		if (galleryId == "0") {
			setAttributes({ galleryId: Math.floor(Math.random() * 999) });
		}
	}, [galleryId, setAttributes]);

	// Check whether to sync block settings with gallery CPT. i.e. if post settings have been updated.
	useEffect(() => {
		const getData = async () => {
			// Get the latest data from the gallery CPT.
			const imagesData = await getImagesMeta(id);
			const settingsData = await getGalleryCptData(id, setAttributes);
			const jsConfigData = await getJsConfig(settingsData);

			// Only update block attributes if the gallery data has changed (i.e. been edited on the gallery CPT).
			const compareImages = equal(images, imagesData);
			const compareSettings = equal(settings, settingsData.modulaSettings);

			//console.log('Compare images:', compareImages);
			//console.log('Compare settings:', compareSettings);

			if (compareImages === false || compareSettings === false) {
				console.log('Syncing data...');
				setAttributes({
					images: imagesData,
					settings: settingsData.modulaSettings,
					jsConfig: jsConfigData.jsConfig,
				})
			}
		};

		// Don't try and sync data if the gallery id hasn't been set yet.
		if (id !== 0) {
			getData();
		}
	}, []);

	useEffect(() => {
		//Grab the instance and set it as attribute to access it when we want
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

	if (!hasResolved) {
		return (
			<div {...blockProps}>
				<div style={{ textAlign: "center" }}><Spinner /></div>
			</div>
		);
	}

	// Important! This should only be defined after 'galleries' has resolved.
	const options = generateSelectOptions(id, galleries);

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

			let config = jQuery(`#${id}`).data('config'),
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

	if (id == 0) {
		return (
			<Fragment>
				<div {...blockProps}>
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
									<>
										<p>
											{' '}
											{__(
												'Display An Existing Gallery',
												'modula-best-grid-gallery'
											)}{' '}
										</p>
										<SelectControl
											value={id}
											options={options}
											onChange={val => {
												galleryIdUpdated(val, setAttributes);
											}}
											__nextHasNoMarginBottom
										/>
									</>
								)}
								{undefined == props.attributes.proInstalled &&
									galleries.length > 0 && (
										<Button
											href="https://wp-modula.com/pricing/?utm_source=modula-lite&utm_campaign=upsell"
											className="modula-button-upsell"
											variant="secondary"
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
				</div>
			</Fragment>
		)
	}

	if (status === 'loading') {
		return (
			<div {...blockProps}>
				<div className="modula-block-preview">
					<div className="modula-block-preview__content">
						<div className="modula-block-preview__logo" />
						<Spinner />
					</div>
				</div>
			</div >
		);
	}

	if (id == 0 || images.length === 0) {
		return (
			<Fragment key="233">
				<Inspector attributes={attributes} setAttributes={setAttributes} galleries={galleries} options={options} />
				<div {...blockProps}>
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
											variant="primary"
										>
											{__('Edit Gallery')}
										</Button>
									)}
								</Fragment>
							)}
						</div>
					</div>
				</div>
			</Fragment>
		);
	}
	if (settings) {
		return (
			<Fragment key="1">
				{blockControls}
				<div {...blockProps}>
					<ModulaGallery
						{...props}
						settings={settings}
						jsConfig={jsConfig}
						modulaRun={modulaRun}
						modulaSlickRun={modulaSlickRun}
						checkHoverEffect={checkHoverEffect}
						galleryId={galleryId}
					/>
				</div>
				<Inspector attributes={attributes} setAttributes={setAttributes} galleries={galleries} options={options} />
			</Fragment>
		);
	}

	return null;
};

export default withFilters('modula.ModulaEdit')(ModulaEdit);
