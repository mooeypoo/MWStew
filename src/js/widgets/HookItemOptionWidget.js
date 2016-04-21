( function ( $ ) {
	mwstew.ui.HookItemOptionWidget = function MwStewUiHookItemOptionWidget( name, config ) {
		var $name = $( '<div>' )
				.addClass( 'mwstew-ui-hookItemOptionWidget-name' ),
			$description = $( '<div>' )
				.addClass( 'mwstew-ui-hookItemOptionWidget-description' );

		// Parent constructor
		mwstew.ui.HookItemOptionWidget.parent.call( this, config );

		$name.text( name );
		this.$element.append( $name );

		if ( config.description ) {
			$description.text( config.description );
			this.$element.append( $description );
		}

		this.$element
			.addClass( 'mwstew-ui-hookItemOptionWidget' );
	};

	/* Initialization */
	OO.inheritClass( mwstew.ui.HookItemOptionWidget, OO.ui.DecoratedOptionWidget );
} )( jQuery );
