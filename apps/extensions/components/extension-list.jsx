import styles from './extension-list.module.scss';
import ExtensionTable from './extension-table';
import ExtensionLicenseHeader from './extension-license-header';

export default function ExtensionList() {
	return (
		<div className={styles.extensionWrapper}>
			<h1 className={styles.pageTitle}>Extensions</h1>
			<ExtensionLicenseHeader />
			<ExtensionTable />
		</div>
	);
}
