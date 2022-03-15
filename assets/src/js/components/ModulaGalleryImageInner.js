import icons from '../utils/icons';
const { Fragment } = wp.element;

const ModulaGalleryImageInner = (props) => {
	const { settings, img, hideTitle, hideDescription, hideSocial } = props;

	let effectArray = [ 'tilt_1', 'tilt_3', 'tilt_7' ],
		overlayArray = [ 'tilt_3', 'tilt_7' ],
		svgArray = [ 'tilt_1', 'tilt_7' ],
		jtgBody = [ 'lily', 'sadie', 'ruby', 'bubba', 'dexter', 'chico', 'ming' ];

	return [
		<Fragment>
			{effectArray.includes(settings.effect) && (
				<div className="tilter__deco tilter__deco--shine">
					<div />
				</div>
			)}
			{overlayArray.includes(settings.effect) && <div className="tilter__deco tilter__deco--overlay" />}

			{svgArray.includes(settings.effect) && <div className="tilter__deco tilter__deco--lines" />}

			<div className="figc">
				<div className="figc-inner">
					{/* checking for undefined because on the first run , imageId doesnt exist */}
					{'0' == settings.hide_title && !hideTitle && <div className={'jtg-title'}> {img.title} </div>}
					<div className={jtgBody.includes(settings.effect) ? 'jtg-body' : ''}>
						{'0' == settings.hide_description &&
						!hideDescription && (
							<p className="description"> {0 != img.description.length && img.description} </p>
						)}

						{!hideSocial &&
						'1' == settings.enableSocial && (
							<div className="jtg-social">
								{'1' == settings.enableTwitter && (
									<a className="modula-icon-twitter" href="#">
										{' '}
										${icons.twitter}{' '}
									</a>
								)}
								{'1' == settings.enableFacebook && (
									<a className="modula-icon-facebook" href="#">
										{' '}
										${icons.facebook}{' '}
									</a>
								)}
								{'1' == settings.enableWhatsapp && (
									<a className="modula-icon-whatsapp" href="#">
										{' '}
										${icons.whatsapp}{' '}
									</a>
								)}
								{'1' == settings.enableLinkedin && (
									<a className="modula-icon-linkedin" href="#">
										{' '}
										${icons.linkedin}{' '}
									</a>
								)}
								{'1' == settings.enablePinterest && (
									<a className="modula-icon-pinterest" href="#">
										{' '}
										${icons.pinterest}{' '}
									</a>
								)}
								{'1' == settings.enableEmail && (
									<a className="modula-icon-email" href="#">
										{' '}
										${icons.email}{' '}
									</a>
								)}
							</div>
						)}
					</div>
				</div>
			</div>
		</Fragment>
	];
};

export default ModulaGalleryImageInner;
