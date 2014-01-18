$(document).on('click', '[data-href]', function () {
	var element = $(this);

	alert(null, translations["admin_scraper_started"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);

	$.ajax({
		url : element.attr("data-href"),
	}).success( function () {
		alert(null, translations["admin_scraper_finished"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
		fetch_views();
	} ).error( function () {
		alert(null, translations["admin_scraper_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	} );
} );

$('#errors').bind('DOMNodeInserted DOMNodeRemoved', function ( event ) {
	if ( event.type == "DOMNodeInserted" ) {
		$(".bs-example-tab").css("margin-top", "95px");
	} else {
		$(".bs-example-tab").css("margin-top", "");
	}
} );

function fetch_views () {
	$.ajax({
		url : base_url + "admin/history"
	}).success( function ( data ) {
		$("#history").html(data);
	} );

	$.ajax({
		url : base_url + "admin/errors"
	}).success( function ( data ) {
		$("#errors_list").html(data);
	} );

	$.ajax({
		url : base_url + "admin/scrapers"
	}).success( function ( data ) {
		$("#listscrapers").html(data);
	} );
}

$(document).on("click", '[data-refresh]', function () {
	fetch_views();
} );