import { useBlockProps } from '@wordpress/block-editor';
import useBlockContext from '../hooks/useBlockContext';
import useSWR from 'swr';
import { fetcher } from '../utils/fetcher';

export const UiBlock = () => {
	const { step, incrementStep, decrementStep } = useBlockContext();
	const blockProps = useBlockProps({
		className: 'modula-block-preview',
	});
	const { data: posts, error } = useSWR('/wp/v2/modula-gallery', fetcher);

	console.log(`posts loading: ${!posts && !error}`, posts);
	if (error) return <div>Error loading posts</div>;
	if (!posts) return <div>Loading...</div>;

	return (
		<div {...blockProps}>
			<div>Hello world - it's going to be ok - step: {step}</div>
			<div>Console log has data from backend</div>
			<div>
				<button onClick={decrementStep}>Click will go znrrr -</button>
				<button onClick={incrementStep}>Click will go brrr +</button>
			</div>
		</div>
	);
};
