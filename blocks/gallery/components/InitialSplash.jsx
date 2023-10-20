import { ModulaIcon } from '../utils/icons';
import { __ } from '@wordpress/i18n';
import { Button, Modal, Placeholder } from '@wordpress/components';
import { BlockIcon } from '@wordpress/block-editor';
import useBlockContext from '../hooks/useBlockContext';
import { usePostCreator } from '../hooks/usePostCreator';
import { useCallback } from '@wordpress/element';

const InitialSplash = () => {
	const { createPost, loading, data } = usePostCreator();
	const { step, incrementStep, decrementStep, setAttributes } =
		useBlockContext();

	const createPostCb = useCallback(async () => {
		// @todo bonus points - you can get the Page/Post title and
		// create the gallery using a title like : "Gallery from {title} {postType}"
		// you can send the title to createPost - check its signature
		const result = await createPost();
		const { id } = result;

		setAttributes({
			galleryId: id,
		});
	}, [createPost, setAttributes]);

	return (
		<Placeholder
			icon={<BlockIcon icon={<ModulaIcon />} />}
			label={__('Modula Gallery Block', 'random-image')}
			instructions={__(
				'Create a new gallery or choose from an existing one.',
				'modula-best-grid-gallery'
			)}
		>
			<Button
				isBusy={loading}
				variant="primary"
				label={__('Add New Gallery', 'modula-best-grid-gallery')}
				onClick={createPostCb}
			>
				{__('Add New Gallery', 'modula-best-grid-gallery')}
			</Button>
			<Button
				onClick={incrementStep}
				label={__(
					'Insert Existing Gallery',
					'modula-best-grid-gallery'
				)}
			>
				{__('Insert Existing Gallery', 'modula-best-grid-gallery')}
			</Button>
		</Placeholder>
	);
};

export default InitialSplash;
