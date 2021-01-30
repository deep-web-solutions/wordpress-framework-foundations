<?php

namespace DeepWebSolutions\Framework\Utilities;

final class DependenciesChecker {
	// region FIELDS AND CONSTANTS

	/**
	 * List of PHP extensions that must be present for functionality to setup.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  private
	 * @var     string[]
	 */
	private array $php_extensions = array();

	/**
	 * List of PHP functions that must be present for functionality to setup.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  private
	 * @var     string[]
	 */
	private array $php_functions = array();

	/**
	 * List of PHP settings that must be present for functionality to setup.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  private
	 * @var     string[]
	 */
	private array $php_settings = array();

	/**
	 * List of WP plugins that must be present and active for functionality to setup.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  private
	 * @var     string[]
	 */
	private array $plugins = array();

	// endregion

	// region MAGIC METHODS



	// endregion

	// region METHODS

	public function are_dependencies_fulfilled(): bool {
		return true;
	}

	// endregion
}