<?php

namespace Onoi\EventDispatcher\Tests;

use Onoi\EventDispatcher\EventDispatcherFactory;

/**
 * @covers \Onoi\EventDispatcher\EventDispatcherFactory
 *
 * @group onoi-event-dispatcher
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class EventDispatcherFactoryTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstructEventContext() {

		$instance = new EventDispatcherFactory();

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\EventContext',
			$instance->newEventContext()
		);
	}

	public function testCanConstructGenericEventDispatcher() {

		$instance = new EventDispatcherFactory();

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\Dispatcher\GenericEventDispatcher',
			$instance->newGenericEventDispatcher()
		);
	}

}
