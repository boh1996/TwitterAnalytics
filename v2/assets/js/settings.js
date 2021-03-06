$(document).on("submit", ".settings-form", function () {
	event.preventDefault();

	if ( ! localStorage.getItem("tws_token") === false ) {
		var data = [];

		$(".settings-form").each( function ( index, form ) {
			$(form).find('[data-setting]').each( function ( index, element ) {
				var key = $(element).attr("data-setting");
				var value = null;
				var type = "";
				if ( $(element).is("input:text") ) {
					if ( $(element).val() != "" ) {
						value = $(element).val();
						type = "text";
					}
				} else if ( $(element).is(":checkbox") ) {
					type = "checkbox"
					if ( $(element).attr("data-checked") !== undefined ) {
						value = $(element).attr("data-checked");
					} else {
						value = $(element).is(':checked');
					}
				} else if ( $(element).is("textarea") ) {
					type = "textarea";
					if ( $(element).val() != "" ) {
						value = $(element).val();
					}
				}

				if ( value !== null ) {
					data.push({
						"key" : key,
						"value" : value,
						"type" : type,
						"section" : $(form).attr("data-section")
					});
				}
			} );
		} );

		$.ajax({
			type : "POST",
			url : base_url + "admin/settings/save" + "?token=" + localStorage.getItem("tws_token"),
			data : JSON.stringify({"keys" : data}),
			contentType: "application/json",
		  	dataType: "json"
		}).success( function ( xhr, status, data ) {
			alert(null, translations["admin_saved_successfully"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
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