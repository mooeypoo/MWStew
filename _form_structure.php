<?php

// Extension details
$extDetailsFieldsetLayout = new OOUI\FieldsetLayout( array(
	'label' => $msg->text( 'form-section-general-label' ),
	'classes' => array( 'mwstew-ui-form-fieldsets-general' ),
	'items' => array(
		// Name
		new OOUI\FieldLayout(
			new OOUI\TextInputWidget( array(
				'placeholder' => 'MyMWExtension',
				'required' => true,
				'name' => 'ext_name',
			) ),
			array(
				'label' => $msg->text( 'form-general-field-name-label' ),
				// 'help' => 'Your extension name. Cannot have spaces.',
				'align' => 'left',
			)
		),
		// title
		new OOUI\FieldLayout(
			new OOUI\TextInputWidget( array(
				'placeholder' => $msg->text( 'form-general-field-title-placeholder' ),
				'name' => 'ext_display_name',
			) ),
			array(
				'label' => $msg->text( 'form-general-field-title-label' ),
				// 'help' => 'Your extension human-readable name.',
				'align' => 'left',
			)
		),
		// Author
		new OOUI\FieldLayout(
			new OOUI\TextInputWidget( array(
				'placeholder' => $msg->text( 'form-general-field-author-placeholder' ),
				'required' => true,
				'name' => 'ext_author',
			) ),
			array(
				'label' => $msg->text( 'form-general-field-author-label' ),
				// 'help' => 'Tell us who the author is. This will be public; you can use your real name or the username people know you by.',
				'align' => 'left',
			)
		),
		// Version
		new OOUI\FieldLayout(
			new OOUI\TextInputWidget( array(
				'placeholder' => '0.0.0',
				'name' => 'ext_version',
			) ),
			array(
				'label' => $msg->text( 'form-general-field-version-label' ),
				// 'help' => 'The version of this extension. Defaults to 0.0.0'
				'align' => 'left',
			)
		),
		// Description
		new OOUI\FieldLayout(
			new OOUI\TextInputWidget( array(
				'placeholder' => $msg->text( 'form-general-field-desc-placeholder' ),
				'multiline' => true,
				'rows' => 3,
				'name' => 'ext_description',
			) ),
			array(
				'label' => $msg->text( 'form-general-field-desc-label' ),
				// 'help' => 'Describe what your extension does.'
				'align' => 'left',
			)
		),
		// URL
		new OOUI\FieldLayout(
			new OOUI\TextInputWidget( array(
				'placeholder' => 'https://www.mediawiki.org/wiki/Extension:YourExtension',
				'name' => 'ext_url',
			) ),
			array(
				'label' => $msg->text( 'form-general-field-url-label' ),
				// 'help' => 'A URL for the extension details.',
				'align' => 'left',
			)
		),
		// License
		new OOUI\FieldLayout(
			// new OOUI\RadioSelectInputWidget( array(
			new OOUI\DropdownInputWidget( array(
				// 'placeholder' => 'Your extension license',
				'required' => true,
				'name' => 'ext_license',
				'options' => array(
					array( 'data' => 'MIT', 'label' => 'MIT' ),
					array( 'data' => 'GPL-2.0', 'label' => 'GPL v2' ),
					array( 'data' => 'GPL-2.0+', 'label' => 'GPL v2 and above' ),
					array( 'data' => 'GPL-3.0', 'label' => 'GPL v3' ),
					array( 'data' => 'GPL-3.0+', 'label' => 'GPL v3 and above' ),
					array( 'data' => 'LGPL-2.0', 'label' => 'LGPL v2' ),
					array( 'data' => 'LGPL-2.0+', 'label' => 'LGPL v2 and above' ),
					array( 'data' => 'LGPL-3.0', 'label' => 'LGPL v3' ),
				)
			) ),
			array(
				'label' => $msg->text( 'form-general-field-license-label' ),
				// 'help' => 'Choose an extension license. MIT License is prefered; all extensions should be open source license.',
				'align' => 'left',
			)
		),
	),
) );

// Extension development details
$extDevelopmentFieldsetLayout = new OOUI\FieldsetLayout( array(
	'label' => $msg->text( 'form-section-devenv-label' ),
	'classes' => array( 'mwstew-ui-form-fieldset-development' ),
	'items' => array(
		// PHP Development
		new OOUI\FieldLayout(
			new OOUI\CheckboxInputWidget( array(
				'name' => 'ext_dev_php',
				'value' => 1,
			) ),
			array(
				'label' => $msg->text( 'form-devenv-field-php-label' ),
				'align' => 'inline',
				'help' => 'Select if your extension has PHP pieces, to add PHP development tools.',
			)
		),
		// Javascript Development
		new OOUI\FieldLayout(
			new OOUI\CheckboxInputWidget( array(
				'name' => 'ext_dev_js',
				'value' => 1,
			) ),
			array(
				'label' => $msg->text( 'form-devenv-field-js-label' ),
				'align' => 'inline',
				'help' => 'Select if your extension has JavaScript modules, to add JavaScript development tools.',
			)
		)
	)
) );

// Special page
$extSpecialPageFieldsetLayout = new OOUI\FieldsetLayout( array(
	'label' => $msg->text( 'form-section-specialpage-label' ),
	'classes' => array( 'mwstew-ui-form-fieldsets-specialpage' ),
	'items' => array(
		// Name
		new OOUI\FieldLayout(
			new MWStew\PrefixedTextInputWidget( array(
				'placeholder' => 'MyExtensionPage',
				'name' => 'ext_specialpage_name',
				'prefix' => $msg->text( 'form-specialpage-field-name-prefix' ),
			) ),
			array(
				'label' => $msg->text( 'form-specialpage-field-name-label' ),
				'align' => 'left',
			)
		),
		// Title
		new OOUI\FieldLayout(
			new OOUI\TextInputWidget( array(
				'placeholder' => $msg->text( 'form-general-field-title-placeholder' ),
				'name' => 'ext_specialpage_title',
			) ),
			array(
				'label' => $msg->text( 'form-specialpage-field-title-label' ),
				'align' => 'left',
			)
		),
		// Text
		new OOUI\FieldLayout(
			new OOUI\TextInputWidget( array(
				'placeholder' => $msg->text( 'form-specialpage-field-intro-placeholder' ),
				'name' => 'ext_specialpage_intro',
				'multiline' => true,
				'rows' => 3
			) ),
			array(
				'label' => $msg->text( 'form-specialpage-field-intro-label' ),
				'align' => 'left',
			)
		),
	)
) );

// Extension hooks
$hooks = json_decode( file_get_contents( 'includes/data/hooks.json' ), true );
$hookFieldsets = array();
foreach ( $hooks as $section => $list ) {
	$hookFields = array();
	foreach ( $list as $hook => $desc ) {
		$hookFields[] = new OOUI\FieldLayout(
			new OOUI\CheckboxInputWidget( array(
				'name' => 'ext_hooks[]',
				'value' => $hook,
			) ),
			array(
				'label' => $hook,
				'align' => 'inline',
				'help' => $desc,
			)
		);
	}
	// Hooks
	$hookFieldsets[] = new OOUI\FieldsetLayout( array(
		'label' => $msg->text( 'form-section-hooks-' . $section ),
		'classes' => array( 'mwstew-ui-form-fieldset-hooks' ),
		'items' => $hookFields,
	) );
}

// Form
$form = new OOUI\FormLayout( array(
	'method' => 'post',
	'action' => 'download.php',
	'classes' => array( 'mwstew-ui-form' )
) );

// Submit button
$submitFieldsetLayout = new OOUI\FieldsetLayout( array(
	'classes' => array( 'mwstew-ui-form-fieldsets-submit' ),
	'items' => array(
		new OOUI\ButtonInputWidget( array(
			'label' => $msg->text( 'form-submit-label' ),
			'classes' => array( 'mwstew-ui-form-fieldsets-submit-button' ),
			'type' => 'submit',
			'flags' => array( 'primary', 'progressive' ),
		) )
	),
) );

// Build the form
$form->addItems( array(
	$extDetailsFieldsetLayout,
	$extDevelopmentFieldsetLayout,
	$extSpecialPageFieldsetLayout,
	$submitFieldsetLayout,
) );

// Hooks
$form->addItems( array(
	new OOUI\LabelWidget( [
		'label' => $msg->text( 'form-section-hooks-label' ),
		'classes' => array( 'mwstew-ui-form-section' ),
	] )
) );
$form->addItems( $hookFieldsets );
$form->addItems( array(
	$submitFieldsetLayout,
) );
