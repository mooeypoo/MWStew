<?php

namespace MWStew;

/**
 * Class to build the hierarchical information for
 * the extension, including its symbolic names and
 * file structure.
 */
class Builder {
	protected $name = '';
	protected $displayName = '';

	protected $files = array();

	public function __construct( $extName, $extDisplayName = '' ) {

		$this->name = Sanitizer::sanitizeFilename( $extName );
		$this->displayName = $extDisplayName ? $extDisplayName : $this->name;
	}

	public function addFile( $filename, $content ) {
		$this->files[ $filename ] = $content;
	}

	public function getFiles() {
		return $this->files;
	}

	public function getName() {
		return $this->name;
	}

	public function getDisplayName() {
		return $this->displayName;
	}
}
