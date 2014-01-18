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
		<link href="<?= $asset_url; ?>css/bootstrap-checkbox.css" rel="stylesheet">

		<script type="text/javascript">
			var base_url = "<?= $base_url; ?>";

			var translations = <?= $translations ?>;
		</script>
	</head>

	<body>

		<div style="display:none;">
			<?= $this->user_control->LoadTemplate("alerts_view"); ?>
		</div>

		<?= $this->user_control->LoadTemplate("nav_bar_view"); ?>

		<div class="container">
			<div class="well" style="height:auto !important; min-height:150px;">
				<div class="page-header text-center col-sm-8 col-sm-offset-2">
					<h1><?= $this->lang->line("admin_scraper_status"); ?></h1>
				</div>
			</div>

			<div class="col-sm-12 errors-container" id="errors">
			</div>

			<div class="bs-example bs-example-tab">
				<div id="scrapers" style="display:inline-block;width:100%;">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#errors_list" data-toggle="tab"><?= $this->lang->line("admin_status_errors"); ?></a>
						</li>
						<li>
							<a href="#history" data-toggle="tab"><?= $this->lang->line("admin_status_history"); ?></a>
						</li>
						<li>
							<a href="#active" data-toggle="tab"><?= $this->lang->line("admin_status_active"); ?></a>
						</li>
						<li>
							<a href="#listscrapers" data-toggle="tab"><?= $this->lang->line("admin_status_scrapers"); ?></a>
						</li>
						<li>
							<a data-refresh="true" href="#"><?= $this->lang->line("admin_refresh"); ?></a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content col-sm-10 col-sm-offset-1">
						<div class="tab-pane active" id="errors_list">
							<?= $this->user_control->LoadTemplate("status_errors_view"); ?>
						</div>
						<div class="tab-pane" id="history">
							<?= $this->user_control->LoadTemplate("status_history_view"); ?>
						</div>
						<div class="tab-pane" id="active">
							<?= $this->user_control->LoadTemplate("status_active_scrapers_view"); ?>
						</div>
						<div class="tab-pane" id="listscrapers">
							<?= $this->user_control->LoadTemplate("status_scrapers_view"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/bootstrap-checkbox.js"></script>
		<script src="<?= $asset_url; ?>js/mustache.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>
		<script src="<?= $asset_url; ?>js/status.js"></script>
	</body>
</html>
