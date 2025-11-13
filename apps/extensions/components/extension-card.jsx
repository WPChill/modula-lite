import styles from './extension-card.module.scss';
import ExtensionCardBody from './extension-card/extension-card-body';
import ExtensionCardFooter from './extension-card/extension-card-footer';
import ExtensionCardHeader from './extension-card/extension-card-header';

export default function ExtensionCard({ extension }) {
	return (
		<div className={`${styles.extensionCard} ${!extension.available ? styles.unavailable : ''}`}>
			<ExtensionCardHeader extension={extension} />
			<ExtensionCardBody extension={extension} />
			<ExtensionCardFooter extension={extension} />
		</div>
	);
}
