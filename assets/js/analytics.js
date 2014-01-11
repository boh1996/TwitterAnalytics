function refresh () {
	$(".table-scroll-header").floatThead({
		scrollingTop : 52,
		useAbsolutePositioning: false
	});
	$('.selectpicker').selectpicker();
	$('input[data-type="daterange"]').daterangepicker({
		timePicker: true,
		timePickerIncrement: 30,
		format: 'DD/MM/YYYY hh:mm',
		timePicker12Hour : false,
		dateLimit : 0
	}, function () {
		words();
	} );
}

function words () {
	$.ajax({
		url : base_url + "user/words/temp?limit=" + $("#limit").val() + "&date=" + $("#date").val()
	}).success( function ( data ) {
		$("#words").html(data);
		refresh();
	} );

	$.ajax({
		url : base_url + "user/alerts/temp?limit=" + $("#limit").val() + "&date=" + $("#date").val()
	}).success( function ( data ) {
		$("#alert_strings").html(data);
		refresh();
	} );
}

$(document).ready( function () {
	refresh();
} );

$(document).on("change", "#limit", function () {
	words();
} );

$(document).on("change", "#date", function () {
	words();
} );

$(document).on("click", ".refresh-list", function () {
	words();
} );

$('[data-clampedwidth]').each(function () {
    var elem = $(this);
    var parentPanel = elem.data('clampedwidth');
    var resizeFn = function () {
        var sideBarNavWidth = $(parentPanel).width() - parseInt(elem.css('paddingLeft')) - parseInt(elem.css('paddingRight')) - parseInt(elem.css('marginLeft')) - parseInt(elem.css('marginRight')) - parseInt(elem.css('borderLeftWidth')) - parseInt(elem.css('borderRightWidth'));
        elem.css('width', sideBarNavWidth);
    };

    resizeFn();
    $(window).resize(resizeFn);
});