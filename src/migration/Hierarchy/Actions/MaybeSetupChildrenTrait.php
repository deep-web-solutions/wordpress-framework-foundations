<?php

namespace DeepWebSolutions\Framework\Foundations\Hierarchy\Actions;

use DeepWebSolutions\Framework\Foundations\Actions\Initializable\Integrations\SetupableDisabledTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\Integrations\SetupableInactiveTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupableIntegrationTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\SetupableInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\ParentInterface;
use DeepWebSolutions\Framework\Foundations\States\ActiveableInterface;
use DeepWebSolutions\Framework\Foundations\States\DisableableInterface;
use DeepWebSolutions\Framework\Helpers\DataTypes\Objects;

\defined( 'ABSPATH' ) || exit;

/**
 * Setup extension trait for setting up children in the same-go.
 *
 * @since   1.2.1
 * @version 1.4.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Hierarchy\Actions
 */
trait MaybeSetupChildrenTrait {
	// region TRAITS

	use SetupableIntegrationTrait;

	// endregion

	// region METHODS

	/**
	 * Makes one's own successful setup dependent on that of one's children, conditionally.
	 *
	 * @since   1.2.1
	 * @version 1.4.0
	 *
	 * @return  SetupFailureException|null
	 */
	protected function integrate_maybe_setup_children(): ?SetupFailureException {
		$setup_result = null;

		if ( $this instanceof ParentInterface ) {
			$children = $this->get_children();
			foreach ( $children as $child ) {
				if ( $child instanceof SetupableInterface && $this->should_setup_child( $child ) ) {
					$setup_result = $child->setup();
					if ( ! \is_null( $setup_result ) ) {
						break;
					}
				}
			}
		}

		return $setup_result;
	}

	/**
	 * Decide whether a child instance should setup or not based on its state.
	 *
	 * @since   1.2.1
	 * @version 1.2.1
	 *
	 * @param   SetupableInterface      $child      Child instance to decide whether it can be setup or not.
	 *
	 * @return  bool
	 */
	protected function should_setup_child( SetupableInterface $child ): bool {
		$should_setup = true;

		if ( $child instanceof DisableableInterface ) {
			$should_setup = ( ! $child->is_disabled() || Objects::has_trait_deep( SetupableDisabledTrait::class, $child ) );
		}

		if ( $should_setup && $child instanceof ActiveableInterface ) {
			$should_setup = ( $child->is_active() || Objects::has_trait_deep( SetupableInactiveTrait::class, $child ) );
		}

		return $should_setup;
	}

	// endregion
}
