<?php
require_once 'bootstrap.php';

// OOUI
OOUI\Theme::setSingleton( new OOUI\MediaWikiTheme() );
OOUI\Element::setDefaultDir( 'ltr' );
$styles = array(
	'assets/lib/ooui/oojs-ui-mediawiki.css',
	'assets/MWStew.css'
);

require_once '_form_structure.php';
?>
<html>
	<head>
	<title>MWStew: MediaWiki Extension Boilerplate Maker</title>
<?php
	// Stylesheets
	for ( $i = 0; $i < count( $styles ); $i++ ) {
		echo '<link rel="stylesheet" href="' . $styles[$i] . '">'."\n";
	}
?>
	</head>
<body>
<?php
	// Header
	echo new MWStew\PageHeadSectionWidget( [
		'title' => 'MWStew',
		'subtitle' => 'MediaWiki extension boilerplate maker'
	] );
?>

	<div class='wrapper'>
		<?php echo $form; ?>
	</div>
</body>
</html>
