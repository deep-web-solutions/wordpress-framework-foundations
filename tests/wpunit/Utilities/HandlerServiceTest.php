<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Utilities;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResetFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunFailureException;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingService;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\HandlerInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Services\ServiceInterface;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\DefaultHandlerServiceObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\EnhancedHandlerObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\EnhancedHandlerServiceObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\HandlerObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\HandlerServiceObject;
use Error;
use Mockery;
use WpunitTester;

/**
 * Tests for the HandlerService abstraction.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Utilities
 */
class HandlerServiceTest extends WPTestCase {
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
	 * Tests the AbstractHandlerService class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_handler_service_object() {
		$plugin_instance = dws_foundations_test_plugin_instance();
		$logging_service = new LoggingService( $plugin_instance );

		// Test setting the handler externally.
		$service = new HandlerServiceObject( $plugin_instance, $logging_service );
		$this->assertInstanceOf( ServiceInterface::class, $service );
		$this->assertEquals( $plugin_instance, $service->get_plugin() );
		$this->assertEquals( $logging_service, $service->get_logging_service() );
		$this->assertEquals( HandlerServiceObject::class, $service->get_id() );

		$handler      = new HandlerObject( 'handler-correct' );
		$mock_handler = Mockery::mock( HandlerInterface::class );

		$this->assertTrue( $service->set_handler( $handler ) );
		$this->assertEquals( $handler, $service->get_handler() );

		$this->assertFalse( $service->set_handler( $mock_handler ) );
		$this->assertEquals( $handler, $service->get_handler() );

		// Test setting the handler in the constructor.
		$service = new HandlerServiceObject( $plugin_instance, $logging_service, $handler );
		$this->assertEquals( $handler, $service->get_handler() );

		$service = new HandlerServiceObject( $plugin_instance, $logging_service, $mock_handler );
		try {
			$this->assertEquals( $mock_handler, $service->get_handler() );
			$this->fail( 'Handler of wrong type has been set successfully in the constructor' );
		} catch ( Error $e ) {
			$this->assertStringStartsWith( 'Typed property', $e->getMessage() );
		}
	}

	/**
	 * Test the AbstractHandlerService class with a default handler.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_default_handler_service_object() {
		$plugin_instance = dws_foundations_test_plugin_instance();
		$logging_service = new LoggingService( $plugin_instance );

		// Test that the default handler is being set when no other handler is passed.
		$service = new DefaultHandlerServiceObject( $plugin_instance, $logging_service );
		$this->assertEquals( 'default-handler-id', $service->get_handler()->get_id() );

		$handler      = new HandlerObject( 'handler-correct' );
		$mock_handler = Mockery::mock( HandlerInterface::class );

		// Test that the default handler can be successfully overwritten.
		$service = new DefaultHandlerServiceObject( $plugin_instance, $logging_service );
		$this->assertTrue( $service->set_handler( $handler ) );
		$this->assertEquals( 'handler-correct', $service->get_handler()->get_id() );

		// Test that the default handler can be successfully overwritten in the constructor.
		$service = new DefaultHandlerServiceObject( $plugin_instance, $logging_service, $handler );
		$this->assertEquals( 'handler-correct', $service->get_handler()->get_id() );

		// Test that the default handler is used when the handler passed on in the constructor is of the wrong type.
		$service = new DefaultHandlerServiceObject( $plugin_instance, $logging_service, $mock_handler );
		$this->assertEquals( 'default-handler-id', $service->get_handler()->get_id() );
	}

	/**
	 * Test the AbstractHandlerService class with outputtable, resettable, and runnable handlers.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $example    Example to run the test on.
	 *
	 * @dataProvider    _enhanced_handler_service_provider
	 */
	public function test_enhanced_handler_service_object( array $example ) {
		$plugin_instance = dws_foundations_test_plugin_instance();
		$logging_service = new LoggingService( $plugin_instance );

		$handler = new EnhancedHandlerObject( 'default', $example['output_result_local'], $example['reset_result_local'], $example['run_result_local'] );
		$service = new EnhancedHandlerServiceObject( $plugin_instance, $logging_service, $handler );

		$service->output();
		$this->assertEquals( $example['is_outputted'], $service->is_outputted() );
		$this->assertEquals( $example['output_result'], $service->get_output_result() );

		$service->run();
		$this->assertEquals( $example['is_run'], $service->is_run() );
		$this->assertEquals( $example['run_result'], $service->get_run_result() );

		$service->reset();
		$this->assertEquals( $example['is_reset'], $service->is_reset() );
		$this->assertEquals( $example['reset_result'], $service->get_reset_result() );
	}

	// endregion

	// region PROVIDERS

	/**
	 * Provides examples for the 'enhanced_handler_service' tester.
	 *
	 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _enhanced_handler_service_provider(): array {
		$default = array(
			'output_result_local' => null,
			'output_result'       => null,
			'is_outputted'        => true,

			'reset_result_local'  => null,
			'reset_result'        => null,
			'is_reset'            => true,

			'run_result_local'    => null,
			'run_result'          => null,
			'is_run'              => true,
		);

		return array(
			array( $default ),

			array(
				wp_parse_args(
					array(
						'output_result_local' => ( $local_result = new OutputFailureException( 'Local output failure' ) ), // phpcs:ignore
						'output_result'       => $local_result,
						'is_outputted'        => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'reset_result_local'  => ( $local_result = new ResetFailureException( 'Local reset failure' ) ), // phpcs:ignore
						'reset_result'       => $local_result,
						'is_reset'           => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'run_result_local'    => ( $local_result = new RunFailureException( 'Local run failure' ) ), // phpcs:ignore
						'run_result'       => $local_result,
						'is_run'           => false,
					),
					$default
				),
			),
		);
	}

	// endregion
}
