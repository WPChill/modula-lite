const ModulaStyle = (props) => {
	const { id, settings } = props;

	let style = ``;

	if ('grid' == settings.type) {
		if ('automatic' != settings.grid_type) {
			style += `#jtg-${id}.modula-gallery .modula-item, .modula-gallery .modula-grid-sizer { width: calc(${100 /
				settings.grid_type}% - ${settings.gutter - settings.gutter / settings.grid_type}px) !important}`;
		}
	}

	if ('0' != settings.borderSize) {
		style += `#jtg-${id} .modula-item {
			border: ${settings.borderSize}px solid ${settings.borderColor};
		}`;
	}

	if ('0' != settings.borderRadius) {
		style += `#jtg-${id} .modula-item {
			border-radius: ${settings.borderRadius}px;
		}`;
	}

	if ('0' != settings.shadowSize) {
		style += `#jtg-${id} .modula-item {
			box-shadow: ${settings.shadowColor} 0px 0px ${settings.shadowSize}px;
		}`;
	}

	if ('#ffffff' != settings.socialIconColor) {
		style += `#jtg-${id} .modula-item .jtg-social a {
			color: ${settings.socialIconColor};
		}`;
	}

	if ('16' != settings.socialIconSize) {
		style += `#jtg-${id} .modula-item .jtg-social svg {
			height: ${settings.socialIconSize}px;
			width: ${settings.socialIconSize}px;
		}`;
	}

	if ('10' != settings.socialIconPadding) {
		style += `#jtg-${id} .modula-item .jtg-social a:not(:last-child) {
			margin-right: ${settings.socialIconPadding}px;
		}`;
	}

	style += `#jtg-${id} .modula-item .caption {
		background-color: ${settings.captionColor};
	}`;

	if ('' != settings.captionColor) {
		style += `#jtg-${id} .modula-item .figc {
			color: ${settings.captionColor};
		}`;
	}

	if ('' != settings.titleFontSize && '0' != settings.titleFontSize) {
		style += `#jtg-${id} .modula-item .figc .jtg-title {
			font-size: ${settings.titleFontSize}px;
		}`;
	}

	if ('' != settings.captionFontSize && '0' != settings.captionFontSize) {
		style += `#jtg-${id} .modula-item .figc p.description {
			font-size: ${settings.captionFontSize}px;
		}`;
	}

	style += `#jtg-${id} .modula-items .figc p.description {
			color: ${settings.captionColor};
	}`;

	if ('' != settings.titleColor) {
		style += `#jtg-${id} .modula-items .figc .jtg-title {
			color: ${settings.titleColor};
		}`;
	} else {
		style += `#jtg-${id} .modula-items .figc .jtg-title {
			color: ${settings.captionColor};
		}`;
	}

	style += `#jtg-${id}.modula-gallery .modula-item > a, #jtg-${id}.modula-gallery .modula-item, #jtg-${id}.modula-gallery .modula-item-content > a  {
		cursor: ${settings.cursor};
	}`;

	// SEE ABOUT LOADED EFFECT IF WE NEED TO ADD OR NOTTTTTTTTTTTTTT #REMINDER

	if ('custom-grid' != settings.type || 'slider' != settings.type) {
		style += `#jtg-${id} {
		width: ${settings.width};
		margin : 0 auto;
		}`;

		if (props.imagesCount == 0) {
			style += `#jtg-${id} .modula-items {
				height: 100px;
			}`;
		} else {
			if ('grid' != settings.type && 'slider' != settings.type) {
				style += `#jtg-${id} .modula-items {
				height: ${settings.height}px;
			}`;
			} else if ( 'slider' == settings.type ) {
				style += `#jtg-${id} .modula-items {
				height: auto;
			}`;
			}
		}
	}

	if (undefined != settings.style && 0 != settings.style.length) {
		style += `${settings.style}`;
	}

	//RESPONSIVE FIXES
	let mobileStyle = ``;
	if ('' != settings.mobileTitleFontSize && 0 != settings.mobileTitleFontSize) {
		mobileStyle += `#jtg-${id} .modula-item .figc .jtg-title {
			font-size: ${settings.mobileTitleFontSize}px
		}`;
	}

	mobileStyle += `#jtg-${id} .modula-items .figc p.description {
		color: ${settings.captionColor};
		font-size: ${settings.mobileCaptionFontSize}px;
	}`;
	style += `@media screen and (max-width:480px){
		${mobileStyle}
		}`;

	if ('none' == settings.effect) {
		style += `#jtg-${id} .modula-items .modula-item:hover img {
			opacity: 1;
		}`;
	}

	style += `#jtg-${id}.modula .modula-items .modula-item .modula-item-overlay,   #jtg-${id}.modula .modula-items .modula-item.effect-layla,   #jtg-${id}.modula .modula-items .modula-item.effect-ruby,  #jtg-${id}.modula .modula-items .modula-item.effect-bubba,  #jtg-${id}.modula .modula-items .modula-item.effect-sarah,  #jtg-${id}.modula .modula-items .modula-item.effect-milo,  #jtg-${id}.modula .modula-items .modula-item.effect-julia,  #jtg-${id}.modula .modula-items .modula-item.effect-hera,  #jtg-${id}.modula .modula-items .modula-item.effect-winston,  #jtg-${id}.modula .modula-items .modula-item.effect-selena,  #jtg-${id}.modula .modula-items .modula-item.effect-terry,  #jtg-${id}.modula .modula-items .modula-item.effect-phoebe,  #jtg-${id}.modula .modula-items} .modula-item.effect-apollo,  #jtg-${id}.modula .modula-items .modula-item.effect-steve,  #jtg-${id}.modula .modula-items .modula-item.effect-ming{ 
		background-color: ${settings.hoverColor};
	}`;

	style += `#jtg-${id}.modula .modula-items .modula-item.effect-oscar {
		background: -webkit-linear-gradient(45deg, ${settings.hoverColor} 0, #9b4a1b 40%, ${settings.hoverColor} 100%);
		background: linear-gradient(45deg, ${settings.hoverColor} 0, #9b4a1b 40%, ${settings.hoverColor} 100%);
	}`;

	style += `#jtg-${id}.modula .modula-items .modula-item.effect-roxy {
		background: -webkit-linear-gradient(45deg, ${settings.hoverColor} 0, #05abe0 100%);
		background: linear-gradient(45deg, ${settings.hoverColor} 0, #05abe0 100%);
	}`;

	style += `#jtg-${id}.modula .modula-items .modula-item.effect-dexter {
		background: -webkit-linear-gradient(top, ${settings.hoverColor} 0, rgba(104,60,19,1) 100%);
		background: linear-gradient(top, ${settings.hoverColor} 0, rgba(104,60,19,1) 100%);
	}`;

	style += `#jtg-${id}.modula .modula-items .modula-item.effect-jazz {
		background: -webkit-linear-gradient(-45deg, ${settings.hoverColor} 0, #f33f58 100%);
		background: linear-gradient(-45deg, ${settings.hoverColor} 0, #f33f58 100%);
	}`;

	style += `#jtg-${id}.modula .modula-items .modula-item.effect-lexi {
		background: -webkit-linear-gradient(-45deg, ${settings.hoverColor} 0, #fff 100%);
		background: linear-gradient(-45deg, ${settings.hoverColor} 0, #fff 100%);
	}`;

	style += `#jtg-${id}.modula .modula-items .modula-item.effect-duke {
		background: -webkit-linear-gradient(-45deg, ${settings.hoverColor} 0, #cc6055 100%);
		background: linear-gradient(-45deg, ${settings.hoverColor} 0, #cc6055 100%);
	}`;

	if (settings.hoverOpacity <= 100 && 'none' != settings.effect) {
		style += `#jtg-${id}.modula .modula-items .modula-item:hover img {
			opacity: ${1 - settings.hoverOpacity / 100} ;
		}`;
	}

	if ('default' != settings.titleFontWeight) {
		style += `#jtg-${id}.modula .modula-items .modula-item .jtg-title {
			font-weight : ${settings.titleFontWeight};
		}`;
	}

	if ('default' != settings.captionFontWeight) {
		style += `#jtg-${id}.modula .modula-items .modula-item p.description {
			font-weight : ${settings.captionFontWeight};
		}`;
	}

	style += `#jtg-${id}.modula-gallery .modula-item.effect-terry .jtg-social a:not(:last-child) {
		margin-bottom: ${settings.socialIconPadding}px;
	}`;

	if ('slider' == settings['type']) {
		if( "true" == jQuery("[aria-label=Settings]").attr('aria-expanded')  ) {
			style += `#jtg-${id} {
					width: 800px;
					}`;
		} else {
			style += `#jtg-${id} {
			width: 1100px;
			}`;
		}
		style += `#jtg-${id} .modula-items {
		height: auto;
		}`;

		style += `#jtg-${id} .modula-item {
		background-color: transparent;
		transform: none;
		}`;
	}

	if(undefined != settings['filters'] && settings['filters'].length > 1 ) {
		style += `#jtg-${id}.modula-gallery .filters {
			text-align: ${settings['filterTextAlignment']};
		}`
	}

	return (
		<style
			dangerouslySetInnerHTML={{
				__html: `
      				${style}
    				`
			}}
		/>
	);
};

export default ModulaStyle;
