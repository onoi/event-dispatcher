<?php

namespace Onoi\EventDispatcher\Tests\Integration;

use Onoi\EventDispatcher\EventListenerFactory;
use Onoi\EventDispatcher\EventDispatcherFactory;
use Onoi\EventDispatcher\EventDispatcher;
use Onoi\EventDispatcher\EventContext;
use Onoi\EventDispatcher\EventListener;

/**
 * @group onoi-event-dispatcher
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class EventRegistryDispatchTest extends \PHPUnit_Framework_TestCase {

	private $mockTester;

	protected function setUp() {
		parent::setUp();

		$this->mockTester = $this->getMockBuilder( '\stdClass' )
			->disableOriginalConstructor()
			->setMethods( array( 'doSomething' ) )
			->getMock();

		$this->mockTester->expects( $this->once() )
			->method( 'doSomething' );
	}

	public function testDispatchSomeEventsToPreInvokedListeners() {

		$eventDispatcherFactory = new EventDispatcherFactory();
		$eventDispatcher = $eventDispatcherFactory->newGenericEventDispatcher();

		$fooRegistery = new FooRegistery( $eventDispatcher, new EventListenerFactory() );
		$fooRegistery->register();

		$eventContext = new EventContext();
		$eventContext->set( 'mock', $this->mockTester );

		$eventDispatcher->dispatch( 'do.something', $eventContext );
		$eventDispatcher->dispatch( 'do.nothing', $eventContext );
	}

	public function testDispatchSomeEventsToSelfSustainedListener() {

		$eventDispatcherFactory = new EventDispatcherFactory();
		$eventDispatcher = $eventDispatcherFactory->newGenericEventDispatcher();

		$eventDispatcher->addListener( 'do.something', new BarListener() );

		$eventContext = new EventContext();
		$eventContext->set( 'mock',  $this->mockTester );

		$eventDispatcher->dispatch( 'do.something', $eventContext );
		$eventDispatcher->dispatch( 'do.nothing', $eventContext );
	}

}

class FooRegistery {

	private $eventDispatcher;
	private $eventListenerFactory;

	public function __construct( EventDispatcher $eventDispatcher, EventListenerFactory $eventListenerFactory ) {
		$this->eventDispatcher = $eventDispatcher;
		$this->eventListenerFactory = $eventListenerFactory;
	}

	public function register() {

		$callbackEventListener = $this->eventListenerFactory->newGenericCallbackEventListener();

		$callbackEventListener->registerCallback( function( EventContext $eventContext ) {
			$eventContext->get( 'mock' )->doSomething();
		} );

		$callbackEventListener->setPropagationStopState( true );

		$this->eventDispatcher->addListener( 'do.something', $callbackEventListener );
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
