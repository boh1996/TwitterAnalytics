<!DOCTYPE html>
<html lang="en">
  	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?= $this->lang->line("app_name"); ?> - <?= $this->lang->line("admin_page"); ?></title>

		<link href="<?= $asset_url; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
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
			<form class="form-signin form-horizontal settings-form" data-section="scraper" role="form">
				<div class="col-sm-10 col-sm-offset-3">
					<div class="page-header">
						<h1><?= $this->lang->line("scraper_settings"); ?><small> <?= $this->lang->line("scraper_settings_description"); ?></small></h1>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-8" id="errors">
					</div>
				</div>

				<?php foreach ( $scraper_settings as $key => $object ): ?>
					<div class="form-group">
						<label for="<?= $key; ?>" class="col-sm-2 control-label col-sm-offset-2"><?= $this->lang->line($object->language_key); ?></label>
						<div class="col-sm-6">
							<input data-setting="<?= $key; ?>" type="text" id="<?= $key; ?>" value="<?= $object->value; ?>" name="<?= $key; ?>" class="form-control" placeholder="<?= $this->lang->line($object->placeholder); ?>" required>
							<span class="help-block"><?= $this->lang->line($object->help_text); ?></span>
						</div>
					</div>
				<?php endforeach; ?>

				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-6">
						<button class="btn btn-lg btn-primary btn-block" type="submit"><?= $this->lang->line("admin_save"); ?></button>
					</div>
				</div>
			</form>
		<div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>
		<script src="<?= $asset_url; ?>js/list-input.js"></script>
		<script src="<?= $asset_url; ?>js/settings.js"></script>
	</body>
</html>
