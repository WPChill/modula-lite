import {
	ContrastChecker,
	InspectorControls as WPInspectorControls,
	PanelColorSettings,
} from '@wordpress/block-editor';
import {
	Panel,
	PanelBody,
	SelectControl,
	RangeControl,
	RadioControl,
	FontSizePicker,
} from '@wordpress/components';
import useBlockContext from '../hooks/useBlockContext';
import { __ } from '@wordpress/i18n';
import { GallerySelector } from '../components/shared/GallerySelector';

export const InspectorControls = () => {
	const { attributes, setAttributes } = useBlockContext();
	const { blockBackground, blockColor, fontSize, imageTitleVisibility } =
		attributes;

	return (
		<WPInspectorControls>
			<Panel>
				<PanelBody
					title={__('Modula Settings', 'modula-best-grid-gallery')}
					initialOpen={true}
				>
					<GallerySelector />
					<SelectControl
						label={__('Columns', 'modula-best-grid-gallery')}
						value={'creative-gallery'}
						options={[
							{
								label: __(
									'One Column',
									'modula-best-grid-gallery'
								),
								value: 'modula-one-column',
							},
							{
								label: __(
									'Two Columns',
									'modula-best-grid-gallery'
								),
								value: 'modula-two-columns',
							},
							{
								label: __(
									'Four Columns',
									'modula-best-grid-gallery'
								),
								value: 'modula-four-columns',
							},
							{
								label: __(
									'Five Columns',
									'modula-best-grid-gallery'
								),
								value: 'modula-five-columns',
							},
							{
								label: __(
									'Six Columns',
									'modula-best-grid-gallery'
								),
								value: 'modula-six-columns',
							},
							{
								label: __(
									'Automatic ',
									'modula-best-grid-gallery'
								),
								value: 'modula-automatic-columns',
							},
						]}
					></SelectControl>
				</PanelBody>
				<PanelBody
					title={__('Lightbox Settings', 'modula-best-grid-gallery')}
					initialOpen={false}
				>
					<RadioControl
						label={__(
							'Enable Lightbox',
							'modula-best-grid-gallery'
						)}
						selected={'enabled'}
						options={[
							{ label: 'Enable', value: 'enabled' },
							{ label: 'Disable', value: 'disabled' },
						]}
					/>
				</PanelBody>
				<PanelBody
					title={__(
						'Image Title Settings',
						'modula-best-grid-gallery'
					)}
					initialOpen={false}
				>
					<PanelColorSettings
						title={__('Color Settings', 'modula-best-grid-gallery')}
						colorSettings={[
							{
								value: blockColor,
								onChange: (val) =>
									setAttributes({ blockColor: val }),
								label: __(
									'Font Color',
									'modula-best-grid-gallery'
								),
							},
							{
								value: blockBackground,
								onChange: (val) =>
									setAttributes({ blockBackground: val }),
								label: __(
									'Background Color',
									'modula-best-grid-gallery'
								),
							},
						]}
					>
						<ContrastChecker
							isLargeText="false"
							textColor={blockColor}
							backgroundColor={blockBackground}
						/>
					</PanelColorSettings>
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
						value={fontSize}
						withSlider={true}
						disabledCustomFontSizes={false}
						fallbackFontSize={'16'}
						onChange={(value) =>
							setAttributes({ fontSize: Number(value) })
						}
					/>

					<RadioControl
						label={__(
							'Show/Hide title',
							'modula-best-grid-gallery'
						)}
						selected={imageTitleVisibility}
						onChange={(value) =>
							setAttributes({
								imageTitleVisibility: String(value),
							})
						}
						options={[
							{
								label: __(
									'Visible',
									'modula-best-grid-gallery'
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
					title={__('Image Caption', 'modula-best-grid-gallery')}
					initialOpen={false}
				></PanelBody>
				<PanelBody
					title={__('Socials', 'modula-best-grid-gallery')}
					initialOpen={false}
				></PanelBody>
				<PanelBody
					title={__('Hover Effects', 'modula-best-grid-gallery')}
					initialOpen={false}
				>
					<RangeControl
						label={__(
							'Hover Effect Opacity',
							'modula-best-grid-gallery'
						)}
						value={'50'}
						allowReset={true}
						//onChange={(value) => setColumns(value)}
						min={0}
						initialPosition={100}
						max={100}
					/>
				</PanelBody>
			</Panel>
		</WPInspectorControls>
	);
};
