import { useBlockProps } from '@wordpress/block-editor';
import useBlockContext from '../hooks/useBlockContext';
import useSWR from 'swr';
import { fetcher } from '../utils/fetcher';
import InitialSplash from './InitialSplash';

export const UiBlock = () => {
	const { step, incrementStep, decrementStep } = useBlockContext();
	const blockProps = useBlockProps({
		className: 'modula-splash-container',
	});

	// console.log(`posts loading: ${!posts && !error}`, posts);
	// if (error) return <div>Error loading posts</div>;
	// if (!posts) return <div>Loading...</div>;

	return (
		<>
			<div {...blockProps}>
				<InitialSplash />
			</div>
		</>
	);
};
