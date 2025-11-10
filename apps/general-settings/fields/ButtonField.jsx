import { Button } from '@wordpress/components';
import { useApiCall } from '../query/useApiCall';
import { useState } from '@wordpress/element';

export default function ButtonField( { field, className, variant = 'primary' } ) {
	const [ loading, setLoading ] = useState( false );
	const doApiCall = useApiCall();

	const handleClick = async () => {
		setLoading( true );
		if ( field.api && field.api?.path ) {
			await doApiCall( field.api.path, field.api.method || 'POST', field.api.data || {} );
		}
		setLoading( false );
	};

	return (
		<div className={ `modula_field_wrapp ${ className || '' }` }>
			{ field.label && field.label.trim() !== '' && (
				<span className="modula_input_label">
					{ field.label }
				</span>
			) }
			<Button
				id={ field.id || '' }
				href={ field.href }
				variant={ variant }
				className={ `modula_field_button ${ className || '' }` }
				onClick={ handleClick }
				disabled={ loading }
			>
				{ field.text }
			</Button>
			{ field.description && (
				<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: field.description } } />
			) }
		</div>
	);
}
