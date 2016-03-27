<?php

namespace MWStew;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Exceptions\ValidationException;

class Sanitizer {
	protected $fieldPrefix = 'ext_';
	protected $rawParams = array();
	protected $errors = array();


	public function __construct( $params ) {
		$this->rawParams = $params;

		return !$this->validateParams();
	}

	public static function validate( $type, $value = '' ) {
		$v = self::getValidator( $type );
		try {
			$v->assert( $value );
		} catch ( ValidationException $e ) {
			return false;
		}
		return true;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function getRawParams() {
		return $this->rawParams;
	}

	/**
	 * Validate all raw parameters
	 * @return boolean Validation successful
	 */
	protected function validateParams() {
		// Reset
		$this->errors = array();

		$validators = array(
			// Names
			array(
				'validator' => $this->getValidator( 'names' ),
				'fields' => array( 'name', 'special_name' ),
				'optional' => array( 'special_name' ),
			),
			// Numbers
			array(
				'validator' => $this->getValidator( 'numbers' ),
				'fields' => array( 'version' ),
				'optional' => array( 'version' ),
			),
			// Booleans
			array(
				'validator' => $this->getValidator( 'booleans' ),
				'fields' => array( 'dev_php', 'dev_js' ),
				'optional' => array( 'dev_php', 'dev_js' ),
			),
			// URL
			array(
				'validator' => $this->getValidator( 'urls' ),
				'fields' => array( 'url' ),
				'optional' => array( 'url' ),
			),
		);

		foreach ( $validators as $v ) {
			foreach ( $v[ 'fields' ] as $field ) {
				try {
					$fieldVal = isset( $this->rawParams[ $this->fieldPrefix . $field ] ) ?
						$this->rawParams[ $this->fieldPrefix . $field ] : null;
					if ( in_array( $field, $v[ 'optional' ] ) ) {
						v::optional( $v[ 'validator' ] )->assert( $fieldVal );
					} else {
						$v[ 'validator' ]->assert( $fieldVal );
					}
				} catch ( NestedValidationException $exception ) {
					$this->errors[ $field ] = $exception->getMessages();
				}
			}
		}
		return count( $this->errors ) === 0;
	}

	protected static function getValidator( $name ) {
		$validators = array(
			'names' => v::alnum('_-')->noWhitespace()->length(1,32),
			'numbers' => v::numeric(),
			'booleans' => v::trueVal(),
			'urls' => v::url()
		);
		return isset( $validators[ $name ] ) ?
			$validators[ $name ] : null;
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
	 * Sanitizes a string that will be in a folder or filename
	 * structure, removes illegal or "dangerous" characters
	 *
	 * @param string $name Extension name
	 * @return string Sanitizes extension name
	 */
	public static function getFilenameFormat( $name ) {
		return preg_replace( "/[^a-zA-Z0-9_-]/", "", $name );
	}

	/**
	 * Get a string formatted as a key. This can
	 * be used for i18n messages or for css classes.
	 *
	 * For example:
	 * * 'MyExtension' => 'myExtension'
	 * * 'MW Extension' => 'mwExtension'
	 * * 'An-Extension Something' => 'anExtensionSomething'
	 *
	 * @param string $name Name to format
	 * @return string Formatted key string
	 */
	public static function getLowerCamelFormat( $name ) {
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
