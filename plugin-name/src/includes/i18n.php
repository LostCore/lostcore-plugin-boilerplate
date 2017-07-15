<?php

namespace PluginName\includes;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 */
class i18n {

	/**
	 * The domain specified for this plugin.
	 *
	 * @var string $domain
	 */
	private $domain;

	/**
	 * The language directory (relative to WP_PLUGIN_DIR)
	 *
	 * @var string
	 */
	private $languageDir;

	public function __construct() {}

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load() {
		load_plugin_textdomain( $this->domain, false, $this->languageDir );
	}

	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @param string $domain
	 */
	public function setDomain( $domain ) {
		$this->domain = $domain;
	}

	/**
	 * Set the language files directory. It is called in class-plugin.php via set_locale().
	 *
	 * @param string $dir
	 */
	public function setLanguageDir( $dir ){
		$this->languageDir = $dir;
	}
}
