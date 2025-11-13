import { useState } from '@wordpress/element';
import { __, sprintf } from '@wordpress/i18n';
import { Button, SelectControl } from '@wordpress/components';
import styles from './extension-bulk-actions.module.scss';

export default function ExtensionBulkActions({ selectedIds, onBulkAction }) {
	const [selectedAction, setSelectedAction] = useState('');

	const handleApply = () => {
		if (!selectedAction || selectedIds.length === 0) {
			return;
		}
		onBulkAction(selectedAction, selectedIds);
		setSelectedAction('');
	};

	const bulkActions = [
		{ value: '', label: __('Bulk Actions', 'modula-best-grid-gallery') },
		{
			value: 'activate',
			label: __('Activate', 'modula-best-grid-gallery'),
		},
		{
			value: 'deactivate',
			label: __('Deactivate', 'modula-best-grid-gallery'),
		},
	];

	return (
		<div className={styles.bulkActionsBar}>
			<div className={styles.bulkActionsLeft}>
				<SelectControl
					value={selectedAction}
					options={bulkActions}
					onChange={setSelectedAction}
					className={styles.bulkSelect}
				/>
				<Button
					variant="secondary"
					onClick={handleApply}
					disabled={!selectedAction || selectedIds.length === 0}
					className={styles.applyButton}
				>
					{__('Apply', 'modula-best-grid-gallery')}
				</Button>
			</div>
			{selectedIds.length > 0 && (
				<div className={styles.bulkActionsRight}>
					{sprintf(
						/* translators: %d: number of selected items */
						__('%d item(s) selected', 'modula-best-grid-gallery'),
						selectedIds.length
					)}
				</div>
			)}
		</div>
	);
}

