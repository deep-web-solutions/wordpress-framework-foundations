<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Utilities;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\StoreableObject;
use WpunitTester;

/**
 * Tests for the Stores abstractions and implementations.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Utilities
 */
class StoreableTest extends WPTestCase {
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
	 * Tests the AbstractStore class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_storeable_object() {
		$storeable = new StoreableObject( 'my-storing-id-1' );
		$this->assertEquals( 'my-storing-id-1', $storeable->get_id() );

		$storeable = new StoreableObject( 'my-storing-id-2' );
		$this->assertEquals( 'my-storing-id-2', $storeable->get_id() );
	}

	// endregion
}
