import modulaIcon from '../../assets/images/logo-dark.png';
import { useModulaState } from './state/use-modula-state';
import { setShowContainer } from './state/actions';

export function NotificationIcon( { notifications } ) {
	const { state, dispatch } = useModulaState();
	const { showContainer, visibleNotifications } = state;
	const handleClick = () => {
		dispatch( setShowContainer( showContainer? false: true ) );
	};

	return (
		<div className="notification-icon" onClick={handleClick}>
			<img src={modulaIcon} className="notification-icon-img"/>
			<span className="warn-icon">
				{visibleNotifications.length}
			</span>
		</div>
	);
}
