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
			<form class="form-signin form-horizontal settings-form" data-section="alerts" role="form">
				<div class="col-sm-10 col-sm-offset-3">
					<div class="page-header">
						<h1><?= $this->lang->line("alert_settings"); ?><small> <?= $this->lang->line("admin_alerts_settings_description"); ?></small></h1>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-8" id="errors">
					</div>
				</div>

				<?php foreach ( $settings as $key => $object ): ?>
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

			<div class="col-sm-10 col-sm-offset-3">
				<div class="page-header">
					<h1><?= $this->lang->line("alert_strings"); ?><small> <?= $this->lang->line("admin_alerts_description"); ?></small></h1>
				</div>
			</div>

			<hr>

			<div id="alert_strings">
				<form class="form-signin form-horizontal list-input-form" id="alert_string_form" role="form" data-array-name="alerts" data-placeholder-text="<?= $this->lang->line("alert_string"); ?>" data-item-endpoint="admin/alert/" data-save-endpoint="admin/alerts/save">

					<?php foreach ( $alerts as $alert ) : ?>
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-6">
								<div class="input-group">
									<input data-id="<?= $alert->id; ?>" data-value="<?= $alert->value ?>" type="text" class="form-control list-input" value="<?= $alert->value ?>">
									<span class="input-group-btn">
	      								<button class="btn btn-lg btn-danger button-addon remove-input" type="button"><?= $this->lang->line("admin_remove_string"); ?></button>
	      							</span>
								</div>
							</div>
						</div>
					<?php endforeach; ?>

					<div class="form-group">
							<div class="col-sm-offset-4 col-sm-6">
								<div class="input-group">
									<input type="text" class="form-control list-input" placeholder="<?= $this->lang->line("alert_string"); ?>">
									<span class="input-group-btn">
	      								<button class="btn btn-lg btn-danger button-addon remove-input" type="button"><?= $this->lang->line("admin_remove_string"); ?></button>
	      							</span>
								</div>
							</div>
						</div>

					<hr>

					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-6">
							<button class="btn btn-lg btn-primary btn-block" id="alert_strings_save" type="submit"><?= $this->lang->line("admin_save"); ?></button>
						</div>
					</div>
				</form>
			</div>
		<div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>
		<script src="<?= $asset_url; ?>js/list-input.js"></script>
		<script src="<?= $asset_url; ?>js/settings.js"></script>
	</body>
</html>
