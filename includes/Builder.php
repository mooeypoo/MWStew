<?php

namespace MWStew;

class Builder {
	protected $rawName = '';
	protected $normalizedExtName = '';
	protected $extName = '';

	protected $sanitizer = null;

	protected $files = array();

	public function __construct( $sanitizer, $extName ) {
		$this->sanitizer = $sanitizer;

		$this->rawName = $extName;
		$this->normalizedExtName = str_replace( ' ', '', $sanitizer->getParam( 'ext_name' ) );
		$this->extName = ucwords( $this->normalizedExtName );
	}

	public function addFile( $filename, $content ) {
		$this->files[ $filename ] = $content;
	}

	public function getFiles() {
		return $this->files;
	}

	public function getRawName() {
		return $this->rawName;
	}

	public function getNormalizedName() {
		return $this->normalizedExtName;
	}

	public function getExtName() {
		return $this->extName;
	}

	public function getLowercaseExtName() {
		return lcfirst( $this->extName );
	}
}