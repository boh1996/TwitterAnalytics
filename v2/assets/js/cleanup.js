$(document).on("click", "#run_cleanup", function ( event ) {
	event.preventDefault();

	$.ajax( {
		url: base_url + "cleanup"
	} ).success( function () {
		alert(null, translations["admin_databased_cleanup_script_finished"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
	} ).error( function () {
		alert(null, translations["admin_error_occured"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	} );
} );

$(document).on("click", "#run_empty", function ( event ) {
	event.preventDefault();

	if ( localStorage.getItem("twa_token") === false ) {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		return;
	}

	$.ajax( {
		url: base_url + "empty?token=" + localStorage.getItem("twa_token"),
	} ).success( function () {
		alert(null, translations["admin_databased_empty_script_finished"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
	} ).error( function () {
		alert(null, translations["admin_error_occured"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	} );
} );