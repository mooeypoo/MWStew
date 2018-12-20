<?php
require_once 'bootstrap.php';

// TODO: Add more translations and add some input to choose
// a language to display
$lang = isset( $_GET[ 'lang' ] ) ? $_GET[ 'lang' ] : 'en';

// Message
$msg = new MWStew\Message( $lang );
$dir = $msg->getDir();
// OOUI
OOUI\Theme::setSingleton( new OOUI\WikimediaUITheme() );
OOUI\Element::setDefaultDir( $dir );
$styles = array(
	'node_modules/oojs-ui/dist/oojs-ui-wikimediaui' . ( $dir === 'rtl' ? '.rtl.min.css' : '.min.css' ),
	'assets/MWStew' . ( $dir === 'rtl' ? '.rtl.css' : '.css' )
);

require_once '_form_structure.php';
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title><?php echo $msg->text( 'html-title' ); ?></title>
		<!-- JavaScript -->
		<script src="node_modules/jquery/dist/jquery.min.js"></script>
		<script src="node_modules/oojs/dist/oojs.jquery.min.js"></script>
		<script src="node_modules/oojs-ui/dist/oojs-ui.min.js"></script>
		<script src="node_modules/oojs-ui/dist/oojs-ui-wikimediaui.min.js"></script>
		<script src="assets/MWStew.js"></script>
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
	echo new MWStew\PageHeadSectionWidget(
		$msg,
		[
			'title' => $msg->text( 'page-title' ),
			'subtitle' => $msg->text( 'page-subtitle' ),
			'lang' => $lang,
		]
	);
?>

	<div class='wrapper'>
		<?php echo $form; ?>
	</div>

<!-- "Fork me on github" banner !-->
<a href="https://github.com/mooeypoo/MWStew" class="mwstew-ui-forkgithub"><img src="assets/images/forkme_right_darkblue_121621.png" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png"></a>

</body>
</html>
