import { useContext } from '@wordpress/element';
import BlockContext from '../context/BlockContext';

const useBlockContext = () => {
	const context = useContext(BlockContext);
	if (!context) {
		throw new Error(
			'useBlockContext must be used within a BlockContextProvider'
		);
	}
	return context;
};

export default useBlockContext;
