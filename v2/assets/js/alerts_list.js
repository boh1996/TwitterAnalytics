function refresh () {
	$(".table").floatThead({
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
		url : base_url + "user/alerts/temp/list?limit=" + $("#limit").val() + "&date=" + $("#date").val()
	}).success( function ( data ) {
		$("#words").html(data);
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