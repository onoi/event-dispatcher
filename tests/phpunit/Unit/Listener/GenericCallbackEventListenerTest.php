<?php

namespace Onoi\EventDispatcher\Tests\Listener;

use Onoi\EventDispatcher\Listener\GenericCallbackEventListener;

/**
 * @covers \Onoi\EventDispatcher\Listener\GenericCallbackEventListener
 *
 * @group onoi-event-dispatcher
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class GenericCallbackEventListenerTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\EventListener',
			new GenericCallbackEventListener()
		);

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\Listener\GenericCallbackEventListener',
			new GenericCallbackEventListener()
		);
	}

	public function testNonCallbackThrowsException() {

		$instance = new GenericCallbackEventListener();

		$this->setExpectedException( 'RuntimeException' );
		$instance->registerCallback( 'foo' );
	}

	public function testRegisterExecuteCallback() {

		$instance = new GenericCallbackEventListener();

		$testClass = $this->getMockBuilder( '\stdClass' )
			->disableOriginalConstructor()
			->setMethods( array( 'runTest' ) )
			->getMock();

		$testClass->expects( $this->once() )
			->method( 'runTest' );

		$instance->registerCallback( function() use( $testClass ) {
			$testClass->runTest();
		} );

		$instance->execute();
	}

	public function testPropagationState() {

		$instance = new GenericCallbackEventListener();

		$this->assertFalse(
			$instance->isPropagationStopped()
		);

		$instance->setPropagationStopState( true );

		$this->assertTrue(
			$instance->isPropagationStopped()
		);
	}

}
