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
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-8" id="errors">
				</div>
			</div>

			<form class="form-signin form-horizontal" role="form">
				<div class="col-sm-10 col-sm-offset-3">
					<div class="page-header">
						<h1><?= $this->lang->line("admin_cleanup"); ?><small> <?= $this->lang->line("cleanup_description"); ?></small></h1>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-3">
						<button class="btn btn-lg btn-primary btn-block" id="run_cleanup" type="submit"><?= $this->lang->line("admin_run_cleanup"); ?></button>
					</div>
					<div class="col-sm-3">
						<button class="btn btn-lg btn-primary btn-block" id="run_empty" type="submit"><?= $this->lang->line("admin_empty_database"); ?></button>
					</div>
				</div>
			</form>

			<form class="form-signin form-horizontal settings-form" data-section="scraper" role="form">
				<div class="col-sm-10 col-sm-offset-3">
					<div class="page-header">
						<h1><?= $this->lang->line("scraper_settings"); ?><small> <?= $this->lang->line("scraper_settings_description"); ?></small></h1>
					</div>
				</div>

				<?php foreach ( $scraper_settings as $key => $object ): ?>
					<div class="form-group">
						<label for="<?= $key; ?>" class="col-sm-2 control-label col-sm-offset-2"><?= $this->lang->line($object->language_key); ?></label>
						<div class="col-sm-6">
							<?php if ( $object->type == "text" ): ?>
								<input data-setting="<?= $key; ?>" type="text" id="<?= $key; ?>" value="<?= $object->value; ?>" name="<?= $key; ?>" class="form-control" placeholder="<?= $this->lang->line($object->placeholder); ?>">
							<?php elseif ( $object->type == "textarea" ) : ?>
								<textarea data-setting="<?= $key; ?>" id="<?= $key; ?>" name="<?= $key; ?>" class="form-control" placeholder="<?= $this->lang->line($object->placeholder); ?>"><?= $object->value; ?></textarea>
							<?php elseif ( $object->type == "checkbox" ) : ?>
								<div class="checkbox">
	    							<label>
										<input data-setting="<?= $key; ?>" <?php if ( $object->value == true ) { echo 'checked="checked"'; }; ?>   type="checkbox" id="<?= $key; ?>" value="<?= $object->value; ?>" name="<?= $key; ?>" placeholder="<?= $this->lang->line($object->placeholder); ?>"> <?= $this->lang->line($object->placeholder); ?>
									</label>
								</div>
							<?php endif; ?>
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

			<form class="form-signin form-horizontal settings-form" data-section="analytics" role="form">
				<div class="col-sm-10 col-sm-offset-3">
					<div class="page-header">
						<h1><?= $this->lang->line("admin_analytics_settings"); ?><small> <?= $this->lang->line("admin_analytics_settings_description"); ?></small></h1>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-8" id="errors">
					</div>
				</div>

				<?php foreach ( $analytics_settings as $key => $object ): ?>
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
		<script src="<?= $asset_url; ?>js/cleanup.js"></script>
	</body>
</html>
