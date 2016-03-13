<?php
require_once "bootstrap.php";
include_once( 'includes/Zipper.php' );

// Helpers
$sanitizer = new MWStew\Sanitizer( $_POST );
$templating = new MWStew\Templating();
$builder = new MWStew\Builder( $sanitizer, $sanitizer->getParam( 'ext_name' ) );

/* Get sanitized parameters */
$fullName = $builder->getExtName();
if ( $sanitizer->getParam( 'ext_specialpage_name' ) !== null ) {
	$specialPageFullName = $sanitizer->getParam( 'ext_specialpage_name' );
}

$params = array(
	"lowername" => $builder->getLowercaseExtName(),
	"name" => $builder->getExtName(),
	"fullName" => $sanitizer, $sanitizer->getParam( 'ext_full_name' ),
	"author" => $sanitizer->getParam( 'ext_author' ),
	"version" => strval( $sanitizer->getParam( 'ext_version' ) || "0.0.0" ),
	"license" => $sanitizer->getParam( 'ext_license' ),
	"desc" => $sanitizer->getParam( 'ext_description' ),
	"url" => $sanitizer->getParam( 'ext_url' ),
	"parts" => array(
		"javascript" => $sanitizer->getParam( 'ext_dev_js' ) !== null,
		"php" => $sanitizer->getParam( 'ext_dev_php' ) !== null,
		"specialpage" => $sanitizer->getParam( 'ext_specialpage_name' ) !== null,
	)
);

if ( isset( $sanitizer->getParam( 'ext_specialpage_name' ) ) ) {
	$params[ 'specialpage' ] = array(
		// Special page
		"special_name" => $sanitizer->getParam( 'ext_specialpage_name' ),
		"lowername" => lcfirst( $sanitizer->getParam( 'ext_specialpage_name' ) ),
		"special_name_nonamespace" => substr(
			$sanitizer->getParam( 'ext_specialpage_name' ),
			strpos( ':', $sanitizer->getParam( 'ext_specialpage_name' ) )
		),
		"special_name_class" => str_replace( ":", "", $sanitizer->getParam( 'ext_specialpage_name' ) ),
		"special_title" => $sanitizer->getParam( 'ext_specialpage_title' ),
		"special_intro" => $sanitizer->getParam( 'ext_specialpage_intro' ),
	);
}

/* Build the extension zip file */

// JS Development files
if ( $sanitizer->getParam( 'ext_dev_js' ) !== null ) {
	$builder->addFile( '.jscsrc', $templating->render( '.jscsrc' ) );
	$builder->addFile( '.jshintignore', $templating->render( '.jshintignore' ) );
	$builder->addFile( '.jshintrc', $templating->render( '.jshintrc' ) );
	$builder->addFile( 'Gruntfile.js', $templating->render( 'Gruntfile.js' ) );
	$builder->addFile( 'package.json', $templating->render( 'package.json', $params ) );
	$builder->addFile( 'modules/ext.' . $builder->getNormalizedName() . '.js', $templating->render( 'modules/ext.extension.js', $params ) );
	$builder->addFile( 'modules/ext.' . $builder->getNormalizedName() . '.css', $templating->render( 'modules/ext.extension.css', $params ) );
}

// PHP Development files
if ( $sanitizer->getParam( 'ext_dev_php' ) !== null ) {
	$builder->addFile( 'composer.json', $templating->render( 'composer.json' ) );
}

// Special page
// TODO: Allow for more than one special page
if ( $sanitizer->getParam( 'ext_specialpage_name' ) !== null ) {
	$specialPageFullName = $fullName;
	$specialPageShortName = str_replace( 'Special:', '', $specialPageFullName );
	$specialPageClassName = str_replace( 'Special', '', $specialPageFullName );

	$params += array(
		'specialpage' => array(
			'fullName' => $specialPageFullName,
			'shortName' => $specialPageShortName,
			'className' => $specialPageClassName,
			'intro' => $sanitizer->getParam( 'ext_specialpage_intro' )
		),
	);
	$builder->addFile( $builder->getNormalizedName() . ".alias.php", $templating->render( 'extension.alias.php', $params ) );
}

// Extension file
$builder->addFile( $builder->getExtName() . ".php", $templating->render( 'extension.php', $params ) );
$builder->addFile( "extension.json", $templating->render( 'extension.json', $params ) );

// Language file
$builder->addFile( 'i18n/en.json', $templating->render( 'i18n/en.json', $params ) );
$builder->addFile( 'i18n/qqq.json', $templating->render( 'i18n/qqq.json', $params ) );

// Special page
$builder->addFile(
	'specials/' . str_replace( ":", "", $params[ 'specialpage' ][ 'special_name' ] ) . '.php',
	$templating->render( 'specials/SpecialPage.php', $params['specialpage'] )
);

// Send to download
$zip = new MWStew\Zipper( BASE_PATH . '/temp/', $builder->getNormalizedName() );
$zip->addFilesToZip( $builder->getFiles() );
$zip->download();
