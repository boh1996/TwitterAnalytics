window.refreshRate = 20000;

$(document).on('click', '#listscrapers [data-href]', function () {
	var element = $(this);

	alert(null, translations["admin_scraper_started"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);

	$.ajax({
		url : element.attr("data-href") + "/launch",
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

function refresh () {
	fetch_views();
	setTimeout( function () {
		refresh();
	}, window.refreshRate );
}

$(document).ready( function () {
	setTimeout( function () {
		refresh();
	}, window.refreshRate );
} );

function fetch_views () {
	$.ajax({
		url : base_url + "user/history"
	}).success( function ( data ) {
		$("#history").html(data);
	} );

	$.ajax({
		url : base_url + "user/errors"
	}).success( function ( data ) {
		$("#errors_list").html(data);
	} );

	$.ajax({
		url : base_url + "user/scrapers"
	}).success( function ( data ) {
		$("#listscrapers").html(data);
	} );

	$.ajax({
		url : base_url + "user/active/scrapers"
	}).success( function ( data ) {
		$("#active").html(data);
	} );
}

$(document).on("click", '[data-refresh]', function () {
	fetch_views();
} );