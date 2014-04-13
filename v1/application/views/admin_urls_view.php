<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?= $this->lang->line("app_name"); ?> - <?= $this->lang->line("admin_page"); ?></title>

		<link href="<?= $asset_url; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/style.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/admin.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>bootstrap/css/docs.css" rel="stylesheet">
	</head>

	<body>

		<form id="import_form" method="post" enctype="multipart/form-data">
			<input type="file" name="file" id="import_file" style="visibility:hidden;position:absolute;top:0;left:0">
			<input type="text" style="visibility:hidden;position:absolute;top:0;left:0" name="url" id="url">
		</form>

		<script type="text/javascript">
			var base_url = "<?= $base_url; ?>";

			var translations = <?= $translations ?>;
		</script>

		<div style="display:none;">
			<?= $this->user_control->LoadTemplate("alerts_view"); ?>
		</div>

		<?= $this->user_control->LoadTemplate("nav_bar_view"); ?>

		<div class="container">
			<div id="urls">
				<div class="col-sm-10 col-sm-offset-3">
					<div class="page-header">
						<h1><?= $this->lang->line("admin_urls_add"); ?><small> <?= $this->lang->line("admin_urls_description"); ?></small></h1>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-8" id="errors">
					</div>
				</div>

				<div class="col-sm-10 col-sm-offset-2">
					<div class="bs-example bs-example-tab" style="display:inline-block;width:100%;">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#category1" data-toggle="tab"><?= $this->lang->line("admin_url_category"); ?> 1</a>
							</li>
							<li>
								<a href="#category2" data-toggle="tab"><?= $this->lang->line("admin_url_category"); ?> 2</a>
							</li>
								<li>
								<a href="#category3" data-toggle="tab"><?= $this->lang->line("admin_url_category"); ?> 3</a>
							</li>
							<li>
								<a href="#category4" data-toggle="tab"><?= $this->lang->line("admin_url_category"); ?> 4</a>
							</li>
							<li>
								<a href="#category5" data-toggle="tab"><?= $this->lang->line("admin_url_category"); ?> 5</a>
							</li>
							<li>
								<a href="#live" data-toggle="tab"><?= $this->lang->line("admin_url_live"); ?></a>
							</li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content col-sm-12">
							<div class="tab-pane active" id="category1">
								<?= $this->user_control->LoadTemplate("admin_url_category_view", array("category" => 1, "objects" => $cat1)); ?>
							</div>
							<div class="tab-pane" id="category2">
								<?= $this->user_control->LoadTemplate("admin_url_category_view", array("category" => 2, "objects" => $cat2)); ?>
							</div>
							<div class="tab-pane" id="category3">
								<?= $this->user_control->LoadTemplate("admin_url_category_view", array("category" => 3, "objects" => $cat3)); ?>
							</div>
							<div class="tab-pane" id="category4">
								<?= $this->user_control->LoadTemplate("admin_url_category_view", array("category" => 4, "objects" => $cat4)); ?>
							</div>
							<div class="tab-pane" id="category5">
								<?= $this->user_control->LoadTemplate("admin_url_category_view", array("category" => 5, "objects" => $cat5)); ?>
							</div>
							<div class="tab-pane" id="live">
								<?= $this->user_control->LoadTemplate("admin_url_category_view", array("category" => "live", "objects" => $live)); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/mustache.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>
		<script src="<?= $asset_url; ?>js/url-input.js"></script>
		<script src="<?= $asset_url; ?>js/io.js"></script>
	</body>
</html>
