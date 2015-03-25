<?php

namespace Onoi\EventDispatcher;

/**
 * Interface for objects that can be listen to
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
interface EventListener {

	/**
	 * Execute a registered listener action
	 *
	 * @since 1.0
	 *
	 * @param DispatchContext|null $dispatchContext
	 */
	public function execute( DispatchContext $dispatchContext = null );

	/**
	 * Whether propagation of events for others with the same identifier
	 * should continue or not
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function isPropagationStopped();

}
