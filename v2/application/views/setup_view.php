<!DOCTYPE html>
<html lang="en">
  	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?= $this->lang->line("app_name"); ?></title>

		<link href="<?= $asset_url; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>bootstrap/css/docs.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/sign_in.css" rel="stylesheet">

		<script type="text/javascript">
			var base_url = "<?= $base_url; ?>";

			var translations = <?= $translations ?>;
		</script>
	</head>

	<body>
		<div style="display:none;">
			<?= $this->user_control->LoadTemplate("alerts_view"); ?>
		</div>

		<div class="container">
			<form class="form-signin form-horizontal" id="login_form" role="form" method="post" action="<?= $base_url; ?>setup/save">
				<div class="col-sm-10 col-sm-offset-2">
						<h2 class="form-signin-heading"><?= $this->lang->line("setup_admin_account"); ?></h2>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10" id="errors">

					</div>
				</div>

				<div class="form-group">
					<label for="username" class="col-sm-2 control-label"><?= $this->lang->line("setup_username"); ?></label>
					<div class="col-sm-10">
						<input type="text" id="username" name="username" class="form-control" placeholder="<?= $this->lang->line("setup_username"); ?>" required autofocus>
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="col-sm-2 control-label"><?= $this->lang->line("setup_password"); ?></label>
					<div class="col-sm-10">
						<input type="password" id="password" name="password" class="form-control" placeholder="<?= $this->lang->line("setup_password"); ?>" required>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button class="btn btn-lg btn-primary btn-block" type="submit"><?= $this->lang->line("setup_setup"); ?></button>
					</div>
				</div>
			</form>
		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
