import modulaIcon from '../../assets/images/logo-dark.png';
import { useModulaState } from './state/use-modula-state';
import { setShowContainer } from './state/actions';

export function NotificationIcon( { notifications } ) {
	const { state, dispatch } = useModulaState();
	const { showContainer } = state;
	const handleClick = () => {
		dispatch( setShowContainer( showContainer ? false : true ) );
	};

	return (
		<button
			className="notification-icon"
			onClick={ handleClick }
			aria-label="Toggle Notifications"
		>
			<img
				src={ modulaIcon }
				className="notification-icon-img"
				alt="Modula Logo"
			/>
			{ Object.entries( notifications ).map(
				( [ type, notification ] ) =>
					notification.length > 0 && (
						<span key={ type } className={ `counter ${ type }` }>
							{ notification.length }
						</span>
					),
			) }
		</button>
	);
}
