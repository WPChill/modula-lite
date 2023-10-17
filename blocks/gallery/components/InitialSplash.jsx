import { ModulaIcon } from '../utils/icons';
import { __ } from '@wordpress/i18n';
import { Button } from '@wordpress/components';
import useBlockContext from '../hooks/useBlockContext';

const InitialSplash = () => {
	const { step, incrementStep, decrementStep } = useBlockContext();

	return (
		<>
			<ModulaIcon />

			<p>
				{__(
					'Create a new gallery or choose from an existing one.',
					'modula-best-grid-gallery'
				)}
			</p>
			<div className={'modula-splash-buttons'}>
				<Button
					variant="primary"
					size={'compact'}
					label={__('Add New Gallery', 'modula-best-grid-gallery')}
					onClick={decrementStep}
				>
					{__('Add New Gallery', 'modula-best-grid-gallery')}
				</Button>
				<Button
					variant="secondary"
					size={'compact'}
					onClick={incrementStep}
					label={__(
						'Insert Existing Gallery',
						'modula-best-grid-gallery'
					)}
				>
					{__('Insert Existing Gallery', 'modula-best-grid-gallery')}
				</Button>
			</div>
		</>
	);
};

export default InitialSplash;
