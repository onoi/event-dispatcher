<?php

namespace Onoi\EventDispatcher;

use Onoi\EventDispatcher\Listener\NullEventListener;
use Onoi\EventDispatcher\Listener\GenericCallbackEventListener;
use Onoi\EventDispatcher\Listener\GenericEventListenerCollection;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class EventListenerFactory {

	/**
	 * @since 1.0
	 *
	 * @return NullEventListener
	 */
	public function newNullEventListener() {
		return new NullEventListener();
	}

	/**
	 * @since 1.0
	 *
	 * @return GenericCallbackEventListener
	 */
	public function newGenericCallbackEventListener() {
		return new GenericCallbackEventListener();
	}

	/**
	 * @since 1.0
	 *
	 * @return GenericEventListenerCollection
	 */
	public function newGenericEventListenerCollection() {
		return new GenericEventListenerCollection();
	}

}
