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
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="well" style="min-height:80px;">
					<div class="col-sm-offset-1 col-sm-3">
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

					<div class="col-sm-2">
						<p><b><?= $this->lang->line("user_average"); ?></b> <span id="avg"></span></p>
					</div>

					<div class="col-sm-3">
						<?php foreach ( $categories as $key => $object ): ?>
							<b><?= $this->lang->line("user_page_category") . " " . $object->name . ":"; ?></b><span class="square" style="background-color:<?= $object->color; ?>;"></span><br>
						<?php endforeach; ?>
					</div>

					<div class="col-sm-1 col-sm-offset-2">
						<button class="btn btn-default" id="refresh"><?= $this->lang->line("user_refresh"); ?></button>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8 col-sm-offset-1">
				<div id="chart" class="bs-example">

				</div>
			</div>

			<div class="bs-example col-sm-2" id="strings">
				
			</div>
		</div>

		<?php if ( $page->embed !== "" ): ?>
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="well">
						<?= html_entity_decode($page->embed); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

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
