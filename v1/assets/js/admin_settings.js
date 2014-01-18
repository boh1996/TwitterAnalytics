$(document).on("submit", "#twitter_settings_form", function ( event ) {
	event.preventDefault();

	var data = [];

	$("div.twitter-account").each(function ( index, element ) {
		var account = {};
		var username = $(element).find(".twitter-username").val();
		var password = $(element).find(".twitter-password").val();
		if ( ( username != $(element).find(".twitter-username").attr("data-username") && username != "" ) || password != "" ) {
			if ( username != $(element).find(".twitter-username").attr("data-username") ) {
				account["username"] = username;
				$(element).find(".twitter-username").attr("data-username", "username");
			}

			if ( password != "" ) {
				account["password"] = password;
			}

			if ( $(element).attr("data-id") != undefined ) {
				account["id"] = $(element).attr("data-id");
			}

			data.push(account);
		}
	} );
	if ( data.length > 0 ) {
		if ( ! localStorage.getItem("twa_token") === false ) {
			$.ajax({
				type : "POST",
				url : base_url + "admin/twitter/save?token=" + localStorage.getItem("twa_token"),
				data : JSON.stringify({"twitter" : data}),
				contentType: "application/json",
		  		dataType: "json"
			}).success( function ( xhr, status, data ) {
				alert(null, translations["admin_twitter_updated"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);

				$("#alertsSuccessTemplateClone").bind("closed.bs.alert", function () {
					window.location = window.location;
				});
			} ).error( function ( xhr, status, data ) {
				var response = $.parseJSON(xhr.responseText);
				for ( var index in response.error_messages ) {
					alert(null, response.error_messages[index] , "alertsErrorTemplate", $("#errors"), "append", null, 5000);
				}
			} );
		} else {
			alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		}
	} else {
		alert(null, translations["admin_missing_post_data"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
} );

$(document).on("click", "button.remove-button", function ( event ) {
	event.preventDefault();

	if ( ! localStorage.getItem("twa_token") === false ) {
		$.ajax({
			type : "GET",
			url : base_url + "admin/twitter/remove/" + $(this).attr("data-id") + "?token=" + localStorage.getItem("twa_token"),
		}).success( function ( xhr, status, data ) {
			alert(null, translations["admin_twitter_removed"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);

			$("#alertsSuccessTemplateClone").bind("closed.bs.alert", function () {
				window.location = window.location;
			});
		} ).error( function ( xhr, status, data ) {
			var response = $.parseJSON(xhr.responseText);
			for ( var index in response.error_messages ) {
				alert(null, response.error_messages[index] , "alertsErrorTemplate", $("#errors"), "append", null, 5000);
			}
		} );
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
} );