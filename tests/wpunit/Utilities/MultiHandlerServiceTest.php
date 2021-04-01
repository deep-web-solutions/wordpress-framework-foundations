<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Utilities;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingService;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\HandlerInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Services\ServiceInterface;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\DefaultHandlerServiceObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\DefaultMultiHandlerServiceObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\HandlerObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\HandlerServiceObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\MultiHandlerServiceObject;
use Error;
use LogicException;
use Mockery;
use WpunitTester;

/**
 * Tests for the MultiHandlerService abstraction.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Utilities
 */
class MultiHandlerServiceTest extends WPTestCase {
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
	 * Tests the AbstractMultiHandlerService class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_multi_handler_service_object() {
		$plugin_instance = dws_foundations_test_plugin_instance();
		$logging_service = new LoggingService( $plugin_instance );

		// Test registering a handler externally.
		$service = new MultiHandlerServiceObject( $plugin_instance, $logging_service );
		$this->assertInstanceOf( ServiceInterface::class, $service );
		$this->assertEquals( $plugin_instance, $service->get_plugin() );
		$this->assertEquals( $logging_service, $service->get_logging_service() );
		$this->assertEquals( MultiHandlerServiceObject::class, $service->get_id() );

		$handler      = new HandlerObject( 'handler-correct' );
		$mock_handler = Mockery::mock( HandlerInterface::class );

		$this->assertEmpty( $service->get_handlers() );
		$this->assertNull( $service->get_handler( 'handler-correct' ) );

		try {
			$service->register_handler( $mock_handler );
			$this->fail( 'Registered handler of wrong type with the service' );
		} catch ( LogicException $e ) {
			$this->assertStringStartsWith( 'The handler registered must be of class', $e->getMessage() );
		}

		$this->assertEmpty( $service->get_handlers() );
		$service->register_handler( $handler );
		$this->assertEquals( 1, count( $service->get_handlers() ) );
		$this->assertEquals( $handler, $service->get_handler( 'handler-correct' ) );

		// Test setting the handler externally.
		$service = new MultiHandlerServiceObject( $plugin_instance, $logging_service );

		try {
			$service->set_handlers( array( $mock_handler, $handler ) );
			$this->fail( 'Set handler of wrong type on the service' );
		} catch ( LogicException $e ) {
			$this->assertStringStartsWith( 'The handler registered must be of class', $e->getMessage() );
		}

		$this->assertEmpty( $service->get_handlers() );
		$this->assertNull( $service->get_handler( 'handler-correct' ) );

		try {
			$service->set_handlers( array( $handler, $mock_handler ) );
			$this->fail( 'Set handler of wrong type on the service' );
		} catch ( LogicException $e ) {
			$this->assertStringStartsWith( 'The handler registered must be of class', $e->getMessage() );
		}

		$this->assertEquals( 1, count( $service->get_handlers() ) );
		$this->assertEquals( $handler, $service->get_handler( 'handler-correct' ) );

		// Test setting the handler in the constructor.
		$service = new MultiHandlerServiceObject( $plugin_instance, $logging_service, array( $handler ) );
		$this->assertEquals( 1, count( $service->get_handlers() ) );
		$this->assertEquals( $handler, $service->get_handler( 'handler-correct' ) );

		try {
			$service = new MultiHandlerServiceObject( $plugin_instance, $logging_service, array( $mock_handler ) );
			$this->fail( 'Handler of wrong type has been set successfully in the constructor' );
		} catch ( LogicException $e ) {
			$this->assertStringStartsWith( 'The handler registered must be of class', $e->getMessage() );
		}

		try {
			$service = new MultiHandlerServiceObject( $plugin_instance, $logging_service, array( $handler, $mock_handler ) );
			$this->fail( 'Handler of wrong type has been set successfully in the constructor' );
		} catch ( LogicException $e ) {
			$this->assertStringStartsWith( 'The handler registered must be of class', $e->getMessage() );
		}
	}

	/**
	 * Test the AbstractMultiHandlerService class with a default handler.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_default_multi_handler_service_object() {
		$plugin_instance = dws_foundations_test_plugin_instance();
		$logging_service = new LoggingService( $plugin_instance );

		$handler      = new HandlerObject( 'default-handler-id' );
		$mock_handler = Mockery::mock( HandlerInterface::class );

		// Test that the default handler is being set when no other handler is passed.
		$service = new DefaultMultiHandlerServiceObject( $plugin_instance, $logging_service );

		$this->assertEquals( 1, count( $service->get_handlers() ) );
		$this->assertTrue( isset( $service->get_handlers()['default-handler-id'] ) );
		$this->assertNotEquals( $handler, $service->get_handler( 'default-handler-id' ) );

		// Test that the default handler can be successfully overwritten.
		$service = new DefaultMultiHandlerServiceObject( $plugin_instance, $logging_service );
		$service->register_handler( $handler );
		$this->assertEquals( 1, count( $service->get_handlers() ) );
		$this->assertEquals( $handler, $service->get_handler( 'default-handler-id' ) );

		// Test that the default handler can be successfully overwritten in the constructor.
		$service = new DefaultMultiHandlerServiceObject( $plugin_instance, $logging_service, array( $handler ) );
		$this->assertEquals( 1, count( $service->get_handlers() ) );
		$this->assertEquals( $handler, $service->get_handler( 'default-handler-id' ) );

		// Test that a handler of the wrong type cannot be passed on through the constructor.
		try {
			$service = new DefaultMultiHandlerServiceObject( $plugin_instance, $logging_service, array( $mock_handler ) );
			$this->fail( 'Handler of wrong type set through the constructor' );
		} catch ( \LogicException $e ) {
			$this->assertStringStartsWith( 'The handler registered must be of class', $e->getMessage() );
		}
	}

	// endregion
}
