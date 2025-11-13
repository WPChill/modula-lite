import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import styles from './extension-table.module.scss';
import ExtensionTableRow from './extension-table-row';
import ExtensionBulkActions from './extension-bulk-actions';

// Mock data - will be replaced with tanstack react query later
const mockExtensions = [
	{
		id: 1,
		title: 'Password Protect Galleries',
		description:
			'Password protect your galleries. This is a perfect solution for exclusive client galleries!',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-password-protect.png',
		status: 'inactive',
		available: true,
		version: '1.1.3',
	},
	{
		id: 2,
		title: 'Watermark',
		description:
			'Easily protect your photos by adding custom watermarks to your WordPress image galleries with Modula.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-watermark.png',
		status: 'active',
		available: true,
		version: '1.0.14',
	},
	{
		id: 3,
		title: 'SEO Deeplink',
		description:
			'Full SEO control over your galleries. Create a unique and indexable URL for each Modula Gallery item.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-deeplink.png',
		status: 'inactive',
		available: true,
		version: '1.0.11',
	},
	{
		id: 4,
		title: 'Image Guardian',
		description:
			'The Modula Image Guardian extension provides the protection your galleries need, from right-click protection to hiding the images URLs and blurring images when focus is moved from the browser window.',
		status: 'inactive',
		available: true,
		version: '1.1.4',
	},
	{
		id: 5,
		title: 'Advanced Shortcode',
		description:
			'Allows you to dynamically link to specific galleries without creating pages for them by using URLs with query strings.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-advanced-shortcodes.png',
		status: 'inactive',
		available: true,
		version: '1.0.7',
	},
	{
		id: 6,
		title: 'SpeedUp',
		description:
			"Allow Modula to automatically optimize your images to load as fast as possible by reducing their file sizes, resizing them through ShortPixel and serve them from StackPath's content delivery network.",
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-speedup.png',
		status: 'active',
		available: true,
		version: '1.0.24',
	},
	{
		id: 7,
		title: 'Video',
		description:
			'Adding a video gallery with both self-hosted videos and videos from sources like YouTube and Vimeo to your website has never been easier.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-video.png',
		status: 'inactive',
		available: true,
		version: '1.1.13',
	},
	{
		id: 8,
		title: 'Comments',
		description: 'Allow your site users to comment on your gallery images.',
		status: 'inactive',
		available: true,
		version: '1.0.3',
	},
	{
		id: 9,
		title: 'Image Proofing',
		description:
			'Create photo proofing galleries with ease in your WordPress website.',
		status: 'inactive',
		available: false,
		version: '1.0.2',
	},
	{
		id: 10,
		title: 'Role Management',
		description:
			'Granular control over user roles and permissions for your Modula galleries.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-roles.png',
		status: 'active',
		available: true,
		version: '1.0.5',
	},
	{
		id: 11,
		title: 'Modula Instagram',
		description:
			'Import and display Instagram photos directly in your Modula galleries.',
		status: 'inactive',
		available: true,
		version: '1.0.0',
	},
	{
		id: 12,
		title: 'EXIF',
		description:
			'Display EXIF data from your images including camera settings, location, and more.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-exif.png',
		status: 'inactive',
		available: false,
		version: '1.0.0',
	},
	{
		id: 13,
		title: 'Lightbox',
		description:
			'Enhance your gallery with beautiful lightbox effects and advanced image viewing options.',
		status: 'inactive',
		available: true,
		version: '1.0.0',
	},
	{
		id: 14,
		title: 'Albums',
		description:
			'Organize your galleries into beautiful albums and collections for better content management.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-albums.png',
		status: 'inactive',
		available: false,
		version: '1.0.0',
	},
	{
		id: 15,
		title: 'Download',
		description:
			'Allow visitors to download images from your galleries with customizable download options.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-download.png',
		status: 'inactive',
		available: true,
		version: '1.0.0',
	},
	{
		id: 16,
		title: 'Zoom',
		description:
			'Add zoom functionality to your gallery images for detailed viewing and better user experience.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-zoom.png',
		status: 'inactive',
		available: false,
		version: '1.0.0',
	},
	{
		id: 17,
		title: 'Slider',
		description:
			'Transform your galleries into stunning sliders with smooth transitions and customizable effects.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-slider.png',
		status: 'inactive',
		available: true,
		version: '1.0.0',
	},
	{
		id: 18,
		title: 'Slideshow',
		description:
			'Create beautiful slideshows from your gallery images with automatic transitions and controls.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-slideshow.png',
		status: 'inactive',
		available: true,
		version: '1.0.0',
	},
	{
		id: 19,
		title: 'Fullscreen',
		description:
			'Display your galleries in fullscreen mode for an immersive viewing experience.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2022/02/loupe.png',
		status: 'inactive',
		available: true,
		version: '1.0.0',
	},
	{
		id: 20,
		title: 'Content Galleries',
		description:
			'Create galleries directly from your WordPress content with automatic image extraction.',
		status: 'inactive',
		available: true,
		version: '1.0.0',
	},
	{
		id: 21,
		title: 'Pagination',
		description:
			'Add pagination to your galleries to improve performance and organize large image collections.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2023/10/069-refresh.webp',
		status: 'inactive',
		available: false,
		version: '1.0.0',
	},
	{
		id: 22,
		title: 'Image Licensing',
		description:
			'Manage image licensing and copyright information directly within your galleries.',
		status: 'inactive',
		available: false,
		version: '1.0.0',
	},
	{
		id: 23,
		title: 'Whitelabel',
		description:
			'Customize the Modula branding and interface to match your brand identity.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-whitelabel.png',
		status: 'inactive',
		available: false,
		version: '1.0.0',
	},
	{
		id: 24,
		title: 'Defaults',
		description:
			'Set default settings for all your galleries to save time and maintain consistency.',
		image: 'https://wp-modula.com/wp-content/uploads/edd/2021/02/modula-defaults.png',
		status: 'inactive',
		available: false,
		version: '1.0.0',
	},
];

export default function ExtensionTable() {
	const [selectedIds, setSelectedIds] = useState([]);

	// Sort extensions by availability (available first, then unavailable)
	const sortedExtensions = [...mockExtensions].sort((a, b) => {
		if (a.available === b.available) {
			return 0;
		}
		return a.available ? -1 : 1;
	});

	const handleSelectAll = (checked) => {
		if (checked) {
			setSelectedIds(sortedExtensions.map((ext) => ext.id));
		} else {
			setSelectedIds([]);
		}
	};

	const handleSelectOne = (id, checked) => {
		if (checked) {
			setSelectedIds([...selectedIds, id]);
		} else {
			setSelectedIds(
				selectedIds.filter((selectedId) => selectedId !== id)
			);
		}
	};

	const handleBulkAction = (action, ids) => {
		// TODO: Implement bulk action with tanstack react query
		console.log('Bulk action:', action, ids);
		// Reset selection after action
		setSelectedIds([]);
	};

	const allSelected =
		selectedIds.length === sortedExtensions.length &&
		sortedExtensions.length > 0;
	const someSelected =
		selectedIds.length > 0 && selectedIds.length < sortedExtensions.length;

	return (
		<>
			<ExtensionBulkActions
				selectedIds={selectedIds}
				onBulkAction={handleBulkAction}
			/>
			<div className={styles.tableWrapper}>
				<table className={styles.extensionTable}>
					<thead>
						<tr>
							<th className={styles.checkboxColumn}>
								<input
									type="checkbox"
									checked={allSelected}
									ref={(input) => {
										if (input) {
											input.indeterminate = someSelected;
										}
									}}
									onChange={(e) =>
										handleSelectAll(e.target.checked)
									}
								/>
							</th>
							<th className={styles.extensionColumn}>
								{__('Extension', 'modula-best-grid-gallery')}
							</th>
							<th className={styles.descriptionColumn}>
								{__('Description', 'modula-best-grid-gallery')}
							</th>
							<th className={styles.statusColumn}>
								{__('Status', 'modula-best-grid-gallery')}
							</th>
						</tr>
					</thead>
					<tbody>
						{sortedExtensions.map((extension) => (
							<ExtensionTableRow
								key={extension.id}
								extension={extension}
								selected={selectedIds.includes(extension.id)}
								onSelectChange={(checked) =>
									handleSelectOne(extension.id, checked)
								}
							/>
						))}
					</tbody>
				</table>
			</div>
		</>
	);
}
