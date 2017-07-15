<?php

namespace PluginName\includes;

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 */
class Loader {

	const TYPE_ACTION = 'action';
	const TYPE_FILTER = 'filter';

	/**
	 * @var array
	 */
	private $actions = [];
	/**
	 * @var array
	 */
	private $filters = [];
	/**
	 * @var string
	 */
	private $basePath;

	/**
	 * Loader constructor.
	 *
	 * @param $basePath
	 */
	public function __construct($basePath) {
		$this->basePath = trailingslashit($basePath);
	}

	/**
	 * @return string
	 */
	public function getBasePath(){
		return $this->basePath;
	}

	/**
	 * @return array
	 */
	public function getActions(){
		return $this->actions;
	}

	/**
	 * @return array
	 */
	public function getFilters(){
		return $this->filters;
	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @param string $hook The name of the WordPress action that is being registered.
	 * @param callable $callback The name of the function definition on the $component.
	 * @param int $priority Optional. The priority at which the function should be fired. Default is 10.
	 * @param int $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function addAction( $hook, callable $callback, $priority = 10, $accepted_args = 1 ) {
		$this->add( self::TYPE_ACTION, $hook, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @param string $hook The name of the WordPress filter that is being registered.
	 * @param callable $callback The name of the function definition on the $component.
	 * @param int $priority Optional. he priority at which the function should be fired. Default is 10.
	 * @param int $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function addFilter( $hook, callable $callback, $priority = 10, $accepted_args = 1 ) {
		$this->add( self::TYPE_FILTER, $hook, $callback, $priority, $accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @param string $type The collection of hooks that is being registered (that is, actions or filters).
	 * @param string $hook The name of the WordPress filter that is being registered.
	 * @param callable $callback The name of the function definition on the $component.
	 * @param int $priority The priority at which the function should be fired.
	 * @param int $accepted_args The number of arguments that should be passed to the $callback.
	 *
	 * @return Loader
	 */
	private function add( $type, $hook, callable $callback, $priority, $accepted_args ) {
		switch ($type){
			case self::TYPE_ACTION:
				$this->actions[] = [
					'hook'          => $hook,
					'callback'      => $callback,
					'priority'      => $priority,
					'accepted_args' => $accepted_args
				];
				break;
			case self::TYPE_FILTER:
				$this->filters[] = [
					'hook'          => $hook,
					'callback'      => $callback,
					'priority'      => $priority,
					'accepted_args' => $accepted_args
				];
				break;
		}

		return $this;
	}

	/**
	 * Register the filters and actions with WordPress.
	 */
	public function run() {
		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], $hook['callback'], $hook['priority'], $hook['accepted_args'] );
		}
		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], $hook['callback'], $hook['priority'], $hook['accepted_args'] );
		}
	}
}
