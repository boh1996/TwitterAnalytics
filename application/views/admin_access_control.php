<!DOCTYPE html>
<html lang="en">
  	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?= $this->lang->line("app_name"); ?> - <?= $this->lang->line("admin_page"); ?></title>

		<link href="<?= $asset_url; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/style.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/admin.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/bootstrap-checkbox.css" rel="stylesheet">

		<script type="text/javascript">
			var base_url = "<?= $base_url; ?>";

			var translations = <?= $translations ?>;
		</script>
	</head>

	<body>

		<div style="display:none;">
			<?= $this->user_control->LoadTemplate("alerts_view"); ?>
		</div>

		<!-- Static navbar -->
		<div class="navbar navbar-default" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only"><?= $this->lang->line("toggle_navigation"); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
				 	</button>
				  	<a class="navbar-brand" href="#"><?= $this->lang->line("app_name"); ?></a>
				</div>
				<div class="navbar-collapse collapse">
				  	<ul class="nav navbar-nav">
				  		<li>
							<a href="<?= $base_url ?>admin"><?= $this->lang->line("admin_settings"); ?></a>
						</li>
						<li>
							<a href="<?= $base_url ?>admin/alerts"><?= $this->lang->line("alerts"); ?></a>
						</li>
						<li>
							<a href="<?= $base_url ?>admin/topics"><?= $this->lang->line("admin_topics"); ?></a>
						</li>
						<li class="active">
							<a href="<?= $base_url ?>admin/access/control"><?= $this->lang->line("admin_access_control"); ?></a>
						</li>
				  	</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="<?= $base_url ?>"><?= $this->lang->line("viewer_section"); ?></a>
						</li>
						<li class="active">
							<a href="<?= $base_url ?>admin"><?= $this->lang->line("control_panel"); ?></a>
						</li>
						<li>
							<a href="<?= $base_url ?>sign_out"><?= $this->lang->line("sign_out"); ?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="well">
				<form class="form-signin form-horizontal" id="access_control_form" role="form">
					<div class="col-sm-10 col-sm-offset-4">
						<h2 class="form-signin-heading"><?= $this->lang->line("admin_access_control_pages"); ?></h2>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5" id="errors">

						</div>
					</div>

					<?php if ( $pages === false ): ?>
						<div class="alert alert-danger alert-dismissable" id="alertsErrorTemplate">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?= $this->lang->line("no_pages_found"); ?>
						</div>
					<?php else: foreach ( $pages as $page ):  ?>

					<div class="form-group">
						<div class="col-sm-2 col-sm-offset-4">
							<label class="control-label" for="<?= $page->page ?>">
								<?= $this->lang->line("admin_page_" . $page->page); ?>
							</label>
						</div>
						<div class="col-sm-6">
							<input type="checkbox" class="checkbox access-control" data-page="<?= $page->page ?>" <?= ( $page->mode == "login" ) ? 'checked="checked"' : "" ?> />
						</div>
						<hr>
					</div>

					<?php endforeach; endif; ?>

					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-3">
							<button class="btn btn-lg btn-primary btn-block" id="access_control_save" type="submit"><?= $this->lang->line("admin_save"); ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/bootstrap-checkbox.js"></script>
		<script src="<?= $asset_url; ?>js/mustache.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>

		<script type="text/javascript">
			$('input[type="checkbox"]').checkbox();
		</script>

		<script type="text/javascript">
			$(document).on("submit", "#access_control_form", function (event) {
				event.preventDefault();
				var data = {"pages" : []};

				$("input.access-control").each( function ( index, element ) {
					var mode = "";

					if ( $(element).attr("data-checked") == "true" ) {
						mode = "login";
					} else {
						mode = "nologin";
					}

					data["pages"].push({"page" : $(element).attr("data-page"), "mode" : mode});
				} );

				if ( ! localStorage.getItem("twa_token") === false ) {
					$.ajax({
						type : "POST",
						url : base_url + "admin/access/control/save?token=" + localStorage.getItem("twa_token"),
						data : JSON.stringify(data),
						contentType: "application/json",
				  		dataType: "json"
					}).success( function ( xhr, status, data ) {
						alert(null, translations["admin_control_post_success"], "alertsSuccessTemplate", $("#errors"), "append", null, 2000);
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
		</script>
	</body>
</html>
