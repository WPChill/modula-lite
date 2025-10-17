import { useWpchillState } from '../state/use-wpchill-state';
import { setStep } from '../state/actions';
import { Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export function GoBackButton() {
	const { state, dispatch } = useWpchillState();

	const goBack = () => {
		if ( state.step > 0 ) {
			dispatch( setStep( state.step - 1 ) );
		}
	};

	return (
		<Button
			variant="tertiary"
			className="wpchill-aboutyou-back"
			onClick={ goBack }
		>
			← { __( 'Go Back', 'wpchill' ) }
		</Button>
	);
}
