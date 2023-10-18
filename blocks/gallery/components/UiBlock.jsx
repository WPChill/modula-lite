import { useBlockProps } from '@wordpress/block-editor';
import useBlockContext from '../hooks/useBlockContext';
import InitialSplash from './InitialSplash';
import ImportExistingSplash from './ImportExistingSplash';

export const UiBlock = () => {
	const { attributes } = useBlockContext();
	const blockProps = useBlockProps({
		className: 'modula-splash-container',
	});

	return (
		<div {...blockProps}>
			{attributes.galleryId > 0 ? (
				<ImportExistingSplash />
			) : (
				<InitialSplash />
			)}
		</div>
	);
};
