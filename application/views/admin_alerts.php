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

		<?= $this->user_control->LoadTemplate("nav_bar_view"); ?>

		<div class="container">
			<form class="form-signin form-horizontal" id="alert_words_form" role="form">
				<div class="col-sm-10 col-sm-offset-4">
					<h2 class="form-signin-heading"><?= $this->lang->line("alert_settings"); ?></h2>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-5" id="errors">
					</div>
				</div>

				<div class="form-group">
					<label for="alert_word_count" class="col-sm-2 control-label col-sm-offset-2"><?= $this->lang->line("alerts_count"); ?></label>
					<div class="col-sm-6">
						<input type="text" id="alert_word_count" name="alert_word_count" class="form-control" placeholder="<?= $this->lang->line("number_of_alerts"); ?>" required autofocus>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-6">
						<button class="btn btn-lg btn-primary btn-block" id="alerts_settings_save" type="submit"><?= $this->lang->line("admin_save"); ?></button>
					</div>
				</div>
			</form>
		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
	</body>
</html>
