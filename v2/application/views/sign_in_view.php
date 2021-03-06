<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?= $this->lang->line("app_name"); ?> - <?= $this->lang->line("sign_in_page"); ?></title>

		<link href="<?= $asset_url; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/style.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/sign_in.css" rel="stylesheet">
	</head>

	<script type="text/javascript">
		var base_url = "<?= $base_url; ?>";

		var translations = <?= $translations ?>;
	</script>

	<body>
		<div style="display:none;">
			<?= $this->user_control->LoadTemplate("alerts_view"); ?>
		</div>

		<?= $this->user_control->LoadTemplate("nav_bar_view"); ?>

		<div class="container">
			<form class="form-signin form-horizontal" id="login_form" role="form">
				<div class="col-sm-10 col-sm-offset-2">
						<h2 class="form-signin-heading"><?= $this->lang->line("please_sign_in"); ?></h2>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10" id="errors">

					</div>
				</div>

				<div class="form-group">
					<label for="username" class="col-sm-2 control-label"><?= $this->lang->line("username"); ?></label>
					<div class="col-sm-10">
						<input type="text" id="username" name="username" class="form-control" placeholder="<?= $this->lang->line("username"); ?>" required autofocus>
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="col-sm-2 control-label"><?= $this->lang->line("password"); ?></label>
					<div class="col-sm-10">
						<input type="password" id="password" name="password" class="form-control" placeholder="<?= $this->lang->line("password"); ?>" required>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button class="btn btn-lg btn-primary btn-block" type="submit"><?= $this->lang->line("sign_in_button"); ?></button>
					</div>
				</div>
			</form>

		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/mustache.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>
		<script src="<?= $asset_url; ?>js/sign_in.js"></script>
	</body>
</html>
