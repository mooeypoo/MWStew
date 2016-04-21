( function ( $ ) {
	mwstew.ui.HooksCapsuleMultiSelectWidget = function MwStewUiHooksCapsuleMultiSelectWidget( config ) {
		// Parent constructor
		mwstew.ui.HooksCapsuleMultiSelectWidget.parent.call( this, config );

		// this.connect( this, { choose: 'toggleSelectItem' } );

		this.$element
			.addClass( 'mwstew-ui-hooksCapsuleMultiSelectWidget' );
	};

	/* Initialization */
	OO.inheritClass( mwstew.ui.HooksCapsuleMultiSelectWidget, OO.ui.CapsuleMultiSelectWidget );

	mwstew.ui.HooksCapsuleMultiSelectWidget.prototype.addItems = function ( items ) {
		// Parent
		mwstew.ui.HooksCapsuleMultiSelectWidget.parent.prototype.addItems.call( this, items );
		this.emit( 'add', items );
	};
	mwstew.ui.HooksCapsuleMultiSelectWidget.prototype.removeItems = function ( items ) {
		// Parent
		mwstew.ui.HooksCapsuleMultiSelectWidget.parent.prototype.removeItems.call( this, items );
		this.emit( 'remove', items );
	};

} )( jQuery );
