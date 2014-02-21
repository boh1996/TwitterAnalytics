$(document).ready( function () {
	$('input[type="checkbox"]').checkbox();
} );

// ################ Page Section ##################
$(document).on("click", ".edit-page",  function ( event ) {
	event.preventDefault();
	var that = $(this);
	var page = $(that).closest(".page-object");

	if ( $(this).parent().parent().find('.page-name').attr("contenteditable") !== "true" ) {
		$(this).parent().parent().find('.page-name').attr("contenteditable", "true");
		$(this).html(translations.admin_pages_save);
		$(this).parent().parent().find('.page-name').focus();
	} else {
		var value = $(this).parent().parent().find('.page-name').html();
		var id = $(this).attr("data-page-id");

		if ( value !== $(this).parent().parent().find('.page-name').attr("data-value") && page.hasClass("add-page") === false ) {
			if ( ! localStorage.getItem("tws_token") === false ) {
				$.ajax({
					url: base_url + "save/page/name?token=" + localStorage.getItem("tws_token") + "&name=" + value + "&id=" + id
				}).success( function () {
					alert(null, translations["admin_saved_successfully"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
				} ).error( function () {
					alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
				} );
			} else {
				alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
			}
		} else {
			console.log("HERE");
			alert(null, translations["admin_please_use_the_large_save"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		}

		$(that).parent().parent().find('.page-name').attr("contenteditable", "false");
		$(that).html(translations.admin_edit_page_name);
		$(that).parent().parent().find('.page-name').attr("data-value", value);

		if ( page.hasClass("add-page") ) {
			page.removeClass("add-page");
		}


		createPage($(".page-container"));
	}
});

$(document).on("click", ".remove-page", function ( event ) {
	event.preventDefault();

	var that = $(this);
	var page = that.closest(".page-object");
	var container = $(".page-container")

	if ( page.attr("data-page-object-id") === undefined ) {
		page.remove();

		if ( container.find(".add-page").length == 0 ) {
			createPage(container);
		}

		return;
	}

	var id = page.attr("data-page-object-id");

	if ( ! localStorage.getItem("tws_token") === false ) {
		$.ajax({
			type : "DELETE",
			url: base_url + "page/" + id + "?token=" + localStorage.getItem("tws_token")
		}).success( function () {
			alert(null, translations["admin_deleted_successfully"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
			console.log($(that).closest(".page-object"));
			$(that).closest(".page-object").remove();
		} ).error( function () {
			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}


	if ( container.find(".add-page").length == 0 ) {
		createPage(container);
	}
} );

function createPage ( container ) {
	var page = $("#newPageTemplate > div").clone();
	$(page).attr("id", makeid(5));
	container.append(page);
	$(".page-container").find('input[type="checkbox"]').checkbox();
}

// ############ String Section ############
$(document).on("click", ".remove-string", function ( event ) {
	event.preventDefault();

	var that = $(this);
	var form = $(that).closest(".category");

	if ( $(this).attr("data-object-id") === undefined ) {
		$(this).closest(".string-object").remove();

		if ( form.find(".add-string").length == 0 ) {
			form.append(returnStringElement(null, form, form.attr("data-category-id")));
		}
		return;
	}

	if ( ! localStorage.getItem("tws_token") === false ) {
		$.ajax({
			type : "DELETE",
			url: base_url + "string/" + $(this).attr("data-object-id") + "?token=" + localStorage.getItem("tws_token")
		}).success( function () {
			alert(null, translations["admin_deleted_successfully"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
			$(that).closest(".string-object").remove();
		} ).error( function () {
			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}


	if ( form.find(".add-string").length == 0 ) {
		form.append(returnStringElement(null, form, form.attr("data-category-id")));
	}
} );

$(document).on("keyup", ".create-string", function ( event ) {
	event.preventDefault();
	var that = this;
	var form = $(that).closest(".category");
	$(form).find('input:text').filter(function() { return $(this).val() == ""; }).each( function ( index, element ) {
		if ( $(element).get(0) != that ) {
			$(element).closest(".string-object").remove();
		}
	} );

	if ( $(this).get(0) == $(form).find("input.create-string").last().get(0) && $(this).val() !== "" ) {
		form.find(".add-string").attr("placeholder", translations.admin_page_string);
		form.find(".add-string").closest(".string-object").find("label").html(translations.admin_page_string);
		form.find(".add-string").removeClass("add-string");
		form.append(returnStringElement(null, form, form.attr("data-category-id")));
	}
} );

function returnStringElement ( after, form, category ) {
	return '<div class="form-group string-object" style="min-width:600px;">' +
				'<label class="col-sm-2 control-label">' + translations.admin_add_string + '</label>' +
				'<div class="col-sm-10">' +
					'<div class="input-group">' +
						'<input type="text" data-category-id="' + category + '" class="form-control create-string add-string" placeholder="' + translations.admin_add_string + '" >' +
						'<span class="input-group-btn">' +
							'<button class="btn btn-lg btn-danger button-addon remove-string" type="button">' + translations.admin_remove_item + '</button>' +
						'</span>' +
					'</div>' +
				'</div>' +
			'</div>';
}

// ############ URL Section ################
$(document).on("click", ".remove-url", function ( event ) {
	event.preventDefault();

	var that = $(this);
	var form = $(that).closest(".list-container");

	if ( $(this).attr("data-object-id") === undefined ) {
		$(this).closest(".url-object").remove();

		if ( form.find(".add-url").length == 0 ) {
			form.append(returnUrlElement(null, form));
		}
		return;
	}

	if ( ! localStorage.getItem("tws_token") === false ) {
		$.ajax({
			type : "DELETE",
			url: base_url + "url/" + $(this).attr("data-object-id") + "?token=" + localStorage.getItem("tws_token")
		}).success( function () {
			alert(null, translations["admin_deleted_successfully"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
			$(that).closest(".url-object").remove();
		} ).error( function () {
			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}

	if ( form.find(".add-url").length == 0 ) {
		form.append(returnUrlElement(null, form));
	}
} );

$(document).on("keyup", ".create-url", function ( event ) {
	event.preventDefault();
	var that = this;
	var form = $(that).closest(".list-container");
	$(form).find('input:text').filter(function() { return $(this).val() == ""; }).each( function ( index, element ) {
		if ( $(element).get(0) != that ) {
			$(element).closest(".url-object").remove();
		}
	} );

	if ( $(this).get(0) == $(form).find("input.create-url").last().get(0) && $(this).val() !== "" ) {
		$(this).closest(".list-container").find(".add-url").attr("placeholder", translations.admin_page_url);
		$(this).closest(".list-container").find(".add-url").closest(".url-object").find("label").html(translations.admin_page_url);
		$(this).closest(".list-container").find(".add-url").removeClass("add-url");
		$(this).closest(".list-container").append(returnUrlElement(null, form));
	}
} );

function returnUrlElement ( after, form ) {
	return '<div class="form-group url-object" style="min-width:600px;">' +
		'<label class="col-sm-2 control-label">' + translations.admin_add_url + '</label>' +
		'<div class="col-sm-10">' +
			'<div class="input-group">' +
				'<input  type="text" class="form-control create-url" placeholder="' + translations.admin_add_url + '" >' +
				'<span class="input-group-btn">' +
					'<button class="btn btn-lg btn-danger button-addon remove-url" type="button">' + translations.admin_remove_item + '</button>' +
				'</span>' +
			'</div>' +
		'</div>' +
	'</div>';
}

// ######## Submit ##########
$(document).on("submit", ".pages-form", function ( event ) {
	event.preventDefault();

	var data = {"pages" : []};

	$(".page-container").find(".page-object").each( function ( pageIndex, pageElement ) {
		if ( ( $(pageElement).hasClass("add-page") == true && $(pageElement).find(".page-name").html() != $(pageElement).find(".page-name").attr("data-value") ) || ! $(pageElement).hasClass("add-page") ) {
			var page = {
				"urls" : [],
				"strings" : [],
				"name" : $(pageElement).find(".page-name").html(),
				"login" : $(pageElement).find(".access-control").attr("data-checked"),
				"embed" : $(pageElement).find(".embed").val(),
				"exact_match" : $(pageElement).find(".exact-match").attr("data-checked"),
			};

			if ( $(pageElement).attr("data-page-object-id") !== undefined ) {
				page.id = $(pageElement).attr("data-page-object-id");
			}

			$(pageElement).find(".url-object").each( function ( urlIndex, urlElement ) {
				if ( $(urlElement).find(".add-url").length == 0 && $(urlElement).find(".create-url").val() !== "" ) {
					if ( $(urlElement).attr("data-object-id") !== undefined ) {
						page.urls.push({
							"id" : $(urlElement).attr("data-object-id"),
							"url" : $(urlElement).find(".create-url").val()
						});
					} else {
						page.urls.push({
							"url" : $(urlElement).find(".create-url").val()
						});
					}
				}
			} );

			$(pageElement).find(".string-object").each( function ( stringIndex, stringElement ) {
				if ( $(stringElement).find(".add-string").length == 0 && $(stringElement).find(".create-string").val() !== "" ) {
					if ( $(stringElement).attr("data-object-id") !== undefined ) {
						page.strings.push({
							"id" : $(stringElement).attr("data-object-id"),
							"string" : $(stringElement).find(".create-string").val(),
							"category" : $(stringElement).closest(".category").attr("data-category-id")
						});
					} else {
						page.strings.push({
							"string" : $(stringElement).find(".create-string").val(),
							"category" : $(stringElement).closest(".category").attr("data-category-id")
						});
					}
				}
			} );
			data.pages.push(page);
		}
	} );

	if ( ! localStorage.getItem("tws_token") === false ) {
		$.ajax({
			url : base_url + "save/pages?token=" + localStorage.getItem("tws_token") ,
			type : "POST",
			data: JSON.stringify(data),
			contentType : "application/json"
		}).success( function () {
			$(".notifications").css("display", "block");
			alert(null, translations["admin_saved_successfully"], "alertsSuccessTemplate", $("#errors"), "append", function () {
				$(".notifications").css("display", "none");
				window.location = window.location;
			} , 2000);
			$.ajax({
				url: base_url + "admin/template/pages"
			}).success( function ( data ) {
				$(".page-container").html(data);
				$(".page-container").find(".checkbox").checkbox();
			} ).error( function () {
				window.location = window.location;
			} );
		} ).error( function () {

			alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		} );
	} else {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
	}
} );