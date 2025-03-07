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
			<div className="modula-ai-item">
				<p>{__('Last optimization was on: ') + data.timestamp}</p>
			</div>
			<div className="modula-ai-item">
				<p>
					<span className="dashicons dashicons-yes icon-success"></span>{' '}
					{__('Optimized images: ', 'modula-best-grid-gallery')}
					<span className="highlight">{data.imagesWithAlt}</span>
				</p>
			</div>
			<div className="modula-ai-item">
				<p>
					{__(
						'Since last optimization, you have added ',
						'modula-best-grid-gallery'
					)}
					<span className="highlight">{data.imagesWithoutAlt}</span>
					{__(
						' images without alt text.',
						'modula-best-grid-gallery'
					)}
				</p>
			</div>
		</>
	);
}
