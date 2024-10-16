import { NotificationIcon } from './notification-icon';
import { NotificationClose } from './notification-close';
import { NotificationsContainer } from './notifications-container';
import { useModulaState } from './state/use-modula-state';
import { useNotificationQuery } from './query/useNotificationQuery';
import { useMemo } from '@wordpress/element';
import { useQueryClient } from '@tanstack/react-query';
import { useEffect } from '@wordpress/element';

export function Notifications() {
	const { data, isLoading } = useNotificationQuery();
	const { state } = useModulaState();
	const { closedBubble, showContainer } = state;
	const queryClient = useQueryClient();

	useEffect(() => {
		if (typeof window.modulaEventBus === 'undefined') {
			return;
		  }
		const handleNotificationUpdate = () => {
			queryClient.invalidateQueries(['notifications']);
		};

		window.modulaEventBus.on('modula_notifications_updated', handleNotificationUpdate);

		return () => {
			window.modulaEventBus.off('modula_notifications_updated', handleNotificationUpdate);
		};
	}, [queryClient] );

	const notifications = useMemo( () => {
		if ( isLoading || ! data ) {
			return [];
		}

		return data || [];
	}, [ data, isLoading ] );

	if ( 0 == notifications.length || closedBubble ) {
		return null;
	}

	return (
		<>
			<NotificationIcon
				notifications={ notifications }
			/>
			<NotificationClose />
			{showContainer && <NotificationsContainer notifications={ notifications } />}
		</>
	);
}
