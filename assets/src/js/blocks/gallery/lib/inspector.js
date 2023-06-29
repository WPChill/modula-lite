import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import { SelectControl, Button, PanelBody, PanelRow } from '@wordpress/components';
import { galleryIdUpdated } from '../../../utils/utility';

const Inspector = (props) => {
	const { attributes: { id, images }, attributes, setAttributes, options, galleries } = props;

	return (
		<InspectorControls key="modula-gallery-settings-sidebar">
			<PanelBody
				title={__('Gallery Settings')}
				initialOpen={true}
			>
				<PanelRow>
					<div style={{ width: '100%' }}>
						<h2 style={{ margin: "0.5em 0" }}>Select Gallery</h2>
						<SelectControl
							value={id}
							options={options}
							onChange={val => {
								galleryIdUpdated(val, setAttributes);
							}}
							__nextHasNoMarginBottom
						/>
					</div>
				</PanelRow>
				<PanelRow>
					<Button
						target="_blank"
						href={`${modulaVars.adminURL}post.php?post=${id}&action=edit`}
						variant="secondary"
					>
						{__('Edit Gallery')}
					</Button>
				</PanelRow>
			</PanelBody>
		</InspectorControls>
	);
}

export default Inspector;
