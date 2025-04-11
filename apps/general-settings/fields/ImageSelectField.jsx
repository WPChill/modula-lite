import { useState } from '@wordpress/element';
import { Button } from '@wordpress/components';

export default function ImageSelector( { fieldState, field, handleChange } ) {
	const [ imageSrc, setImageSrc ] = useState( field.src || null );

	const openMediaLibrary = () => {
		const mediaFrame = wp.media( {
			title: 'Select an image pentru fundal',
			button: {
				text: 'Folosește această imagine',
			},
			multiple: false,
		} );

		mediaFrame.on( 'select', () => {
			const selection = mediaFrame.state().get( 'selection' ).first().toJSON();
			const attachmentId = selection.id;
			const attachmentSrc = selection.url;

			handleChange( attachmentId );
			setImageSrc( attachmentSrc );
		} );

		mediaFrame.open();
	};

	const removeImage = () => {
		handleChange( null );
		setImageSrc( null );
	};

	return (
		<>
			<label className="modula_input_label" htmlFor={ field.name }>
				{ field.label }
			</label>
			<div className="modula_image_holder">
				<div className="modula_image">
					{ imageSrc && (
						<img src={ imageSrc } alt="Selected" width={ 200 } />
					) }
					{ ! imageSrc && (
						<Button isPrimary onClick={ openMediaLibrary }>Set watermark image</Button>
					) }
					{ imageSrc && (
						<div className="modula_image_buttons">
							<Button isSecondary onClick={ openMediaLibrary }>Replace</Button>
							<Button isDestructive onClick={ removeImage }>Remove</Button>
						</div>
					) }
				</div>
			</div>
			{ field.description && (
				<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: field.description } } />
			) }
		</>
	);
}
