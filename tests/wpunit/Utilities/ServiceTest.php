<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Utilities;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingService;
use DeepWebSolutions\Framework\Foundations\Services\ServiceInterface;
use DeepWebSolutions\Framework\Tests\FoundationsServiceObject;
use WpunitTester;

/**
 * Tests for the Service abstraction.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Utilities
 */
class ServiceTest extends WPTestCase {
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
	 * Tests the AbstractService class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_service_object() {
		$plugin_instance = dws_foundations_test_plugin_instance();
		$logging_service = new LoggingService( $plugin_instance );
		$service         = new ServiceObject( $plugin_instance, $logging_service );

		$this->assertInstanceOf( ServiceInterface::class, $service );
		$this->assertEquals( $plugin_instance, $service->get_plugin() );
		$this->assertEquals( $logging_service, $service->get_logging_service() );
		$this->assertEquals( ServiceObject::class, $service->get_id() );
	}

	// endregion
}
