import { Report } from './report';
import { Actions } from './actions';

import { Spinner } from '@wordpress/components';
import { Optimizing } from './optimizing';
import { Optimized } from './optimized';
import { ErrorLog } from './debug';
import useStateContext from './context/useStateContext';

export function Optimizer() {
	const { data, isLoading } = useStateContext();

	if (isLoading) {
		return <Spinner />;
	}

	if (data.status === 'running') {
		return (
			<>
				<Optimizing />
				<ErrorLog />
			</>
		);
	}

	if (data.status === 'finished') {
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
