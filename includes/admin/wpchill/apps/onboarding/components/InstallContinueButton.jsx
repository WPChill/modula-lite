import { useWpchillState } from '../state/use-wpchill-state';
import { useInstallPlugins } from '../query/useInstallPlugins';
import { setStep } from '../state/actions';
import { Button, Spinner } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export function InstallContinueButton( { plugins } ) {
	const { state, dispatch } = useWpchillState();
	const mutation = useInstallPlugins();

	const saveStep = () => {
		mutation.mutate(
			{plugins},
			{
				onSettled: () => {
					dispatch( setStep( state.step + 1 ) );
				},
			},
		);
	};

	return (
		<Button
			variant="primary"
			className="wpchill-save-step-button"
			onClick={ saveStep }
			disabled={ mutation.isPending }
		>
			{ mutation.isPending ? (
				<>
					<Spinner className="wpchill-save-step-spinner" />
					<span className="wpchill-save-step-text">
						{ __( 'Saving…', 'wpchill' ) }
					</span>
				</>
			) : (
				<span className="wpchill-save-step-text">
					{ __( 'Save & Continue', 'wpchill' ) }
				</span>
			) }
		</Button>
	);
}
