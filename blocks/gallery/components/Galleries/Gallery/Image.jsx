import styles from './Image.module.scss';

export const Image = ({ id, src }) => {
	return (
		<span
			id={id}
			className={styles.image}
			style={{
				backgroundImage: `url(${src})`,
			}}
		/>
	);
};
