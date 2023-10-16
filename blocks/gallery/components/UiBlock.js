import { useBlockProps } from '@wordpress/block-editor';
import useBlockContext from '../hooks/useBlockContext';
import useSWR from 'swr';
import { fetcher } from '../utils/fetcher';
import InitialSplash from '../components/initialSplash';
import AddNewSplash from '../components/addNewSplash';

export const UiBlock = () => {
	const { step, incrementStep, decrementStep } = useBlockContext();
	const blockProps = useBlockProps({
		className: 'modula-splash-container',
	});
	const { data: posts, error } = useSWR('/wp/v2/modula-gallery', fetcher);

	console.log(`posts loading: ${!posts && !error}`, posts);
	if (error) return <div>Error loading posts</div>;
	if (!posts) return <div>Loading...</div>;

	return (
		<>
			<div {...blockProps}>
				<InitialSplash />
			</div>

			<div {...blockProps}>
				<AddNewSplash />
			</div>
		</>
	);
};
