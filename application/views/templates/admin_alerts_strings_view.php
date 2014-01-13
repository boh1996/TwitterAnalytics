<div id="alert_strings">
	<div class="col-sm-10 col-sm-offset-2">
		<div class="page-header">
			<h1><?= $this->lang->line("alert_strings"); ?><small> <?= $this->lang->line("admin_alerts_description"); ?></small></h1>
		</div>
	</div>

	<form data-input-class="col-sm-offset-3 col-sm-6" data-ajax-url="admin/alerts/template/strings" class="form-signin form-horizontal list-input-form" role="form" data-array-name="alerts" data-placeholder-text="<?= $this->lang->line("alert_string"); ?>" data-item-endpoint="admin/alert/" data-save-endpoint="admin/alerts/save">

		<?php foreach ( $alerts as $alert ) : ?>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<div class="input-group">
						<input data-id="<?= $alert->id; ?>" data-value="<?= $alert->value ?>" type="text" class="form-control list-input" value="<?= $alert->value ?>">
						<span class="input-group-btn">
								<button class="btn btn-lg btn-danger button-addon remove-input" type="button"><?= $this->lang->line("admin_remove_string"); ?></button>
							</span>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-6">
				<div class="input-group">
					<input type="text" class="form-control list-input" placeholder="<?= $this->lang->line("alert_string"); ?>">
					<span class="input-group-btn">
							<button class="btn btn-lg btn-danger button-addon remove-input" type="button"><?= $this->lang->line("admin_remove_string"); ?></button>
						</span>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-6">
				<button class="btn btn-lg btn-primary btn-block" id="alert_strings_save" type="submit"><?= $this->lang->line("admin_save"); ?></button>
			</div>
		</div>
	</form>
</div>