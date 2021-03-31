<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Actions;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResetFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\ResettableInterface;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\RunnableInterface;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable\ResettableLocalObject;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable\ResettableObject;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable\RunnableLocalObject;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable\RunnableObject;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable\RunnableResettableLocalObject;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable\RunnableResettableObject;
use WpunitTester;

/**
 * Tests for the Runnable and Resettable objects and traits.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Actions
 */
class RunnableResettableTest extends WPTestCase {
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
	 * Tests the default runnable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   RunnableInterface|null      $runnable_object    Object to run tests against.
	 */
	public function test_runnable_trait( ?RunnableInterface $runnable_object = null ) {
		$runnable_object = is_null( $runnable_object ) ? new RunnableObject() : $runnable_object;

		$this->assertEquals( null, $runnable_object->is_run() );
		try {
			/* @noinspection PhpExpressionResultUnusedInspection */
			$runnable_object->get_run_result();
			$this->fail( 'Accessed run result before running the object' );
		} catch ( \Error $e ) {
			$this->assertStringStartsWith( 'Typed property', $e->getMessage() );
		}

		$runnable_object->run();
		$this->assertEquals( true, $runnable_object->is_run() );
		$this->assertEquals( null, $runnable_object->get_run_result() );

		$run_result = $runnable_object->run();
		$this->assertInstanceOf( RunFailureException::class, $run_result );
		$this->assertStringEndsWith( 'has been run already', $run_result->getMessage() );
	}

	/**
	 * Test for the local runnable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array                       $example            Example to run the test on.
	 * @param   RunnableInterface|null      $runnable_object    Object to run tests against.
	 *
	 * @dataProvider    _runnable_local_trait_provider
	 */
	public function test_runnable_local_trait( array $example, ?RunnableInterface $runnable_object = null ) {
		$runnable_object = is_null( $runnable_object ) ? new RunnableLocalObject( $example['run_result_local'] ) : $runnable_object;

		$this->assertEquals( null, $runnable_object->is_run() );
		try {
			/* @noinspection PhpExpressionResultUnusedInspection */
			$runnable_object->get_run_result();
			$this->fail( 'Accessed run result before running the object' );
		} catch ( \Error $e ) {
			$this->assertStringStartsWith( 'Typed property', $e->getMessage() );
		}

		$runnable_object->run();
		$this->assertEquals( $example['is_run'], $runnable_object->is_run() );
		$this->assertEquals( $example['run_result'], $runnable_object->get_run_result() );
	}

	/**
	 * Tests the default resettable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   ResettableInterface|null    $resettable_object      Object to run tests against.
	 */
	public function test_resettable_trait( ?ResettableInterface $resettable_object = null ) {
		$resettable_object = is_null( $resettable_object ) ? new ResettableObject() : $resettable_object;

		$this->assertEquals( null, $resettable_object->is_reset() );
		try {
			/* @noinspection PhpExpressionResultUnusedInspection */
			$resettable_object->get_reset_result();
			$this->fail( 'Accessed reset result before resetting the object' );
		} catch ( \Error $e ) {
			$this->assertStringStartsWith( 'Typed property', $e->getMessage() );
		}

		$resettable_object->reset();
		$this->assertEquals( true, $resettable_object->is_reset() );
		$this->assertEquals( null, $resettable_object->get_reset_result() );

		$reset_result = $resettable_object->reset();
		$this->assertInstanceOf( ResetFailureException::class, $reset_result );
		$this->assertStringEndsWith( 'has been reset already', $reset_result->getMessage() );
	}

	/**
	 * Test for the local resettable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array                       $example                Example to run the test on.
	 * @param   ResettableInterface|null    $resettable_object      Object to run tests against.
	 *
	 * @dataProvider    _resettable_local_trait_provider
	 */
	public function test_resettable_local_trait( array $example, ?ResettableInterface $resettable_object = null ) {
		$resettable_object = is_null( $resettable_object ) ? new ResettableLocalObject( $example['reset_result_local'] ) : $resettable_object;

		$this->assertEquals( null, $resettable_object->is_reset() );
		try {
			/* @noinspection PhpExpressionResultUnusedInspection */
			$resettable_object->get_reset_result();
			$this->fail( 'Accessed reset result before resetting the object' );
		} catch ( \Error $e ) {
			$this->assertStringStartsWith( 'Typed property', $e->getMessage() );
		}

		$resettable_object->reset();
		$this->assertEquals( $example['is_reset'], $resettable_object->is_reset() );
		$this->assertEquals( $example['reset_result'], $resettable_object->get_reset_result() );
	}

	/**
	 * Test that a runnable and resettable object can only be run->reset->run->reset etc.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_runnable_resettable_traits() {
		$test_object = new RunnableResettableObject();

		$this->test_runnable_trait( $test_object );
		$this->test_resettable_trait( $test_object );
		$this->test_runnable_trait( $test_object );
		$this->test_resettable_trait( $test_object );
	}

	/**
	 * Test of an object that's both runnable and resettable and has local logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $example    Example to run the test on.
	 *
	 * @dataProvider    _runnable_resettable_local_trait_provider
	 */
	public function test_runnable_resettable_local_traits( array $example ) {
		$test_object = new RunnableResettableLocalObject( $example['run_result_local'], $example['reset_result_local'] );

		$this->test_runnable_local_trait( $example, $test_object );
		$this->test_resettable_local_trait( $example, $test_object );
		$this->test_runnable_local_trait( $example, $test_object );
		$this->test_resettable_local_trait( $example, $test_object );
	}

	// endregion

	// region HELPERS

	/**
	 * Provides examples for the 'runnable_local_trait' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _runnable_local_trait_provider(): array {
		return array(
			array(
				array(
					'run_result_local' => null,
					'run_result'       => null,
					'is_run'           => true,
				),
			),
			array(
				array(
					'run_result_local' => ( $local_result = new RunFailureException() ), // phpcs:ignore
					'run_result'       => $local_result,
					'is_run'           => false,
				),
			),
		);
	}

	/**
	 * Provides examples for the 'resettable_local_trait' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _resettable_local_trait_provider(): array {
		return array(
			array(
				array(
					'reset_result_local' => null,
					'reset_result'       => null,
					'is_reset'           => true,
				),
			),
			array(
				array(
					'reset_result_local' => ( $local_result = new ResetFailureException() ), // phpcs:ignore
					'reset_result'       => $local_result,
					'is_reset'           => false,
				),
			),
		);
	}

	/**
	 * Provides examples for the 'resettable_local_trait' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _runnable_resettable_local_trait_provider(): array {
		return array(
			array(
				array(
					'run_result_local'   => null,
					'run_result'         => null,
					'is_run'             => true,
					'reset_result_local' => null,
					'reset_result'       => null,
					'is_reset'           => true,
				),
			),
			array(
				array(
					'run_result_local'   => null,
					'run_result'         => null,
					'is_run'             => true,
					'reset_result_local' => ( $local_result = new ResetFailureException() ), // phpcs:ignore
					'reset_result'       => $local_result,
					'is_reset'           => false,
				),
			),
			array(
				array(
					'run_result_local'   => ( $local_result = new RunFailureException() ), // phpcs:ignore
					'run_result'         => $local_result,
					'is_run'             => false,
					'reset_result_local' => null,
					'reset_result'       => null,
					'is_reset'           => true,
				),
			),
			array(
				array(
					'run_result_local'   => ( $local_run_result = new RunFailureException() ), // phpcs:ignore
					'run_result'         => $local_run_result,
					'is_run'             => false,
					'reset_result_local' => ( $local_reset_result = new ResetFailureException() ), // phpcs:ignore
					'reset_result'       => $local_reset_result,
					'is_reset'           => false,
				),
			),
		);
	}

	// endregion
}
