import './editor.scss';
import { BlockProvider } from './context/BlockContext';
import { InspectorControls } from './components/InspectorControls';
import { UiBlock } from './components/UiBlock';

export function Edit({ attributes, setAttributes }) {
	const initialValues = {};

	return (
		<BlockProvider initialValues={initialValues} attributes={attributes} setAttributes={setAttributes}>
			{/* Main block UI */}
			<UiBlock />
			{/* These render in the right sidebar - but needs to be put here */}
			<InspectorControls />
		</BlockProvider>
	);
}

export default Edit;
