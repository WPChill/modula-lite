<?php


class Modula_Script_Manager {

	private $scripts = array();
	private $styles  = array();
	private $compress_versions = array(
		'modula-all' => array( 'modula-isotope-packery', 'modula-isotope', 'modula-grid-justified-gallery', 'modula-fancybox', 'modula-lazysizes', 'modula' ),
		'modula-wf'  => array( 'modula-isotope-packery', 'modula-isotope', 'modula-lazysizes', 'modula' ),
		'modula-wl'  => array( 'modula-isotope-packery', 'modula-isotope', 'modula-fancybox', 'modula' ),
		'modula-wfl' => array( 'modula-isotope-packery', 'modula-isotope', 'modula' ),
		'modula-justified-wf'  => array( 'modula-grid-justified-gallery', 'modula-lazysizes', 'modula' ),
		'modula-justified-wl'  => array( 'modula-grid-justified-gallery', 'modula-fancybox', 'modula' ),
		'modula-justified-wfl' => array( 'modula-grid-justified-gallery', 'modula' ),
	);

	function __construct() {

		add_action( 'wp_footer', array( $this, 'enqueue_scripts' ), 10 );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

	}

	public static function get_instance() {
		static $inst;
		if ( ! $inst ) {
			$inst = new Modula_Script_Manager();
		}
		return $inst;
	}

	public function register_scripts(){

		wp_register_script( 'modula-all', MODULA_URL . 'assets/js/modula-all.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'modula-wf', MODULA_URL . 'assets/js/modula-wf.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'modula-wl', MODULA_URL . 'assets/js/modula-wl.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'modula-wfl', MODULA_URL . 'assets/js/modula-wfl.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'modula-justified-wf', MODULA_URL . 'assets/js/modula-justified-wf.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'modula-justified-wl', MODULA_URL . 'assets/js/modula-justified-wl.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'modula-justified-wfl', MODULA_URL . 'assets/js/modula-justified-wfl.js', array( 'jquery' ), MODULA_LITE_VERSION, true );

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

            foreach ( $this->compress_versions as $handle => $scripts ) {

            	$compressed_handle = $handle;
            	foreach ( $scripts as $key ) {
            		
            		if ( ! in_array( $key, $handles['scripts'] ) ) {
            			$compressed_handle = '';
            			break;
            		}

            	}

            	if ( '' != $compressed_handle ) {
            		break;
            	}

            }

            $max = max( count( $handles['scripts'] ), count( $this->scripts ) );

            if ( '' == $compressed_handle || ! isset( $this->compress_versions[ $compressed_handle ] ) ) {
                $compress_scripts = array();
            }else{
                $compress_scripts = $this->compress_versions[ $compressed_handle ];
            }

            $main_is_enq = false;
            for ( $i=0; $i < $max; $i++ ) { 
                
                if ( isset( $handles['scripts'][ $i ] ) ) {
                    if ( ! wp_script_is( $handles['scripts'][ $i ], 'enqueued') ) {
                        if ( ! in_array( $handles['scripts'][ $i ], $compress_scripts ) ) {
                            wp_enqueue_script( $handles['scripts'][ $i ] );
                        }elseif ( 'modula' == $handles['scripts'][ $i ] && '' != $compressed_handle && ! $main_is_enq ) {
                            wp_enqueue_script( $compressed_handle );
                            $main_is_enq = true;
                        }
                    }
                }

                if ( isset( $this->scripts[ $i ] ) ) {
                    if ( ! wp_script_is( $this->scripts[ $i ], 'enqueued') ) {
                        if ( ! in_array( $this->scripts[ $i ], $compress_scripts ) ) {
                            wp_enqueue_script( $this->scripts[ $i ] );
                        }elseif ( 'modula' == $handles['scripts'][ $i ] && '' != $compressed_handle && ! $main_is_enq ) {
                            wp_enqueue_script( $compressed_handle );
                            $main_is_enq = true;
                        }
                    }
                }


            }

        }else{

        	foreach ( $this->compress_versions as $handle => $scripts ) {

            	$compressed_handle = $handle;
            	foreach ( $scripts as $key ) {
            		
            		if ( ! in_array( $key, $this->scripts ) ) {
            			$compressed_handle = '';
            			break;
            		}

            	}

            	if ( '' != $compressed_handle ) {
            		break;
            	}

            }

        	if ( '' == $compressed_handle || ! isset( $this->compress_versions[ $compressed_handle ] ) ) {
        		$compress_scripts = array();
        	}else{
        		$compress_scripts = $this->compress_versions[ $compressed_handle ];
        	}

        	foreach ( $this->scripts as $key ) {
        		
        		if ( ! wp_script_is( $key, 'enqueued') ) {
        			if ( ! in_array( $key, $compress_scripts  ) ) {
        				wp_enqueue_script( $key );
        			}elseif ( 'modula' == $key && '' != $compressed_handle ) {
        				wp_enqueue_script( $compressed_handle );
        			}
                    
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

}

new Modula_Script_Manager();