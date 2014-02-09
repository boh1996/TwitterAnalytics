<form class="form-signin form-horizontal settings-form" data-ajax-url="admin/alerts/template/settings" data-section="alerts" role="form">
	<div class="col-sm-9 col-sm-offset-2">
		<div class="page-header">
			<h1><?= $this->lang->line("alert_settings"); ?><small> <?= $this->lang->line("admin_alerts_settings_description"); ?></small></h1>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-8" id="errors">
		</div>
	</div>

	<?php foreach ( $settings as $key => $object ): ?>
		<div class="form-group">
			<label for="<?= $key; ?>" class="col-sm-2 control-label col-sm-offset-2"><?= $this->lang->line($object->language_key); ?></label>
			<div class="col-sm-6">
				<?php if ( $object->type == "text" ): ?>
					<input data-setting="<?= $key; ?>" type="text" id="<?= $key; ?>" value="<?= $object->value; ?>" name="<?= $key; ?>" class="form-control" placeholder="<?= $this->lang->line($object->placeholder); ?>">
				<?php elseif ( $object->type == "textarea" ) : ?>
					<textarea data-setting="<?= $key; ?>" id="<?= $key; ?>" name="<?= $key; ?>" class="form-control" placeholder="<?= $this->lang->line($object->placeholder); ?>"><?= $object->value; ?></textarea>
				<?php elseif ( $object->type == "checkbox" ) : ?>
					<div class="checkbox">
						<label>
							<input data-setting="<?= $key; ?>" <?php if ( $object->value == true ) { echo 'checked="checked"'; }; ?>   type="checkbox" id="<?= $key; ?>" value="<?= $object->value; ?>" name="<?= $key; ?>" placeholder="<?= $this->lang->line($object->placeholder); ?>"> <?= $this->lang->line($object->placeholder); ?>
						</label>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-6">
			<button class="btn btn-lg btn-primary btn-block" type="submit"><?= $this->lang->line("admin_save"); ?></button>
		</div>
	</div>
</form>