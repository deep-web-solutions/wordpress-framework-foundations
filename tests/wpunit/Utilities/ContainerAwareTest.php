<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Utilities;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Exceptions\NotFoundException;
use DeepWebSolutions\Framework\Tests\FoundationsContainerAwareObject;
use Mockery;
use Psr\Container\ContainerInterface;
use WpunitTester;

/**
 * Tests for the ContainerAware abstractions.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Utilities
 */
class ContainerAwareTest extends WPTestCase {
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
	 * Tests the ContainerAware interface and trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_container_aware_object() {
		$double = Mockery::mock( ContainerInterface::class );
		$double->allows()->get( 'existing_entry' )->andReturns( 'existing_value' );
		$double->allows()->get( 'inexisting_entry' )->andThrows( new NotFoundException( 'not found inexisting_entry' ) );

		$container_aware_object = new ContainerAwareObject();
		$container_aware_object->set_container( $double );

		$this->assertEquals( $double, $container_aware_object->get_container() );
		$this->assertEquals( 'existing_value', $container_aware_object->get_container_entry( 'existing_entry' ) );
		$this->assertNull( $container_aware_object->get_container_entry( 'inexisting_entry' ) );
	}

	// endregion
}
