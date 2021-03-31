<?php

namespace DeepWebSolutions\Framework\Tests\Foundations;

use DeepWebSolutions\Framework\Foundations\Helpers\AssetsHelpersTrait;
use DeepWebSolutions\Framework\Foundations\Helpers\HooksHelpersTrait;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginAwareInterface;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginAwareTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class PluginAwareObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations
 */
class PluginAwareObject implements PluginAwareInterface {
	// region TRAITS

	use PluginAwareTrait;
	use AssetsHelpersTrait;
	use HooksHelpersTrait;

	// endregion
}
