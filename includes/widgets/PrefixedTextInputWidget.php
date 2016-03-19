<?php

namespace MWStew;

class PrefixedTextInputWidget extends \OOUI\Widget {

	protected $prefix = null;
	protected $inputWidget = null;

	public function __construct( array $config = [] ) {
		// Parent constructor
		parent::__construct( $config );

		$wrapper = new \OOUI\Tag();
		$wrapper->addClasses( [ 'mwstew-ui-prefixedTextInputWidget-row' ] );

		if ( isset( $config['prefix' ] ) ) {
			$this->prefix = new \OOUI\LabelWidget( [
				'classes' => [ 'mwstew-ui-prefixedTextInputWidget-prefix' ],
				'label' => $config['prefix']
			] );
			// Add the prefix
			$wrapper->appendContent( $this->prefix );
		}

		$this->inputWidget = new \OOUI\TextInputWidget( array_merge( [
			'classes' => [ 'mwstew-ui-prefixedTextInputWidget-input' ],
		], $config ) );
		$wrapper->appendContent( $this->inputWidget );

		$this->appendContent( $wrapper );
		$this->addClasses( [ 'mwstew-ui-prefixedTextInputWidget' ] );
	}
}
