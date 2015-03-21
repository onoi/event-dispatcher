<?php

namespace Onoi\EventDispatcher\Tests\Integration;

use Onoi\EventDispatcher\EventDispatcherFactory;
use Onoi\EventDispatcher\EventDispatcher;
use Onoi\EventDispatcher\EventContext;
use Onoi\EventDispatcher\EventListener;
use Onoi\EventDispatcher\EventListenerCollection;

/**
 * @group onoi-event-dispatcher
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class EventRegistryDispatchTest extends \PHPUnit_Framework_TestCase {

	public function testDispatchSomeEventsToCollectionOfListenersWithoutPropagationStop() {

		$mockTester = $this->getMockBuilder( '\stdClass' )
			->setMethods( array( 'doSomething', 'doSomethingElse' ) )
			->getMock();

		$mockTester->expects( $this->once() )
			->method( 'doSomething' );

		$mockTester->expects( $this->once() )
			->method( 'doSomethingElse' );

		$eventDispatcherFactory = new EventDispatcherFactory();

		$listenerRegistery = new ListenerRegistery(
			$eventDispatcherFactory->newGenericEventListenerCollection()
		);

		$eventDispatcher = $eventDispatcherFactory->newGenericEventDispatcher();
		$eventDispatcher->addListenerCollection( $listenerRegistery->getListenerCollection() );

		$eventContext = new EventContext();
		$eventContext->set( 'mock', $mockTester );

		$eventDispatcher->dispatch( 'do.something', $eventContext );
	}

	public function testDispatchSomeEventsToCollectionOfListenersWithPropagationStop() {

		$mockTester = $this->getMockBuilder( '\stdClass' )
			->setMethods( array( 'doSomething', 'doSomethingElse' ) )
			->getMock();

		$mockTester->expects( $this->once() )
			->method( 'doSomething' );

		$mockTester->expects( $this->never() )
			->method( 'doSomethingElse' );

		$eventDispatcherFactory = new EventDispatcherFactory();

		$listenerRegistery = new ListenerRegistery(
			$eventDispatcherFactory->newGenericEventListenerCollection()
		);

		$eventDispatcher = $eventDispatcherFactory->newGenericEventDispatcher();
		$eventDispatcher->addListenerCollection( $listenerRegistery->getListenerCollection() );

		$eventContext = new EventContext();
		$eventContext->set( 'mock', $mockTester );
		$eventContext->set( 'propagationstop', true );

		$eventDispatcher->dispatch( 'do.something', $eventContext );
	}

	public function testDispatchSomeEventsToAdHocListener() {

		$mockTester = $this->getMockBuilder( '\stdClass' )
			->setMethods( array( 'doSomething' ) )
			->getMock();

		$mockTester->expects( $this->once() )
			->method( 'doSomething' );

		$eventDispatcherFactory = new EventDispatcherFactory();
		$eventDispatcher = $eventDispatcherFactory->newGenericEventDispatcher();

		$eventDispatcher->addListener( 'do.something', new BarListener() );

		$eventContext = new EventContext();
		$eventContext->set( 'mock', $mockTester );

		$eventDispatcher->dispatch( 'do.something', $eventContext );
		$eventDispatcher->dispatch( 'do.nothing' );
	}

}

class ListenerRegistery {

	private $eventListenerCollection;

	public function __construct( EventListenerCollection $eventListenerCollection ) {
		$this->eventListenerCollection = $eventListenerCollection;
	}

	public function getListenerCollection() {

		$this->eventListenerCollection->registerCallback( 'do.something', function( EventContext $eventContext ) {
			$eventContext->get( 'mock' )->doSomething();
		} );

		$this->eventListenerCollection->registerCallback( 'do.something', function( EventContext $eventContext ) {
			$eventContext->get( 'mock' )->doSomethingElse();
		} );

		return $this->eventListenerCollection;
	}

}

class BarListener implements EventListener {

	public function execute( EventContext $eventContext = null ) {
		$eventContext->get( 'mock' )->doSomething();
	}

	public function isPropagationStopped() {
		return false;
	}
}
