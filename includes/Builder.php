<?php

namespace MWStew;

/**
 * Class to build the hierarchical file information
 * for the extension.
 */
class Builder {
	protected $files = array();

	public function addFile( $filename, $content ) {
		$this->files[ $filename ] = $content;
	}

	public function getFiles() {
		return $this->files;
	}
}
