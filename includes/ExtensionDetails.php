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
	protected $license;

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
		$this->license = $license;
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
		return str_replace( ' ', '_', $this->specialName );
	}

	public function getHooks() {
		return $this->hooks;
	}

	public function getAllParams() {
		return array(
			'name' => $this->name,
			'lowerCamelName' => Sanitizer::getLowerCamelFormat( $this->name ),
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
					'i18n' => 'special-' . Sanitizer::getLowerCamelFormat( $this->specialName ),
				),
				'className' => $this->getSpecialPageClassName(),
				'title' => $this->specialTitle,
				'intro' => $this->specialIntro,
			),
		);
	}
}
