<?php
require_once 'bootstrap.php';
include_once( 'includes/Zipper.php' );

// Helpers
$sanitizer = new MWStew\Sanitizer( $_POST );
$templating = new MWStew\Templating();
$builder = new MWStew\Builder(
	$sanitizer->getParam( 'ext_name' ),
	$sanitizer->getParam( 'ext_display_name' )
);

$useHooksFile = false;

/* Get sanitized parameters */
$params = array(
	'name' => $builder->getName(),
	'lowername' => MWStew\Sanitizer::getKeyFormat( $builder->getName() ),
	'displayName' => $builder->getDisplayName(),
	'author' => $sanitizer->getParam( 'ext_author' ),
	'version' => strval( $sanitizer->getParam( 'ext_version' ) || '0.0.0' ),
	'license' => $sanitizer->getParam( 'ext_license' ),
	'desc' => $sanitizer->getParam( 'ext_description' ),
	'url' => $sanitizer->getParam( 'ext_url' ),
	'parts' => array(
		'javascript' => $sanitizer->getParam( 'ext_dev_js' ) !== null,
		'php' => $sanitizer->getParam( 'ext_dev_php' ) !== null,
		'specialpage' => $sanitizer->getParam( 'ext_specialpage_name' ) !== null,
	)
);

/* Build the extension zip file */

// JS Development files
if ( $sanitizer->getParam( 'ext_dev_js' ) !== null ) {
	$builder->addFile( '.jscsrc', $templating->render( '.jscsrc' ) );
	$builder->addFile( '.jshintignore', $templating->render( '.jshintignore' ) );
	$builder->addFile( '.jshintrc', $templating->render( '.jshintrc' ) );
	$builder->addFile( 'Gruntfile.js', $templating->render( 'Gruntfile.js' ) );
	$builder->addFile( 'package.json', $templating->render( 'package.json', $params ) );
	$builder->addFile( 'modules/ext.' . $builder->getName() . '.js', $templating->render( 'modules/ext.extension.js', $params ) );
	$builder->addFile( 'modules/ext.' . $builder->getName() . '.css', $templating->render( 'modules/ext.extension.css', $params ) );

	// Add unit test file
	$builder->addFile( 'tests/' . $builder->getName() . '.test.js', $templating->render( 'tests/qunit.js', $params ) );

	$useHooksFile = true;
}

// PHP Development files
if ( $sanitizer->getParam( 'ext_dev_php' ) !== null ) {
	$builder->addFile( 'composer.json', $templating->render( 'composer.json' ) );

	// Add unit test file
	$builder->addFile( 'tests/ ' . $builder->getName() . '.test.php', $templating->render( 'tests/phpunit.php', $params ) );
}

// Special page
// TODO: Allow for more than one special page
if ( $sanitizer->getParam( 'ext_specialpage_name' ) !== '' ) {
	$specialPageFullName = $sanitizer->getParam( 'ext_specialpage_name' );
	$specialPageShortName = str_replace( 'Special:', '', $specialPageFullName );
	$specialPageClassName = str_replace( ':', '', $specialPageFullName );

	$params += array(
		'specialpage' => array(
			'name' => array(
				'full' => $specialPageFullName,
				'noNamespace' => $specialPageShortName,
				'lowerNoNamespace' => MWStew\Sanitizer::getKeyFormat( $specialPageShortName ),
				'i18nKey' => 'special-' . MWStew\Sanitizer::getKeyFormat( $specialPageShortName ),
			),
			'className' => $specialPageClassName,
			'title' => $sanitizer->getParam( 'ext_specialpage_title' ),
			'intro' => $sanitizer->getParam( 'ext_specialpage_intro' ),
		),
	);

	// Special page
	$builder->addFile(
		'specials/' . $specialPageClassName . '.php',
		$templating->render( 'specials/SpecialPage.php', $params )
	);
	$builder->addFile( $builder->getName() . '.alias.php', $templating->render( 'extension.alias.php', $params ) );
}

// Hooks
$hookArray = $sanitizer->getParam( 'ext_hooks' );
if ( $hookArray !== null && count( $hookArray ) > 0 ) {
	$useHooksFile = true;
	$hooksObject = array();
	$hooksClassName = $builder->getName() . 'Hooks';

	// Build the array for extension.json
	// and for Hooks.php.twig
	foreach ( $hookArray as $hook ) {
		$hooksObject[ $hook ] = $hooksClassName . '::on' . $hook;
	}

	$params += array(
		// This is for extension.json file, to write out the 'Hooks': {}
		// object directly
		'hooksObject' => json_encode( $hooksObject, JSON_UNESCAPED_UNICODE ),
		// This is for the Hooks.php file, to include the hook subtemplates
		'hooks' => $hookArray,
	);
}

// Add the hooks file if we need to
// TODO: Make this actually conditional. This condition is commented out for now
// see comment in extension.json.twig for the explanation of why this file is
// added in to all boilerplates for the moment
// Add: if ( $useHooksFile ) { }
$builder->addFile( 'Hooks.php', $templating->render( 'Hooks.php', $params ) );

// Extension file
$builder->addFile( $builder->getName() . '.php', $templating->render( 'extension.php', $params ) );
$builder->addFile( 'extension.json', $templating->render( 'extension.json', $params ) );

// Language file
$builder->addFile( 'i18n/en.json', $templating->render( 'i18n/en.json', $params ) );
$builder->addFile( 'i18n/qqq.json', $templating->render( 'i18n/qqq.json', $params ) );

// Send to download
$zip = new MWStew\Zipper( BASE_PATH . '/temp/', $builder->getName() );
$zip->addFilesToZip( $builder->getFiles() );
$zip->download();
