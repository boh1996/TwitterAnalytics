$('[data-class]').each( function ( index, element ) {
	$(element).attr("class", $(element).attr("class") + " " + $(element).attr("data-class"));
} );