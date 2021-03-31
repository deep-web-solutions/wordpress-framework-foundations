<?php

namespace DeepWebSolutions\Framework\Tests\Foundations;

use DeepWebSolutions\Framework\Foundations\Helpers\AssetsHelpersTrait;
use DeepWebSolutions\Framework\Foundations\Helpers\HooksHelpersTrait;
use DeepWebSolutions\Framework\Foundations\PluginComponent\PluginComponentInterface;
use DeepWebSolutions\Framework\Foundations\PluginComponent\PluginComponentTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class PluginComponent
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations
 */
class PluginComponent implements PluginComponentInterface {
	// region TRAITS

	use PluginComponentTrait;
	use AssetsHelpersTrait;
	use HooksHelpersTrait;

	// endregion
}
