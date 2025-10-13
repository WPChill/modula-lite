import { useWpchillState } from '../state/use-wpchill-state';

export function ProgressBar() {
	const { state } = useWpchillState();
	const steps = Array.from( { length: state.maxStep }, ( _, i ) => i + 1 );

	return (
		<div className="wpchill-progress">
			<div className="wpchill-progress__line">
				<div
					className="wpchill-progress__line-fill"
					style={ {
						width: `${ ( ( state.step - 1 ) / ( state.maxStep - 1 ) ) * 100 }%`,
					} }
				/>
			</div>

			<div className="wpchill-progress__steps">
				{ steps.map( ( num ) => (
					<div
						key={ num }
						className={ `wpchill-progress__step ${
							num <= state.step ? 'is-active' : ''
						}` }
					>
						<span className="wpchill-progress__step-number">{ num }</span>
					</div>
				) ) }
			</div>
		</div>
	);
}
