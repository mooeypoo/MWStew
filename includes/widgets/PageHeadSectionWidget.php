<?php

namespace MWStew;

class PageHeadSectionWidget extends \OOUI\Widget {
	public function __construct( $msg, array $config = [] ) {
		// Parent constructor
		parent::__construct( $config );

		$langSelector = new \OOUI\DropdownInputWidget( array(
			'infusable' => true,
			'name' => 'lang',
			'options' => [
				array( 'data' => 'en', 'label' => 'English' ),
				array( 'data' => 'he', 'label' => 'Hebrew' ),
			],
			'classes' => [ 'mwstew-ui-pageHeadSectionWidget-langSelectorForm-input' ],
		) );
		if ( isset( $config[ 'lang' ] ) ) {
			$langSelector->setValue( $config[ 'lang' ] );
		}

		$languageForm = new \OOUI\FormLayout( array(
			'method' => 'get',
			'action' => 'index.php',
			'classes' => [ 'mwstew-ui-pageHeadSectionWidget-langSelectorForm' ],
		) );

		// Language selector
		$languageForm->addItems( [
			new \OOUI\ActionFieldLayout(
				// Input
				$langSelector,
				// Button
				new \OOUI\ButtonInputWidget( [
					'label' => $msg->text( 'lang-selector-submit' ),
					'type' => 'submit',
				] )
			)
		] );

		// Title
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

		$this->appendContent( $languageForm, $titleWrapper );
		$this->addClasses( [ 'mwstew-ui-pageHeadSectionWidget' ] );
	}
}
