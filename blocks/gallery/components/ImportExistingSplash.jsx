import { __ } from '@wordpress/i18n';
import useBlockContext from '../hooks/useBlockContext';
import { Text } from './shared/Text';
import { Gallery } from './Gallery';

const ImportExistingSplash = () => {
	const { attributes } = useBlockContext();

	// you don't need to translate debug logs :P
	return (
		<>
			<Text>Rendering gallery: {attributes.galleryId}</Text>
			<Gallery />
		</>
	);
};

export default ImportExistingSplash;
