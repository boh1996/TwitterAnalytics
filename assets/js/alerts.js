$(document).on("submit", "#alert_settings_form", function () {
	event.preventDefault();

	if ( ! localStorage.getItem("twa_token") === false ) {
		var data = [];

		$('[data-setting]').each( function ( index, element ) {
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
			}

			if ( value !== null ) {
				data.push({
					"key" : key,
					"value" : value,
					"type" : type,
					"section" : "alerts"
				});
			}
		} );

		$.ajax({
			type : "POST",
			url : base_url + "admin/settings/save" + "?token=" + localStorage.getItem("twa_token"),
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

$(document).on("keyup", ".list-input", function ( event ) {
	var that = this;
	$('input:text').filter(function() { return $(this).val() == ""; }).each( function ( index, element ) {
		if ( $(element).get(0) != that ) {
			$(element).parent("div").parent("div").parent("div").remove();
		}
	} );

	if ( $(this).get(0) == $("input.list-input").last().get(0) && $(this).val() !== "" ) {
		$(this).parent("div").parent("div").parent("div").after(returnElement());
	}
} );

$(document).on("click", "button.remove-input", function () {
	var element = $(this).parent("span").prev("input");

	if ( $(element).attr("data-id") !== undefined ) {
		if ( ! localStorage.getItem("twa_token") === false ) {
			$.ajax({
				type : "DELETE",
				url : base_url + "admin/alert/" + $(element).attr("data-id") + "?token=" + localStorage.getItem("twa_token"),
			}).success( function ( xhr, status, data ) {
				alert(null, translations["admin_alert_deleted"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
			} ).error( function ( xhr, status, data ) {
				var response = $.parseJSON(xhr.responseText);
				for ( var index in response.error_messages ) {
					alert(null, response.error_messages[index] , "alertsErrorTemplate", $("#errors"), "append", null, 5000);
				}
			} );
		} else {
			alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		}
	}

	$(element).parent("div").parent("div").parent("div").remove();
	if ( $('.list-input').last().val() != "" ) {
		$('.list-input').last().after(returnElement());
	}

	if ( $('.list-input').length == 0 ) {
		$("#alert_string_form").prepend(returnElement());
	}
} );

$(document).on("submit", ".list-input-form", function ( event ) {
	event.preventDefault();

	var data = [];

	$(this).find('.list-input').each( function ( index, element ) {
		if ( ( $(element).attr("data-value") === undefined || $(element).attr('data-value') !== $(element).val() ) && $(element).val() != "" ) {
			if ( $(element).attr("data-id") !== undefined ) {
				data.push({
					"id" : $(element).attr("data-id"),
					"value" : $(element).val()
				});
			} else {
				data.push({
					"value" : $(element).val()
				});
			}
		}
	} );

	if ( ! localStorage.getItem("twa_token") === false ) {
		$.ajax({
			type : "POST",
			url : base_url + "admin/alerts/save" + "?token=" + localStorage.getItem("twa_token"),
			data : JSON.stringify({"alerts" : data}),
			contentType: "application/json",
		  	dataType: "json"
		}).success( function ( xhr, status, data ) {
			alert(null, translations["admin_saved_successfully"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);

			$("#alertsSuccessTemplateClone").bind("closed.bs.alert", function () {
				window.location = window.location;
			});
		});
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
} );

function returnElement ( after ) {
	var input = '<input type="text" class="form-control list-input" placeholder="' + translations["alert_string"] + '">';
	return '<div class="form-group">' +
		'<div class="col-sm-offset-4 col-sm-6">' +
			'<div class="input-group">' +
				input +
				'<span class="input-group-btn">' +
					'<button class="btn btn-lg btn-danger button-addon remove-input" type="button">' + translations["admin_remove_string"] + '</button>' +
				'</span>' +
			'</div>' +
		'</div>'+
	'</div>';
}