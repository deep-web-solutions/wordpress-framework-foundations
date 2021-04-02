<?php

namespace DeepWebSolutions\Framework\Foundations\Hierarchy\Plugin;

use DeepWebSolutions\Framework\Foundations\Hierarchy\NodeInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\NodeTrait;
use DeepWebSolutions\Framework\Foundations\Hierarchy\ParentInterface;
use DeepWebSolutions\Framework\Foundations\Plugin\AbstractPlugin;

\defined( 'ABSPATH' ) || exit;

/**
 * Template for encapsulating some of the most often required abilities of a tree-like plugin's root.
 *
 * @since   1.0.0
 * @version 1.1.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Hierarchy\Plugin
 */
abstract class AbstractPluginRoot extends AbstractPlugin implements NodeInterface {
	// region TRAITS

	use NodeTrait;

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns the plugin instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  $this
	 */
	final public function get_plugin(): AbstractPluginRoot {
		return $this;
	}

	/**
	 * Return null. The root has no parent by definition.
	 *
	 * @since   1.0.0
	 * @version 1.1.0
	 *
	 * @return  ParentInterface|null
	 */
	final public function get_parent(): ?ParentInterface {
		return null;
	}

	/**
	 * Set the parent to null. Roots have no parent by definition.
	 *
	 * @since   1.0.0
	 * @version 1.1.0
	 *
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 *
	 * @param   ParentInterface|null    $parent     New parent.
	 */
	final public function set_parent( ?ParentInterface $parent = null ) {
		if ( ! \is_null( $parent ) ) {
			$this->log_event( 'The plugin root cannot have a parent', array(), 'framework' )
				->doing_it_wrong( __FUNCTION__, '1.1.0' )->finalize();
		}

		$this->parent = null;
	}

	// endregion
}
