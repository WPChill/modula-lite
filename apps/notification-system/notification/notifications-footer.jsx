import { __ } from '@wordpress/i18n';
import { useModulaState } from '../state/use-modula-state';
import { setClosedBubble } from '../state/actions';
import { Button } from '@wordpress/components';
import { useNotificationsDismiss } from '../query/useNotificationsDismiss';
export function NotificationsFooter() {
	const { dispatch } = useModulaState();
	const mutation = useNotificationsDismiss();
	const closePanel = () => {
		dispatch( setClosedBubble( true ) );
		mutation.mutate();
	};

	return(
			<Button className="dismiss_all_notifications" onClick={closePanel}>
				{__(' Dismiss All Notifications', 'modula-best-grid-gallery')}
			</Button>
		);
}
