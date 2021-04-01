<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Functional;

use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StoreException;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StoreInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\Stores\MemoryStore;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\Stores\OptionsStore;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\Stores\UserMetaStore;
use DeepWebSolutions\Framework\Tests\Foundations\Utilities\StoreableObject;
use FunctionalTester;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Tests for the WP Database Stores.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Functional
 */
class StoresCest {
	// region TESTS

	/**
	 * Tests the MemoryStore.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   FunctionalTester    $I      Codeception actor instance.
	 */
	public function test_memory_store( FunctionalTester $I ) {
		$memory_store = new MemoryStore( 'dummy-memory-store' );

		$I->assertEquals( 'dummy-memory-store', $memory_store->get_id() );
		$I->assertEquals( 'memory', $memory_store->get_storage_type() );

		$this->test_default_store_functionality( $I, $memory_store );
	}

	/**
	 * Test that the options store really pushes stuff to the database.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   FunctionalTester    $I  Codeception actor instance.
	 *
	 * @throws  StoreException  Thrown when adding an object to the database fails.
	 */
	public function test_options_store( FunctionalTester $I ) {
		$options_store = new OptionsStore( 'dummy-options-store', 'dummy-options-store-key' );

		$I->assertEquals( 'dummy-options-store', $options_store->get_id() );
		$I->assertEquals( 'options-table', $options_store->get_storage_type() );

		$I->cantSeeOptionInDatabase( 'dummy-options-store-key' );
		$this->test_default_store_functionality( $I, $options_store );
		$I->cantSeeOptionInDatabase( 'dummy-options-store-key' );

		$storeable = new StoreableObject( 'dummy-entry' );
		$options_store->add( $storeable );
		$I->canSeeOptionInDatabase( 'dummy-options-store-key' );

		$storeable->dummy_property = 'dafuq';
		$options_store->update( $storeable );

		unset( $storeable );
		$I->assertFalse( isset( $storeable ) );

		$database_object = $options_store->get( 'dummy-entry' );
		$I->assertEquals( 'dummy-entry', $database_object->get_id() );
		$I->assertEquals( 'dafuq', $database_object->dummy_property );
	}

	/**
	 * Test that the user-meta store really pushes stuff to the database.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   FunctionalTester    $I  Codeception actor instance.
	 *
	 * @throws  StoreException  Thrown when adding an object to the database fails.
	 */
	public function test_usermeta_store( FunctionalTester $I ) {
		$user_id        = 1;
		$usermeta_store = new UserMetaStore( 'dummy-usermeta-store', 'dummy-usermeta-store-key' );

		$I->assertEquals( 'dummy-usermeta-store', $usermeta_store->get_id() );
		$I->assertEquals( 'user-meta', $usermeta_store->get_storage_type() );

		$GLOBALS['current_user'] = new \WP_User( $user_id ); // phpcs:ignore

		$I->cantSeeUserMetaInDatabase(
			array(
				'user_id'  => $user_id,
				'meta_key' => 'dummy-usermeta-store-key', // phpcs:ignore
			)
		);
		$this->test_default_store_functionality( $I, $usermeta_store );
		$I->cantSeeUserMetaInDatabase(
			array(
				'user_id'  => $user_id,
				'meta_key' => 'dummy-usermeta-store-key', // phpcs:ignore
			)
		);

		$storeable = new StoreableObject( 'dummy-entry' );
		$usermeta_store->add( $storeable );
		$I->canSeeUserMetaInDatabase(
			array(
				'user_id'  => $user_id,
				'meta_key' => 'dummy-usermeta-store-key', // phpcs:ignore
			)
		);

		$storeable->dummy_property = 'dafuq';
		$usermeta_store->update( $storeable );

		unset( $storeable );
		$I->assertFalse( isset( $storeable ) );

		$database_object = $usermeta_store->get( 'dummy-entry' );
		$I->assertEquals( 'dummy-entry', $database_object->get_id() );
		$I->assertEquals( 'dafuq', $database_object->dummy_property );

		$user_id = 1000;
		$I->cantSeeUserMetaInDatabase(
			array(
				'user_id'  => $user_id,
				'meta_key' => 'dummy-usermeta-store-key', // phpcs:ignore
			)
		);
		$usermeta_store->add( $database_object, $user_id );
		$I->canSeeUserMetaInDatabase(
			array(
				'user_id'  => $user_id,
				'meta_key' => 'dummy-usermeta-store-key', // phpcs:ignore
			)
		);

		$database_object = $usermeta_store->get( 'dummy-entry', $user_id );
		$I->assertEquals( 'dummy-entry', $database_object->get_id() );
		$I->assertEquals( 'dafuq', $database_object->dummy_property );
	}

	// endregion

	// region HELPERS

	/**
	 * A collection of sensible store tests.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   FunctionalTester    $I      Codeception actor instance.
	 * @param   StoreInterface      $store  Store to run the tests against.
	 */
	protected function test_default_store_functionality( FunctionalTester $I, StoreInterface $store ) {
		$I->assertEquals( 0, $store->count() );
		$I->assertEmpty( $store->get_all() );
		$I->assertFalse( $store->has( 'dummy-entry' ) );

		try {
			$store->get( 'dummy-entry' );
			$I->fail( 'Retrieved non-existent entry from store' );
		} catch ( NotFoundExceptionInterface $exception ) {
			$I->assertStringStartsWith( 'Could not retrieve entry dummy-entry', $exception->getMessage() );
		}
		try {
			$store->remove( 'dummy-entry' );
			$I->fail( 'Removed non-existent entry from store' );
		} catch ( NotFoundExceptionInterface $exception ) {
			$I->assertStringStartsWith( 'Could not delete entry dummy-entry', $exception->getMessage() );
		}

		$storeable = new StoreableObject( 'dummy-entry' );
		$store->add( $storeable );
		$I->assertTrue( $store->has( 'dummy-entry' ) );
		$I->assertEquals( $storeable, $store->get( 'dummy-entry' ) );
		$I->assertEquals( 1, $store->count() );

		try {
			$store->add( $storeable );
			$I->fail( 'Used add to overwrite an entry' );
		} catch ( StoreException $exception ) {
			$I->assertStringStartsWith( 'Entry dummy-entry already exists', $exception->getMessage() );
		}

		$I->assertEquals( 1, $store->count() );
		$store->remove( $storeable->get_id() );
		$I->assertEquals( 0, $store->count() );
		$I->assertFalse( $store->has( 'dummy-entry' ) );

		$store->add( $storeable );
		$I->assertTrue( $store->has( 'dummy-entry' ) );
		$I->assertEquals( $storeable, $store->get( 'dummy-entry' ) );

		$storeable2                 = new StoreableObject( 'dummy-entry' );
		$storeable2->dummy_property = 'test';

		$store->update( $storeable2 );
		$I->assertTrue( $store->has( 'dummy-entry' ) );

		$I->assertEquals( $storeable2, $store->get( 'dummy-entry' ) );
		$I->assertNotEquals( $storeable, $store->get( 'dummy-entry' ) );

		$store->remove( $storeable->get_id() );
		$I->assertFalse( $store->has( 'dummy-entry' ) );

		$I->assertEquals( 0, $store->count() );
		$store->add( new StoreableObject( 'dummy-empty-1' ) );
		$store->add( new StoreableObject( 'dummy-empty-2' ) );
		$I->assertEquals( 2, $store->count() );

		$store->empty();
		$I->assertEquals( 0, $store->count() );
	}

	// endregion
}
