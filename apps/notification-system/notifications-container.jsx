import { NotificationsList } from './notification/notifications-list';
import { NotificationsHead } from './notification/notifications-head';
import { NotificationsFooter } from './notification/notifications-footer';

export function NotificationsContainer( { notifications } ) {
	return (
		<div className="notification-container">
			<div className="notification-header">
				<NotificationsHead />
			</div>
			<NotificationsList notifications={ notifications } />
			<div className="notification-footer">
				<NotificationsFooter />
			</div>
		</div>
	);
}
