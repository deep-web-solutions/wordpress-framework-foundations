<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Utilities;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Services\MultiHandlerAwareInterface;
use DeepWebSolutions\Framework\Foundations\Storage\Stores\MemoryStore;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\HandlerObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\MultiHandlerAwareObject;
use WpunitTester;

/**
 * Tests for the MultiHandlerAware abstractions.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Utilities
 */
class MultiHandlerAwareTest extends WPTestCase {
	// region FIELDS AND CONSTANTS

	/**
	 * Instance of the WP actor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     WpunitTester
	 */
	protected WpunitTester $tester;

	// endregion

	// region TESTS

	/**
	 * Tests the MultiHandlerAware interface and trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_multi_handler_aware_object() {
		$handler1 = new HandlerObject( 'test-handler-1' );
		$handler2 = new HandlerObject( 'test-handler-2' );

		$handler_aware_object = new MultiHandlerAwareObject();
		$this->assertInstanceOf( MultiHandlerAwareInterface::class, $handler_aware_object );

		$memory_store = new MemoryStore( MultiHandlerAwareObject::class );
		$handler_aware_object->set_stores_store( $memory_store );
		$this->assertEquals( $memory_store, $handler_aware_object->get_stores_store() );

		$this->assertNull( $handler_aware_object->get_handlers_store() );
		$handlers_store = new MemoryStore( 'handlers' );
		$handler_aware_object->set_handlers_store( $handlers_store );
		$this->assertEquals( $handlers_store, $handler_aware_object->get_handlers_store() );

		$this->assertEmpty( $handler_aware_object->get_handlers() );
		$handler_aware_object->register_handler( $handler1 );
		$this->assertNotEmpty( $handler_aware_object->get_handlers() );
		$this->assertEquals( $handler1, $handler_aware_object->get_handler( 'test-handler-1' ) );
		$this->assertNull( $handler_aware_object->get_handler( 'test-handler-2' ) );

		$handler_aware_object->set_handlers( array( $handler2, new \stdClass() ) );
		$this->assertNull( $handler_aware_object->get_handler( 'test-handler-1' ) );
		$this->assertEquals( $handler2, $handler_aware_object->get_handler( 'test-handler-2' ) );
		$this->assertEquals( 1, count( $handler_aware_object->get_handlers() ) );

		$handler_aware_object->set_handlers( array( $handler1, $handler2, new \stdClass() ) );
		$this->assertEquals( $handler1, $handler_aware_object->get_handler( 'test-handler-1' ) );
		$this->assertEquals( $handler2, $handler_aware_object->get_handler( 'test-handler-2' ) );
		$this->assertEquals( 2, count( $handler_aware_object->get_handlers() ) );
	}

	// endregion
}
