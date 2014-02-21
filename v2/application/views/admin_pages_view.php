<!DOCTYPE html>
<html lang="en">
  	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?= $this->lang->line("app_name"); ?> - <?= $this->lang->line("admin_page"); ?></title>

		<link href="<?= $asset_url; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>bootstrap/css/docs.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/bootstrap-checkbox.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/style.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/admin.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/pages.css" rel="stylesheet">
	</head>
	<body>

		<div style="display:none;" >
			<div id="newPageTemplate">
				<?= $this->user_control->LoadTemplate("new_page_template_view"); ?>
			</div>
		</div>

		<script type="text/javascript">
			var base_url = "<?= $base_url; ?>";

			var translations = <?= $translations ?>;
		</script>

		<div style="display:none;">
			<?= $this->user_control->LoadTemplate("alerts_view"); ?>
		</div>

		<?= $this->user_control->LoadTemplate("nav_bar_view"); ?>

			<div class="container">
			<div class="well" style="height:auto !important; min-height:150px;">
				<div class="page-header text-center col-sm-10 col-sm-offset-1">
					<h1><?= $this->lang->line("admin_pages_settings"); ?><small> <?= $this->lang->line("pages_page_description"); ?></small></h1>
				</div>
			</div>

			<form class="form-signin form-horizontal pages-form" role="form">
				<div class="page-container">
					<?= $this->user_control->LoadTemplate("pages_list_view"); ?>

					<?= $this->user_control->LoadTemplate("new_page_view"); ?>
				</div>

				<div class="well notifications" style="display:none; text-align:center;">
					<div class="form-group">
						<div class="col-sm-12" id="errors"></div>
					</div>
				</div>

				</div>

				<div class="well" style="height:auto !important; min-height:80px;">
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<button class="btn btn-lg btn-primary btn-block" type="submit"><?= $this->lang->line("admin_save"); ?></button>
						</div>
					</div>
				</div>
			</form>
		<div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/bootstrap-checkbox.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>
		<script src="<?= $asset_url; ?>js/list-input.js"></script>
		<script src="<?= $asset_url; ?>js/settings.js"></script>
		<script src="<?= $asset_url; ?>js/pages.js"></script>
	</body>
</html>