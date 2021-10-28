<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Utilities;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Storage\StorableInterface;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\StoreableObject;
use WpunitTester;

/**
 * Tests for the Storable abstraction.
 *
 * @since   1.0.0
 * @version 1.3.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Utilities
 */
class StorableTest extends WPTestCase {
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
	 * @version 1.3.0
	 */
	public function test_storable_object() {
		$storeable = new StoreableObject( 'my-storing-id-1' );
		$this->assertInstanceOf( StorableInterface::class, $storeable );
		$this->assertEquals( 'my-storing-id-1', $storeable->get_id() );

		$storeable = new StoreableObject( 'my-storing-id-2' );
		$this->assertInstanceOf( StorableInterface::class, $storeable );
		$this->assertEquals( 'my-storing-id-2', $storeable->get_id() );
	}

	// endregion
}
