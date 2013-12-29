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
				url : base_url + $(".list-input-form").attr("data-item-endpoint") + $(element).attr("data-id") + "?token=" + localStorage.getItem("twa_token"),
			}).success( function ( xhr, status, data ) {
				alert(null, translations["admin_object_deleted"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
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
		$('.list-input').last().parent("div").parent("div").parent("div").after(returnElement());
	}

	if ( $('.list-input').length == 0 ) {
		$(".list-input-form").prepend(returnElement());
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

	if ( data.length > 0) {
		if ( ! localStorage.getItem("twa_token") === false ) {
			var arrayName = $(".list-input-form").attr("data-array-name");
			var post = {};
			post[arrayName] = data;
			$.ajax({
				type : "POST",
				url : base_url + $(".list-input-form").attr("data-save-endpoint") + "?token=" + localStorage.getItem("twa_token"),
				data : JSON.stringify(post),
				contentType: "application/json",
			  	dataType: "json"
			}).success( function ( xhr, status, data ) {
				alert(null, translations["admin_saved_successfully"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);

				$("#alertsSuccessTemplateClone").bind("closed.bs.alert", function () {
					window.location = window.location;
				});
			}).error( function () {
				alert(null, translations["admin_duplicated"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);

				removeDuplicate();

				$('.list-input').trigger("keyup");

			} );
		} else {
			alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		}
	}
} );

function returnElement ( after ) {
	var input = '<input type="text" class="form-control list-input" placeholder="' + $(".list-input-form").attr("data-placeholder-text") + '">';
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

function removeDuplicate ( values, second ) {
	second = second || false;
	values = values || [];

	$(".list-input").each( function ( index, element ) {
		if ( $.inArray($(element).val(), values) ) {
			if ( $(element).attr("data-id") === undefined ) {
				$(element).parent("div").parent("div").parent("div").remove();
			} else {
				if ( ! second ) {
					removeDuplicate(values, true);
				}
			}
		} else {
			values.push($(element).val());
		}
	} );

	$('.list-input').trigger("keyup");
}