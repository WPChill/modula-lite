import styles from './Image.module.scss';
import useBlockContext from '../../../hooks/useBlockContext';

export const Image = ({ id, src }) => {
	const { attributes } = useBlockContext();
	return (
		<span
			id={id}
			className={styles.image}
			style={{
				backgroundImage: `url(${src})`,
				'--columns': attributes.galleryColumns,
			}}
		/>
	);
};
