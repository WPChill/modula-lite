<?php
namespace Modula\Ai;

trait Debug {
	public $debug_option = 'modula_ai_debug';
	private $debug_lock  = 'modula_ai_debug_lock';

	public function reset_debug() {
		update_option( $this->debug_option, array() );
	}

	public function get_debug() {
		return get_option( $this->debug_option, array() );
	}

	public function write_debug( $value ) {
		while ( get_transient( $this->debug_lock ) ) {
			usleep( 1000 );
		}
		set_transient( $this->debug_lock, true, 10 );

		$current_debug = $this->get_debug();
		if ( $this->debug ) {
			if ( is_array( $value ) ) {
				update_option(
					$this->debug_option,
					array_merge(
						$current_debug,
						$value
					)
				);
			} else {
				$current_debug[] = $value;
				update_option( $this->debug_option, $current_debug );
			}
		}

		delete_transient( $this->debug_lock );
	}
}
