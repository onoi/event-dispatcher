# Event dispatcher

[![Build Status](https://secure.travis-ci.org/onoi/event-dispatcher.svg?branch=master)](http://travis-ci.org/onoi/event-dispatcher)
[![Code Coverage](https://scrutinizer-ci.com/g/onoi/event-dispatcher/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/onoi/event-dispatcher/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/onoi/event-dispatcher/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/onoi/event-dispatcher/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/onoi/event-dispatcher/version.png)](https://packagist.org/packages/onoi/event-dispatcher)
[![Packagist download count](https://poser.pugx.org/onoi/event-dispatcher/d/total.png)](https://packagist.org/packages/onoi/event-dispatcher)
[![Dependency Status](https://www.versioneye.com/php/onoi:event-dispatcher/badge.png)](https://www.versioneye.com/php/onoi:event-dispatcher)

A minimalistic event dispatcher (observer) interface that was part of the [Semantic MediaWiki][smw] code base and
is now being deployed as independent library.

## Requirements

PHP 5.3/HHVM 3.3 or later

## Installation

The recommended installation method for this library is by either adding
the dependency to your [composer.json][composer] or to execute

 `composer require onoi/event-dispatcher:~0.1`

```json
{
	"require": {
		"onoi/event-dispatcher": "~0.1"
	}
}
```
## Usage

```php
class ListenerRegistery {

	private $eventListenerCollection;

	public function __construct( EventListenerCollection $eventListenerCollection ) {
		$this->eventListenerCollection = $eventListenerCollection;
	}

	public function getListenerCollection() {

		$this->eventListenerCollection->registerCallback( 'do.something', function() {
			// Do something
		} );

		$this->eventListenerCollection->registerCallback( 'do.something.else', function( EventContext $eventContext = null ) {

			// Do something else
			if ( $eventContext !== null ) {
				$eventContext->get( 'dosomethingelse' );
			}
		} );

		return $this->eventListenerCollection;
	}
}
```
```php
class BarListener implements EventListner {

	public function execute( EventContext $eventContext = null ) {
		// Do something
	}

	public function isPropagationStopped() {
		return false;
	}
}
```
```php
$eventDispatcherFactory = new EventDispatcherFactory();

$listenerRegistery = new ListenerRegistery(
	$eventDispatcherFactory->newGenericEventListenerCollection()
);

$eventDispatcher = $eventDispatcherFactory->newGenericEventDispatcher();
$eventDispatcher->addListenerCollection( $listenerRegistery->getListenerCollection() );

// Ad hoc listener
$eventDispatcher->addListener( 'notify.bar', new BarListener() );

class Foo {

	public function __construct( EventDispatcher $eventDispatcher ) {
		$this->eventDispatcher = $eventDispatcher;
	}

	public function doSomething() {
		$this->eventDispatcher->dispatch( 'do.something' );

		$eventContext = new EventContext();
		$eventContext->set( 'dosomethingelse', new \stdClass );

		$this->eventDispatcher->dispatch( 'do.something.else', $eventContext );
	}

	public function doNotifyBar() {
		$this->eventDispatcher->dispatch( 'notify.bar' );
	}
}

$foo = new Foo( $eventDispatcher );
$foo->doSomething();
$foo->doNotifyBar();
```

## Contribution and support

If you want to contribute work to the project please subscribe to the
developers mailing list and have a look at the [contribution guidelinee](/CONTRIBUTING.md). A list of people who have made contributions in the past can be found [here][contributors].

* [File an issue](https://github.com/onoi/event-dispatcher/issues)
* [Submit a pull request](https://github.com/onoi/event-dispatcher/pulls)

### Tests

The library provides unit tests that covers the core-functionality normally run by the [continues integration platform][travis]. Tests can also be executed manually using the PHPUnit configuration file found in the root directory.

### Release notes

* 0.1 initial release (2015-03-21)

## License

[GNU General Public License 2.0 or later][license].

[composer]: https://getcomposer.org/
[contributors]: https://github.com/onoi/event-dispatcher/graphs/contributors
[license]: https://www.gnu.org/copyleft/gpl.html
[travis]: https://travis-ci.org/onoi/event-dispatcher
[smw]: https://github.com/SemanticMediaWiki/SemanticMediaWiki/
