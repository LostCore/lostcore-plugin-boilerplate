<?php

namespace PluginName\includes;

/**
 * Class Plugin
 * @package ClientNotify
 */
abstract class BasePlugin {

	/**
	 * @var Loader
	 */
	private $Loader;

	/**
	 * @var i18n
	 */
	private $I18n;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $relativeMainFile;

	/**
	 * @var string
	 */
	private $mainFile;

	/**
	 * @var
	 */
	private $relativeDir;

	/**
	 * @var string $version
	 */
	private $version;

	/**
	 * @var bool
	 */
	private $debugMode = false;

	/**
	 * Plugin constructor.
	 *
	 * @param Loader $Loader
	 * @param i18n $I18n
	 */
	public function __construct($mainFile, Loader $Loader, i18n $I18n) {
		$this->Loader = $Loader;
		$this->I18n = $I18n;
		$this->name = basename($this->Loader->getBasePath());
		$this->relativeMainFile = ltrim(preg_replace('|'.WP_PLUGIN_DIR.'|','',$mainFile),"/");
		$this->mainFile = $mainFile;
		$this->relativeDir = $this->name;

		//Get the version
		$version = '';
		if(function_exists("get_plugin_data")){
			$pluginHeader = get_plugin_data($mainFile, false, false);
			if ( isset($pluginHeader['Version']) ) {
				$this->version = $pluginHeader['Version'];
			}
		}
		$this->version = $version;

		//Check if debug mode must be activated
		if( defined( 'WP_DEBUG' ) && WP_DEBUG ){
			$this->debugMode = true;
		}

		$this->setLocale();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 */
	private function setLocale() {
		$this->I18n->setDomain($this->getName());
		$this->I18n->setLanguageDir($this->getName()."/languages/");
		$this->Loader->addAction( 'plugins_loaded', [$this->I18n,'load'] );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run() {
		global $lstPlugins;
		$lstPlugins[$this->getName()] = &$this;
		$this->Loader->run();
	}

	/**
	 * @return string The name of the plugin.
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getRelativeDir(){
		return $this->getName();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return Loader
	 */
	public function getLoader() {
		return $this->Loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return string
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * Get plugin directory uri
	 *
	 * @return string
	 */
	public function getUri(){
		static $uri;
		if($uri) return $uri; //We want to save some queries
		$uri = site_url()."/wp-content/plugins/".$this->getRelativeDir()."/";
		return $uri;
	}

	/**
	 * Get plugin full path to directory

	 * @return string
	 */
	public function getPath(){
		return $this->Loader->getBasePath();
	}

	/**
	 * @return string
	 */
	public function getRelativeMainFile() {
		return $this->relativeMainFile;
	}

	/**
	 * @return string
	 */
	public function getMainFile() {
		return $this->mainFile;
	}

	/**
	 * Checks if the plugin is in debug mode. The debug mode is activated by WP_DEBUG constant.
	 *
	 * @return bool
	 */
	public function isDebug(){
		return $this->debugMode;
	}
}
