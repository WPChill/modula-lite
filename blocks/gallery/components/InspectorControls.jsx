import { InspectorControls as WPInspectorControls } from '@wordpress/block-editor';
import {
	Panel,
	PanelBody,
	SelectControl,
	RangeControl,
	RadioControl,
	FontSizePicker,
	CheckboxControl,
	TextControl,
	ColorPicker,
	__experimentalText as Text,
} from '@wordpress/components';
import useBlockContext from '../hooks/useBlockContext';
import { __ } from '@wordpress/i18n';
import { GallerySelector } from '../components/shared/GallerySelector';

export const InspectorControls = () => {
	const { attributes, setAttributes } = useBlockContext();
	const {
		galleryType,
		galleryColumns,
		galleryLightbox,
		rowHeight,
		lastRow,
		titleColor,
		titleFontSize,
		titleVisibility,
		captionColor,
		captionFontSize,
		captionVisibility,
		socialIconsFontSize,
		socialIconsGutter,
		enableFacebook,
		enableTwitter,
		enableWhatsapp,
		enableLinkedIN,
		enablePinterest,
		enableEmail,
		hoverColor,
		hoverOpacity,
	} = attributes;

	return (
		<WPInspectorControls group={'settings'}>
			<Panel>
				<PanelBody
					title={__('Modula Settings', 'modula-best-grid-gallery')}
					initialOpen={true}
				>
					<GallerySelector />
					<SelectControl
						label={__('Gallery Type', 'modula-best-grid-gallery')}
						value={galleryType || 'creative'}
						onChange={(value) =>
							setAttributes({ galleryType: value })
						}
						options={[
							{
								label: __(
									'Creative',
									'modula-best-grid-gallery',
								),
								value: 'creative',
							},
							{
								label: __(
									'Masonry',
									'modula-best-grid-gallery',
								),
								value: 'masonry',
							},
							{
								label: __(
									'Custom grid',
									'modula-best-grid-gallery',
								),
								value: 'custom-grid',
							},
						]}
					/>
					{galleryType === 'masonry' && (
						<>
							<SelectControl
								label={__(
									'Columns',
									'modula-best-grid-gallery',
								)}
								value={galleryColumns}
								onChange={(value) =>
									setAttributes({
										galleryColumns: Number(value),
									})
								}
								options={[
									{
										label: __(
											'One Column',
											'modula-best-grid-gallery',
										),
										value: 1,
									},
									{
										label: __(
											'Two Columns',
											'modula-best-grid-gallery',
										),
										value: 2,
									},
									{
										label: __(
											'Three Columns',
											'modula-best-grid-gallery',
										),
										value: 3,
									},
									{
										label: __(
											'Four Columns',
											'modula-best-grid-gallery',
										),
										value: 4,
									},
									{
										label: __(
											'Five Columns',
											'modula-best-grid-gallery',
										),
										value: 5,
									},
									{
										label: __(
											'Six Columns',
											'modula-best-grid-gallery',
										),
										value: 6,
									},
									// {
									// 	label: __(
									// 		'Automatic ',
									// 		'modula-best-grid-gallery'
									// 	),
									// 	value: 'modula-automatic-columns',
									// },
								]}
							/>

							<TextControl
								label={__(
									'Row Height',
									'modula-best-grid-gallery',
								)}
								type="number"
								onChange={(value) =>
									setAttributes({ rowHeight: value })
								}
								value={rowHeight}
							/>

							<CheckboxControl
								label={__(
									'Enable last row',
									'modula-best-grid-gallery',
								)}
								checked={lastRow}
								onChange={(value) => {
									setAttributes({ lastRow: Boolean(value) });
								}}
							/>
						</>
					)}
				</PanelBody>
				<PanelBody
					title={__('Lightbox Settings', 'modula-best-grid-gallery')}
					initialOpen={false}
				>
					<RadioControl
						label={__(
							'Enable Lightbox',
							'modula-best-grid-gallery',
						)}
						onChange={(value) =>
							setAttributes({ galleryLightbox: Boolean(value) })
						}
						selected={galleryLightbox}
						options={[
							{ label: 'Enable', value: 'enabled' },
							{ label: 'Disable', value: 'disabled' },
						]}
					/>
				</PanelBody>
				<PanelBody
					title={__(
						'Image Title Settings',
						'modula-best-grid-gallery',
					)}
					initialOpen={false}
				>
					<Text>
						{__(
							'Pick a color for the gallery title.',
							'modula-best-grid-gallery',
						)}
					</Text>
					<ColorPicker
						color={titleColor}
						onChange={(value) => {
							setAttributes({ titleColor: value });
						}}
						enableAlpha
						defaultValue="#000"
					/>
					<FontSizePicker
						__nextHasNoMarginBottom
						fontSizes={[
							{
								name: __('Small', 'modula-best-grid-gallery'),
								slug: 'small',
								size: 12,
							},
							{
								name: __('Medium', 'modula-best-grid-gallery'),
								slug: 'medium',
								size: 18,
							},
							{
								name: __('Big', 'modula-best-grid-gallery'),
								slug: 'big',
								size: 26,
							},
						]}
						value={titleFontSize}
						withSlider={true}
						disabledCustomFontSizes={false}
						fallbackFontSize={'16'}
						onChange={(value) =>
							setAttributes({ titleFontSize: Number(value) })
						}
					/>
					<RadioControl
						label={__(
							'Show/Hide title',
							'modula-best-grid-gallery',
						)}
						selected={titleVisibility}
						onChange={(value) =>
							setAttributes({
								titleVisibility: String(value),
							})
						}
						options={[
							{
								label: __(
									'Visible',
									'modula-best-grid-gallery',
								),
								value: 'visible',
							},
							{
								label: __('Hidden', 'modula-best-grid-gallery'),
								value: 'hidden',
							},
						]}
					/>
				</PanelBody>
			</Panel>
			<Panel>
				<PanelBody
					title={__(
						'Image Caption Settings',
						'modula-best-grid-gallery',
					)}
					initialOpen={false}
				>
					<Text>
						{__(
							'Pick a color for the gallery caption.',
							'modula-best-grid-gallery',
						)}
					</Text>
					<ColorPicker
						color={captionColor}
						onChange={(value) => {
							setAttributes({ captionColor: value });
						}}
						enableAlpha
						defaultValue="#000"
					/>
					<FontSizePicker
						__nextHasNoMarginBottom
						fontSizes={[
							{
								name: __('Small', 'modula-best-grid-gallery'),
								slug: 'small',
								size: 12,
							},
							{
								name: __('Medium', 'modula-best-grid-gallery'),
								slug: 'medium',
								size: 18,
							},
							{
								name: __('Big', 'modula-best-grid-gallery'),
								slug: 'big',
								size: 26,
							},
						]}
						value={captionFontSize}
						withSlider={true}
						disabledCustomFontSizes={false}
						fallbackFontSize={'16'}
						onChange={(value) =>
							setAttributes({ captionFontSize: Number(value) })
						}
					/>
					<RadioControl
						label={__(
							'Show/Hide Caption',
							'modula-best-grid-gallery',
						)}
						selected={captionVisibility}
						onChange={(value) =>
							setAttributes({
								captionVisibility: String(value),
							})
						}
						options={[
							{
								label: __(
									'Visible',
									'modula-best-grid-gallery',
								),
								value: 'visible',
							},
							{
								label: __('Hidden', 'modula-best-grid-gallery'),
								value: 'hidden',
							},
						]}
					/>
				</PanelBody>
				<PanelBody
					title={__('Socials', 'modula-best-grid-gallery')}
					initialOpen={false}
				>
					<FontSizePicker
						fontSizes={[
							{
								name: __('Small', 'modula-best-grid-gallery'),
								size: 12,
								slug: 'small',
							},
							{
								name: __('Normal', 'modula-best-grid-gallery'),
								size: 16,
								slug: 'normal',
							},
							{
								name: __('Big', 'modula-best-grid-gallery'),
								size: 26,
								slug: 'big',
							},
						]}
						onChange={(value) =>
							setAttributes({
								socialIconsFontSize: Number(value),
							})
						}
						withReset={false}
						units={['px', 'em', 'rem']}
						value={socialIconsFontSize}
					/>
					<RangeControl
						label={__('Gutter', 'modula-best-grid-gallery')}
						value={socialIconsGutter}
						allowReset={false}
						onChange={(value) =>
							setAttributes({
								socialIconsGutter: Number(value),
							})
						}
						min={0}
						initialPosition={10}
						max={20}
					/>

					<CheckboxControl
						label={__('Facebook', 'modula-best-grid-gallery')}
						checked={enableFacebook}
						onChange={(value) => {
							setAttributes({ enableFacebook: Boolean(value) });
						}}
					/>
					<CheckboxControl
						label={__('Twitter', 'modula-best-grid-gallery')}
						checked={enableTwitter}
						onChange={(value) => {
							setAttributes({ enableTwitter: Boolean(value) });
						}}
					/>
					<CheckboxControl
						label={__('Whatsapp', 'modula-best-grid-gallery')}
						checked={enableWhatsapp}
						onChange={(value) => {
							setAttributes({ enableWhatsapp: Boolean(value) });
						}}
					/>
					<CheckboxControl
						label={__('LinkedIN', 'modula-best-grid-gallery')}
						checked={enableLinkedIN}
						onChange={(value) => {
							setAttributes({ enableLinkedIN: Boolean(value) });
						}}
					/>
					<CheckboxControl
						label={__('Pinterest', 'modula-best-grid-gallery')}
						checked={enablePinterest}
						onChange={(value) => {
							setAttributes({ enablePinterest: Boolean(value) });
						}}
					/>
					<CheckboxControl
						label={__('Email', 'modula-best-grid-gallery')}
						checked={enableEmail}
						onChange={(value) => {
							setAttributes({ enableEmail: Boolean(value) });
						}}
					/>
				</PanelBody>
				<PanelBody
					title={__('Hover Effects', 'modula-best-grid-gallery')}
					initialOpen={false}
				>
					<ColorPicker
						color={hoverColor}
						onChange={(value) => {
							setAttributes({ hoverColor: value });
						}}
						enableAlpha
						defaultValue="#FFF"
					/>
					<RangeControl
						label={__(
							'Hover Effect Opacity',
							'modula-best-grid-gallery',
						)}
						value={hoverOpacity}
						allowReset={false}
						onChange={(value) =>
							setAttributes({
								hoverOpacity: Number(value),
							})
						}
						min={0}
						initialPosition={100}
						max={100}
					/>
				</PanelBody>
			</Panel>
		</WPInspectorControls>
	);
};
