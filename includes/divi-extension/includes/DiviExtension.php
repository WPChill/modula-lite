<?php

class MODULA_DiviExtension extends DiviExtension {


	/**
	 * MODULA_DiviExtension constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'modula-divi', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}
}

new MODULA_DiviExtension;
