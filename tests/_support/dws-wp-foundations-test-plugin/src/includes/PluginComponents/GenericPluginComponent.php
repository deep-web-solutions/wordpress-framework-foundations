<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\PluginComponents;

use DeepWebSolutions\Framework\Foundations\AbstractPluginComponent;

\defined( 'ABSPATH' ) || exit;

/**
 * Class GenericPluginComponent
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\PluginComponents
 */
class GenericPluginComponent extends AbstractPluginComponent {
	// region FIELDS AND CONSTANTS

	/**
	 * Dummy property.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  private
	 * @var     bool
	 */
	private bool $test;

	/**
	 * Dummy property.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  private
	 * @var     string
	 */
	private string $readonly_test = 'immutable';

	// endregion

	// region GETTERS

	/**
	 * Returns the value of the 'test' dummy.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	public function is_test(): bool {
		return $this->test;
	}

	/**
	 * Returns the value of the 'readonly_test' dummy.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_readonly_test(): string {
		return $this->readonly_test;
	}

	// endregion

	// region SETTERS

	/**
	 * Sets the value of test anew.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   bool    $new_test   The new value of test.
	 */
	public function set_test( bool $new_test ): void {
		$this->test = $new_test;
	}

	// endregion
}
