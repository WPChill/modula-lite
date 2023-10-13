import { InspectorControls as WPInspectorControls } from '@wordpress/block-editor'
import { PanelBody, TextControl } from '@wordpress/components';
import useBlockContext from '../hooks/useBlockContext';

export const InspectorControls = () => {
	const { attributes, setAttributes } = useBlockContext();
	const { myText } = attributes;

	return <WPInspectorControls>
		<PanelBody title="My Block Settings" initialOpen={true}>
			<TextControl
				label="My Text Setting"
				value={myText}
				onChange={(value) => setAttributes({ myText: value })}
			/>
		</PanelBody>
	</WPInspectorControls>
}
