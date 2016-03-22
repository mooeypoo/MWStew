<?php

namespace MWStew;

/**
 * A very simple and raw class to create translations by key: message
 * with basic support for parameters.
 */
class Message {
	protected $lang = 'en';
	protected $dir = 'ltr';
	protected $data = array();

	public function __construct( $langCode = 'en', $langDir = 'ltr' ) {
		$this->lang = $langCode ? $langCode : 'en';
		$this->dir = $langDir ? $langDir : 'ltr';

		// Load language file
		$filename = BASE_PATH . '/i18n/' . $this->lang . '.json';
		if ( !file_exists( $filename ) ) {
			// If language file doesn't exist,
			// fall back on English
			$filename = BASE_PATH . '/i18n/en.json';
		}

		try {
			$this->data = json_decode( file_get_contents( $filename ), true );
		} catch ( Exception $e ) {
			echo "Error: Could not find or open the base English language file.\n";
			echo $e->getMessage();
			die();
		}
	}

	/**
	 * Output text (do not parse html)
	 *
	 * @param string $key Message key
	 * @param Mixed... Parameters to replace in the message
	 * @return string Message in the language set up in the class, with
	 *  all parameters replaced.
	 */
	public function text( $key /* $param1, $param2, $param3 ... */) {
		// Parse parameters
		$params = func_get_args();
		// First value is the $key, so get rid of it
		array_shift( $params );

		$msg = $this->parseKeyParams( $key, $params );
		// Unparse html
		return htmlspecialchars( $msg );
	}


	/**
	 * Output html
	 *
	 * @param string $key Message key
	 * @param Mixed... Parameters to replace in the message
	 * @return string Message in the language set up in the class, with
	 *  all parameters replaced.
	 */
	public function html( $key /* $param1, $param2, $param3 ... */) {
		// Parse parameters
		$params = func_get_args();
		// First value is the $key, so get rid of it
		array_shift( $params );

		return $this->parseKeyParams( $key, $params );
	}

	/**
	 * Parse and replace
	 * @param [type] $key [description]
	 * @return [type] [description]
	 */
	protected function parseKeyParams( $key, $params ) {
		if ( !$key ) {
			return '<no key given>';
		} elseif ( !$this->keyExists( $key ) ) {
			// Message not found. Display the key
			return '<' . $key . '>';
		}

		$msg = $this->data[ $key ];
		for ( $i = 0; $i < count( $params ); $i++ ) {
			$msg = str_replace( '$' . $i, $params[ $i ], $msg );
		}
		return $msg;
	}

	protected function keyExists( $key ) {
		return isset( $this->data[ $key ] );
	}
}
