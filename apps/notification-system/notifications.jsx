import { NotificationIcon } from './notification-icon';
import { NotificationsContainer } from './notifications-container';
import { useModulaState } from './state/use-modula-state';
import { useNotificationQuery } from './query/useNotificationQuery';
import { useEffect } from '@wordpress/element';
import { useQueryClient } from '@tanstack/react-query';
import { setVisibleNotifications } from './state/actions';

export function Notifications() {
	const { data, isLoading } = useNotificationQuery();
	const { state, dispatch } = useModulaState();
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
	}, [queryClient]);

	useEffect(() => {
		if (!isLoading && data) {
			const allNotifications = Object.values(data).flat();
			dispatch(setVisibleNotifications(allNotifications));
		}
	}, [data, isLoading, dispatch]);

	if (0 === state.visibleNotifications.length || closedBubble) {
		return null;
	}

	return (
		<>
			<NotificationIcon />
			{showContainer && <NotificationsContainer />}
		</>
	);
}
