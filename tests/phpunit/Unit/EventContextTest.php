<?php

namespace Onoi\EventDispatcher\Tests;

use Onoi\EventDispatcher\EventContext;

/**
 * @covers \Onoi\EventDispatcher\EventContext
 *
 * @group onoi-event-dispatcher
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class EventContextTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\EventContext',
			new EventContext()
		);
	}

	public function testRountrip() {

		$instance = new EventContext();

		$this->assertFalse(
			$instance->has( 'FOO' )
		);

		$instance->set( 'foo', 'bar' );

		$this->assertTrue(
			$instance->has( 'FOO' )
		);

		$this->assertEquals(
			'bar',
			$instance->get( 'FOO' )
		);

		$instance->set( 'foo', new \stdClass );

		$this->assertEquals(
			new \stdClass,
			$instance->get( 'FOO' )
		);
	}

	public function testToAlterPropagationState() {

		$instance = new EventContext();

		$this->assertFalse(
			$instance->isPropagationStopped()
		);

		$instance->set( 'proPagationSTOP', true );

		$this->assertTrue(
			$instance->isPropagationStopped()
		);
	}

	public function testUnknownKeyThrowsException() {

		$instance = new EventContext();

		$this->setExpectedException( 'InvalidArgumentException' );
		$instance->get( 'FOO' );
	}

}
