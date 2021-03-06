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
		<div class="container">
			<div class="col-sm-12 bs-example">
				<h1 class="text-center"><?= $this->lang->line("user_pages"); ?></h1>
				<table class="table table-striped table-hover ">
					<thead>
						<th>#</th>
						<th><?= $this->lang->line("user_page_name"); ?></th>
					</thead>

					<tbody>
						<?php $index = 0; ?>
						<?php foreach ( $objects as $key => $object ): ?>
						<?php $index++; ?>
							<tr>
								<td><?= $index; ?></td>
								<td><a href="<?= $base_url . "page/" . $object->id ?>"><?= $object->name; ?><a></td>
							</tr>
						<?php endforeach; ?>
					</tbody>

					<tfoot>
						<th>#</th>
						<th><?= $this->lang->line("user_page_name"); ?></th>
					</tfoot>
				</table>
			</div>
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
