import { InspectorControls as WPInspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import useBlockContext from '../hooks/useBlockContext';

export const InspectorControls = () => {
	const { attributes, setAttributes } = useBlockContext();

	return (
		<WPInspectorControls>
			<PanelBody title="My Block Settings" initialOpen={true}>
				<TextControl
					label="My gallery id"
					value={Number(attributes.galleryId)}
					onChange={(value) =>
						setAttributes({ galleryId: Number(value) })
					}
				/>
			</PanelBody>
		</WPInspectorControls>
	);
};
