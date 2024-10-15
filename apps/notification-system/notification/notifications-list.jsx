import { useEffect, useState } from '@wordpress/element';
import { Panel, PanelBody, PanelRow, __experimentalText as Text, Button } from '@wordpress/components';
import { Markup } from 'interweave';
import { __ } from '@wordpress/i18n';
import { useNotificationDismiss } from '../query/useNotificationDismiss';
import { useQueryClient } from '@tanstack/react-query';
import { NotificationActions } from './notification-actions';
import { useModulaState } from '../state/use-modula-state';
import { setOpenPanels } from '../state/actions';

export function NotificationsList( { notifications } ) {
	const allNotifications = Object.values(notifications).flat();
	const mutation = useNotificationDismiss();
	const queryClient = useQueryClient();
	const { state, dispatch } = useModulaState();
	const [visibleNotifications, setVisibleNotifications] = useState(allNotifications);
	const {openPanels} = state;

	const dismissNotification = (id) => {
		mutation.mutate( id, {
			onSettled: () => {
				queryClient.invalidateQueries(['notifications']);
			},
		} );
		setVisibleNotifications(prevNotifications =>
			prevNotifications.filter(notification => notification.id !== id)
		);
    };

	useEffect(() => {
		const timers = visibleNotifications.map(notification => {
			if (notification.timed && openPanels[notification.id] ) {
				const timer = setTimeout(() => {
					dismissNotification(notification.id);
				}, notification.timed);

				return timer;
			}
			return null;
		});


		return () => {};

	}, [visibleNotifications, openPanels] );

	const handleTogglePanel = (id) => {
		dispatch(setOpenPanels({
			[id]: true
		}));
	};

	return (
		<Panel>
			{visibleNotifications?.length === 0 && (
				<div className="notification-log-empty">
					<Text>{__('No notifications!', 'modula-best-grid-gallery')}</Text>
				</div>
			)}
			{visibleNotifications?.length > 0 &&
				visibleNotifications?.map((notification) => (
					<PanelBody
						title={
							<>
								<span className={`notification-state ${notification?.status}`}></span>
								<span className="notification-title">{notification?.title}</span>
							</>
						}
						key={notification?.id}
						initialOpen={false}
						isOpen={openPanels[notification.id]}
						onToggle={() => handleTogglePanel(notification.id)}
					>
						<PanelRow className='notification-row'>
							<Text variant="muted">
								<Markup content={notification.message} />
							</Text>
							{ (notification?.dismissible === undefined || notification.dismissible) && 
							<Button className="notification_dismiss_button" onClick={() => dismissNotification(notification.id)}>
								{__('Dismiss', 'modula-best-grid-gallery')}
							</Button>}
						</PanelRow>
						{(notification?.actions !== undefined && notification.actions.length > 0) && 
						<PanelRow className='notification-row'>
							<NotificationActions actions={notification.actions} id={notification.id} onDismiss={dismissNotification} />
						</PanelRow>}
					</PanelBody>
				))}
		</Panel>
	);
}
