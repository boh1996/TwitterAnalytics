$(document).on("keyup", ".list-input", function ( event ) {
	var that = this;
	var form = $(that).parents(".list-input-form");
	$(form).find('input:text').filter(function() { return $(this).val() == ""; }).each( function ( index, element ) {
		if ( $(element).get(0) != that ) {
			$(element).parent("div").parent("div").parent("div").remove();
		}
	} );

	if ( $(this).get(0) == $(form).find("input.list-input").last().get(0) && $(this).val() !== "" ) {
		$(this).parent("div").parent("div").parent("div").after(returnElement(null, form));
	}
} );

$(document).on("click", "button.remove-input", function () {
	var element = $(this).parent("span").prev("input");
	var form = $(element).parents(".list-input-form");
	if ( $(element).attr("data-id") !== undefined ) {
		if ( ! localStorage.getItem("twa_token") === false ) {
			$.ajax({
				type : "DELETE",
				url : base_url + $(form).attr("data-item-endpoint") + $(element).attr("data-id") + "?token=" + localStorage.getItem("twa_token"),
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
	if ( $(form).find('.list-input').last().val() != "" ) {
		$(form).find('.list-input').last().parent("div").parent("div").parent("div").after(returnElement(null, form));
	}

	if ( $(form).find('.list-input').length == 0 ) {
		$(form).find(".list-input-form").prepend(returnElement());
	}
} );

$(document).on("submit", ".list-input-form", function ( event ) {
	event.preventDefault();

	var data = [];
	var that = this;

	$(this).find('.list-input').each( function ( index, element ) {
		if ( ( $(element).attr("data-value") === undefined || $(element).attr('data-value') !== $(element).val() ) && $(element).val() != "" ) {
			if ( $(element).attr("data-id") !== undefined ) {
				data.push({
					"id" : $(element).attr("data-id"),
					"value" : $(element).val(),
					"category" : $(that).attr("data-category")
				});
			} else {
				data.push({
					"value" : $(element).val(),
					"category" : $(that).attr("data-category")
				});
			}
		}
	} );

	if ( data.length > 0) {
		if ( ! localStorage.getItem("twa_token") === false ) {
			var arrayName = $(this).attr("data-array-name");
			var post = {};
			post[arrayName] = data;
			$.ajax({
				type : "POST",
				url : base_url + $(this).attr("data-save-endpoint") + "?token=" + localStorage.getItem("twa_token") + "&category=" + $(this).attr("data-category"),
				data : JSON.stringify(post),
				contentType: "application/json",
			  	dataType: "json"
			}).success( function ( xhr, status, data ) {
				alert(null, translations["admin_saved_successfully"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);

				$("#alertsSuccessTemplateClone").bind("closed.bs.alert", function () {
					if ( $(that).attr("data-ajax-url") !== undefined ) {
						$.ajax({
							url : base_url + $(that).attr("data-ajax-url")
						}).success( function ( data ) {
							$(that).replaceWith(data);
						} ).error( function () {
							window.location = window.location;
						} );
					} else {
						window.location = window.location;
					}
				});
			}).error( function () {
				alert(null, translations["admin_duplicated"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);

				//removeDuplicate();

				$(that).find('.list-input').trigger("keyup");

			} );
		} else {
			alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		}
	}
} );

function returnElement ( after, form ) {
	var classString = $(form).attr("data-input-class") || "col-sm-offset-2 col-sm-6";
	var input = '<input type="text" class="form-control list-input" placeholder="' + $(form).attr("data-placeholder-text") + '">';
	return '<div class="form-group">' +
		'<div class="' + classString + '">' +
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

	$(".list-input-form").each( function ( i, form ) {
		$(form).find(".list-input").each( function ( index, element ) {
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
	} );
}