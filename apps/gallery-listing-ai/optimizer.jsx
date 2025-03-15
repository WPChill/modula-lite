import { Report } from './report';
import { Actions } from './actions';
import { Spinner, Button } from '@wordpress/components';
import { Optimizing } from './optimizing';
import { Optimized } from './optimized';
import { ErrorLog } from './debug';
import useStateContext from './context/useStateContext';
import { __ } from '@wordpress/i18n';

export function Optimizer() {
	const { data, isLoading, state, dispatch } = useStateContext();

	if ( ! state.isStarted ) {
		return (
			<div className="modula-ai-start-container">
				<Button
					variant="primary"
					onClick={ () => dispatch( { type: 'SET_STARTED', payload: true } ) }
				>
					{ __( 'Start optimizing now', 'modula-gallery' ) }
				</Button>
			</div>
		);
	}

	if ( isLoading ) {
		return <Spinner />;
	}

	if ( data.status === 'running' ) {
		return (
			<>
				<Optimizing />
				<ErrorLog />
			</>
		);
	}

	if ( data.status === 'finished' ) {
		return (
			<>
				<Optimized />
				<ErrorLog />
			</>
		);
	}

	return (
		<>
			<div className="modula-ai-list">
				<Report />
				<Actions />
			</div>
			<ErrorLog />
		</>
	);
}
