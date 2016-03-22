<?php
require_once 'bootstrap.php';

// TODO: Add more translations and add some input to choose
// a language to display
$lang = isset( $_GET[ 'lang' ] ) ? $_GET[ 'lang' ] : 'en';
// TODO: We should be able to infer, from a list of languages,
// the default direction. For the moment, we'll just have it
// hard-coded parameter.
$dir = isset( $_GET[ 'dir' ] ) ? $_GET[ 'dir' ] : 'ltr';

// Message
$msg = new MWStew\Message( $lang, $dir );

// OOUI
OOUI\Theme::setSingleton( new OOUI\MediaWikiTheme() );
OOUI\Element::setDefaultDir( $dir );
$styles = array(
	'assets/lib/ooui/oojs-ui-mediawiki' . ( $dir === 'rtl' ? '.rtl.css' : '.css' ),
	'assets/MWStew' . ( $dir === 'rtl' ? '.rtl.css' : '.css' )
);

require_once '_form_structure.php';
?>
<html>
	<head>
	<title><?php echo $msg->text( 'html-title' ); ?></title>
<?php
	// Stylesheets
	for ( $i = 0; $i < count( $styles ); $i++ ) {
		echo '<link rel="stylesheet" href="' . $styles[$i] . '">'."\n";
	}
?>
	</head>
<body dir="<?php echo $dir; ?>">
<?php
	// Header
	echo new MWStew\PageHeadSectionWidget( [
		'title' => $msg->text( 'page-title' ),
		'subtitle' => $msg->text( 'page-subtitle' )
	] );
?>

	<div class='wrapper'>
		<?php echo $form; ?>
	</div>

<!-- "Fork me on github" banner !-->
<a href="https://github.com/mooeypoo/MWStew" class="mwstew-ui-forkgithub"><img src="https://camo.githubusercontent.com/38ef81f8aca64bb9a64448d0d70f1308ef5341ab/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6461726b626c75655f3132313632312e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png"></a>

</body>
</html>
