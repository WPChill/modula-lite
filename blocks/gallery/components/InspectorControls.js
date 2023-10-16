import {
    ContrastChecker,
    InspectorControls as WPInspectorControls,
    PanelColorSettings,
    RichText,
    useBlockProps
} from '@wordpress/block-editor';
import {
    Panel,
    PanelBody,
    TextControl,
    SelectControl,
    RangeControl,
    RadioControl,
    FontSizePicker,
    ToggleControl
} from '@wordpress/components';
import useBlockContext from '../hooks/useBlockContext';
import {__} from "@wordpress/i18n";

export const InspectorControls = () => {
    const {attributes, setAttributes} = useBlockContext();
    const {blockBackground, blockColor, fontSize, imageTitleVisibility} = attributes;

    return (
        <WPInspectorControls>
            <Panel>
                <PanelBody title={__('Modula Settings', 'modula-best-grid-gallery')} initialOpen={true}>
                    <TextControl
                        label={__('Gallery ID', 'modula-best-grid-gallery')}
                        value={Number(attributes.galleryId)}
                        onChange={(value) => setAttributes({galleryId: Number(value)})}
                    />
                    <SelectControl label={__('Gallery Type', 'modula-best-grid-gallery')} value={'creative-gallery'}
                                   options={[{
                                       label: __('Creative Gallery', 'modula-best-grid-gallery'),
                                       value: 'creative-gallery'
                                   }, {
                                       label: __('Custom Grid Gallery', 'modula-best-grid-gallery'),
                                       value: 'custom-grid-gallery'
                                   }, {
                                       label: __('Masonry Gallery', 'modula-best-grid-gallery'),
                                       value: 'masonry-gallery'
                                   },]}>
                    </SelectControl>
                    <SelectControl label={__('Columns', 'modula-best-grid-gallery')} value={'creative-gallery'}
                                   options={[{
                                       label: __('One Column', 'modula-best-grid-gallery'),
                                       value: 'modula-one-column'
                                   }, {
                                       label: __('Two Columns', 'modula-best-grid-gallery'),
                                       value: 'modula-two-columns'
                                   }, {
                                       label: __('Four Columns', 'modula-best-grid-gallery'),
                                       value: 'modula-four-columns'
                                   },
                                       {
                                           label: __('Five Columns', 'modula-best-grid-gallery'),
                                           value: 'modula-five-columns'
                                       },
                                       {
                                           label: __('Six Columns', 'modula-best-grid-gallery'),
                                           value: 'modula-six-columns'
                                       },
                                       {
                                           label: __('Automatic ', 'modula-best-grid-gallery'),
                                           value: 'modula-automatic-columns'
                                       }
                                   ]}>
                    </SelectControl>
                </PanelBody>
                <PanelBody title={__('Lightbox Settings', 'modula-best-grid-gallery')} initialOpen={false}>
                    <RadioControl
                        label={__('Enable Lightbox', 'modula-best-grid-gallery')}
                        selected={'enabled'}
                        options={[
                            {label: 'Enable', value: 'enabled'},
                            {label: 'Disable', value: 'disabled'},
                        ]}
                    />
                </PanelBody>
                <PanelBody title={__('Image Title Settings', 'modula-best-grid-gallery')} initialOpen={false}>
                    <PanelColorSettings
                        title={__('Color Settings', 'modula-best-grid-gallery')}
                        colorSettings={[
                            {
                                value: blockColor,
                                onChange: (blockColor) => setAttributes({blockColor}),
                                label: __('Font Color', 'wholesome-plugin'),
                            },
                            {
                                value: blockBackground,
                                onChange: (blockBackground) => setAttributes({blockBackground}),
                                label: __('Background Color', 'wholesome-plugin'),
                            }
                        ]}>
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
                            }]}
                        value={fontSize}
                        withSlider={true}
                        disabledCustomFontSizes={false}
                        fallbackFontSize={'16'}
                        onChange={(value) => setAttributes({fontSize: Number(value)})}
                    />

                    <RadioControl
                        label={__('Show/Hide title', 'modula-best-grid-gallery')}
                        selected={imageTitleVisibility}
                        onChange={(value) => setAttributes({imageTitleVisibility: String(value)})}
                        options={[
                            {label: 'Visible', value: 'visible'},
                            {label: 'Hidden', value: 'hidden'},
                        ]}
                    />

                </PanelBody>

            </Panel>
            <Panel>

                <PanelBody title={__('Image Caption', 'modula-best-grid-gallery')} initialOpen={false}>

                </PanelBody>
                <PanelBody title={__('Socials', 'modula-best-grid-gallery')} initialOpen={false}>

                </PanelBody>
                <PanelBody title={__('Hover Effects', 'modula-best-grid-gallery')} initialOpen={false}>
                    <RangeControl
                        label={__('Hover Effect Opacity', 'modula-best-grid-gallery')}
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
