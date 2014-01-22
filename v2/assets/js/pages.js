$(document).on("click", '[data-page-id]',  function ( event ) {
	event.preventDefault();
	var that = this;
	if ( $(this).parent().parent().find('.page-name').attr("contenteditable") !== "true" ) {
		$(this).parent().parent().find('.page-name').attr("contenteditable", "true");
		$(this).html(translations.admin_pages_save);
		$(this).parent().parent().find('.page-name').focus();
	} else {
		var value = $(this).parent().parent().find('.page-name').html();
		var id = $(this).attr("data-page-id");

		if ( value !== $(this).parent().parent().find('.page-name').attr("data-value") ) {
			if ( ! localStorage.getItem("twa_token") === false ) {
				$.ajax({
					url: base_url + "save/page/name?token=" + localStorage.getItem("twa_token") + "&name=" + value + "&id=" + id
				}).success( function () {
					alert(null, translations["admin_saved_successfully"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
				} ).error( function () {
					alert(null, translations["admin_sorry_something_failed"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
				} );
			} else {
				alert(null, translations["admin_please_log_in"], "alertsErrorTemplate", $("#errors"), "append", null, 2000);
			}

			$(that).parent().parent().find('.page-name').attr("contenteditable", "false");
			$(that).html(translations.admin_edit_page_name);
			$(that).parent().parent().find('.page-name').attr("data-value", value);
		}
	}
});