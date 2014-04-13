<!DOCTYPE html>
<html lang="en">
  	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?= $this->lang->line("app_name"); ?></title>

		<link href="<?= $asset_url; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>bootstrap/css/docs.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/bootstrap-select.min.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/daterangepicker.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/style.css" rel="stylesheet">

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
		<div class="col-sm-12 errors-container" id="errors">
		</div>

		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="well" style="min-height:80px;">
					<div class="col-sm-offset-1 col-sm-3">
						<form class="form-inline" role="form">
							<div class="form-group">
								<label for="intervals"><?= $this->lang->line("user_interval"); ?></label>
								<select class="selectpicker" id="intervals">
									<?php foreach ( $intervals as $interval ): ?>
										<option value="$interval"> <?= str_replace("{{time}}", $interval, $this->lang->line("user_per")); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-7 col-sm-offset-1">
				<div id="chart_top" class="bs-example">

				</div>
			</div>

			<div class="bs-example col-sm-3">
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
							<?= $this->user_control->LoadTemplate("live_status_errors_view"); ?>
						</div>
						<div class="tab-pane" id="history">
							<?= $this->user_control->LoadTemplate("live_status_history_view"); ?>
						</div>
						<div class="tab-pane" id="active">
							<?= $this->user_control->LoadTemplate("live_status_active_scrapers_view"); ?>
						</div>
						<div class="tab-pane" id="listscrapers">
							<?= $this->user_control->LoadTemplate("status_scrapers_view"); ?>
						</div>
					</div>
				</div>
			</div>
			</div>
			<div class="col-sm-7 col-sm-offset-1">
				<div id="chart_bottom" class="bs-example">

				</div>
			</div>
		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/bootstrap-select.min.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/underscore-min.js"></script>
		<script src="<?= $asset_url; ?>js/highcharts.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>
		<script src="<?= $asset_url; ?>js/live.js"></script>
		<script src="<?= $asset_url; ?>js/status_live.js"></script>
	</body>
</html>
