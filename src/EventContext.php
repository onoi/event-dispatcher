<?php

namespace Onoi\EventDispatcher;

use InvalidArgumentException;

/**
 * Generic context to can be attached during the dispatch and can be accessed
 * by a listener
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
	private $container = array();

	/**
	 * @since 1.0
	 *
	 * @param string $key
	 *
	 * @return boolean
	 */
	public function has( $key ) {
		return isset( $this->container[strtolower( $key )] );
	}

	/**
	 * @since 1.0
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function set( $key, $value ) {
		$this->container[strtolower( $key )] = $value;
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

		if ( $this->has( $key ) ) {
			return $this->container[strtolower( $key )];
		}

		throw new InvalidArgumentException( "{$key} is unknown" );
	}

	/**
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function isPropagationStopped() {
		return $this->has( 'propagationstop' ) ? $this->get( 'propagationstop' ) : false;
	}

}
