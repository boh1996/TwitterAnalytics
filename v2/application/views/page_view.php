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

			var page = "<?= $page_string; ?>";

			var pageObject = <?= json_encode($page); ?>;
		</script>
	</head>

	<body>
		<div style="display:none;">
			<?= $this->user_control->LoadTemplate("alerts_view"); ?>
		</div>

		<?= $this->user_control->LoadTemplate("nav_bar_view"); ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="well">
						<h1 class="text-center"><?= $page->name; ?></h1>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="well">
						<div class="col-sm-offset-1">
							<form class="form-inline" role="form">
								<div class="form-group">
									<label for="intervals"><?= $this->lang->line("user_interval"); ?></label>
									<select class="selectpicker" id="intervals">
										<?php foreach ( $intervals as $key => $object ): ?>
											<option value="<?= $object->value; ?>" data-key="<?= $object->key; ?>"><?= $object->name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div id="chart">

					</div>
				</div>
			</div>

			<?php if ( $page->embed !== "" ): ?>
				<div class="row">
					<div class="col-sm-12">
						<div class="well">
							<?= $page->embed; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/bootstrap-select.min.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/underscore-min.js"></script>
		<script src="<?= $asset_url; ?>js/highcharts.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>
		<script src="<?= $asset_url; ?>js/viewer.js"></script>
	</body>
</html>
