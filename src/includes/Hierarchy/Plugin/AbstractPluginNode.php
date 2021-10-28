<?php

namespace DeepWebSolutions\Framework\Foundations\Hierarchy\Plugin;

use DeepWebSolutions\Framework\Foundations\AbstractPluginComponent;
use DeepWebSolutions\Framework\Foundations\Hierarchy\NodeInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\NodeTrait;
use DeepWebSolutions\Framework\Foundations\PluginInterface;
use Psr\Log\LogLevel;

\defined( 'ABSPATH' ) || exit;

/**
 * Template for encapsulating some of the most often required abilities of a tree-like plugin's component.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Hierarchy\Plugin
 */
abstract class AbstractPluginNode extends AbstractPluginComponent implements NodeInterface {
	// region TRAITS

	use NodeTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Whether the plugin has been set on the instance or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     bool
	 */
	protected bool $set_plugin = false;

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns the plugin instance that the current node belongs to.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @noinspection PhpDocMissingThrowsInspection
	 * @throws  \LogicException     Thrown if the node does NOT belong to a plugin tree.
	 *
	 * @return  PluginInterface
	 */
	public function get_plugin(): PluginInterface {
		if ( $this->set_plugin ) {
			return parent::get_plugin();
		} else {
			$plugin = $this->get_closest( PluginInterface::class );
			if ( $plugin instanceof PluginInterface ) {
				$this->set_plugin( $plugin );
				return $plugin;
			}

			/* @noinspection PhpUnhandledExceptionInspection */
			throw $this->log_event( \sprintf( 'Could not find plugin root from within node. Node name: %s', $this->get_name() ), array(), 'framework' )
						->set_log_level( LogLevel::ERROR )
						->return_exception( \LogicException::class )
						->finalize();
		}
	}

	/**
	 * Sets the protected plugin variable.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 *
	 * @param   PluginInterface|null    $plugin     NOT USED BY THIS IMPLEMENTATION.
	 */
	public function set_plugin( ?PluginInterface $plugin = null ) {
		$this->plugin     = \is_null( $plugin ) ? $this->get_plugin() : $plugin;
		$this->set_plugin = true;
	}

	// endregion

	// region METHODS

	/**
	 * Method inspired by jQuery's 'closest' for getting the first parent node that is an instance of a given class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   string  $class          The name of the class of the searched-for parent node.
	 * @param   bool    $ignore_self    Whether to ignore oneself if oneself also fulfills the requirements.
	 *
	 * @return  NodeInterface|null
	 */
	public function get_closest( string $class, bool $ignore_self = false ): ?NodeInterface {
		if ( ! $this->has_parent() || ( \is_a( $this, $class ) && ! $ignore_self ) ) {
			return null;
		}

		$current = $this;
		do {
			$current = $current->get_parent();
		} while ( $current->has_parent() && ! \is_a( $current, $class ) );

		return \is_a( $current, $class ) ? $current : null;
	}

	// endregion
}
