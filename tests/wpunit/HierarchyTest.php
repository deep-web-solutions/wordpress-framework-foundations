<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Hierarchy\ChildInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\ParentInterface;
use DeepWebSolutions\Framework\Tests\Foundations\Hierarchy\ChildObject;
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
	 */
	public function test_node_trait() {
		$node1 = new NodeObject();
		$node2 = new NodeObject();
		$node3 = new NodeObject();

		$this->test_parent_child_traits( $node1, $node2 );
		$this->test_parent_child_traits( $node2, $node3 );

		$this->assertEquals( 0, $node1->get_depth() );
		$this->assertEquals( 1, $node2->get_depth() );
		$this->assertEquals( 2, $node3->get_depth() );
	}

	// endregion
}
