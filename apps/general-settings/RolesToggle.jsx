import { useState, useEffect } from '@wordpress/element';
import { Button } from '@wordpress/components';

export default function RolesToggle( { submenu, form } ) {
	const [ active, setActive ] = useState( submenu.options[ 0 ]?.value );

	useEffect( () => {
		form.setFieldValue( 'activeToggle', active );
	}, [ active, form ] );

	const handleClick = ( key ) => {
		setActive( key );
	};

	return (
		<div className={ `modula_submenu_toggle_wrapper ${ submenu.class || '' }` }>
			{ submenu.options.map( ( { label, value } ) => (
				<Button
					key={ value }
					variant={ active === value ? 'primary' : 'secondary' }
					onClick={ () => handleClick( value ) }
				>
					{ label }
				</Button>
			) ) }

		</div>
	);
}
