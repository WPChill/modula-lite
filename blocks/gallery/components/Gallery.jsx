import useSWR from 'swr';
import { fetcher } from '../utils/fetcher';
import useBlockContext from '../hooks/useBlockContext';
import { Spinner } from '@wordpress/components';
import { useMemo } from '@wordpress/element';
import { Image } from './Gallery/Image';
import styles from './Gallery.module.scss';

export const Gallery = () => {
	const { attributes } = useBlockContext();
	const { data, error, isLoading } = useSWR(
		`/wp/v2/modula-gallery/${attributes.galleryId}`,
		fetcher
	);

	const images = useMemo(() => {
		if (isLoading || error || !data) {
			return [];
		}

		return data.modulaImages.map((image) => ({
			id: image.id,
			src: image.thumbnail,
		}));
	}, [data, error, isLoading]);

	if (isLoading) {
		return <Spinner />;
	}

	return (
		<div className={styles.galleryContainer}>
			{images.map((image) => (
				<Image key={image.id} id={image.id} src={image.src} />
			))}
		</div>
	);
};
