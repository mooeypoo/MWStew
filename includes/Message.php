<?php

namespace MWStew\UI;

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
	protected $data = [];

	/**
	 * An array of RTL languages
	 * @var array
	 */
	protected $rtlLangs = [ 'he', 'ar', 'fa', 'ur', 'yi', 'ji' ];

	/**
	 * Construct the message object according to the given language
	 * (or default to English). If a direction is given, it will
	 * force the default and language-default directionality.
	 *
	 * @param string $langCode Language code
	 * @param string $forceLangDir Forced language directionality.
	 *  If given, it will override any default direction.
	 */
	public function __construct( string $langCode = 'en', string $forceLangDir = '' ) {
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

	/**
	 * @param string $lang Langage code
	 */
	private function loadLangFile( string $lang ) {
		// Initialize
		$this->data[ $lang ] = [];

		// Load language file
		$filename = dirname( __DIR__ ) . '/i18n/' . $lang . '.json';
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
	public function getDir() : string {
		return $this->dir;
	}

	/**
	 * Output text (do not parse html)
	 *
	 * @param string $key Message key
	 * @param Mixed $params,... Parameters to replace in the message
	 * @return string Message in the language set up in the class, with
	 *  all parameters replaced.
	 */
	public function text( string $key, ...$params ) : string {
		$msg = $this->parseKeyParams( $key, $params );
		// Unparse html
		return htmlspecialchars( $msg );
	}

	/**
	 * Output html
	 *
	 * @param string $key Message key
	 * @param Mixed $params,... Parameters to replace in the message
	 * @return string Message in the language set up in the class, with
	 *  all parameters replaced.
	 */
	public function html( string $key, ...$params ) : string {
		return $this->parseKeyParams( $key, $params );
	}

	/**
	 * Parse and replace
	 *
	 * @param string $key
	 * @param array $params
	 * @return string
	 */
	protected function parseKeyParams( string $key, array $params ) : string {
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

	/**
	 * Parse and replace
	 *
	 * @param string $key
	 * @param string $lang
	 * @return string
	 */
	protected function getRawMessageByKey( string $key, string $lang = 'en' ) : string {
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

	/**
	 * Parse and replace
	 *
	 * @param string $key
	 * @param string $lang
	 * @return bool
	 */
	protected function keyExists( string $key, string $lang = 'en' ) : bool {
		return isset( $this->data[ $lang ][ $key ] );
	}
}
