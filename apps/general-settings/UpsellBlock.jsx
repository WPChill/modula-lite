import { Button } from '@wordpress/components';

export default function UpsellBlock( { field } ) {
	const { label, desc, buttons = [] } = field;

	return (
		<div className="modula_upsell_field_wrapper">
			{ label && <h3>{ label }</h3> }
			{ desc && <p dangerouslySetInnerHTML={ { __html: desc } } /> }

			{ buttons.length > 0 && (
				<div className="modula_upsell_buttons_wrapper">
					{ buttons.map( ( button, index ) => {
						return (
							<Button
								key={ index }
								href={ button.href }
								variant={ button.variant || 'primary' }
								target="blank"
								rel="noopener noreferrer"
							>
								{ button.label }
							</Button>
						);
					} ) }
				</div>
			) }
		</div>
	);
}
