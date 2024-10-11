import modulaIcon from '../../assets/images/logo-dark.png';

export function NotificationIcon( { notifications } ) {

	const handleClick = () => {
		alert('Icon clicked!');
	};

	return (
		<div className="notification-icon" onClick={handleClick}>
			<img src={modulaIcon} className="notification-icon-img"/>
			{Object.entries(notifications).map(([type, notification]) => (
				<span key={type} className={`counter ${type}`}>
					{notification.length}
				</span>
			))}
		</div>
	);
}
