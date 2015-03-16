<?php

namespace Onoi\EventDispatcher;

use Onoi\EventDispatcher\Dispatcher\GenericEventDispatcher;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class EventDispatcherFactory {

	/**
	 * @since 1.0
	 *
	 * @return GenericEventDispatcher
	 */
	public function newGenericEventDispatcher() {
		return new GenericEventDispatcher();
	}

	/**
	 * @since 1.0
	 *
	 * @return EventContext
	 */
	public function newEventContext() {
		return new EventContext();
	}

}
