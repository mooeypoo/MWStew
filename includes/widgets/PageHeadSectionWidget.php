<?php

namespace MWStew;

class PageHeadSectionWidget extends \OOUI\Widget {
	public function __construct( array $config = [] ) {
		// Parent constructor
		parent::__construct( $config );

		$titleWrapper = new \OOUI\Tag();
		$titleWrapper->addClasses( [ 'mwstew-ui-pageHeadSectionWidget-title' ] );

		if ( $config[ 'title' ] ) {
			$title = new \OOUI\LabelWidget( [
				'label' => $config[ 'title' ],
				'classes' => [ 'mwstew-ui-pageHeadSectionWidget-title-main' ]
			] );
			$titleWrapper->appendContent( $title );

		}
		if ( $config[ 'subtitle' ] ) {
			$subtitle = new \OOUI\LabelWidget( [
				'label' => $config[ 'subtitle' ],
				'classes' => [ 'mwstew-ui-pageHeadSectionWidget-title-sub' ]
			] );
			$titleWrapper->appendContent( $subtitle );
		}

		$this->appendContent( $titleWrapper );
		$this->addClasses( [ 'mwstew-ui-pageHeadSectionWidget' ] );
	}
}
