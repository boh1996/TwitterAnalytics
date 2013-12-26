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
				  		<li>
							<a href="<?= $base_url ?>admin"><?= $this->lang->line("admin_settings"); ?></a>
						</li>
						<li class="active">
							<a href="<?= $base_url ?>admin/alerts"><?= $this->lang->line("alerts"); ?></a>
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

		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
