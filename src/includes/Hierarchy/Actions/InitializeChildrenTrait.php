<?php

namespace DeepWebSolutions\Framework\Foundations\Hierarchy\Actions;

use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializableExtensionTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializationFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\InitializableInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\ParentInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Initialization extension trait for initializing children in the same-go.
 *
 * @since   1.0.0
 * @version 1.1.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Hierarchy\Actions
 */
trait InitializeChildrenTrait {
	// region TRAITS

	use InitializableExtensionTrait;

	// endregion

	// region METHODS

	/**
	 * Makes one's own successful initialization dependent on that of one's children.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  InitializationFailureException|null
	 */
	protected function initialize_children(): ?InitializationFailureException {
		$init_result = null;

		if ( $this instanceof ParentInterface ) {
			$children = $this->get_children();
			foreach ( $children as $child ) {
				if ( $child instanceof InitializableInterface ) {
					$init_result = $child->initialize();
					if ( ! \is_null( $init_result ) ) {
						break;
					}
				}
			}
		}

		return $init_result;
	}

	// endregion
}
