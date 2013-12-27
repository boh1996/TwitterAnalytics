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
				  		<li class="active">
							<a href="<?= $base_url ?>admin"><?= $this->lang->line("admin_settings"); ?></a>
						</li>
						<li>
							<a href="<?= $base_url ?>admin/alerts"><?= $this->lang->line("alerts"); ?></a>
						</li>
						<li>
							<a href="<?= $base_url ?>admin/topics"><?= $this->lang->line("admin_topics"); ?></a>
						</li>
						<li>
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
			<form class="form-signin form-horizontal" id="login_form" role="form">
				<div class="col-sm-10 col-sm-offset-4">
					<h2 class="form-signin-heading"><?= $this->lang->line("enter_twitter_details"); ?></h2>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8" id="errors">

					</div>
				</div>

				<div class="form-group">
					<label for="username" class="col-sm-2 control-label col-sm-offset-2"><?= $this->lang->line("username"); ?></label>
					<div class="col-sm-6">
						<input type="text" id="username" name="username" class="form-control" placeholder="<?= $this->lang->line("username"); ?>" required autofocus>
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="col-sm-2 col-sm-offset-2 control-label"><?= $this->lang->line("password"); ?></label>
					<div class="col-sm-6">
						<input type="password" id="password" name="password" class="form-control" placeholder="<?= $this->lang->line("password"); ?>" required>
					</div>
				</div>
			</form>

			<form class="form-signin form-horizontal" id="alert_words_form" role="form">
				<div class="col-sm-10 col-sm-offset-4">
					<h2 class="form-signin-heading"><?= $this->lang->line("alert_word_settings"); ?></h2>
				</div>

				<div class="form-group">
					<label for="alert_word_count" class="col-sm-2 control-label col-sm-offset-2"><?= $this->lang->line("alert_word_count"); ?></label>
					<div class="col-sm-6">
						<input type="text" id="alert_word_count" name="alert_word_count" class="form-control" placeholder="<?= $this->lang->line("username"); ?>" required autofocus>
					</div>
				</div>
				</div>
			</form>

			<!-- Replaced strings -->
			<form class="form-signin form-horizontal" id="replaced_strings_form" role="form">
				<div class="col-sm-10 col-sm-offset-4">
					<h2 class="form-signin-heading"><?= $this->lang->line("replaced_string_settings"); ?></h2>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-6">
						<input type="text" id="alert_word_count" name="alert_word_count" class="form-control" placeholder="<?= $this->lang->line("username"); ?>" required autofocus>
					</div>
				</div>
				</div>
			</form>
		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
