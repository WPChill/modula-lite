import useSWR from 'swr';
import { fetcher } from '../../utils/fetcher';
import useBlockContext from '../../hooks/useBlockContext';
import { Spinner } from '@wordpress/components';
import { useMemo } from '@wordpress/element';
import { Image } from './Masonry/Image';
import { Masonry as ReactMasonry } from 'react-masonry';
import styles from './Masonry.module.scss';

export const Masonry = () => {
	const { attributes } = useBlockContext();
	const { data, error, isLoading } = useSWR(
		`/wp/v2/modula-gallery/${attributes.galleryId}`,
		fetcher
	);

	const images = useMemo(() => {
		if (isLoading || error || !data) {
			return [];
		}

		if (!Array.isArray(data.modulaImages)) {
			return [];
		}

		return data.modulaImages.map((image) => ({
			id: image.id,
			src: image.thumbnail,
			orientation: image.orientation,
		}));
	}, [data, error, isLoading]);

	if (isLoading) {
		return <Spinner />;
	}

	return (
		<div className={styles.galleryContainer}>
			<ReactMasonry>
				{images.map((image, index) => (
					<Image
						key={index}
						index={index}
						id={image.id}
						orientation={image.orientation}
						src={image.src}
					/>
				))}
			</ReactMasonry>
		</div>
	);
};
