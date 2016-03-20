<?php
require_once 'bootstrap.php';
include_once( 'includes/Zipper.php' );

// Helpers
$sanitizer = new MWStew\Sanitizer( $_POST );
if ( !$sanitizer) {
	// Validation failed
	var_dump( $sanitizer->getErrors() );
	return;
}

$templating = new MWStew\Templating();
$details = new MWStew\ExtensionDetails( $sanitizer->getRawParams() );
$builder = new MWStew\Builder();

$useHooksFile = false;

/* Get sanitized parameters */
$params = $details->getAllParams();

/* Build the extension zip file */

// JS Development files
if ( $details->isEnvironment( 'js' ) ) {
	$builder->addFile( '.jscsrc', $templating->render( '.jscsrc' ) );
	$builder->addFile( '.jshintignore', $templating->render( '.jshintignore' ) );
	$builder->addFile( '.jshintrc', $templating->render( '.jshintrc' ) );
	$builder->addFile( 'Gruntfile.js', $templating->render( 'Gruntfile.js' ) );
	$builder->addFile( 'package.json', $templating->render( 'package.json', $params ) );
	$builder->addFile( 'modules/ext.' . $details->getName() . '.js', $templating->render( 'modules/ext.extension.js', $params ) );
	$builder->addFile( 'modules/ext.' . $details->getName() . '.css', $templating->render( 'modules/ext.extension.css', $params ) );

	// Add unit test file
	$builder->addFile( 'tests/' . $details->getName() . '.test.js', $templating->render( 'tests/qunit.js', $params ) );

	$useHooksFile = true;
}

// PHP Development files
if ( $details->isEnvironment( 'php' ) ) {
	$builder->addFile( 'composer.json', $templating->render( 'composer.json' ) );

	// Add unit test file
	$builder->addFile( 'tests/ ' . $details->getName() . '.test.php', $templating->render( 'tests/phpunit.php', $params ) );
}

// Special page
// TODO: Allow for more than one special page
if ( $details->hasSpecialPage() ) {
	// Special page
	$builder->addFile(
		'specials/' . $details->getSpecialPageClassName() . '.php',
		$templating->render( 'specials/SpecialPage.php', $params )
	);
	$builder->addFile( $details->getName() . '.alias.php', $templating->render( 'extension.alias.php', $params ) );
}

// Hooks
$hookArray = $details->getHooks();
if ( count( $hookArray ) > 0 ) {
	$useHooksFile = true;
	$hooksObject = array();
	$hooksClassName = $details->getName() . 'Hooks';

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
$builder->addFile( $details->getName() . '.php', $templating->render( 'extension.php', $params ) );
$builder->addFile( 'extension.json', $templating->render( 'extension.json', $params ) );

// Language file
$builder->addFile( 'i18n/en.json', $templating->render( 'i18n/en.json', $params ) );
$builder->addFile( 'i18n/qqq.json', $templating->render( 'i18n/qqq.json', $params ) );

// Send to download
$zip = new MWStew\Zipper( BASE_PATH . '/temp/', $details->getName() );
$zip->addFilesToZip( $builder->getFiles() );
$zip->download();
