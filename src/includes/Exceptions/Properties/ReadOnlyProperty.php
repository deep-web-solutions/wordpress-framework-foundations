<?php

namespace DeepWebSolutions\Framework\Utilities\Exceptions\Properties;

defined( 'ABSPATH' ) || exit;

/**
 * An exception thrown when trying to modify a read-only property.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Exceptions\Properties
 */
class ReadOnlyProperty extends \Exception {
	/* empty on purpose */
}
