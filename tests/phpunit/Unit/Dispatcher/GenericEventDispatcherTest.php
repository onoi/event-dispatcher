<?php

namespace Onoi\EventDispatcher\Tests;

use Onoi\EventDispatcher\Dispatcher\GenericEventDispatcher;

/**
 * @covers \Onoi\EventDispatcher\Dispatcher\GenericEventDispatcher
 *
 * @group onoi-event-dispatcher
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class GenericEventDispatcherTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\EventDispatcher',
			new GenericEventDispatcher()
		);

		$this->assertInstanceOf(
			'\Onoi\EventDispatcher\Dispatcher\GenericEventDispatcher',
			new GenericEventDispatcher()
		);
	}

	public function testInvalidEventIdentifierThrowsException() {

		$instance = new GenericEventDispatcher();

		$eventListener = $this->getMockBuilder( '\Onoi\EventDispatcher\EventListener' )
			->disableOriginalConstructor()
			->getMock();

		$this->setExpectedException( 'RuntimeException' );
		$instance->addListener( new \stdClass, $eventListener );
	}

	public function testAddListener() {

		$instance = new GenericEventDispatcher();

		$eventListener = $this->getMockBuilder( '\Onoi\EventDispatcher\EventListener' )
			->disableOriginalConstructor()
			->getMock();

		$instance->addListener( 'foo', $eventListener );

		$this->assertTrue(
			$instance->hasEvent( 'FOO' )
		);
	}

	public function testRemoveListenerForSpecificListener() {

		$instance = new GenericEventDispatcher();

		$eventListener = $this->getMockBuilder( '\Onoi\EventDispatcher\EventListener' )
			->disableOriginalConstructor()
			->getMock();

		$genericCallbackEventListener = $this->getMockBuilder( '\Onoi\EventDispatcher\Listener\GenericCallbackEventListener' )
			->disableOriginalConstructor()
			->getMock();

		$instance->addListener( 'foo', $eventListener );
		$instance->addListener( 'foo', $genericCallbackEventListener );

		$this->assertTrue(
			$instance->hasEvent( 'FOO' )
		);

		$instance->removeListener( 'foo', $eventListener );

		$this->assertTrue(
			$instance->hasEvent( 'FOO' )
		);

		$instance->removeListener( 'foo', $genericCallbackEventListener );

		$this->assertFalse(
			$instance->hasEvent( 'FOO' )
		);
	}

	public function testRemoveAllListenerForSpecificEvent() {

		$instance = new GenericEventDispatcher();

		$eventListener = $this->getMockBuilder( '\Onoi\EventDispatcher\EventListener' )
			->disableOriginalConstructor()
			->getMock();

		$genericCallbackEventListener = $this->getMockBuilder( '\Onoi\EventDispatcher\Listener\GenericCallbackEventListener' )
			->disableOriginalConstructor()
			->getMock();

		$instance->addListener( 'foo', $eventListener );
		$instance->addListener( 'foo', $genericCallbackEventListener );

		$this->assertTrue(
			$instance->hasEvent( 'FOO' )
		);

		$instance->removeListener( 'foo' );

		$this->assertFalse(
			$instance->hasEvent( 'FOO' )
		);
	}
	public function testDispatchEvent() {

		$instance = new GenericEventDispatcher();

		$eventListener = $this->getMockBuilder( '\Onoi\EventDispatcher\EventListener' )
			->disableOriginalConstructor()
			->getMock();

		$eventListener->expects( $this->once() )
			->method( 'execute' );

		$eventListener->expects( $this->once() )
			->method( 'isPropagationStopped' );

		$instance->addListener( 'foo', $eventListener );

		$instance->dispatch( 'foo' );
	}

	public function testDispatchEventWithContext() {

		$instance = new GenericEventDispatcher();

		$eventContext = $this->getMockBuilder( '\Onoi\EventDispatcher\EventContext' )
			->disableOriginalConstructor()
			->getMock();

		$eventListener = $this->getMockBuilder( '\Onoi\EventDispatcher\EventListener' )
			->disableOriginalConstructor()
			->getMock();

		$eventListener->expects( $this->once() )
			->method( 'execute' )
			->with( $this->identicalTo( $eventContext ) );

		$eventListener->expects( $this->once() )
			->method( 'isPropagationStopped' );

		$instance->addListener( 'foo', $eventListener );

		$instance->dispatch( 'foo', $eventContext );
	}

	public function testDispatchForListenerCollection() {

		$instance = new GenericEventDispatcher();

		$eventContext = $this->getMockBuilder( '\Onoi\EventDispatcher\EventContext' )
			->disableOriginalConstructor()
			->getMock();

		$eventListener = $this->getMockBuilder( '\Onoi\EventDispatcher\EventListener' )
			->disableOriginalConstructor()
			->getMock();

		$eventListener->expects( $this->once() )
			->method( 'execute' )
			->with( $this->identicalTo( $eventContext ) );

		$eventListenerCollection = $this->getMockBuilder( '\Onoi\EventDispatcher\EventListenerCollection' )
			->disableOriginalConstructor()
			->getMock();

		$eventListenerCollection->expects( $this->once() )
			->method( 'getCollection' )
			->will( $this->returnValue(
				array(
					'foo' => array( $eventListener ),
					'bar' => array( $eventListener ) ) ) );

		$instance->addListenerCollection( $eventListenerCollection );

		$this->assertTrue(
			$instance->hasEvent( 'FOO' )
		);

		$this->assertTrue(
			$instance->hasEvent( 'bAr' )
		);

		$instance->dispatch( 'foo', $eventContext );
	}

}
