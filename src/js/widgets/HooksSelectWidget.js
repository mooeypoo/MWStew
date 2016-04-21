( function ( $ ) {
	mwstew.ui.HooksSelectWidget = function MwStewUiHooksSelectWidget( capsuleWidget, config ) {
		// Parent constructor
		mwstew.ui.HooksSelectWidget.parent.call( this, config );

		this.capsuleWidget = capsuleWidget;

		this.connect( this, { choose: 'onChoose' } );
		this.capsuleWidget.connect( this, {
			add: 'onCapsuleWidgetAdd',
			remove: 'onCapsuleWidgetRemove'
		} );

		this.$element
			.addClass( 'mwstew-ui-hookSelectWidget' );
	};

	/* Initialization */
	OO.inheritClass( mwstew.ui.HooksSelectWidget, OO.ui.SelectWidget );

	/* Methods */
	mwstew.ui.HooksSelectWidget.prototype.onCapsuleWidgetAdd = function ( items ) {
		this.toggleItemsSelectStatus( items, true );
	};
	mwstew.ui.HooksSelectWidget.prototype.onCapsuleWidgetRemove = function ( items ) {
		this.toggleItemsSelectStatus( items, false );
	};

	mwstew.ui.HooksSelectWidget.prototype.toggleItemsSelectStatus = function ( items, isSelected ) {
		for ( i = 0; i < items.length; i++ ) {
			item = items[ i ];
			data = item && item.getData();
			existingItem = this.getItemFromData( data );

			if ( existingItem ) {
				existingItem.$element
					.toggleClass(
						'mwstew-ui-hookSelectWidget-selected',
						isSelected
					);
				existingItem.setSelected( false );
			}
		}
	};

	mwstew.ui.HooksSelectWidget.prototype.onChoose = function ( item ) {
		var data = item && item.getData(),
			existingCapsuleItem = this.capsuleWidget.getItemFromData( data );

		if ( existingCapsuleItem ) {
			this.capsuleWidget.removeItemsFromData( [ data ] );
		} else {
			this.capsuleWidget.addItemsFromData( [ data ] );
		}
		this.toggleItemsSelectStatus( [ item ], !existingCapsuleItem );
	};
} )( jQuery );
