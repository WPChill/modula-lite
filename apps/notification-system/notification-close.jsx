import { useModulaState } from './state/use-modula-state';
import { setClosedBubble } from './state/actions';
import { __ } from '@wordpress/i18n';

export function NotificationClose() {
	const { dispatch } = useModulaState();
	const handleCloseClick = () => {
		dispatch( setClosedBubble( true ) );
	};

	return (
		<button
			className="bullet close"
			aria-label={ __( 'Close Notification', 'modula-best-grid-gallery' ) }
			onClick={ handleCloseClick }
		>
			<span className="dashicons dashicons-no-alt"></span>
		</button>
	);
}
