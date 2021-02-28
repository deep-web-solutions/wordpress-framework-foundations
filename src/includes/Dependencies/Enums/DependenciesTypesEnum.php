<?php

namespace DeepWebSolutions\Framework\Utilities\Dependencies\Enums;

/**
 * Valid values for dependency types.
 *
 * @see     DependenciesContainer
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Dependencies\Enums
 */
final class DependenciesTypesEnum {
	/**
	 * Enum-type constant for referring to php extensions dependencies.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string
	 */
	public const PHP_EXTENSIONS = 'php_extensions';

	/**
	 * Enum-type constant for referring to php functions dependencies.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string
	 */
	public const PHP_FUNCTIONS = 'php_functions';

	/**
	 * Enum-type constant for referring to php settings dependencies.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string
	 */
	public const PHP_SETTINGS = 'php_settings';

	/**
	 * Enum-type constant for referring to WP plugins dependencies.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string
	 */
	public const WP_PLUGINS = 'active_plugins';
}
