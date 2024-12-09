import { __ } from '@wordpress/i18n';
import { Spinner } from '@wordpress/components';
import useStateContext from './context/useStateContext';

export function FinishedReport() {
	const { data, isLoading } = useStateContext();

	if (isLoading) {
		return <Spinner />;
	}

	return (
		<>
			<div className="image-seo-item">
				<p>{__('Last optimization was on: ') + data.timestamp}</p>
			</div>
			<div className="image-seo-item">
				<p>
					<span className="dashicons dashicons-yes icon-success"></span>{' '}
					{__('Optimized images: ', 'modula-imageseo')}
					<span className="highlight">{data.imagesWithAlt}</span>
				</p>
			</div>
			<div className="image-seo-item">
				<p>
					{__(
						'Since last optimization, you have added ',
						'modula-imageseo'
					)}
					<span className="highlight">{data.imagesWithoutAlt}</span>
					{__(' images without alt text.', 'modula-imageseo')}
				</p>
			</div>
		</>
	);
}
