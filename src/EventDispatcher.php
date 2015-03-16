<?php

namespace Onoi\EventDispatcher;

/**
 * Dispatches events to registered listeners
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
interface EventDispatcher {

	/**
	 * Registers a collection of listeners
	 *
	 * @since 1.0
	 *
	 * @param EventListenerCollection $listenerCollection
	 */
	public function addListenerCollection( EventListenerCollection $listenerCollection );

	/**
	 * Registers a listener to an event identifier
	 *
	 * @since 1.0
	 *
	 * @param string $event
	 * @param EventListener|null $listener
	 */
	public function addListener( $event, EventListener $listener );

	/**
	 * Remove all (or a specific) listener that matches the event identifier
	 *
	 * @since 1.0
	 *
	 * @param string $event
	 * @param EventListener|null $listener
	 */
	public function removeListener( $event, EventListener $listener = null );

	/**
	 * Whether an event identifier has registered listeners
	 *
	 * @since 1.0
	 *
	 * @param string $event
	 *
	 * @return boolean
	 */
	public function hasEvent( $event );

	/**
	 * Notifies all listeners register to an event identifier
	 *
	 * @since 1.0
	 *
	 * @param string $event
	 * @param EventContext|null $eventContext
	 */
	public function dispatch( $event, EventContext $eventContext = null );

}
