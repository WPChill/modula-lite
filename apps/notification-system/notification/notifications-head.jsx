import { __ } from '@wordpress/i18n';
import { useModulaState } from '../state/use-modula-state';
import { setShowContainer } from '../state/actions';
import { Button } from '@wordpress/components';

export function NotificationsHead() {
	const { dispatch } = useModulaState();

	const closePanel = () => {
		dispatch( setShowContainer( false ) );
	};

	return  <>
				<h2>{__('Modula Notification Center', 'modula-best-grid-gallery')}</h2>
				<Button onClick={closePanel}>
					<span className="dashicons dashicons-no-alt" ></span>
				</Button>
			</>;
}
