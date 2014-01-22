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
		<link href="<?= $asset_url; ?>css/pages.css" rel="stylesheet">
	</head>
	<body>

		<script type="text/javascript">
			var base_url = "<?= $base_url; ?>";

			var translations = <?= $translations ?>;
		</script>

		<div style="display:none;">
			<?= $this->user_control->LoadTemplate("alerts_view"); ?>
		</div>

		<?= $this->user_control->LoadTemplate("nav_bar_view"); ?>

		<div class="container">
			<div class="well" style="height:auto !important; min-height:150px;">
				<div class="page-header text-center col-sm-10 col-sm-offset-1">
					<h1><?= $this->lang->line("admin_pages_settings"); ?><small> <?= $this->lang->line("scraper_settings_description"); ?></small></h1>
				</div>
			</div>

			<form class="form-signin form-horizontal" role="form">

				<div class="bs-example bs-example-tab">
					<div id="scrapers" style="display:inline-block;width:100%;">

						<div class="col-sm-offset-1 col-sm-10">
							<div class="form-group">
								<div class="col-sm-12" id="errors">
								</div>
							</div>

							<?php foreach ( $objects as $object ): ?>
								<div class="col-sm-12">
									<h2><span class="page-name" data-value="<?= $object->name ?>"><?= $object->name ?></span> <small><a href="#" data-page-id="<?= $object->id; ?>"><?= $this->lang->line("admin_edit_page_name"); ?></a></small></h2>
								</div>
								<div class="form-group col-sm-12">
									<ul class="nav nav-tabs">
										<li class="active"><a data-toggle="tab" href="#urls_<?= $object->id ?>"><?= $this->lang->line("admin_pages_urls_tab"); ?></a></li>
									  	<li><a data-toggle="tab" href="#strings_<?= $object->id ?>"><?= $this->lang->line("admin_pages_strings_tab"); ?></a></li>
									</ul>

									<div class="tab-content">
										<div class="tab-pane active" id="urls_<?= $object->id ?>">
											<div class="col-sm-offset-1 col-sm-5 list-container">
												<?php foreach ( $object->urls as $url ): ?>
													<div class="form-group" style="min-width:600px;">
														<label for="url_<?= $object->id; ?>_<?= $url['id']; ?>" class="col-sm-2 control-label"><?= $this->lang->line("admin_page_url"); ?></label>
														<div class="col-sm-10">
															<input id="url_<?= $object->id; ?>_<?= $url['id']; ?>" type="text" class="form-control" value="<?= $url["url"]; ?>" >
														</div>
													</div>
												<?php endforeach; ?>
											</div>
										</div>
										<div class="tab-pane" id="strings_<?= $object->id ?>">
											<div class="col-sm-offset-1 col-sm-10 list-container">
												ORDER BY CATEGORY
												<?php foreach ( $object->strings as $string ): ?>
													<div class="form-group" style="min-width:600px;">
														<label for="string_<?= $object->id; ?>_<?= $string['id']; ?>" class="col-sm-2 control-label"><?= $this->lang->line("admin_page_string"); ?></label>
														<div class="col-sm-10">
															<input id="string_<?= $object->id; ?>_<?= $string['id']; ?>" type="text" class="form-control" value="<?= $string["value"]; ?>" >
														</div>
													</div>
												<?php endforeach; ?>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<div class="well" style="height:auto !important;">
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<button class="btn btn-lg btn-primary btn-block" type="submit"><?= $this->lang->line("admin_save"); ?></button>
						</div>
					</div>
				</div>
			</form>
		<div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>
		<script src="<?= $asset_url; ?>js/list-input.js"></script>
		<script src="<?= $asset_url; ?>js/settings.js"></script>
		<script src="<?= $asset_url; ?>js/pages.js"></script>
	</body>
</html>