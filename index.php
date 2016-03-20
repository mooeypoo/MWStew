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

<!-- "Fork me on github" banner !-->
<a href="https://github.com/mooeypoo/MWStew" class="mwstew-ui-forkgithub"><img style="top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/38ef81f8aca64bb9a64448d0d70f1308ef5341ab/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6461726b626c75655f3132313632312e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png"></a>

</body>
</html>
