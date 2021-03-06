$(document).on("submit", "#login_form", function ( event ) {
	event.preventDefault();

	if ( $("#username").val() == "" && $("#password").val() == "" ) {
		alert(null, translations["sign_in_empty_fields"], "alertsErrorTemplate", $("#errors"), "append", null, 5000);
		return;
	}

	if ( $("#password").val() == "" ) {
		alert(null, translations["sign_in_empty_password_field"], "alertsErrorTemplate", $("#errors"), "append", null, 5000);
		return;
	}

	if ( $("#username").val() == "" ) {
		alert(null, translations["sign_in_empty_username_field"], "alertsErrorTemplate", $("#errors"), "append", null, 5000);
		return;
	}

	var data = {
		"username" : $("#username").val(),
		"password" : $("#password").val()
	};

	$.ajax({
		type : "POST",
		url : base_url + "sign_in/auth",
		data : JSON.stringify(data),
		contentType: "application/json",
  		dataType: "json"
	} ).success( function ( xhr, status, data ) {
		var response = $.parseJSON(data.responseText);
		if ( response.status == true ) {
			localStorage.setItem("tws_token", response.token);
			window.location = base_url;
		} else {
			alert(null, translations["sign_in_error_occured"], "alertsErrorTemplate", $("#errors"), "append", null, 5000);
		}
	} ).error( function ( xhr, status, data ) {
		var response = $.parseJSON(xhr.responseText);
		for ( var index in response.error_messages ) {
			alert(null, response.error_messages[index] , "alertsErrorTemplate", $("#errors"), "append", null, 5000);
		}
	} );
});