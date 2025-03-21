import { __ } from '@wordpress/i18n';
import { Spinner } from '@wordpress/components';
import useStateContext from './context/useStateContext';

export function Report() {
	const { data, isLoading } = useStateContext();

	if (isLoading) {
		return <Spinner />;
	}

	return (
		<>
			<div className="modula-ai-item">
				<p>
					<span className="dashicons dashicons-format-gallery"></span>{' '}
					{__('Total images:', 'modula-best-grid-gallery')}{' '}
					<span className="highlight">{data.totalImages}</span>
				</p>
			</div>
			<div className="modula-ai-item">
				<p>
					<span className="dashicons dashicons-no icon-error"></span>{' '}
					{__(
						'Without optimized report:',
						'modula-best-grid-gallery'
					)}{' '}
					<span className="highlight">{data.imagesWithoutAlt}</span>
				</p>
			</div>
			<div className="modula-ai-item">
				<p>
					<span className="dashicons dashicons-yes icon-success"></span>{' '}
					{__('With report', 'modula-best-grid-gallery')}{' '}
					<span className="highlight">{data.imagesWithAlt}</span>
				</p>
			</div>
		</>
	);
}
