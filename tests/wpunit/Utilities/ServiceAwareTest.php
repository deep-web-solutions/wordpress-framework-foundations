<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Utilities;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Exceptions\NotFoundException;
use DeepWebSolutions\Framework\Foundations\Utilities\Services\ServiceAwareInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Services\ServiceInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StoreException;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StoreInterface;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\ServiceAwareObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\StoreableObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\StoreAwareObject;
use Mockery;
use WpunitTester;

/**
 * Tests for the ServiceAware abstractions.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Utilities
 */
class ServiceAwareTest extends WPTestCase {
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
	 * Tests the ServiceAware interface and trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_store_aware_object() {
		$service_double = Mockery::mock( ServiceInterface::class );

		$service_aware_object = new ServiceAwareObject();
		$this->assertInstanceOf( ServiceAwareInterface::class, $service_aware_object );
		$service_aware_object->set_service( $service_double );
		$this->assertEquals( $service_double, $service_aware_object->get_service() );
	}

	// endregion
}
