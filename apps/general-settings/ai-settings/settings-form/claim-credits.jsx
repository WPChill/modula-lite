import {
	Button,
	Flex,
	FlexItem,
	Icon,
	TextControl,
	SelectControl,
	__experimentalSpacer as Spacer,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import styles from './claim-credits.module.css';
import { useForm } from '@tanstack/react-form';
import { useSettingsQuery } from '../../query/useSettingsQuery';
import { check, close } from '@wordpress/icons';
import { LANGUAGES } from './languages';
import useStateContext from '../../context/useStateContext';
import { setOptions } from '../../context/actions';

export default function ClaimCredits() {
	const { data } = useSettingsQuery();
	const { state, dispatch } = useStateContext();

	const form = useForm( {
		defaultValues: {
			modula_ai_api_key: data?.api_key || '',
			modula_ai_language: data?.language || 'en',
			email: data?.readonly?.email,
			first_name: data?.readonly?.first_name,
			last_name: data?.readonly?.last_name,
			valid_key: data?.readonly?.valid_key,
		},
	} );

	const claimCredits = () => {
		window.open( 'https://wp-modula.com/my-account', '_blank' );
	};

	const handleChange = ( val, field ) => {
		field.handleChange( val );
		console.error( field );
		dispatch(
			setOptions( {
				...state.options,
				[ field.name ]: val,
			} ),
		);
	};

	const validKey = data?.readonly?.valid_key;

	return (
		<div className={ styles.container }>
			{ ! validKey && (
				<>
					<p className={ styles.description }>
						{ __(
							'In order to use this powerful functionality you will first need to claim your credits.',
							'modula-best-grid-gallery',
						) }
					</p>
					<p className={ styles.description }>
						{ __(
							'If you already have the api key, use it in the field below or click "Claim Credits" to get a new one.',
							'modula-best-grid-gallery',
						) }
					</p>
				</>
			) }

			<Flex gap={ 4 } align="flex-start">
				<FlexItem style={ { flex: 2 } }>
					<form.Field
						name="modula_ai_api_key"
						children={ ( field ) => (
							<TextControl
								__nextHasNoMarginBottom
								__next40pxDefaultSize
								label={
									<Flex justify="space-between">
										<FlexItem>
											<Flex
												justify="flex-start"
												gap={ 2 }
											>
												<FlexItem>
													{ __(
														'API Key',
														'modula-best-grid-gallery',
													) }
												</FlexItem>

												<FlexItem>
													<Icon
														style={ {
															fill: validKey
																? 'green'
																: 'red',
														} }
														size={
															validKey
																? 18
																: 14
														}
														icon={
															validKey
																? check
																: close
														}
														className="modula-settings-form-valid-key"
													/>
												</FlexItem>
											</Flex>
										</FlexItem>
										<FlexItem>
											{ validKey && (
												<>
													{
														data?.readonly
															?.credits
													}{ ' ' }
													{ __(
														'Credits remaining',
														'modula-best-grid-gallery',
													) }
												</>
											) }
											{ ! validKey && (
												<>
													{ __(
														'Invalid API Key',
														'modula-best-grid-gallery',
													) }
												</>
											) }
										</FlexItem>
									</Flex>
								}
								value={ field.state.value }
								onChange={ ( val ) => handleChange( val, field ) }
							/>
						) }
					/>
				</FlexItem>
				<FlexItem style={ { flex: 1 } }>
					<form.Field
						name="modula_ai_language"
						children={ ( field ) => (
							<SelectControl
								__nextHasNoMarginBottom
								__next40pxDefaultSize
								label={ __(
									'Language used to generate reports',
									'modula-best-grid-gallery',
								) }
								value={ field.state.value }
								options={ LANGUAGES }
								onChange={ ( val ) => handleChange( val, field ) }
							/>
						) }
					/>
				</FlexItem>
			</Flex>
			<Spacer marginTop={ 4 } marginBottom={ 4 } />
			<Flex
				justify="flex-start"
				gap={ 4 }
				className={ styles.buttonContainer }
			>
				{ ! validKey && (
					<Button variant="link" onClick={ claimCredits }>
						{ __( 'Claim Credits', 'modula-best-grid-gallery' ) }
					</Button>
				) }
			</Flex>
		</div>
	);
}
