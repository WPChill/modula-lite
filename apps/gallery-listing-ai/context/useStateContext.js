import { useContext } from '@wordpress/element';
import { OptimizerContext } from './optimizer-context';

const useStateContext = () => {
	const context = useContext(OptimizerContext);

	if (context === undefined) {
		throw new Error(
			'useStateContext must be used within a OptimizerProvider'
		);
	}

	return context;
};

export default useStateContext;
