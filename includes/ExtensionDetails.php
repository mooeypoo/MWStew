<?php

namespace MWStew;

class ExtensionDetails {
	public static $param_prefix = 'ext_';

	protected $name = '';
	protected $title = '';
	protected $author = '';
	protected $version = '0.0.0';
	protected $desc = '';
	protected $url = '';
	protected $license = '';

	/**
	 * Licenses we know about
	 */
	protected $knownLicenses = [ 'GPL-2.0+', 'MIT', 'Apache-2.0' ];

	protected $devEnvironment = array();

	protected $specialName = '';
	protected $specialTitle = '';
	protected $specialIntro = '';

	protected $hooks = array();

	public function __construct( $formParams ) {
		$this->rawParams = $formParams;

		$this->setName( $this->getRawParam( 'name' ) );
		$this->setTitle( $this->getRawParam( 'title' ) );
		$this->setAuthor( $this->getRawParam( 'author' ) );
		$this->setVersion( $this->getRawParam( 'version' ) );
		$this->setDescription( $this->getRawParam( 'description' ) );
		$this->setURL( $this->getRawParam( 'url' ) );
		$this->setLicense( $this->getRawParam( 'license' ) );

		$this->setDevEnv(
			$this->getRawParam( 'dev_php' ),
			$this->getRawParam( 'dev_js' )
		);

		$this->setSpecialPage(
			$this->getRawParam( 'specialpage_name' ),
			$this->getRawParam( 'specialpage_title' ),
			$this->getRawParam( 'specialpage_intro' )
		);

		$this->setHooks( $this->getRawParam( 'hooks' ) );
	}

	protected function getRawParam( $paramName ) {
		return isset( $this->rawParams[ self::$param_prefix . $paramName ] ) ?
			$this->rawParams[ self::$param_prefix . $paramName ] :
			null;
	}

	public function setName( $name ) {
		$this->name = str_replace( ' ', '', Sanitizer::getFilenameFormat( $name ) );
	}

	public function setTitle( $title ) {
		$this->title = $title ? $title : $this->name;
	}

	public function setAuthor( $author ) {
		$this->author = $author;
	}

	public function setVersion( $version ) {
		$this->version = $version ? $version : '0.0.0';
	}

	public function setDescription( $desc ) {
		$this->desc = $desc;
	}

	public function setURL( $url ) {
		$this->url = $url;
	}

	public function setLicense( $license ) {
		if ( in_array( $license, $this->knownLicenses ) ) {
			$this->license = $license;
		}
	}

	public function getLicense() {
		return $this->license;
	}

	public function setDevEnv( $isPhp, $isJs ) {
		$this->devEnvironment[ 'php' ] = (bool)$isPhp;
		$this->devEnvironment[ 'js' ] = (bool)$isJs;
	}

	public function setSpecialPage( $name, $title = '', $intro = '' ) {
		$this->specialName = $name;
		$this->specialTitle = $title;
		$this->specialIntro = $intro;
	}

	public function setHooks( $hooks ) {
		$this->hooks = $hooks ? $hooks : array();
	}

	public function getName() {
		return $this->name;
	}

	public function getLowerCamelName() {
		return Sanitizer::getLowerCamelFormat( $this->name );
	}

	public function getClassName() {
		return $this->name;
	}

	public function isEnvironment( $env ) {
		return (
			isset( $this->devEnvironment[ $env ] ) ?
				$this->devEnvironment[ $env ] : false
		);
	}

	public function hasSpecialPage() {
		return ( (bool) $this->specialName );
	}

	public function getSpecialPageClassName() {
		return 'Special' . str_replace( ' ', '_', $this->specialName );
	}

	public function getHooks() {
		return $this->hooks;
	}

	protected function sanitizeHookFunctionName( $hook ) {
		$hook = str_replace( '::', ':', $hook );
		$parts = explode( ':', $hook );
		$newHook = '';

		foreach ( $parts as $p ) {
			$newHook .= ucfirst( $p );
		}

		return $newHook;
	}

	public function getAllParams() {
		$params = array(
			'name' => $this->name,
			'lowerCamelName' => $this->getLowerCamelName(),
			'title' => $this->title,
			'author' => $this->author,
			'version' => $this->version,
			'license' => $this->license,
			'desc' => $this->desc,
			'url' => $this->url,
			'parts' => array(
				'javascript' => $this->isEnvironment( 'js' ),
				'php' => $this->isEnvironment( 'php' ),
			),
			'specialpage' => array(
				'name' => array(
					'name' => $this->specialName,
					'lowerCamelName' => Sanitizer::getLowerCamelFormat( $this->specialName ),
					'i18n' => $this->getSpecialPageKeyFormat(),
				),
				'className' => $this->getSpecialPageClassName(),
				'title' => $this->specialTitle,
				'intro' => $this->specialIntro,
			),
		);

		if ( count( $this->getHooks() ) > 0 ) {
			$params[ 'hooks' ] = [];

			foreach ( $this->getHooks() as $hook ) {
				$params[ 'hooks' ][] = $hook;
			}
		}
		return $params;
	}

	public function getSpecialPageKeyFormat() {
		return 'special-' . Sanitizer::getLowerCamelFormat( $this->specialName );
	}

	/**
	 * Output extension details in the JSON format that fits
	 * extension.json schema
	 *
	 * @param  boolean $outputAsString Return a prettified json
	 *  string. Otherwise, the object is returned.
	 * @return array Extension schema
	 */
	public function getExtensionJson( $outputAsString = false ) {
		$json = [
			'name' => $this->getName(),
			'version' => $this->version,
			'author' => [ $this->author ],
			'url' => $this->url,
			'namemsg' => $this->getLowerCamelName(),
			'descriptionmsg' => $this->getLowerCamelName() . '-desc',
			'license-name' => $this->license,
			'type' => 'other',
			'manifest_version' => 1,
			'MessagesDirs' => [],
			'AutoloadClasses' => [],
		];
		$json[ 'MessagesDirs' ][ $this->getName() ] = [ 'i18n' ];

		// JavaScript
		if ( $this->isEnvironment( 'js' ) ) {
			$extModule = 'ext.' . $this->getLowerCamelName();

			$json[ 'ResourceModules' ][ $extModule ] = [
				'scripts' => [ $extModule . '.js' ],
				'styles' => [ $extModule . '.css' ],
				'messages' => [],
				'dependencies' => [],
			];

			$json[ 'ResourceFileModulePaths' ] = [
				'localBasePath' => 'modules',
				'remoteExtPath' =>  $this->getName() . '/modules',
			];
		}

		// Special Page
		if ( $this->hasSpecialPage() ) {
			$json[ 'SpecialPages' ] = [];

			$json[ 'ExtensionMessagesFiles' ][ $this->getName() . 'Alias' ] = $this->getName() . '.alias.php';

			$json[ 'SpecialPages' ][ $this->specialName ] = $this->getSpecialPageClassName();

			$json[ 'AutoloadClasses' ][ $this->getSpecialPageClassName() ] = 'specials/' . $this->getSpecialPageClassName() . '.php';
		}

		// Hooks
		$hookClassName = $this->getName() . 'Hooks';
		if ( $this->isEnvironment( 'js' ) || count( $this->getHooks() ) ) {
			$json[ 'AutoloadClasses' ][ $hookClassName ] = 'Hooks.php';
		}

		// Hook list
		if ( count( $this->getHooks() ) > 0 ) {
			$json[ 'Hooks' ] = [];

			foreach ( $this->getHooks() as $hook ) {
				$json[ 'Hooks' ][ $hook ] = [ $hookClassName . '::on' . $this->sanitizeHookFunctionName( $hook ) ];
			}

		}
		if ( $this->isEnvironment( 'js' ) ) {
			if ( !isset( $json[ 'Hooks' ] ) ) {
				$json[ 'Hooks' ] = [];
			}

			$json[ 'Hooks' ][ 'ResourceLoaderTestModules' ] = [
				$this->getName() . 'Hooks::onResourceLoaderTestModules'
			];
		}

		return $outputAsString ?
			json_encode( $json, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE ) :
			$json;
	}

	/**
	 * Get the content of the language file in json format.
	 *
	 * @param string $type The file type; 'lang' for a language file
	 *  and 'doc' for the qqq file.
	 * @param  boolean [$outputAsString=true] Return a prettified json
	 *  string. Otherwise, the object is returned.
	 * @return array language file schema
	 */
	public function getLangFileJson( $type = 'lang', $outputAsString = true ) {
		$lang = [
			'@metadata' => [ 'authors' => [ $this->author ] ]
		];

		$lang[ $this->getLowerCamelName() ] = $type == 'lang' ?
			$this->title :
			'The name of the extension';

		$lang[ $this->getLowerCamelName() . '-desc' ] = $type == 'lang' ?
			$this->desc :
			'{{desc|name=' . $this->getName() . '|url=' . $this->url . '}}';

		if ( $this->hasSpecialPage() ) {
			$lang[ $this->getSpecialPageKeyFormat() . '-intro' ] = $type == 'lang' ?
				$this->specialTitle :
				'Description appearing on top of <tvar|1>Special:{{ll|' . $this->specialName . '}}</>.';
			$lang[ $this->getSpecialPageKeyFormat() . '-title' ] = $type == 'lang' ?
				$this->specialIntro :
				'Title of the special page Special:' . $this->specialName;
		}

		return $outputAsString ?
			json_encode( $lang, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE ) :
			$lang;
	}
}
