import { ModulaIcon } from '../utils/icons';
import { __ } from '@wordpress/i18n';
import { Button, Modal, Spinner } from '@wordpress/components';
import useBlockContext from '../hooks/useBlockContext';
import { usePostCreator } from '../hooks/usePostCreator';
import { useCallback } from '@wordpress/element';
import styles from './InitialSplash.module.scss';
import { Text } from './shared/Text';

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
		<>
			<ModulaIcon />

			<Text>
				{__(
					'Create a new gallery or choose from an existing one.',
					'modula-best-grid-gallery'
				)}
			</Text>
			<div className={styles.buttonContainer}>
				<Button
					variant="primary"
					size={'compact'}
					label={__('Add New Gallery', 'modula-best-grid-gallery')}
					onClick={createPostCb}
					className={styles.button}
				>
					{__('Add New Gallery', 'modula-best-grid-gallery')}
					{loading && <Spinner />}
				</Button>
				<Button
					className={styles.button}
					variant="secondary"
					size={'compact'}
					onClick={incrementStep}
					label={__(
						'Insert Existing Gallery',
						'modula-best-grid-gallery'
					)}
				>
					{__('Insert Existing Gallery', 'modula-best-grid-gallery')}
				</Button>
			</div>
		</>
	);
};

export default InitialSplash;
