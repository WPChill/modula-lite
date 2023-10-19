/* eslint-disable jsx-a11y/alt-text */
import styles from './Image.module.scss';
import { forwardRef } from '@wordpress/element';

export const Image = forwardRef(({ id, src, orientation, ...props }, ref) => {
	return (
		<div
			ref={ref}
			className={styles.imageContainer}
			style={{
				...props.style,
				width: 'calc(25% - 10px)',
				height: orientation === 'landscape' ? '200px' : '400px',
			}}
		>
			<div
				className={styles.image}
				style={{
					backgroundImage: `url(${src})`,
				}}
			></div>
		</div>
	);
});
