<?php

namespace Onoi\EventDispatcher;

use InvalidArgumentException;

/**
 * Generic options to be attachable during the execution of a listener
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class EventContext {

	/**
	 * @var array
	 */
	private $options = array(
		'propagationstop' => false
	);

	/**
	 * @since 1.0
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function set( $key, $value ) {
		$this->options[strtolower( $key )] = $value;
	}

	/**
	 * @since 1.0
	 *
	 * @param string $key
	 *
	 * @return mixed
	 * @throws InvalidArgumentException
	 */
	public function get( $key ) {

		$key = strtolower( $key );

		if ( isset( $this->options[$key] ) ) {
			return $this->options[$key];
		}

		throw new InvalidArgumentException(  "{$key} is unknown" );
	}

	/**
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function isPropagationStopped() {
		return $this->get( 'propagationstop' );
	}

}
