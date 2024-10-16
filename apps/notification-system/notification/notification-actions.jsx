import { __ } from '@wordpress/i18n';
import { Button } from '@wordpress/components';
import he from 'he';

export function NotificationActions( { actions, id, onDismiss } ) {

	const handleClick = (action, id) => {
		if (action.callback && typeof window[action.callback] === 'function') {
			window[action.callback](action, id);
		}

		if (action.dismiss) {
			onDismiss(id);
		}
	};

	return (
		<div className="notification-actions-wrapp">
			{actions.map((action, index) => (
				<Button
					key={index}
					className={action.class || 'notification-action'}
					{...(action.url ? { href: action.url } : {})}
					{...(action.id ? { id: action.id } : {})}
					target={action.target || ''}
					text={he.decode(action.label || __('Action', 'modula-best-grid-gallery'))}
					variant={action.variant || 'secondary'}
					size={action.size || 'small'}
					onClick={() => handleClick(action, id)}
				/>
			))}
		</div>
	);
}
