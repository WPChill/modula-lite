import { __ } from '@wordpress/i18n';
import styles from './extension-table-row.module.scss';
import modulaLogo from '../../../assets/images/modula-logo.jpg';

export default function ExtensionTableRow({
	extension,
	selected = false,
	onSelectChange,
}) {
	const handleToggle = () => {
		if (!extension.available) {
			return;
		}
		// TODO: Implement toggle functionality with tanstack react query
		console.log('Toggle extension:', extension.id, extension.status);
	};

	const imageSrc = extension.image || modulaLogo;

	return (
		<tr className={!extension.available ? styles.unavailable : ''}>
			<td className={styles.checkboxColumn}>
				<input
					type="checkbox"
					checked={selected}
					onChange={(e) => onSelectChange(e.target.checked)}
				/>
			</td>
			<td className={styles.extensionColumn}>
				<div className={styles.extensionInfo}>
					<div className={styles.extensionDetails}>
						<strong className={styles.title}>
							{extension.title}
						</strong>
						<div className={styles.actions}>
							{extension.status === 'active' ? (
								<span className={styles.actionLink}>
									{__(
										'Deactivate',
										'modula-best-grid-gallery'
									)}
								</span>
							) : (
								<span className={styles.actionLink}>
									{__('Activate', 'modula-best-grid-gallery')}
								</span>
							)}
							<span className={styles.separator}>|</span>
							<span className={styles.actionLink}>
								{__('Settings', 'modula-best-grid-gallery')}
							</span>
						</div>
					</div>
				</div>
			</td>
			<td className={styles.descriptionColumn}>
				<div className={styles.description}>
					{extension.description} Version {extension.version}
				</div>
			</td>
			<td className={styles.statusColumn}>
				<div className={styles.statusActions}>
					{!extension.available && (
						<span className={styles.upgradeBadge}>
							{__('Upgrade Required', 'modula-best-grid-gallery')}
						</span>
					)}
					<label
						className={styles.toggleWrapper}
						htmlFor={`toggle-${extension.id}`}
					>
						<input
							id={`toggle-${extension.id}`}
							type="checkbox"
							checked={extension.status === 'active'}
							onChange={handleToggle}
							disabled={!extension.available}
							className={styles.toggle}
							aria-label={__(
								'Toggle extension status',
								'modula-best-grid-gallery'
							)}
						/>
						<span className={styles.toggleSlider}></span>
					</label>
				</div>
			</td>
		</tr>
	);
}
