import { __, sprintf } from '@wordpress/i18n';
import styles from './extension-license-header.module.scss';

// Mock data - will be replaced with tanstack react query later
const mockLicense = {
	active: true,
	name: 'John Doe',
	type: 'Business',
	expiresAt: '2025-12-31',
	activationLink: 'https://wp-modula.com/account/licenses',
};

export default function ExtensionLicenseHeader() {
	// TODO: Replace with actual license data from tanstack react query
	const license = mockLicense;

	return (
		<div className={styles.licenseHeader}>
			{license.active ? (
				<div className={styles.licenseActive}>
					<p className={styles.greeting}>
						{sprintf(
							/* translators: 1: User name, 2: License type, 3: Expiration date */
							__(
								'Hello %1$s, license (%2$s) active until %3$s',
								'modula-best-grid-gallery'
							),
							license.name,
							license.type,
							new Date(license.expiresAt).toLocaleDateString()
						)}
					</p>
				</div>
			) : (
				<div className={styles.licenseInactive}>
					<p className={styles.greeting}>
						{sprintf(
							/* translators: 1: Activation link */
							__(
								'Hello, please %1$s here in order to activate extensions',
								'modula-best-grid-gallery'
							),
							<a
								href={license.activationLink}
								className={styles.activationLink}
							>
								{__(
									'activate your license',
									'modula-best-grid-gallery'
								)}
							</a>
						)}
					</p>
				</div>
			)}
		</div>
	);
}
