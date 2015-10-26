<?php

namespace MWStew;

class Sanitizer {
	protected $rawParams = array();

	public function __construct( $params ) {
		$this->rawParams = $params;
	}

	public function getParam( $property ) {
		if ( isset( $this->rawParams[ $property ] ) ) {
			return $this->rawParams[ $property ];
		}
		return null;
	}
}