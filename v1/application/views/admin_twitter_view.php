<!DOCTYPE html>
<html lang="en">
  	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?= $this->lang->line("app_name"); ?> - <?= $this->lang->line("admin_page"); ?></title>

		<link href="<?= $asset_url; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/style.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/admin.css" rel="stylesheet">

		<style type="text/css">
			body {
				padding-top: 0px !important;
			}
		</style>
	</head>

	<body>

		<?= $this->user_control->LoadTemplate("nav_bar_view"); ?>

		<script type="text/javascript">
			var base_url = "<?= $base_url; ?>";

			var translations = <?= $translations ?>;
		</script>

		<div style="display:none;">
			<?= $this->user_control->LoadTemplate("alerts_view"); ?>
		</div>

		<div class="container">
			<form class="form-signin form-horizontal" id="twitter_settings_form" role="form">
				<div class="col-sm-10 col-sm-offset-2">
					<div class="page-header">
						<h2><?= $this->lang->line("enter_twitter_details"); ?><small> <?= $this->lang->line("admin_twitter_details_description"); ?></small></h2>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-8" id="errors">
					</div>
				</div>

				<?php if ( $accounts !== false ): ?>
					<?php foreach ( $accounts as $account ): ?>
						<div class="twitter-account" data-id="<?= $account->id ?>">
							<div class="form-group">
								<label for="username" class="col-sm-2 control-label col-sm-offset-2"><?= $this->lang->line("username"); ?></label>
								<div class="col-sm-6">
									<input type="text" data-username="<?= $account->username; ?>" name="username" class="form-control twitter-username" value="<?= $account->username; ?>" placeholder="<?= $this->lang->line("username"); ?>" required autofocus>
								</div>
							</div>

							<div class="form-group">
								<label for="password" class="col-sm-2 col-sm-offset-2 control-label"><?= $this->lang->line("password"); ?></label>
								<div class="col-sm-6">
									<input type="password" name="password" class="form-control twitter-password" placeholder="<?= $this->lang->line("password"); ?>">
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-4 col-sm-6">
									<button data-id="<?= $account->id ?>" class="btn btn-lg btn-block btn-danger remove-button"><?= $this->lang->line("admin_remove_account"); ?></button>
								</div>
							</div>
						</div>

						<hr>
					<?php endforeach; ?>
				<?php endif; ?>
				<div class="twitter-account">
					<div class="col-sm-10 col-sm-offset-4">
						<h3><?= $this->lang->line("add_account"); ?></h3>
					</div>

					<div class="form-group">
						<label for="username" class="col-sm-2 control-label col-sm-offset-2"><?= $this->lang->line("username"); ?></label>
						<div class="col-sm-6">
							<input type="text" name="username" class="form-control twitter-username" placeholder="<?= $this->lang->line("username"); ?>" autofocus>
						</div>
					</div>

					<div class="form-group">
						<label for="password" class="col-sm-2 col-sm-offset-2 control-label"><?= $this->lang->line("password"); ?></label>
						<div class="col-sm-6">
							<input type="password" name="password" class="form-control twitter-password" placeholder="<?= $this->lang->line("password"); ?>">
						</div>
					</div>
				</div>

				<hr>

				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-6">
						<button class="btn btn-lg btn-primary btn-block" id="admin_settings_save" type="submit"><?= $this->lang->line("admin_save"); ?></button>
					</div>
				</div>
			</form>


		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>
		<script src="<?= $asset_url; ?>js/admin_settings.js"></script>
	</body>
</html>
