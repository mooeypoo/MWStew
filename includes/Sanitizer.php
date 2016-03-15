<?php

namespace MWStew;

class Sanitizer {
	protected $rawParams = array();

	public function __construct( $params ) {
		$this->rawParams = $params;
	}

	/**
	 * Get a value of a parameter out of the stored object.
	 *
	 * @param string $property Requested property
	 * @return Mixed Value of the property; null if nonexistent.
	 */
	public function getParam( $property ) {
		return isset( $this->rawParams[ $property ] ) ?
			$this->rawParams[ $property ] :
			null;
	}

	/**
	 * Get a string formatted as a key. This can
	 * be used for i18n messages or for css classes.
	 *
	 * For example:
	 * * "MyExtension" => "myExtension"
	 * * "MW Extension" => "mwExtension"
	 * * "An-Extension Something" => "anExtensionSomething"
	 *
	 * @param string $name Name to format
	 * @return string Formatted key string
	 */
	public static function getKeyFormat( $name ) {
		$normalized = preg_replace( '/[^a-zA-Z0-9]/', ' ', $name );

		$pieces = explode( ' ', $normalized );
		if ( count( $pieces ) > 1 ) {
			// Make the first word fully lowercase
			$pieces[ 0 ] = strtolower( $pieces[ 0 ] );

			// Make the rest of the words uppercase
			for ( $i = 1; $i < count( $pieces ); $i++ ) {
				$pieces[ $i ] = ucwords( $pieces[ $i ] );
			}
		} else {
			$pieces[ 0 ] = lcfirst( $pieces[ 0 ] );
		}

		// Connect it back up
		return implode( '', $pieces );
	}
}
