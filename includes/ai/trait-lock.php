<?php
namespace Modula\Ai;

trait Lock {
	/**
	 * Attempts to acquire a lock.
	 *
	 * @param string $lock_name The name of the lock.
	 * @param int $expiration The expiration of the lock in seconds.
	 * @return bool True if the lock was acquired, false otherwise.
	 */
	public function acquire_lock( $lock_name, $expiration = 5 ) {
		// Check if the lock already exists
		if ( get_transient( $lock_name ) ) {
			return false;  // Lock is already present
		}
		// Set the lock
		set_transient( $lock_name, true, $expiration );
		return true;
	}

	/**
	 * Releases a lock.
	 *
	 * @param string $lock_name The name of the lock to release.
	 */
	public function release_lock( $lock_name ) {
		delete_transient( $lock_name );
	}
}
