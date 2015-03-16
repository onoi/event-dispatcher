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
interface EventListenerCollection {

	/**
	 * Returns a collection of invoked EventListener
	 *
	 * @since 1.0
	 *
	 * @param array
	 */
	public function getCollection();

}
