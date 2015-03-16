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
	 * Excute a registered listener action
	 *
	 * @since 1.0
	 *
	 * @param EventContext|null $eventContext
	 */
	public function execute( EventContext $eventContext = null );

	/**
	 * Whether propagation of events for others with the same identifier
	 * should continue
	 *
	 * @since 1.0
	 *
	 * @return true
	 */
	public function isPropagationStopped();

}
