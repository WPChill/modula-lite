import { __ } from '@wordpress/i18n';
import useBlockContext from '../hooks/useBlockContext';

const ImportExistingSplash = () => {
	const { attributes } = useBlockContext();

	return (
		<p>
			{__(
				`Rendering gallery: ${attributes.galleryId}`,
				'modula-best-grid-gallery'
			)}
		</p>
	);
};

export default ImportExistingSplash;
