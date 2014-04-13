<!DOCTYPE html>
<html lang="en">
  	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?= $this->lang->line("app_name"); ?> - <?= $this->lang->line("admin_page"); ?></title>

		<link href="<?= $asset_url; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>bootstrap/css/docs.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/style.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/admin.css" rel="stylesheet">
	</head>
	<body>

		<script type="text/javascript">
			var base_url = "<?= $base_url; ?>";

			var translations = <?= $translations ?>;
		</script>

		<div style="display:none;">
			<?= $this->user_control->LoadTemplate("alerts_view"); ?>
		</div>

		<?= $this->user_control->LoadTemplate("nav_bar_view"); ?>

		<div class="container">
			<div class="bs-example">
				<div class="col-sm-12 errors-container" id="errors">
				</div>
				<ul class="nav nav-tabs col-sm-12 row">
					<li class="active">
						<a href="#settings" data-toggle="tab"><?= $this->lang->line("admin_alerts_settings_nav_title"); ?></a>
					</li>
					<li>
						<a href="#strings" data-toggle="tab"><?= $this->lang->line("admin_alerts_strings_nav_title"); ?></a>
					</li>
					<li>
						<a href="#connected" data-toggle="tab"><?= $this->lang->line("admin_alerts_connected_hidden_nav_title"); ?></a>
					</li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="settings">
						<?= $this->user_control->LoadTemplate("admin_alerts_settings_view"); ?>
					</div>

					<div class="tab-pane" id="strings">
						<?= $this->user_control->LoadTemplate("admin_alerts_strings_view"); ?>
					</div>

					<div class="tab-pane" id="connected">
						<?= $this->user_control->LoadTemplate("admin_alerts_connected_words_view"); ?>
					</div>
				</div>
			</div>
		<div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>
		<script src="<?= $asset_url; ?>js/list-input.js"></script>
		<script src="<?= $asset_url; ?>js/settings.js"></script>
		<script src="<?= $asset_url; ?>js/io.js"></script>
	</body>
</html>
