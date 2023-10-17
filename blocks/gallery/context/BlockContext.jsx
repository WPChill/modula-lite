import {
	createContext,
	useReducer,
	useMemo,
	useEffect,
	useCallback,
} from '@wordpress/element';
import { reducer } from './reducer';
import { initialState } from './state';
import { useAfterSave } from '../hooks/useAfterSave';
import apiFetch from '@wordpress/api-fetch';

const BlockContext = createContext();

export const BlockProvider = ({
	children,
	initialValues,
	attributes,
	setAttributes,
}) => {
	const isAfterSave = useAfterSave();
	const mergedInitialState = { ...initialState, ...initialValues };
	const [state, dispatch] = useReducer(reducer, mergedInitialState);

	const incrementStep = useCallback(() => {
		dispatch({ type: 'INCREMENT_STEP' });
	}, []);

	const decrementStep = useCallback(() => {
		dispatch({ type: 'DECREMENT_STEP' });
	}, []);

	const goToStep = useCallback((step) => {
		dispatch({ type: 'GO_TO_STEP', payload: Number(step) });
	}, []);

	const saveGalleryPost = useCallback(async () => {
		try {
			await apiFetch({
				path: `/wp/v2/modula-gallery/${attributes.galleryId}`,
				method: 'POST',
				data: {
					// This does not work because of how meta field is registered
					// it needs update callback
					meta: { modulaSettings: { ...attributes } },
				},
			});
		} catch (err) {
			console.log(err);
		}
	}, [attributes]);

	const value = useMemo(() => {
		return {
			// Wp core stuff
			attributes,
			setAttributes,
			// State management
			incrementStep,
			decrementStep,
			goToStep,
			// Exposed state
			step: state.step,
		};
	}, [
		attributes,
		setAttributes,
		incrementStep,
		decrementStep,
		goToStep,
		state.step,
	]);

	useEffect(() => {
		if (isAfterSave) {
			saveGalleryPost();
		}
	}, [isAfterSave, saveGalleryPost]);

	return (
		<BlockContext.Provider value={value}>{children}</BlockContext.Provider>
	);
};

export default BlockContext;
