$(document).on("click", ".export a", function () {
	if ( localStorage.getItem("twa_token") === false ) {
		alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
		return;
	}

	var element = $(this).closest(".export");

	category = "";

	if ( element.attr("data-category") != undefined ) {
		 category = "&category=" + element.attr("data-category");
	}

	document.location = base_url + "export/" + $(this).parents(".export").attr("data-type") + "/" + $(this).attr("data-value") + "?token=" + localStorage.getItem("twa_token") + category;
});

$(document).on("click", ".import a", function () {
	$(".import").attr("data-filetype", $(this).attr("data-value"));
	$("#import_file").trigger("click");
});

$(document).on("click", ".import-upload, #import_upload", function() {
	var element = $(this).parents(".form-group").find(".import");

	category = "";

	if ( element.attr("data-category") != undefined ) {
		 category = "&category=" + element.attr("data-category");
	}

	url = base_url + "import/" + element.attr("data-type") + "/" + element.attr("data-filetype") + "?token=" + localStorage.getItem("twa_token") + category;

	$("#url").val(document.location.href);

	$("#import_form").attr("action", url);
	$("#import_form").submit();
});