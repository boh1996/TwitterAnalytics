<!DOCTYPE html>
<html lang="en">
  	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?= $this->lang->line("app_name"); ?> - <?= $this->lang->line("admin_page"); ?></title>

		<link href="<?= $asset_url; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>bootstrap/css/docs.css" rel="stylesheet">
		<link href="<?= $asset_url; ?>css/bootstrap-checkbox.css" rel="stylesheet">
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
			<div class="well">
				<form class="form-signin form-horizontal" id="access_control_form" role="form">
					<div class="col-sm-9 col-sm-offset-5">
						<h2 class="form-signin-heading"><?= $this->lang->line("admin_intervals_settings"); ?></h2>
						<small class="text-muted"><i><?= $this->lang->line("admin_intervals_description"); ?></i></small>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-7" id="errors" style="text-align:center;">

						</div>
					</div>

					<?php if ( $objects === false ): ?>
						<div class="alert alert-danger alert-dismissable" id="alertsErrorTemplate">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?= $this->lang->line("admin_no_intervals_found"); ?>
						</div>
					<?php else: foreach ( $objects as $object ):  ?>

						<div class="form-group" data-key="<?= $object->key ?>" data-default="<?= ( isset( $object->default ) ) ? ( $object->default == 1 ) ? "true" : "false" : "false"; ?>">
							<div class="col-sm-2 col-sm-offset-2">
								<label class="control-label" for="<?= $object->key ?>">
									<?= $object->name; ?>
								</label>
							</div>

							<div class="col-sm-3">
								<div class="input-group">
									<input type="text" <?= ( isset( $object->default ) && $object->default == 1 ) ? 'disabled="true"' : '' ?> value="<?= $object->value; ?>" placeholder="<?= ( isset( $object->default ) && $object->default == 1 ) ? $object->value : $this->lang->line("admin_intervals_value"); ?>" class="form-control">
									<span class="input-group-addon"><b><?= $this->lang->line("admin_interval_seconds"); ?></b></span>
								</div>
							</div>

							<div class="col-sm-2">
								<label class="control-label" for="<?= $object->key ?>">
									<i><?= $this->lang->line("admin_interval_login"); ?></i>
								</label>
								<input type="checkbox" class="checkbox access-control" data-key="<?= $object->key ?>" <?= ( $object->login == "login" ) ? 'checked="checked"' : "" ?> />
								<?php if ( isset($object->default) && $object->default == 1 ) : ?>
									<?php if ( $object->status == true ): ?>
										<a href="#" data-key="<?= $object->key; ?>" class="btn btn-danger hide-default"><?= $this->lang->line("admin_interval_hide"); ?></a>
									<?php else: ?>
										<a href="#" data-key="<?= $object->key; ?>" class="btn btn-default unhide-default"><?= $this->lang->line("admin_interval_show"); ?></a>
									<?php endif; ?>
								<?php else: ?>

								<?php endif; ?>

							</div>

							<div class="col-sm-2">
								<label class="control-label" for="<?= $object->key ?>">
									<i><?= $this->lang->line("admin_email_alert_interval"); ?></i>
								</label>
								<input type="checkbox" class="checkbox email-alert" data-key="<?= $object->key ?>" <?= ( $object->email == "true" ) ? 'checked="checked"' : "" ?> />
							</div>
						</div>

						<hr>

					<?php endforeach; endif; ?>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-8">
							<button class="btn btn-lg btn-primary btn-block" id="access_control_save" type="submit"><?= $this->lang->line("admin_save"); ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<script src="<?= $asset_url; ?>jquery.min.js"></script>
		<script src="<?= $asset_url; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= $asset_url; ?>js/bootstrap-checkbox.js"></script>
		<script src="<?= $asset_url; ?>js/nav.js"></script>
		<script src="<?= $asset_url; ?>js/functions.js"></script>
		<script src="<?= $asset_url; ?>js/list-input.js"></script>
		<script src="<?= $asset_url; ?>js/settings.js"></script>
		<script src="<?= $asset_url; ?>js/intervals.js"></script>
	</body>
</html>