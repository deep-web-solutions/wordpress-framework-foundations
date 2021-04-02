<?php

namespace DeepWebSolutions\Framework\Foundations\Hierarchy\Actions;

use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupableExtensionTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\SetupableInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\ParentInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Setup extension trait for setting up children in the same-go.
 *
 * @since   1.0.0
 * @version 1.1.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Hierarchy\Actions
 */
trait SetupChildrenTrait {
	// region TRAITS

	use SetupableExtensionTrait;

	// endregion

	// region METHODS

	/**
	 * Makes one's own successful setup dependent on that of one's children.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  SetupFailureException|null
	 */
	public function setup_children(): ?SetupFailureException {
		$setup_result = null;

		if ( $this instanceof ParentInterface ) {
			$children = $this->get_children();
			foreach ( $children as $child ) {
				if ( $child instanceof SetupableInterface ) {
					$setup_result = $child->setup();
					if ( ! \is_null( $setup_result ) ) {
						break;
					}
				}
			}
		}

		return $setup_result;
	}

	// endregion
}
