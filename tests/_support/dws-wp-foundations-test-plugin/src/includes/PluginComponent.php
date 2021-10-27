<?php

namespace DeepWebSolutions\Framework\Tests\Foundations;

use DeepWebSolutions\Framework\Foundations\Helpers\AssetsHelpersTrait;
use DeepWebSolutions\Framework\Foundations\Helpers\HooksHelpersTrait;
use DeepWebSolutions\Framework\Foundations\PluginInterface;
use DeepWebSolutions\Framework\Foundations\PluginComponentInterface;
use DeepWebSolutions\Framework\Foundations\PluginComponentTrait;

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

	// region MAGIC METHODS

	/**
	 * PluginComponent constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   PluginInterface     $plugin             Instance of the plugin.
	 * @param   string              $component_id       ID of the instance.
	 * @param   string              $component_name     Name of the instance.
	 */
	public function __construct( PluginInterface $plugin, string $component_id, string $component_name ) {
		$this->set_plugin( $plugin );
		$this->set_id( $component_id );
		$this->set_name( $component_name );
	}

	// endregion
}
