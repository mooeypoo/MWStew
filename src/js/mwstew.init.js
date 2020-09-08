$( function () {
	// eslint-disable-next-line no-jquery/no-global-selector
	var $fields = $( '.container' ).find( 'input, select, textarea' ),
		// eslint-disable-next-line no-jquery/no-global-selector
		$button = $( '.mwstew-ui-floating-button button' ),
		$required = $fields.filter( function () {
			return $( this ).prop( 'required' );
		} ),
		isValid = function () {
			// The $required jquery array isn't a real Array
			// so we can't call 'every' on it; we first translate
			// it to a pure JS array, so we can quickly verify
			// the required fields have content
			return Array.prototype.slice.call( $required )
				.every( function ( el ) {
					return $( el ).val().length > 0;
				} );
		},
		onChange = function () {
			$button.prop( 'disabled', !isValid() );
		};

	$button.prop( 'disabled', true );
	$fields.on( 'change keypress', onChange );
} );
