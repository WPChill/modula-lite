import { Button } from '@wordpress/components';
import useStateContext from './context/useStateContext';
import { setActiveTab } from './context/actions';
import { useEffect } from '@wordpress/element';
import { useTabsQuery } from './query/useTabsQuery';

export default function Navigation() {
	const { state, dispatch } = useStateContext();
	const { data, isLoading } = useTabsQuery();

	useEffect( () => {
		if ( ! state.activeTab && 'undefined' !== data && ! isLoading ) {
			const firstButton = data.find( ( link ) => ( 'undefined' === typeof link.type || link.type === 'button' ) );
			if ( firstButton ) {
				dispatch( setActiveTab( firstButton.slug ) );
			}
		}
	}, [ state.activeTab, dispatch, data, isLoading ] );

	if ( 'undefined' === data || isLoading ) {
		return;
	}

	return (
		<div className="modula-page-navigation">
			{ data.map( ( { label, slug, type = 'button', target = false } ) => {
				const isLink = type === 'link';

				return (
					<Button
						key={ slug }
						href={ isLink ? slug : undefined }
						target={ isLink && target ? '_blank' : undefined }
						rel={ isLink && target ? 'noopener noreferrer' : undefined }
						onClick={
							! isLink ? () => dispatch( setActiveTab( slug ) ) : undefined
						}
						className={ `modula-header-button ${
							state.activeTab === slug ? 'modula-header-button-active' : ''
						}` }
					>
						{ label }
					</Button>
				);
			} ) }
		</div>
	);
}
