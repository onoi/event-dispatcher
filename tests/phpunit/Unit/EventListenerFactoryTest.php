<?php

namespace Onoi\EventDispatcher\Tests;

use Onoi\EventDispatcher\EventListenerFactory;

/**
 * @covers \Onoi\EventDispatcher\EventListenerFactory
 *
 * @group onoi-event-dispatcher
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class EventListenerFactoryTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstructNullEventListener() {

		$instance = new EventListenerFactory();

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\Listener\NullEventListener',
			$instance->newNullEventListener()
		);
	}

	public function testCanConstructGenericCallbackEventListener() {

		$instance = new EventListenerFactory();

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\Listener\GenericCallbackEventListener',
			$instance->newGenericCallbackEventListener()
		);
	}

	public function testCanConstructGenericEventListenerCollection() {

		$instance = new EventListenerFactory();

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\Listener\GenericEventListenerCollection',
			$instance->newGenericEventListenerCollection()
		);
	}

}
