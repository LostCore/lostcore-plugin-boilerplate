<?php

namespace PluginName;

use PluginName\includes\BasePlugin;
use PluginName\includes\i18n;
use PluginName\includes\Loader;

class PluginName extends BasePlugin {
	public function __construct( $mainFile, Loader $Loader, i18n $I18n ) {
		parent::__construct( $mainFile, $Loader, $I18n );

		$this->defineGlobalHooks();
		$this->defineAdminHooks();
		$this->definePublicHooks();
	}

	/**
	 * Register all of the hooks related to the global scope of the plugin
	 */
	private function defineGlobalHooks(){
		$this->getLoader()->addAction( 'init', function(){
			//Do something amazing
		});
	}

	/**
	 * Register all of the hooks related to the admin area functionality of the plugin.
	 */
	private function defineAdminHooks() {}

	/**
	 * Register all of the hooks related to the public-facing functionality of the plugin.
	 */
	private function definePublicHooks() {}
}