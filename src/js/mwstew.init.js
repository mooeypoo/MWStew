( function ( $ ) {
	$( document ).ready( function () {
		var section, hook, hookItem, sectionItems,
			selectWidget,
			hooksFieldsetLayout, hooksCapsuleWidget,
			hookItems = [];

		$( '*[ data-ooui ]' ).each( function () {
			OO.ui.infuse( this.id );
		} );

		// i18n
		i18nFiles = {
			// Fallback language; always load English
			en: 'i18n/en.json'
		};
		if ( mwstewData.lang !== 'en' ) {
			i18nFiles[ mwstewData.lang ] = 'i18n/' + mwstewData.lang + '.json';
		}
		// $.i18n().load( i18nFiles );
		$.i18n().load( i18nFiles );
		if ( mwstewData.lang !== 'en' ) {
			$.i18n().locale = 'en';
		} else {
			$.i18n().locale = mwstewData.lang;
		}

		// Hooks
		if ( mwstewData.hooks && Object.keys( mwstewData.hooks ).length > 0 ) {
			hooksCapsuleWidget = new mwstew.ui.HooksCapsuleMultiSelectWidget( {
				allowArbitrary: false
			} );
			hooksFieldsetLayout = new OO.ui.FieldsetLayout( {
				items: [ hooksCapsuleWidget ]
			} );
			for ( section in mwstewData.hooks ) {
				hooksFieldsetLayout.addItems( [ new OO.ui.LabelWidget( {
					// TODO: Before merging this with master, make
					// sure i18n lib in JS is working so we can use
					// the proper messages here
					label: $.i18n( 'form-section-hooks-' + section ),
					classes: [ 'mwstew-ui-form-hooks-subsection' ]
				} ) ] );
				selectWidget = new mwstew.ui.HooksSelectWidget( hooksCapsuleWidget );
				for ( hook in mwstewData.hooks[ section ] ) {
					selectWidget.addItems( [ new mwstew.ui.HookItemOptionWidget(
						hook,
						{
							data: hook,
							description: mwstewData.hooks[ section ][ hook ]
						}
					) ] );
					hookItems.push( new OO.ui.OptionWidget( {
						data: hook,
						label: hook
					} ) );
				}
				hooksFieldsetLayout.addItems( [ selectWidget ] );
			}

			hooksCapsuleWidget.getMenu().addItems( hookItems );

			$( '.mwstew-ui-form-fieldset-hooks' ).remove();
			hooksFieldsetLayout.$element
				.insertAfter( '.mwstew-ui-form-section-hooks' );
		}
	} );
} )( jQuery );
