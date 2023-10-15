import { useBlockProps } from '@wordpress/block-editor';
import useBlockContext from '../hooks/useBlockContext';

export const UiBlock = () => {
	const { step, incrementStep, decrementStep } = useBlockContext();
	const blockProps = useBlockProps({
		className: 'modula-block-preview',
	});

	return (
		<div {...blockProps}>
			Hello world - it's going to be ok - step: {step}
			<br />
			<div>
				<button onClick={decrementStep}>Click will go znrrr -</button>
				<button onClick={incrementStep}>Click will go brrr +</button>
			</div>
		</div>
	);
};
