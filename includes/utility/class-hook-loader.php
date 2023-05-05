<?php
/**
 * Hooks loader.
 *
 * This class is not used presently
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\SEO
 */

namespace TSMLXtras\Utility;

class Hook_Loader {
	/**
	 * A reference to the collection of actions used throughout the plugin.
	 *
	 * @access protected
	 * @var    array    $actions    The array of actions that are defined throughout the plugin.
	 */
	protected $actions;
	/**
	 * A reference to the collection of filters used throughout the plugin.
	 *
	 * @access protected
	 * @var    array    $actions    The array of filters that are defined throughout the plugin.
	 */
	protected $filters;
	/**
	 * Instantiates the plugin by setting up the data structures that will
	 * be used to maintain the actions and the filters.
	 */
	public function __construct() {
		$this->actions = array();
		$this->filters = array();
	}
	/**
	 * Registers the actions with WordPress and the respective objects and
	 * their methods.
	 *
	 * @param  string    $hook        The name of the WordPress hook to which we're registering a callback.
	 * @param  object    $component   The object that contains the method to be called when the hook is fired.
	 * @param  string    $callback    The function that resides on the specified component.
	 */
	public function add_action( $hook, $component, $callback ) {
		$this->actions[] = [ 'hook'      => $hook,
		                     'component' => $component,
		                     'callback'  => $callback
		];
	}
	
	/**
	 * Registers the filters with WordPress and the respective objects and
	 * their methods.
	 *
	 * @param  string    $hook        The name of the WordPress hook to which we're registering a callback.
	 * @param  object    $component   The object that contains the method to be called when the hook is fired.
	 * @param  string    $callback    The function that resides on the specified component.
	 */
	public function add_filter( $hook, $component, $callback ) {
		$this->filters[] = [ 'hook'      => $hook,
		                     'component' => $component,
		                     'callback'  => $callback
		];
	}
	
	/**
	 * Registers all of the defined filters and actions with WordPress.
	 */
	public function run() {
		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
	}
}
