<?php
require_once "bootstrap.php";
include_once( 'includes/Zipper.php' );

// Helpers
$sanitizer = new MWStew\Sanitizer( $_POST );
$templating = new MWStew\Templating();
$builder = new MWStew\Builder( $sanitizer, $sanitizer->getParam( 'ext_name' ) );

/* Build the extension zip file */

// Extension file
$builder->addFile( $builder->getExtName() . ".php", $templating->render( 'extension', array(
	"lowername" => $builder->getLowercaseExtName(),
	"name" => $builder->getExtName(),
	"author" => $sanitizer->getParam( 'ext_author' ),
	"license" => $sanitizer->getParam( 'ext_license' ),
	"url" => $sanitizer->getParam( 'ext_url' ),
) ) );

// JS Development files
if ( $sanitizer->getParam( 'ext_dev_js' ) !== null ) {
	$builder->addFile( '.jscsrc', $templating->render( '.jscsrc' ) );
	$builder->addFile( '.jshintignore', $templating->render( '.jshintignore' ) );
	$builder->addFile( '.jshintrc', $templating->render( '.jshintrc' ) );
	$builder->addFile( 'Gruntfile.js', $templating->render( 'Gruntfile.js' ) );
	$builder->addFile( 'package.json', $templating->render( 'package.json', array(
		"name" => $builder->getExtName(),
		"version" => $sanitizer->getParam( 'ext_version' ) || '0.0.0',
	) ) );
	$builder->addFile( 'modules/ext.' . $builder->getNormalizedName() . '.js', $templating->render( 'modules/ext.extension.js', array(
		"lowername" => $builder->getLowercaseExtName(),
	) ) );
}

// Language file
$builder->addFile( 'i18n/en.json', $templating->render( 'i18n/en.json', array(
	"lowername" => $builder->getLowercaseExtName(),
	"name" => $builder->getExtName(),
	"desc" => $sanitizer->getParam( 'ext_description' ),
	"url" => $sanitizer->getParam( 'ext_url' ),
) ) );
$builder->addFile( 'i18n/qqq.json', $templating->render( 'i18n/qqq.json', array(
	"lowername" => $builder->getLowercaseExtName(),
	"name" => $builder->getExtName(),
	"url" => $sanitizer->getParam( 'ext_url' ),
) ) );

// Send to download
$zip = new MWStew\Zipper( BASE_PATH . '/temp/', $builder->getNormalizedName() );
$zip->addFilesToZip( $builder->getFiles() );
$zip->download();
