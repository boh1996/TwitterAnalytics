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
				<div class="page-header col-sm-8 col-sm-offset-3">
					<h1><?= $this->lang->line("admin_scraper_status"); ?> <small><i><?= $this->lang->line("admin_scraper_status_description"); ?></i></small></h1>
				</div>
			</div>

			<div class="bs-example bs-example-tabs" class="col-sm-12">
				<div id="scrapers" style="display:inline-block;width:100%;">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#errors" data-toggle="tab"><?= $this->lang->line("admin_status_errors"); ?></a>
						</li>
						<li>
							<a href="#history" data-toggle="tab"><?= $this->lang->line("admin_status_history"); ?></a>
						</li>
						<li>
							<a href="#active" data-toggle="tab"><?= $this->lang->line("admin_status_active"); ?></a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content col-sm-10 col-sm-offset-1">
						<div class="tab-pane active" id="errors">
							<?php if ( count($errors) > 0 ): ?>
								<div class="table-responsive">
									<table class="table table-striped table-hover">
										<thead>
											<th>#</th>
											<th><?= $this->lang->line("admin_error_created_time"); ?></th>
											<th><?= $this->lang->line("admin_error_string"); ?></th>
											<th><?= $this->lang->line("admin_error_url"); ?></th>
											<th><?= $this->lang->line("admin_error_item_type"); ?></th>
										</thead>

										<?php $index = 0; ?>
										<?php foreach ( $errors as $error ): ?>
											<?php $index = $index+1; ?>
											<tr>
												<td><strong><?= $index; ?></strong></th>
												<td><i><time datetime="<?= strftime( "%Y-%m-%dT%H:%M:%SZ" , $error->created_at) ?>"><?= strftime( "%d / %m / %Y - %H:%M:%S" , $error->created_at) ?></time></i></td>
												<td><?= $error->error_string; ?></td>
												<td><?= $error->url; ?></td>
												<td><?= $error->item_type; ?></td>
											</tr>
										<?php endforeach; ?>

										<tfoot>
											<th>#</th>
											<th><?= $this->lang->line("admin_error_created_time"); ?></th>
											<th><?= $this->lang->line("admin_error_string"); ?></th>
											<th><?= $this->lang->line("admin_error_url"); ?></th>
											<th><?= $this->lang->line("admin_error_item_type"); ?></th>
										</tfoot>
									</table>
								</div>
							<?php else: ?>
								<p><?= $this->lang->line("admin_status_no_errors"); ?><p>
							<?php endif; ?>
						</div>
						<div class="tab-pane" id="history">
							...
						</div>
						<div class="tab-pane" id="active">
							...
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
	</body>
</html>
