<?php


class Modula_Script_Manager {

	private $scripts = array();
	private $styles  = array();

	function __construct() {

		add_action( 'wp_footer', array( $this, 'enqueue_scripts' ), 10 );

		// Exclude scripts from concatenation.
		add_filter( 'rocket_exclude_js', array( $this, 'exclude_from_wp_rocket' ) );
		add_filter( 'autoptimize_filter_js_exclude', array( $this, 'exclude_from_autoptimize' ) );
	}

	public static function get_instance() {
		static $inst;
		if ( ! $inst ) {
			$inst = new Modula_Script_Manager();
		}
		return $inst;
	}

	public function enqueue_scripts(){
		$compressed_handle = '';

		$defaults = apply_filters( 'modula_troubleshooting_defaults', array(
            'enqueue_files'    => false,
            'gridtypes'        => array(),
            'lightboxes'       => array(),
            'lazy_load'        => false
        ));

        $ts_opt = get_option( 'modula_troubleshooting_option', array() );
        $ts_opt = wp_parse_args( $ts_opt, $defaults );

        if ( $ts_opt['enqueue_files'] ) {

        	$handles = array(
                'scripts' => array(),
                'styles'  => array(),
            );

            /**
             * Hook: modula_troubleshooting_frontend_handles.
             *
             * @hooked check_lightbox - 10
             * @hooked check_lazyload - 20
             * @hooked check_gridtype - 30
             * @hooked main_lite_files - 50
             */
            $handles = apply_filters( 'modula_troubleshooting_frontend_handles', $handles, $ts_opt );

			$scripts = array();
			$styles  = array();
			
			$scripts = array_unique( array_merge( $handles['scripts'], $this->scripts ) );
			$styles = array_unique( array_merge( $handles ['styles'], $this->styles ) );
        	
			foreach ( $scripts as $script ) {
        		if ( ! wp_script_is( $script, 'enqueued') && ! empty( $script ) ) {
        				wp_enqueue_script( $script );
				}
			}     

			foreach ( $styles as $style ) {
        		if ( ! wp_style_is( $style, 'enqueued') && ! empty( $style ) ) {
        				wp_enqueue_style( $script );
				}
			}

        }else{
        	foreach ( $this->scripts as $script ) {
        		if ( ! wp_script_is( $script, 'enqueued') ) {
        				wp_enqueue_script( $script );
				}
			}
        	foreach ( $this->styles as $style ) {
        		if ( ! wp_style_is( $style, 'enqueued') ) {
        				wp_enqueue_script( $style );
				}
			}
		}
	}
	

	public function add_script( $handler ){
		$this->scripts[] = $handler;
	}

	public function add_style( $handler ){
		$this->styles[] = $handler;
	}

	public function add_scripts( $handlers ){
		$this->scripts = array_merge( $this->scripts, $handlers );
	}

	public function add_styles( $handlers ){
		$this->styles = array_merge( $this->styles, $handlers );
	}

	public function exclude_from_wp_rocket( $excluded_js ) {
		global $wp_scripts;

		if ( ! isset( $wp_scripts ) || empty( $this->scripts ) ) {
			return $excluded_js;
		}

		foreach ( $this->scripts as $handle ) {
			if ( isset( $wp_scripts->registered[ $handle ] ) ) {
				$src = $wp_scripts->registered[ $handle ]->src;

				// Convert the full URL into a relative path (e.g. /wp-content/plugins/...)
				if ( ! empty( $src ) ) {
					$path = wp_parse_url( $src, PHP_URL_PATH );
					if ( $path ) {
						$excluded_js[] = $path;
					}
				}
			}
		}

		// jQuery is a must have.
		$excluded_js[] = '/wp-includes/js/jquery/jquery(.min)?.js';

		return array_unique( array_filter( $excluded_js ) );
	}

	public function exclude_from_autoptimize( $excluded ) {
		$excludes = explode( ',', $excluded );

		$excludes = array_merge(
			$excludes,
			$this->scripts,
			array( 'jquery', 'jquery.min' ) // jQuery is a must have.
		);

		return implode( ',', array_unique( array_filter( $excludes ) ) );
	}
}
