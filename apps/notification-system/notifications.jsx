import { NotificationIcon } from './notification-icon';
import { NotificationClose } from './notification-close';
import { NotificationsContainer } from './notifications-container';
import { useModulaState } from './state/use-modula-state';
import { useNotificationQuery } from './query/useNotificationQuery';
import { useMemo } from '@wordpress/element';

export function Notifications() {
	const { data, isLoading } = useNotificationQuery();
	const { state } = useModulaState();
	const { closedBubble, showContainer } = state;
	const notifications = useMemo( () => {
		if ( isLoading || ! data ) {
			return [];
		}

		return data || [];
	}, [ data, isLoading ] );

	if ( 0 === notifications.length || closedBubble ) {
		return null;
	}

	return (
		<>
			<NotificationIcon notifications={ notifications } />
			<NotificationClose />
			{ showContainer && (
				<NotificationsContainer notifications={ notifications } />
			) }
		</>
	);
}
