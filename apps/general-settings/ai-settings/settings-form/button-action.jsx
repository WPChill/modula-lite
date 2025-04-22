import { __ } from '@wordpress/i18n';
import { Button, Notice } from '@wordpress/components';
import { useState } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

export default function ButtonAction() {
	const [isLoading, setIsLoading] = useState(false);
	const [isCleaning, setIsCleaning] = useState(false);
	const [notification, setNotification] = useState(null);

	const handleButtonClick = async () => {
		setIsLoading(true);
		setNotification(null);

		try {
			const response = await apiFetch({
				path: '/modula-ai-image-descriptor/v1/update-alts-from-image-array',
				method: 'POST',
			});

			if (response.success) {
				setNotification({
					status: 'success',
					message: response.message,
					details: response.data
						? `(${response.data.updated_images} images from ${response.data.total_galleries} galleries)`
						: '',
				});
			} else {
				setNotification({
					status: 'error',
					message:
						response.message ||
						__(
							'Failed to update gallery images.',
							'modula-best-grid-gallery'
						),
				});
			}
		} catch (error) {
			setNotification({
				status: 'error',
				message:
					error.message ||
					__(
						'An error occurred while updating gallery images.',
						'modula-best-grid-gallery'
					),
			});
		} finally {
			setIsLoading(false);
		}
	};

	const handleCleanupClick = async () => {
		if (
			!window.confirm(
				__(
					'Are you sure you want to delete all trash and draft galleries? This action cannot be undone.',
					'modula-best-grid-gallery'
				)
			)
		) {
			return;
		}

		setIsCleaning(true);
		setNotification(null);

		try {
			const response = await apiFetch({
				path: '/modula-ai-image-descriptor/v1/cleanup-galleries',
				method: 'POST',
			});

			if (response.success) {
				setNotification({
					status: 'success',
					message: response.message,
					details: response.data
						? `(${response.data.deleted_posts} galleries and ${response.data.deleted_meta} meta entries)`
						: '',
				});
			} else {
				setNotification({
					status: 'error',
					message:
						response.message ||
						__(
							'Failed to cleanup galleries.',
							'modula-best-grid-gallery'
						),
				});
			}
		} catch (error) {
			setNotification({
				status: 'error',
				message:
					error.message ||
					__(
						'An error occurred while cleaning up galleries.',
						'modula-best-grid-gallery'
					),
			});
		} finally {
			setIsCleaning(false);
		}
	};

	return (
		<div className="modula-button-action">
			{notification && (
				<Notice
					status={notification.status}
					isDismissible={false}
					className="modula-notice"
				>
					{notification.message}
					{notification.details && (
						<span className="modula-notice-details">
							{' '}
							{notification.details}
						</span>
					)}
				</Notice>
			)}
			<p className="modula-description">
				{__(
					'With the latest update, we have changed the way the image information is handled, now the information is retrieved from the Media Library. If you wish to set your previous details for the gallery images, please click the below button.',
					'modula-best-grid-gallery'
				)}
			</p>
			<Button
				variant="primary"
				isBusy={isLoading}
				disabled={isLoading}
				onClick={handleButtonClick}
			>
				{isLoading
					? __('Processing…', 'modula-best-grid-gallery')
					: __('Update Gallery Images', 'modula-best-grid-gallery')}
			</Button>

			<div className="modula-cleanup-section">
				<p className="modula-description">
					{__(
						'Clean up your database by removing all wrongfully created galleries.',
						'modula-best-grid-gallery'
					)}
				</p>
				<Button
					isDestructive
					isBusy={isCleaning}
					disabled={isCleaning}
					onClick={handleCleanupClick}
				>
					{isCleaning
						? __('Cleaning up…', 'modula-best-grid-gallery')
						: __('Cleanup database', 'modula-best-grid-gallery')}
				</Button>
			</div>
		</div>
	);
}
