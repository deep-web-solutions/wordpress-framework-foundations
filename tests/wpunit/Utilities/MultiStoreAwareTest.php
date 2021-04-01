<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Utilities;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\MultiStoreAwareInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\Stores\MemoryStore;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\HandlerObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\MultiStoreAwareObject;
use WpunitTester;

/**
 * Tests for the MultiStoreAware abstractions.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Utilities
 */
class MultiStoreAwareTest extends WPTestCase {
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
	 * Tests the MultiStoreAware interface and trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_multi_store_aware_object() {
		$store1 = new MemoryStore( 'test-store-1' );
		$store2 = new MemoryStore( 'test-store-2' );

		$store_aware_object = new MultiStoreAwareObject();
		$this->assertInstanceOf( MultiStoreAwareInterface::class, $store_aware_object );

		$memory_store = new MemoryStore( MultiStoreAwareObject::class );
		$store_aware_object->set_stores_store( $memory_store );
		$this->assertEquals( $memory_store, $store_aware_object->get_stores_store() );

		$this->assertEmpty( $store_aware_object->get_stores() );
		$store_aware_object->register_store( $store1 );
		$this->assertNotEmpty( $store_aware_object->get_stores() );
		$this->assertEquals( $store1, $store_aware_object->get_store( 'test-store-1' ) );
		$this->assertNull( $store_aware_object->get_store( 'test-store-2' ) );

		$store_aware_object->set_stores( array( $store2, new \stdClass() ) );
		$this->assertNull( $store_aware_object->get_store( 'test-store-1' ) );
		$this->assertEquals( $store2, $store_aware_object->get_store( 'test-store-2' ) );
		$this->assertEquals( 1, count( $store_aware_object->get_stores() ) );

		$store_aware_object->set_stores( array( $store1, $store2, new \stdClass() ) );
		$this->assertEquals( $store1, $store_aware_object->get_store( 'test-store-1' ) );
		$this->assertEquals( $store2, $store_aware_object->get_store( 'test-store-2' ) );
		$this->assertEquals( 2, count( $store_aware_object->get_stores() ) );
	}

	// endregion
}
