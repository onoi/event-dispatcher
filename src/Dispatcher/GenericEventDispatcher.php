<?php

namespace Onoi\EventDispatcher\Dispatcher;

use Onoi\EventDispatcher\EventDispatcher;
use Onoi\EventDispatcher\EventListener;
use Onoi\EventDispatcher\EventListenerCollection;
use Onoi\EventDispatcher\EventContext;

use RuntimeException;

/**
 * Dispatches events to registered listeners
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class GenericEventDispatcher implements EventDispatcher {

	/**
	 * @var array
	 */
	private $dispatchableListeners = array();

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function addListenerCollection( EventListenerCollection $listenerCollection ) {
		foreach ( $listenerCollection->getCollection() as $event => $listeners ) {
			foreach ( $listeners as $listener ) {
				$this->addListener( $event, $listener );
			}
		}
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function addListener( $event, EventListener $listener ) {

		if ( !is_string( $event ) ) {
			throw new RuntimeException( "Expected a string " );
		}

		$event = strtolower( $event );

		if ( !isset( $this->dispatchableListeners[$event] ) ) {
			$this->dispatchableListeners[$event] = array();
		}

		$this->dispatchableListeners[$event][] = $listener;
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function removeListener( $event, EventListener $listener = null ) {

		$event = strtolower( $event );

		if ( !$this->hasEvent( $event ) ) {
			return;
		}

		if ( $listener !== null ) {
			foreach ( $this->dispatchableListeners[$event] as $key => $dispatchableListener ) {
				if ( $dispatchableListener == $listener ) {
					unset( $this->dispatchableListeners[$event][$key] );
				}
			}
		}

		if ( $listener === null || $this->dispatchableListeners[$event] === array() ) {
			unset( $this->dispatchableListeners[$event] );
		}
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function hasEvent( $event ) {
		return isset( $this->dispatchableListeners[strtolower( $event )] );
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function dispatch( $event, EventContext $eventContext = null ) {

		$event = strtolower( $event );

		if ( !$this->hasEvent( $event ) ) {
			return;
		}

		foreach ( $this->dispatchableListeners[$event] as $listener ) {

			$listener->execute( $eventContext );

			if ( $listener->isPropagationStopped() ) {
				break;
			}
		}
	}

}
