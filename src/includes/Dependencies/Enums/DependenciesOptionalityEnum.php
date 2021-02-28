<?php

namespace DeepWebSolutions\Framework\Utilities\Dependencies\Enums;

/**
 * Valid values for dependency optionality types.
 *
 * @see     DependenciesContainer
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Dependencies\Enums
 */
final class DependenciesOptionalityEnum {
	/**
	 * Enum-type constant for referring to required dependencies.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string
	 */
	public const REQUIRED = 'required';

	/**
	 * Enum-type constant for referring to optional dependencies.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string
	 */
	public const OPTIONAL = 'optional';
}
