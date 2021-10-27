<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Hierarchy;

use DeepWebSolutions\Framework\Foundations\Hierarchy\Actions\AddContainerChildrenTrait;
use DeepWebSolutions\Framework\FoundationsDependencyInjection\ContainerAwareInterface;
use DeepWebSolutions\Framework\FoundationsDependencyInjection\ContainerAwareTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ContainerNodeObject
 *
 * @since   1.1.0
 * @version 1.1.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Hierarchy
 */
class ContainerNodeObject extends NodeObject implements ContainerAwareInterface {
	// region TRAITS

	use AddContainerChildrenTrait;
	use ContainerAwareTrait;

	// endregion

	// region INHERITED METHODS

	/**
	 * List of DI children.
	 *
	 * @since   1.1.0
	 * @version 1.1.0
	 *
	 * @return  string[]
	 */
	protected function get_di_container_children(): array {
		return array( 'dummy-child-1', 'dummy-child-2' );
	}

	// endregion
}
