import { useBlockProps } from '@wordpress/block-editor';

export const UiBlock = () => {
	const blockProps = useBlockProps({
		className: 'modula-block-preview',
	});

	return <div {...blockProps}>
		Hello world - it's going to be ok
	</div>
}
