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
		<div class="container" style="padding:0px 10px 0px 10px; width:100%; display:inline-block;">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-1 well">
					<form class="form-inline" role="form">
						<div class="form-group col-sm-4">
							<label for="limit" class="control-label"><?= $this->lang->line("user_rows"); ?></label>
							<select class="selectpicker" id="limit">
								<?php foreach ( $limits as $key => $value ): ?>
								<option <?= ( $key == "value" ) ? "selected=selected" : "" ?> value="<?= $value; ?>"><?= $value; ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group col-sm-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input type="text" class="form-control" id="date" data-type="daterange">
							</div>
						</div>

						<div class="form-group col-sm-2">
							<a href="#" class="btn btn-default refresh-list"><?= $this->lang->line("user_refresh"); ?></a>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8 col-sm-offset-1 well" id="words">
					<?= $this->user_control->LoadTemplate("analytics_words_view"); ?>
				</div>

				<div class="col-sm-3 push-left sidebar">
					<div id="alert_strings" data-spy="affix" data-offset-top="90" data-offset-bottom="200" data-clampedwidth=".sidebar">
						<?= $this->user_control->LoadTemplate("analytics_alerts_view"); ?>
					</div>
				</div>
			</div>
		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/bootstrap-select.min.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/underscore-min.js"></script>
		<script src="<?= $asset_url; ?>js/moment-with-langs.min.js"></script>
		<script src="<?= $asset_url; ?>js/daterangepicker.js"></script>
		<script src="<?= $asset_url; ?>js/jquery.floatThead.min.js"></script>
		<script src="<?= $asset_url; ?>js/analytics.js"></script>
	</body>
</html>
