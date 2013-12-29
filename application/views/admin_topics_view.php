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

		<script type="text/javascript">
			var base_url = "<?= $base_url; ?>";

			var translations = <?= $translations ?>;
		</script>

		<div style="display:none;">
			<?= $this->user_control->LoadTemplate("alerts_view"); ?>
		</div>

		<?= $this->user_control->LoadTemplate("nav_bar_view"); ?>

		<div class="container">
			<div id="topics">
				<form class="form-signin form-horizontal list-input-form" id="topics_form" role="form" data-array-name="topics" data-placeholder-text="<?= $this->lang->line("admin_new_topic"); ?>" data-item-endpoint="admin/topic/" data-save-endpoint="admin/topics/save">
					<div class="col-sm-10 col-sm-offset-4">
						<h2 class="form-signin-heading"><?= $this->lang->line("admin_topics_add"); ?></h2>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-8" id="errors">
						</div>
					</div>

					<?php foreach ( $topics as $topic ) : ?>
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-6">
								<div class="input-group">
									<input data-id="<?= $topic->id; ?>" data-value="<?= $topic->value ?>" type="text" class="form-control list-input" value="<?= $topic->value ?>">
									<span class="input-group-btn">
	      								<button class="btn btn-lg btn-danger button-addon remove-input" type="button"><?= $this->lang->line("admin_remove_string"); ?></button>
	      							</span>
								</div>
							</div>
						</div>
					<?php endforeach; ?>

					<div class="form-group">
							<div class="col-sm-offset-4 col-sm-6">
								<div class="input-group">
									<input type="text" class="form-control list-input" placeholder="<?= $this->lang->line("admin_new_topic"); ?>">
									<span class="input-group-btn">
	      								<button class="btn btn-lg btn-danger button-addon remove-input" type="button"><?= $this->lang->line("admin_remove_string"); ?></button>
	      							</span>
								</div>
							</div>
						</div>

					<hr>

					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-6">
							<button class="btn btn-lg btn-primary btn-block" id="topics_save" type="submit"><?= $this->lang->line("admin_save"); ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>
		<script src="<?= $asset_url; ?>js/list-input.js"></script>
	</body>
</html>
