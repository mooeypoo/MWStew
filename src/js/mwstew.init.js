( function ( $ ) {
	$( document ).ready( function () {
		$( '*[ data-ooui ]' ).each( function () {
			OO.ui.infuse( this.id );
		} );
	} );
} )( jQuery );
