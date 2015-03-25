<?php

namespace Onoi\EventDispatcher;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
interface EventListenerCollection {

	/**
	 * Returns a collection of registered EventListeners
	 *
	 * @since 1.0
	 *
	 * @param array
	 */
	public function getCollection();

}
