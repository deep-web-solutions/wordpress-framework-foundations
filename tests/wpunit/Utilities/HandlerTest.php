<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Utilities;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Services\HandlerInterface;
use DeepWebSolutions\Framework\Foundations\Storage\StorableInterface;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\HandlerObject;
use WpunitTester;

/**
 * Tests for the Handler abstraction.
 *
 * @since   1.0.0
 * @version 1.3.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Utilities
 */
class HandlerTest extends WPTestCase {
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
	 * Tests the AbstractHandler class.
	 *
	 * @since   1.0.0
	 * @version 1.3.0
	 */
	public function test_handler_object() {
		$handler = new HandlerObject( 'my-handler-id-1' );
		$this->assertInstanceOf( HandlerInterface::class, $handler );
		$this->assertInstanceOf( StorableInterface::class, $handler );
		$this->assertEquals( 'my-handler-id-1', $handler->get_id() );
		$this->assertEquals( 'test-handler', $handler->get_type() );

		$handler = new HandlerObject( 'my-handler-id-2' );
		$this->assertInstanceOf( HandlerInterface::class, $handler );
		$this->assertInstanceOf( StorableInterface::class, $handler );
		$this->assertEquals( 'my-handler-id-2', $handler->get_id() );
		$this->assertEquals( 'test-handler', $handler->get_type() );
	}

	// endregion
}
