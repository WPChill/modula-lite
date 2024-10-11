import { useModulaState } from './state/use-modula-state';
import { setClosedBubble } from './state/actions';

export function NotificationClose() {
	const { dispatch } = useModulaState();
    const handleCloseClick = () => {
        dispatch( setClosedBubble( true ) );
    };

	return (
        <span className="bullet close" onClick={handleCloseClick}>
            <span class="dashicons dashicons-no-alt"></span>
        </span>
	);
}