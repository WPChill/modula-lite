import styles from './Image.module.scss';

export const Image = ({ id, src }) => {
	return (
		<div
			className={styles.image}
			style={{
				backgroundImage: `url(${src})`,
			}}
		>
			{id}
		</div>
	);
};
