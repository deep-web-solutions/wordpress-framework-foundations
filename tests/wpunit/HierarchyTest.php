<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializationFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupFailureException;
use DeepWebSolutions\Framework\Foundations\Hierarchy\ChildInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\NodeInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\ParentInterface;
use DeepWebSolutions\Framework\Tests\Foundations\Hierarchy\ChildObject;
use DeepWebSolutions\Framework\Tests\Foundations\Hierarchy\EnhancedNodeObject;
use DeepWebSolutions\Framework\Tests\Foundations\Hierarchy\NodeObject;
use DeepWebSolutions\Framework\Tests\Foundations\Hierarchy\ParentObject;
use WpunitTester;

/**
 * Tests for the Hierarchy objects and traits.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration
 */
class HierarchyTest extends WPTestCase {
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
	 * Tests the default parent-child traits.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   ParentInterface|null    $parent     Parent object to run tests against.
	 * @param   ChildInterface|null     $child      Child object to run tests against.
	 */
	public function test_parent_child_traits( ?ParentInterface $parent = null, ?ChildInterface $child = null ) {
		$parent = $parent ?? new ParentObject();
		$this->assertFalse( $parent->has_children() );
		$this->assertEmpty( $parent->get_children() );

		$child = $child ?? new ChildObject();
		$this->assertFalse( $child->has_parent() );
		$this->assertNull( $child->get_parent() );

		// Test adding child using parent's 'add_child' method.
		$this->assertTrue( $parent->add_child( $child ) );
		$this->assertTrue( $parent->has_children() );
		$this->assertNotEmpty( $parent->get_children() );
		$this->assertEquals( 1, count( $parent->get_children() ) );
		$this->assertEquals( $child, $parent->get_children()[0] );

		$this->assertTrue( $child->has_parent() );
		$this->assertEquals( $parent, $child->get_parent() );

		// Test removing all children from parent.
		$parent->set_children( array() );
		$this->assertFalse( $parent->has_children() );
		$this->assertEmpty( $parent->get_children() );

		// Child already has a parent, so this should fail this time around.
		$this->assertFalse( $parent->add_child( $child ) );

		// We can set the child again using 'set_children'.
		$parent->set_children( array( $child ) );
		$this->assertTrue( $parent->has_children() );
		$this->assertNotEmpty( $parent->get_children() );
		$this->assertEquals( 1, count( $parent->get_children() ) );
		$this->assertEquals( $child, $parent->get_children()[0] );

		// Adding non-ChildInterface children fails.
		$this->assertFalse( $parent->add_child( $this ) );
		$this->assertFalse( $parent->add_child( ParentInterface::class ) );
		$this->assertEquals( 1, count( $parent->get_children() ) );
		$this->assertEquals( $child, $parent->get_children()[0] );
	}

	/**
	 * Tests the node trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   NodeInterface|null  $node1  Node to run the tests against.
	 * @param   NodeInterface|null  $node2  Node to run the tests against.
	 * @param   NodeInterface|null  $node3  Node to run the tests against.
	 */
	public function test_node_trait( ?NodeInterface $node1 = null, ?NodeInterface $node2 = null, ?NodeInterface $node3 = null ) {
		$node1 = $node1 ?? new NodeObject();
		$node2 = $node2 ?? new NodeObject();
		$node3 = $node3 ?? new NodeObject();

		$this->test_parent_child_traits( $node1, $node2 );
		$this->test_parent_child_traits( $node2, $node3 );

		$this->assertEquals( 0, $node1->get_depth() );
		$this->assertEquals( 1, $node2->get_depth() );
		$this->assertEquals( 2, $node3->get_depth() );
	}

	/**
	 * Tests node that have inheritable actions and states.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $example    Example to run the test on.
	 *
	 * @dataProvider    _enhanced_node_provider
	 */
	public function test_enhanced_node( array $example ) {
		$enhanced_node1 = new EnhancedNodeObject( $example['is_active_local1'], $example['is_disabled_local1'], $example['init_result_local1'], $example['setup_result_local1'] );
		$enhanced_node2 = new EnhancedNodeObject( $example['is_active_local2'], $example['is_disabled_local2'], $example['init_result_local2'], $example['setup_result_local2'] );
		$enhanced_node3 = new EnhancedNodeObject( $example['is_active_local3'], $example['is_disabled_local3'], $example['init_result_local3'], $example['setup_result_local3'] );

		$this->test_node_trait( $enhanced_node1, $enhanced_node2, $enhanced_node3 );

		$this->assertEquals( $example['is_active1'], $enhanced_node1->is_active() );
		$this->assertEquals( $example['is_active2'], $enhanced_node2->is_active() );
		$this->assertEquals( $example['is_active3'], $enhanced_node3->is_active() );

		$this->assertEquals( $example['is_disabled1'], $enhanced_node1->is_disabled() );
		$this->assertEquals( $example['is_disabled2'], $enhanced_node2->is_disabled() );
		$this->assertEquals( $example['is_disabled3'], $enhanced_node3->is_disabled() );

		$enhanced_node1->initialize(); $enhanced_node2->initialize(); $enhanced_node3->initialize(); // phpcs:ignore
		$this->assertEquals( $example['init_result1'], $enhanced_node1->get_initialization_result() );
		$this->assertEquals( $example['init_result2'], $enhanced_node2->get_initialization_result() );
		$this->assertEquals( $example['init_result3'], $enhanced_node3->get_initialization_result() );
		$this->assertEquals( $example['is_init1'], $enhanced_node1->is_initialized() );
		$this->assertEquals( $example['is_init2'], $enhanced_node2->is_initialized() );
		$this->assertEquals( $example['is_init3'], $enhanced_node3->is_initialized() );

		$enhanced_node1->setup(); $enhanced_node2->setup(); $enhanced_node3->setup(); // phpcs:ignore
		$this->assertEquals( $example['setup_result1'], $enhanced_node1->get_setup_result() );
		$this->assertEquals( $example['setup_result2'], $enhanced_node2->get_setup_result() );
		$this->assertEquals( $example['setup_result3'], $enhanced_node3->get_setup_result() );
		$this->assertEquals( $example['is_setup1'], $enhanced_node1->is_setup() );
		$this->assertEquals( $example['is_setup2'], $enhanced_node2->is_setup() );
		$this->assertEquals( $example['is_setup3'], $enhanced_node3->is_setup() );
	}

	// endregion

	// region HELPERS

	/**
	 * Provides examples for the 'enhanced_node' tester.
	 *
	 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _enhanced_node_provider(): array {
		$default = array(
			'is_active_local1'    => true,
			'is_active_local2'    => true,
			'is_active_local3'    => true,
			'is_active1'          => true,
			'is_active2'          => true,
			'is_active3'          => true,

			'is_disabled_local1'  => false,
			'is_disabled_local2'  => false,
			'is_disabled_local3'  => false,
			'is_disabled1'        => false,
			'is_disabled2'        => false,
			'is_disabled3'        => false,

			'init_result_local1'  => null,
			'init_result_local2'  => null,
			'init_result_local3'  => null,
			'init_result1'        => null,
			'init_result2'        => null,
			'init_result3'        => null,
			'is_init1'            => true,
			'is_init2'            => true,
			'is_init3'            => true,

			'setup_result_local1' => null,
			'setup_result_local2' => null,
			'setup_result_local3' => null,
			'setup_result1'       => null,
			'setup_result2'       => null,
			'setup_result3'       => null,
			'is_setup1'           => true,
			'is_setup2'           => true,
			'is_setup3'           => true,
		);

		return array(
			array( $default ),

			array(
				wp_parse_args(
					array(
						'is_active_local1' => false,
						'is_active_local2' => true,
						'is_active_local3' => true,
						'is_active1'       => false,
						'is_active2'       => false,
						'is_active3'       => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'is_active_local1' => true,
						'is_active_local2' => false,
						'is_active_local3' => true,
						'is_active1'       => true,
						'is_active2'       => false,
						'is_active3'       => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'is_active_local1' => true,
						'is_active_local2' => true,
						'is_active_local3' => false,
						'is_active1'       => true,
						'is_active2'       => true,
						'is_active3'       => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'is_active_local1' => false,
						'is_active_local2' => false,
						'is_active_local3' => true,
						'is_active1'       => false,
						'is_active2'       => false,
						'is_active3'       => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'is_active_local1' => false,
						'is_active_local2' => true,
						'is_active_local3' => false,
						'is_active1'       => false,
						'is_active2'       => false,
						'is_active3'       => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'is_active_local1' => true,
						'is_active_local2' => false,
						'is_active_local3' => false,
						'is_active1'       => true,
						'is_active2'       => false,
						'is_active3'       => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'is_active_local1' => false,
						'is_active_local2' => false,
						'is_active_local3' => false,
						'is_active1'       => false,
						'is_active2'       => false,
						'is_active3'       => false,
					),
					$default
				),
			),

			array(
				wp_parse_args(
					array(
						'is_disabled_local1' => true,
						'is_disabled_local2' => false,
						'is_disabled_local3' => false,
						'is_disabled1'       => true,
						'is_disabled2'       => true,
						'is_disabled3'       => true,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'is_disabled_local1' => false,
						'is_disabled_local2' => true,
						'is_disabled_local3' => false,
						'is_disabled1'       => false,
						'is_disabled2'       => true,
						'is_disabled3'       => true,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'is_disabled_local1' => false,
						'is_disabled_local2' => false,
						'is_disabled_local3' => true,
						'is_disabled1'       => false,
						'is_disabled2'       => false,
						'is_disabled3'       => true,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'is_disabled_local1' => true,
						'is_disabled_local2' => true,
						'is_disabled_local3' => false,
						'is_disabled1'       => true,
						'is_disabled2'       => true,
						'is_disabled3'       => true,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'is_disabled_local1' => true,
						'is_disabled_local2' => false,
						'is_disabled_local3' => true,
						'is_disabled1'       => true,
						'is_disabled2'       => true,
						'is_disabled3'       => true,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'is_disabled_local1' => false,
						'is_disabled_local2' => true,
						'is_disabled_local3' => true,
						'is_disabled1'       => false,
						'is_disabled2'       => true,
						'is_disabled3'       => true,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'is_disabled_local1' => true,
						'is_disabled_local2' => true,
						'is_disabled_local3' => true,
						'is_disabled1'       => true,
						'is_disabled2'       => true,
						'is_disabled3'       => true,
					),
					$default
				),
			),

			array(
				wp_parse_args(
					array(
						'init_result_local1' => ( $local_result1 = new InitializationFailureException( 'Local failure 1' ) ), // phpcs:ignore
						'init_result_local2' => null,
						'init_result_local3' => null,
						'init_result1'       => $local_result1,
						'init_result2'       => null,
						'init_result3'       => null,
						'is_init1'           => false,
						'is_init2'           => true,
						'is_init3'           => true,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'init_result_local1' => null,
						'init_result_local2' => ( $local_result2 = new InitializationFailureException( 'Local failure 2' ) ), // phpcs:ignore
						'init_result_local3' => null,
						'init_result1'       => $local_result2,
						'init_result2'       => $local_result2,
						'init_result3'       => null,
						'is_init1'           => false,
						'is_init2'           => false,
						'is_init3'           => true,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'init_result_local1' => null,
						'init_result_local2' => null,
						'init_result_local3' => ( $local_result3 = new InitializationFailureException( 'Local failure 3' ) ), // phpcs:ignore
						'init_result1'       => $local_result3,
						'init_result2'       => $local_result3,
						'init_result3'       => $local_result3,
						'is_init1'           => false,
						'is_init2'           => false,
						'is_init3'           => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'init_result_local1' => ( $local_result1 = new InitializationFailureException( 'Local failure 1' ) ), // phpcs:ignore
						'init_result_local2' => ( $local_result2 = new InitializationFailureException( 'Local failure 2' ) ), // phpcs:ignore
						'init_result_local3' => null,
						'init_result1'       => $local_result1,
						'init_result2'       => $local_result2,
						'init_result3'       => null,
						'is_init1'           => false,
						'is_init2'           => false,
						'is_init3'           => true,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'init_result_local1' => ( $local_result1 = new InitializationFailureException( 'Local failure 1' ) ), // phpcs:ignore
						'init_result_local2' => null,
						'init_result_local3' => ( $local_result3 = new InitializationFailureException( 'Local failure 3' ) ), // phpcs:ignore
						'init_result1'       => $local_result1,
						'init_result2'       => $local_result3,
						'init_result3'       => $local_result3,
						'is_init1'           => false,
						'is_init2'           => false,
						'is_init3'           => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'init_result_local1' => null,
						'init_result_local2' => ( $local_result2 = new InitializationFailureException( 'Local failure 2' ) ), // phpcs:ignore
						'init_result_local3' => ( $local_result3 = new InitializationFailureException( 'Local failure 3' ) ), // phpcs:ignore
						'init_result1'       => $local_result2,
						'init_result2'       => $local_result2,
						'init_result3'       => $local_result3,
						'is_init1'           => false,
						'is_init2'           => false,
						'is_init3'           => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'init_result_local1' => ( $local_result1 = new InitializationFailureException( 'Local failure 1' ) ), // phpcs:ignore
						'init_result_local2' => ( $local_result2 = new InitializationFailureException( 'Local failure 2' ) ), // phpcs:ignore
						'init_result_local3' => ( $local_result3 = new InitializationFailureException( 'Local failure 3' ) ), // phpcs:ignore
						'init_result1'       => $local_result1,
						'init_result2'       => $local_result2,
						'init_result3'       => $local_result3,
						'is_init1'           => false,
						'is_init2'           => false,
						'is_init3'           => false,
					),
					$default
				),
			),

			array(
				wp_parse_args(
					array(
						'setup_result_local1' => ( $local_result1 = new SetupFailureException( 'Local failure 1' ) ), // phpcs:ignore
						'setup_result_local2' => null,
						'setup_result_local3' => null,
						'setup_result1'       => $local_result1,
						'setup_result2'       => null,
						'setup_result3'       => null,
						'is_setup1'           => false,
						'is_setup2'           => true,
						'is_setup3'           => true,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'setup_result_local1' => null,
						'setup_result_local2' => ( $local_result2 = new SetupFailureException( 'Local failure 2' ) ), // phpcs:ignore
						'setup_result_local3' => null,
						'setup_result1'       => $local_result2,
						'setup_result2'       => $local_result2,
						'setup_result3'       => null,
						'is_setup1'           => false,
						'is_setup2'           => false,
						'is_setup3'           => true,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'setup_result_local1' => null,
						'setup_result_local2' => null,
						'setup_result_local3' => ( $local_result3 = new SetupFailureException( 'Local failure 3' ) ), // phpcs:ignore
						'setup_result1'       => $local_result3,
						'setup_result2'       => $local_result3,
						'setup_result3'       => $local_result3,
						'is_setup1'           => false,
						'is_setup2'           => false,
						'is_setup3'           => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'setup_result_local1' => ( $local_result1 = new SetupFailureException( 'Local failure 1' ) ), // phpcs:ignore
						'setup_result_local2' => ( $local_result2 = new SetupFailureException( 'Local failure 2' ) ), // phpcs:ignore
						'setup_result_local3' => null,
						'setup_result1'       => $local_result1,
						'setup_result2'       => $local_result2,
						'setup_result3'       => null,
						'is_setup1'           => false,
						'is_setup2'           => false,
						'is_setup3'           => true,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'setup_result_local1' => ( $local_result1 = new SetupFailureException( 'Local failure 1' ) ), // phpcs:ignore
						'setup_result_local2' => null,
						'setup_result_local3' => ( $local_result3 = new SetupFailureException( 'Local failure 3' ) ), // phpcs:ignore
						'setup_result1'       => $local_result1,
						'setup_result2'       => $local_result3,
						'setup_result3'       => $local_result3,
						'is_setup1'           => false,
						'is_setup2'           => false,
						'is_setup3'           => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'setup_result_local1' => null,
						'setup_result_local2' => ( $local_result2 = new SetupFailureException( 'Local failure 2' ) ), // phpcs:ignore
						'setup_result_local3' => ( $local_result3 = new SetupFailureException( 'Local failure 3' ) ), // phpcs:ignore
						'setup_result1'       => $local_result2,
						'setup_result2'       => $local_result2,
						'setup_result3'       => $local_result3,
						'is_setup1'           => false,
						'is_setup2'           => false,
						'is_setup3'           => false,
					),
					$default
				),
			),
			array(
				wp_parse_args(
					array(
						'setup_result_local1' => ( $local_result1 = new SetupFailureException( 'Local failure 1' ) ), // phpcs:ignore
						'setup_result_local2' => ( $local_result2 = new SetupFailureException( 'Local failure 2' ) ), // phpcs:ignore
						'setup_result_local3' => ( $local_result3 = new SetupFailureException( 'Local failure 3' ) ), // phpcs:ignore
						'setup_result1'       => $local_result1,
						'setup_result2'       => $local_result2,
						'setup_result3'       => $local_result3,
						'is_setup1'           => false,
						'is_setup2'           => false,
						'is_setup3'           => false,
					),
					$default
				),
			),
		);
	}

	// endregion
}
