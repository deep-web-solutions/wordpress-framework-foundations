<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Utilities;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\HandlerInterface;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\HandlerAwareObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\HandlerObject;
use Mockery;
use WpunitTester;

/**
 * Tests for the HandlerAware abstractions.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Utilities
 */
class HandlerAwareTest extends WPTestCase {
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
	 * Tests the HandlerAware interface and trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_handler_aware_object() {
		$handler = new HandlerObject( 'test-handler-1' );

		$handler_aware_object = new HandlerAwareObject();
		$handler_aware_object->set_handler( $handler );
		$this->assertEquals( $handler, $handler_aware_object->get_handler() );
	}

	// endregion
}
