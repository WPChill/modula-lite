import useBlockContext from '../hooks/useBlockContext';
import { __experimentalText as Text } from '@wordpress/components';
import { Gallery } from './Galleries/Gallery';
import { Masonry } from './Galleries/Masonry';

const ImportExistingSplash = () => {
	const { attributes } = useBlockContext();
	const { galleryType } = attributes;
	// you don't need to translate debug logs :P
	if (galleryType === 'creative') {
		return (
			<>
				<Text>Rendering creative gallery: {attributes.galleryId}</Text>
				<Gallery />
			</>
		);
	}

	if (galleryType === 'masonry') {
		return (
			<>
				<Text>Rendering masonry gallery: {attributes.galleryId}</Text>
				<Masonry />
			</>
		);
	}

	if (galleryType === 'custom-grid') {
		return (
			<>
				<Text>Rendering custom grid: {attributes.galleryId}</Text>
				<Gallery />
			</>
		);
	}

	return <Text>Unknown gallery type: {galleryType}</Text>;
};

export default ImportExistingSplash;
