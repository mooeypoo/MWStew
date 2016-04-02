<?php

namespace MWStew;

/**
 * A very simple and raw class to create translations by key: message
 * with basic support for parameters.
 */
class Message {
	/**
	 * The language of the translation
	 * @var string
	 */
	protected $lang = 'en';

	/**
	 * Directionality of the translation
	 * @var string
	 */
	protected $dir = 'ltr';

	/**
	 * The translation data
	 * @var array
	 */
	protected $data = array();

	/**
	 * An array of RTL languages
	 * @var array
	 */
	protected $rtlLangs = array( 'he', 'ar', 'fa', 'ur', 'yi', 'ji' );

	/**
	 * Construct the message object according to the given language
	 * (or default to English). If a direction is given, it will
	 * force the default and language-default directionality.
	 *
	 * @param string $langCode Language code
	 * @param string $forceLangDir Forced language directionality.
	 *  If given, it will override any default direction.
	 */
	public function __construct( $langCode = 'en', $forceLangDir = '' ) {
		$this->lang = $langCode ? $langCode : 'en';

		// Get direction
		$this->dir = 'ltr';
		if ( in_array( $this->lang, $this->rtlLangs ) ) {
			$this->dir = 'rtl';
		}
		$this->dir = $forceLangDir ? $forceLangDir : $this->dir;

		$this->loadLangFile( $this->lang );

		if ( $this->lang !== 'en' ) {
			// Always load English for fallbacks
			$this->loadLangFile( 'en' );
		}
	}

	private function loadLangFile( $lang ) {
		// Initialize
		$this->data[ $lang ] = [];

		// Load language file
		$filename = BASE_PATH . '/i18n/' . $lang . '.json';
		if ( !file_exists( $filename ) ) {
			return;
		}

		try {
			$data = json_decode( file_get_contents( $filename ), true );
		} catch ( Exception $e ) {
			// TODO: Handle this error better...
			echo "Error: Could not find or open the base English language file.\n";
			echo $e->getMessage();
			die();
		}

		$this->data[ $lang ] = $data;
	}

	/**
	 * Get the current directionality of the translation
	 *
	 * @return string Direcitonality 'rtl' or 'ltr'
	 */
	public function getDir() {
		return $this->dir;
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
		$msg = $this->getRawMessageByKey( $key, $this->lang );

		if ( !$msg ) {
			return '<' . $key . '>';
		}

		// Replace parameters
		for ( $i = 0; $i < count( $params ); $i++ ) {
			$msg = str_replace( '$' . $i, $params[ $i ], $msg );
		}
		return $msg;
	}

	protected function getRawMessageByKey( $key, $lang = 'en' ) {

		if ( !$this->keyExists( $key, $this->lang ) ) {
			// Key doesn't exist, see if it exists in
			// the fallback English
			if ( $this->lang !== 'en' && $this->keyExists( $key, 'en' ) ) {
				return $this->data[ 'en' ][ $key ];
			} else {
				return null;
			}
		} else {
			return $this->data[ $lang ][ $key ];
		}
	}

	protected function keyExists( $key, $lang = 'en' ) {
		return isset( $this->data[ $lang ][ $key ] );
	}
}
