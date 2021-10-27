<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingHandler;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingService;
use DeepWebSolutions\Framework\Foundations\Logging\LogMessageBuilder;
use LogicException;
use Mockery;
use Psr\Log\LoggerInterface;
use WpunitTester;

/**
 * Tests for the LoggingService.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration
 */
class LoggingServiceTest extends WPTestCase {
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
	 * Tests the LogMessageBuilder class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_log_message_builder() {
		$null_handler = new LoggingHandler();

		// Test null return by default.
		$builder = new LogMessageBuilder( $null_handler, false, 'My test message' );
		$this->assertNull( $builder->finalize() );

		// Test return a given object.
		$to_return = new \RuntimeException( 'my test exception' );
		$builder   = new LogMessageBuilder( $null_handler, false, 'My test message 2' );

		$this->assertEquals( $to_return, $builder->return_throwable( $to_return )->finalize() );

		// Test returning an exception works fine.
		$builder = new LogMessageBuilder( $null_handler, false, 'My test message 2' );
		$result  = $builder->return_exception( LogicException::class )->finalize();

		$this->assertInstanceOf( LogicException::class, $result );
		$this->assertEquals( 'My test message 2', $result->getMessage() );
		$this->assertNull( $result->getPrevious() );

		$builder = new LogMessageBuilder( $null_handler, false, 'My test message 2' );
		$result  = $builder->return_exception( LogicException::class, $to_return )->finalize();

		$this->assertInstanceOf( LogicException::class, $result );
		$this->assertEquals( $to_return, $result->getPrevious() );

		// Test sensitive content filter.
		$builder = new LogMessageBuilder( $null_handler, false, 'My <sensitive>test message</sensitive> 3' );
		$result  = $builder->return_exception( LogicException::class )->finalize();
		$this->assertEquals( 'My <sensitive>REDACTED FOR PRIVACY</sensitive> 3', $result->getMessage() );

		$builder = new LogMessageBuilder( $null_handler, true, 'My <sensitive>test message</sensitive> 3' );
		$result  = $builder->return_exception( LogicException::class )->finalize();
		$this->assertEquals( 'My test message 3', $result->getMessage() );
	}

	/**
	 * Tests the LoggingHandler class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_logging_handler() {
		$logging_handler = new LoggingHandler();
		$this->assertInstanceOf( LoggerInterface::class, $logging_handler );
		$this->assertEquals( 'null', $logging_handler->get_id() );

		$logging_handler = new LoggingHandler( 'non-default value' );
		$this->assertEquals( 'non-default value', $logging_handler->get_id() );
	}

	/**
	 * Tests the LoggingService class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_logging_service() {
		$plugin_instance = dws_foundations_test_plugin_instance();

		$logging_service = new LoggingService( $plugin_instance );
		$this->assertFalse( $logging_service->log_sensitive_messages() );

		$logging_service = new LoggingService( $plugin_instance, array(), true );
		$this->assertTrue( $logging_service->log_sensitive_messages() );

		$logging_service = new LoggingService( $plugin_instance );
		$this->assertEquals( 'null', $logging_service->get_handler( 'random-name' )->get_id() );

		$logging_handler = new LoggingHandler( 'specific-name', Mockery::mock( LoggerInterface::class ) );
		$logging_service = new LoggingService( $plugin_instance, array( $logging_handler ) );
		$this->assertEquals( 'null', $logging_service->get_handler( 'random-name' )->get_id() );
		$this->assertEquals( $logging_handler, $logging_service->get_handler( 'specific-name' ) );
	}

	// endregion
}
