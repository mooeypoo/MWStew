<?php

namespace MWStew;

class DescriptionFieldLayout extends \OOUI\FieldLayout {
	public function __construct( $fieldWidget, array $config = [] ) {

		$label = new \OOUI\Tag( 'div' );
		$label->addClasses( [ 'mwstew-ui-descriptionFieldLayout-label' ] );

		if ( isset( $config[ 'link' ] ) ) {
			$link = new \OOUI\ButtonWidget( [
				'framed' => false,
				// We don't usually specify a target to
				// a new tab, but in this case, accidentally
				// clicking the link can take the user
				// away from the filled form, which can be
				// a huge pain.
				'target' => '_blank',
				'classes' => [ 'mwstew-ui-descriptionFieldLayout-label-link' ],
				'icon' => 'info',
				'href' => $config[ 'link' ],
			] );

			$label->appendContent( $link );
		}

		$title = new \OOUI\LabelWidget( [
			'classes' => [ 'mwstew-ui-descriptionFieldLayout-label-title' ],
		] );
		if ( isset( $config[ 'label' ] ) ) {
			// Rebuild the label
			$title = new \OOUI\LabelWidget( [
				'classes' => [ 'mwstew-ui-descriptionFieldLayout-label-title' ],
				'label' => $config[ 'label' ],
			] );
			$label->appendContent( $title );
		}

		if ( isset( $config[ 'description' ] ) ) {
			$desc = new \OOUI\LabelWidget( [
				'classes' => [ 'mwstew-ui-descriptionFieldLayout-label-desc' ],
				'label' => $config[ 'description' ],
			] );
			$label->appendContent( $desc );
		}

		parent::__construct( $fieldWidget, array_merge(
			$config,
			[
				'label' => $label
			]
		) );

		$this->field->addClasses( [ 'mwstew-ui-descriptionFieldLayout-field' ] );

		$this->addClasses( [ 'mwstew-ui-descriptionFieldLayout' ] );
	}
}
