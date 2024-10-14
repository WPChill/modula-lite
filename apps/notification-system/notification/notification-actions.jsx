import { __ } from '@wordpress/i18n';
import { Button } from '@wordpress/components';
export function NotificationActions( {actions} ) {
	const closePanel = () => {
		console.error('!');
		console.error(actions);
	};

	return(
			<div className="notification-actions-wrapp" >

				{actions.map(( action, index ) => (
				<Button
					key={index}
					className={ action.class || 'notification-action'}
					href={action.url}
					target="__BLANK"
					text={action.label || __('Action', 'modula-best-grid-gallery')}
					variant={ action.variant || 'secondary'}
					size={ action.size || 'small'}
				/>
				))}
			</div>
		);
}
