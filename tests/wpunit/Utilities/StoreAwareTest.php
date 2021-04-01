<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Utilities;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Exceptions\NotFoundException;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StoreException;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StoreInterface;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\StoreableObject;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\StoreAwareObject;
use Mockery;
use WpunitTester;

/**
 * Tests for the StoreAware abstractions.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Utilities
 */
class StoreAwareTest extends WPTestCase {
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
	 * Tests the StoreAware interface and trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_store_aware_object() {
		$store_double         = Mockery::mock( StoreInterface::class . '[get,update,remove]' )->makePartial();
		$existing_storeable   = new StoreableObject( 'existing_entry' );
		$inexisting_storeable = new StoreableObject( 'inexisting_entry' );

		$store_aware_object = new StoreAwareObject();
		$store_aware_object->set_store( $store_double );
		$this->assertEquals( $store_double, $store_aware_object->get_store() );

		$store_double->allows()->get( 'existing_entry' )->andReturns( $existing_storeable );
		$store_double->allows()->get( 'inexisting_entry' )->once()->andThrows( new NotFoundException( 'not found inexisting_entry' ) );
		$this->assertEquals( $existing_storeable, $store_aware_object->get_store_entry( 'existing_entry' ) );
		$this->assertNull( $store_aware_object->get_store_entry( 'inexisting_entry' ) );

		$store_double->allows()->add( $inexisting_storeable )->andReturns( 'whatever' );
		$store_double->allows()->add( $existing_storeable )->andThrows( new StoreException( 'Entry exists already' ) );
		$this->assertTrue( $store_aware_object->add_store_entry( $inexisting_storeable ) );
		$this->assertFalse( $store_aware_object->add_store_entry( $existing_storeable ) );

		$store_double->allows()->get( 'inexisting_entry' )->andReturns( $inexisting_storeable );
		$this->assertEquals( $inexisting_storeable, $store_aware_object->get_store_entry( 'inexisting_entry' ) );

		$store_double->allows()->update( $existing_storeable )->andReturns( $existing_storeable );
		$store_double->allows()->update( $inexisting_storeable )->andThrows( new StoreException( 'Something went wrong, idk' ) );
		$this->assertTrue( $store_aware_object->update_store_entry( $existing_storeable ) );
		$this->assertFalse( $store_aware_object->update_store_entry( $inexisting_storeable ) );

		$store_double->allows()->remove( $existing_storeable->get_id() )->andReturns( 'whatever' );
		$store_double->allows()->remove( $inexisting_storeable->get_id() )->andThrows( new StoreException( 'Error, error, error' ) );
		$this->assertTrue( $store_aware_object->remove_store_entry( $existing_storeable->get_id() ) );
		$this->assertFalse( $store_aware_object->remove_store_entry( $inexisting_storeable->get_id() ) );
	}

	// endregion
}
