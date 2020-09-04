<?php
require_once './vendor/autoload.php';

// TODO: Add more translations and add some input to choose
// a language to display
$lang = isset( $_GET[ 'lang' ] ) ? $_GET[ 'lang' ] : 'en';

// Message
$msg = new MWStew\UI\Message( $lang );
$dir = $msg->getDir();
$styles = [
	// 'node_modules/oojs-ui/dist/oojs-ui-wikimediaui' . ( $dir === 'rtl' ? '.rtl.min.css' : '.min.css' ),
	'assets/MWStew' . ( $dir === 'rtl' ? '.rtl.css' : '.css' ),
	'assets/bootstrap' . ( $dir === 'rtl' ? '.rtl.css' : '.min.css' ),
];

// require_once '_form_structure.php';
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../../../../favicon.ico">

		<title><?php echo $msg->text( 'html-title' ); ?></title>

		<!-- Custom styles for this template -->
		<!-- <link href="form-validation.css" rel="stylesheet"> -->
		<?php
			// Stylesheets
			for ( $i = 0; $i < count( $styles ); $i++ ) {
				echo '<link rel="stylesheet" href="' . $styles[$i] . '">'."\n";
			}
		?>
	</head>
	<body class="bg-light" dir="<?php echo $dir; ?>">

		<div class="mwstew-ui-language">
			<form class="form-inline" action="index.php" method="get">
			<select class="custom-select mb-2 mr-sm-2" id="lang" name="lang">
				<?php
					// TODO: Use ULS
					$langoptions = [
						'en' => 'English',
						'he' => 'Hebrew',
					];

					foreach ( $langoptions as $code => $label ) {
						$selected = $code === $lang ? 'selected' : '';
						echo '<option value="' . $code . '" ' . $selected . '>' . $label . '</option>';
					}
				?>
			</select>
			<button type="submit" class="btn btn-secondary mb-2"><?php echo $msg->text( 'lang-selector-submit' ); ?></button>
		</form>
		</div>

		<form class="mwstew-ui-form" action="download.php" method="POST">

		<div class="container">
			<div class="py-5 text-center">
				<h2><?php echo $msg->text( 'page-title' ); ?></h2>
				<p class="lead"><?php echo $msg->text( 'page-subtitle' ); ?></p>
			</div>


			<div class="row">
				<!-- <div class="col-md-4 order-md-2 mb-4">
					<div class="mwstew-ui-summary">
						<h4 class="d-flex justify-content-between align-items-center mb-3">
							<span class="text-muted">Your extension</span>
							<span class="badge badge-secondary badge-pill">3</span>
						</h4>
					</div>
				</div> -->

				<div class="col-md-12 order-md-1">
<?php
	$requiredSpan = '<span class="badge badge-pill badge-warning">' . $msg->text( 'form-required-field' ) . '</span>';
	// Define form sections
	$sections = [
		'general' => [
			'label' => $msg->text( 'form-section-general-label' ),
			'items' => [
				'ext_name' => [
					'required' => true,
					'label' => $msg->text( 'form-general-field-name-label' ),
					'placeholder' => 'MyMWExtension',
					'type' => 'text'
				],
				'ext_display_name' => [
					'label' => $msg->text( 'form-general-field-title-label' ),
					'placeholder' => $msg->text( 'form-general-field-title-placeholder' ),
					'type' => 'text'
				],
				'ext_author' => [
					'label' => $msg->text( 'form-general-field-author-label' ),
					'placeholder' => $msg->text( 'form-general-field-author-placeholder' ),
					'type' => 'text'
				],
				'ext_version' => [
					'label' => $msg->text( 'form-general-field-version-label' ),
					'placeholder' => '0.0.0',
					'type' => 'text'
				],
				'ext_description' => [
					'label' => $msg->text( 'form-general-field-desc-label' ),
					'placeholder' => $msg->text( 'form-general-field-desc-placeholder' ),
					'type' => 'text'
				],
				'ext_url' => [
					'label' => $msg->text( 'form-general-field-url-label' ),
					'placeholder' => 'https://www.mediawiki.org/wiki/Extension:YourExtension',
					'type' => 'text'
				],
				'ext_license' => [
					'label' => $msg->text( 'form-general-field-license-label' ),
					'type' => 'select',
					'options' => [
						[ 'value' => 'GPL-2.0+', 'label' => 'GPL v2 or later' ],
						[ 'value' => 'MIT', 'label' => 'MIT' ],
						[ 'value' => 'Apache-2.0', 'label' => 'Apache 2' ],
					]
				]
			],
		],
		'devenv' => [
			'label' => $msg->text( 'form-section-devenv-label' ),
			'items' => [
				'ext_dev_php' => [
					'label' => $msg->text( 'form-devenv-field-php-label' ),
					'type' => 'checkbox',
				],
				'ext_dev_js' => [
					'label' => $msg->text( 'form-devenv-field-js-label' ),
					'type' => 'checkbox',
				]
			]
		],
		'special' => [
			'label' => $msg->text( 'form-section-specialpage-label' ),
			'items' => [
				'ext_specialpage_name' => [
					'type' => 'prefixed-text',
					'label' => $msg->text( 'form-specialpage-field-name-label' ),
					'placeholder' => 'MyExtensionPage',
					'prefix' => $msg->text( 'form-specialpage-field-name-prefix' ),
				],
				'ext_specialpage_title' => [
					'type' => 'text',
					'label' => $msg->text( 'form-specialpage-field-title-label' ),
					'placeholder' => $msg->text( 'form-general-field-title-placeholder' ),
				],
				'ext_specialpage_intro' => [
					'type' => 'textarea',
					'label' => $msg->text( 'form-specialpage-field-intro-label' ),
				],
			]
		],
	];

	foreach ( $sections as $sName => $sData ) {
?>
		<h4 class="mb-3"><?php echo $sData['label']; ?></h4>
<?php
		foreach ( $sData['items'] as $itemName => $itemData ) {
?>
			<div class="mb-3">
<?php
if ( $itemData['type'] === 'text' ) {
?>
				<label for="<?php echo $itemName; ?>">
					<?php echo $itemData[ 'label' ]; ?>
					<?php echo $itemData[ 'required' ] ? $requiredSpan : '' ?>
				</label>
				<input
					type="text"
					class="form-control"
					id="<?php echo $itemName; ?>"
					name="<?php echo $itemName; ?>"
					placeholder="<?php echo $itemData[ 'placeholder' ]; ?>"
					<?php echo $itemData[ 'required' ] ? 'required' : '' ?>
				>
<?php
} else if ( $itemData['type'] === 'select' ) {
?>
			<label for="<?php echo $itemName; ?>">
				<?php echo $itemData[ 'label' ]; ?>
				<?php echo $itemData[ 'required' ] ? $requiredSpan : '' ?>
			</label>
			<select
				class="form-control"
				id="<?php echo $itemName; ?>"
				name="<?php echo $itemName; ?>"
				<?php echo $itemData[ 'required' ] ? 'required' : '' ?>
			>
<?php
			foreach ( $itemData[ 'options' ] as $opt ) {
				echo "<option value='" . $opt['value'] . "'>" . $opt['label'] . "</option>";
			}
?>
			</select>
<?php
} else if ( $itemData['type'] === 'checkbox' ) {
?>
			<div class="custom-control custom-checkbox">
				<input
					class="custom-control-input"
					type="checkbox"
					id="<?php echo $itemName; ?>"
					name="<?php echo $itemName; ?>"
					value="1"
					<?php echo $itemData[ 'required' ] ? 'required' : '' ?>
				>
				<label class="custom-control-label" for="<?php echo $itemName; ?>">
					<?php echo $itemData[ 'label' ]; ?>
					<?php echo $itemData[ 'required' ] ? $requiredSpan : '' ?>
				</label>
			</div>
<?php
} else if ( $itemData['type'] === 'prefixed-text' ) {
?>
			<label class="sr-only" for="<?php echo $itemName; ?>">
				<?php echo $itemData[ 'label' ]; ?>
				<?php echo $itemData[ 'required' ] ? $requiredSpan : '' ?>
			</label>
			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<div class="input-group-text"><?php echo $itemData[ 'prefix' ]; ?></div>
				</div>
				<input
					type="text"
					class="form-control"
					id="<?php echo $itemName; ?>"
					name="<?php echo $itemName; ?>"
					placeholder="<?php echo $itemData[ 'placeholder' ]; ?>"
					<?php echo $itemData[ 'required' ] ? 'required' : '' ?>
				>
			</div>
<?php
} else if ( $itemData['type'] === 'textarea' ) {
?>
	<div class="form-group">
		<label for="<?php echo $itemName; ?>">
			<?php echo $itemData[ 'label' ]; ?>
			<?php echo $itemData[ 'required' ] ? $requiredSpan : '' ?>
		</label>
		<textarea
			class="form-control"
			id="<?php echo $itemName; ?>"
			name="<?php echo $itemName; ?>"
			placeholder="<?php echo $itemData[ 'placeholder' ]; ?>"
			rows="3"
			<?php echo $itemData[ 'required' ] ? 'required' : '' ?>
		></textarea>
	</div>
<?php
}
?>
				<!-- <div class="invalid-feedback">
					Please enter your shipping address.
				</div> -->
			</div>
<?php
		}
		echo '<hr class="mb-4">';
	}
?>
				</div>

				</div>
			</div>

			<div class="mwstew-ui-floating-button">
				<button class="btn btn-primary btn-lg btn-block" type="submit"><?php echo $msg->text( 'form-submit-label' ); ?></button>
			</div>
		</form>

			<footer class="my-5 pt-5 text-muted text-center text-small">
				<p class="mb-1">Please contribute and submit bug reports!</p>
				<ul class="list-inline">
					<li class="list-inline-item"><a href="https://github.com/mooeypoo/MWStew">Code on Github</a></li>
					<li class="list-inline-item">Licensed under <a href="https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html">GPL-v2</a></li>
				</ul>
			</footer>
		</div>

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="assets/jquery.3.3.1.slim.min.js"></script>
		<script src="assets/bootstrap.min.js"></script>
		<script src="assets/MWStew.js"></script>
		<!-- <script src="../../assets/js/vendor/popper.min.js"></script>
		<script src="../../assets/js/vendor/holder.min.js"></script> -->
	</body>
</html>
