$(document).ready( function () {
	$('input[type="checkbox"]').checkbox();
} );

$(document).on("click", ".hide-default", function ( event ) {
	event.preventDefault();
	var that = $(this);

	if ( ! localStorage.getItem("tws_token") === false ) {
		$.ajax({
			type : "GET",
			url : base_url + "admin/interval/hide?key=" + $(that).attr("data-key") + "&token=" + localStorage.getItem("tws_token"),
		}).success( function ( xhr, status, data ) {
			alert(null, translations["admin_object_hide"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
			that.removeClass("hide-default");
			that.addClass("unhide-default");
			that.removeClass("btn-danger");
			that.addClass("btn-default");
			that.html(translations.admin_interval_show);
		} ).error( function ( xhr, status, data ) {
			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
} );

$(document).on("click", ".unhide-default", function ( event ) {
	event.preventDefault();
	var that = $(this);

	if ( ! localStorage.getItem("tws_token") === false ) {
		$.ajax({
			type : "GET",
			url : base_url + "admin/interval/show?key=" + $(that).attr("data-key") + "&token=" + localStorage.getItem("tws_token"),
		}).success( function ( xhr, status, data ) {
			alert(null, translations["admin_object_show"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
			that.removeClass("unhide-default");
			that.addClass("hide-default");
			that.html(translations.admin_interval_hide);
			that.addClass("btn-danger");
			that.removeClass("btn-default");
		} ).error( function ( xhr, status, data ) {
			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
} );

$(document).on("change", ".access-control", function ( event ) {
	event.preventDefault();
	var that = $(this);

	if ( ! localStorage.getItem("tws_token") === false ) {
		$.ajax({
			type : "POST",
			data : JSON.stringify({
				"key" : $(that).attr("data-key"),
				"login" : ( $(that).attr("data-checked") == "true" ) ? "login" : "nologin"
			}),
			contentType : "application/json",
			url : base_url + "admin/interval/edit?key=" + $(that).attr("data-key") + "&token=" + localStorage.getItem("tws_token"),
		}).success( function ( xhr, status, data ) {
			alert(null, translations["admin_access_control_changed"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
		} ).error( function ( xhr, status, data ) {
			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
} );

$(document).on("change", ".increase-alert", function ( event ) {
	event.preventDefault();
	var that = $(this);

	if ( ! localStorage.getItem("tws_token") === false ) {
		$.ajax({
			type : "POST",
			data : JSON.stringify({
				"key" : $(that).attr("data-key"),
				"increase_email" : $(that).attr("data-checked")
			}),
			contentType : "application/json",
			url : base_url + "admin/interval/edit?key=" + $(that).attr("data-key") + "&token=" + localStorage.getItem("tws_token"),
		}).success( function ( xhr, status, data ) {
			alert(null, translations["admin_email_setting_changed"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
		} ).error( function ( xhr, status, data ) {
			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
} );

$(document).on("change", ".decrease-alert", function ( event ) {
	event.preventDefault();
	var that = $(this);

	if ( ! localStorage.getItem("tws_token") === false ) {
		$.ajax({
			type : "POST",
			data : JSON.stringify({
				"key" : $(that).attr("data-key"),
				"decrease_email" : $(that).attr("data-checked")
			}),
			contentType : "application/json",
			url : base_url + "admin/interval/edit?key=" + $(that).attr("data-key") + "&token=" + localStorage.getItem("tws_token"),
		}).success( function ( xhr, status, data ) {
			alert(null, translations["admin_email_setting_changed"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
		} ).error( function ( xhr, status, data ) {
			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
} );

$(document).on("change", ".category-difference", function ( event ) {
	event.preventDefault();
	var that = $(this);

	if ( ! localStorage.getItem("tws_token") === false ) {
		$.ajax({
			type : "POST",
			data : JSON.stringify({
				"key" : $(that).attr("data-key"),
				"category_difference" : $(that).attr("data-checked")
			}),
			contentType : "application/json",
			url : base_url + "admin/interval/edit?key=" + $(that).attr("data-key") + "&token=" + localStorage.getItem("tws_token"),
		}).success( function ( xhr, status, data ) {
			alert(null, translations["admin_email_setting_changed"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
		} ).error( function ( xhr, status, data ) {
			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
} );

$(document).on("change", ".email-change-value", function ( event ) {
	event.preventDefault();
	var that = $(this);

	if ( ! localStorage.getItem("tws_token") === false ) {
		$.ajax({
			type : "POST",
			data : JSON.stringify({
				"key" : $(that).attr("data-key"),
				"email_change_value" : $(that).val()
			}),
			contentType : "application/json",
			url : base_url + "admin/interval/edit?key=" + $(that).attr("data-key") + "&token=" + localStorage.getItem("tws_token"),
		}).success( function ( xhr, status, data ) {
			alert(null, translations["admin_email_setting_changed"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
		} ).error( function ( xhr, status, data ) {
			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
} );

$(document).on("change", ".category-difference-value", function ( event ) {
	event.preventDefault();
	var that = $(this);

	if ( ! localStorage.getItem("tws_token") === false ) {
		$.ajax({
			type : "POST",
			data : JSON.stringify({
				"key" : $(that).attr("data-key"),
				"category_change_value" : $(that).val()
			}),
			contentType : "application/json",
			url : base_url + "admin/interval/edit?key=" + $(that).attr("data-key") + "&token=" + localStorage.getItem("tws_token"),
		}).success( function ( xhr, status, data ) {
			alert(null, translations["admin_email_setting_changed"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
		} ).error( function ( xhr, status, data ) {
			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
} );