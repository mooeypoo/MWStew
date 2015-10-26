<?php

namespace MWStew;

class Templating {
	protected $loader = null;
	protected $twig = null;
	protected $twigPath;

	public function __construct( $twigPath = '' ) {
		if ( strlen( $twigPath ) > 0 ) {
			$this->twigPath = $twigPath;
		} else {
			$this->twigPath = BASE_PATH . '/includes/twig';
		}
		$this->loader = new \Twig_Loader_Filesystem( $this->twigPath . '/templates' );
		$this->twig = new \Twig_Environment( $this->loader, array(
			'cache' => $this->twigPath . '/cache',
		) );
	}

	public function render( $templateName, $data = array() ) {
		$filename = $templateName . '.twig';

		return $this->twig->render( $filename, $data );
	}
}
