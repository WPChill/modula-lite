import {
	Button,
	Flex,
	FlexItem,
	Icon,
	Spinner,
	TextControl,
	__experimentalSpacer as Spacer,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import styles from './claim-credits.module.css';
import { useForm } from '@tanstack/react-form';
import { useState } from '@wordpress/element';
import { useSettingsQuery } from '../query/useSettingsQuery';
import { check, close } from '@wordpress/icons';
import { useSettingsMutation } from '../query/useSettingsMutation';

export default function ClaimCredits() {
	const [loading, setLoading] = useState(false);
	const [saved, setSaved] = useState(false);
	const { mutate: updateSettings } = useSettingsMutation();
	const { data } = useSettingsQuery();

	const form = useForm({
		defaultValues: {
			apiKey: data?.api_key || '',
			email: data?.readonly?.email,
			first_name: data?.readonly?.first_name,
			last_name: data?.readonly?.last_name,
			valid_key: data?.readonly?.valid_key,
		},
		onSubmit: async ({ value }) => {
			setLoading(true);
			updateSettings({
				api_key: value.apiKey,
			});
			setLoading(false);
			setSaved(true);
		},
	});

	const claimCredits = () => {
		window.open('https://wp-modula.com/my-account', '_blank');
	};

	const validKey = data?.readonly?.valid_key;
	return (
		<div className={styles.container}>
			{!validKey && (
				<>
					<p className={styles.description}>
						{__(
							'In order to use this powerful functionality you will first need to claim your credits.',
							'modula-best-grid-gallery'
						)}
					</p>
					<p className={styles.description}>
						{__(
							'If you already have the api key, use it in the field below or click "Claim Credits" to get a new one.',
							'modula-best-grid-gallery'
						)}
					</p>
				</>
			)}
			<form
				onSubmit={(e) => {
					e.preventDefault();
					e.stopPropagation();
					form.handleSubmit();
				}}
			>
				<form.Field
					name="apiKey"
					children={(field) => (
						<TextControl
							__nextHasNoMarginBottom
							__next40pxDefaultSize
							label={
								<Flex justify="space-between">
									<FlexItem>
										<Flex justify="flex-start" gap={2}>
											<FlexItem>
												{__(
													'API Key',
													'modula-best-grid-gallery'
												)}
											</FlexItem>

											<FlexItem>
												<Icon
													style={{
														fill: validKey
															? 'green'
															: 'red',
													}}
													size={validKey ? 18 : 14}
													icon={
														validKey ? check : close
													}
													className="modula-settings-form-valid-key"
												/>
											</FlexItem>
										</Flex>
									</FlexItem>
									<FlexItem>
										{validKey && (
											<>
												{data?.readonly?.credits}{' '}
												{__(
													'Credits remaining',
													'modula-best-grid-gallery'
												)}
											</>
										)}
										{!validKey && (
											<>
												{__(
													'Invalid API Key',
													'modula-best-grid-gallery'
												)}
											</>
										)}
									</FlexItem>
								</Flex>
							}
							value={field.state.value}
							onChange={(e) => {
								field.handleChange(e);
							}}
						/>
					)}
				/>
				<Spacer marginTop={4} marginBottom={4} />
				<Flex
					justify="flex-start"
					gap={4}
					className={styles.buttonContainer}
				>
					<form.Subscribe
						selector={(state) => [state.canSubmit]}
						children={([canSubmit]) => (
							<Button
								variant="primary"
								type="submit"
								iconPosition="right"
								icon={
									loading ? <Spinner /> : saved ? check : null
								}
								isDisabled={!canSubmit}
							>
								{loading
									? __('… saving', 'modula-best-grid-gallery')
									: saved
										? __(
												'Saved',
												'modula-best-grid-gallery'
											)
										: __(
												'Save API Key',
												'modula-best-grid-gallery'
											)}
							</Button>
						)}
					/>
					{!validKey && (
						<Button variant="link" onClick={claimCredits}>
							{__('Claim Credits', 'modula-best-grid-gallery')}
						</Button>
					)}
				</Flex>
			</form>
		</div>
	);
}
