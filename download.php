<?php
require_once './vendor/autoload.php';

function getValueIfExists( string $key ) : ?string {
	if ( isset( $_POST[$key] ) ) {
		return $_POST[$key];
	}
	return null;
}

$extName = getValueIfExists( 'ext_name' );
$data = [
	'name' => $extName,
	'author' => getValueIfExists( 'ext_author' ),
	'title' => getValueIfExists( 'ext_display_name' ),
	'description' => getValueIfExists( 'ext_description' ),
	'version' => getValueIfExists( 'ext_version' ),
	'url' => getValueIfExists( 'ext_url' ),
	'license' => getValueIfExists( 'ext_license' ),
	'specialpage_name' => getValueIfExists( 'ext_specialpage_name' ),
	'specialpage_title' => getValueIfExists( 'ext_specialpage_title' ),
	'specialpage_intro' => getValueIfExists( 'ext_specialpage_intro' ),
];

if ( getValueIfExists( 'ext_dev_js' ) ) {
	$data['dev_js'] = '1';
}
if ( getValueIfExists( 'ext_dev_php' ) ) {
	$data['dev_php'] = '1';
}

// Build extension files
try {
	$generator = new MWStew\Builder\Generator( $data, [ 'cacheDir' => './cache' ] );
} catch ( Exception $e ) {
	// TODO: Display a proper error page!
	echo json_encode( [
		'status' => 'error',
		'errors' => $e->getMessage()
	] );
	return;
}

// Send to download
$zip = new MWStew\Builder\Zipper( __DIR__ . '/temp/', $extName );
$zip->addFilesToZip( $generator->getFiles() );
$zip->download();
