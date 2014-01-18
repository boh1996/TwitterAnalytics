<form data-input-class="col-sm-offset-3 col-sm-6" data-ajax-url="admin/alerts/template/connected" class="form-signin form-horizontal list-input-form" role="form" data-array-name="list" data-placeholder-text="<?= $this->lang->line("admin_hidden_word"); ?>" data-item-endpoint="admin/hidden/word/" data-save-endpoint="admin/hidden/words/save">

	<div class="col-sm-10 col-sm-offset-2">
		<div class="page-header">
			<h1><?= $this->lang->line("alert_hidden_connected_words"); ?><small> <?= $this->lang->line("alert_hidden_connected_words_description"); ?></small></h1>
		</div>
	</div>


	<?php foreach ( $hidden_words as $object ) : ?>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-6">
				<div class="input-group">
					<input data-id="<?= $object->id; ?>" data-value="<?= $object->value ?>" type="text" class="form-control list-input" value="<?= $object->value ?>">
					<span class="input-group-btn">
							<button class="btn btn-lg btn-danger button-addon remove-input" type="button"><?= $this->lang->line("admin_remove_hidden_word"); ?></button>
						</span>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<div class="input-group">
				<input type="text" class="form-control list-input" placeholder="<?= $this->lang->line("admin_hidden_word"); ?>">
				<span class="input-group-btn">
						<button class="btn btn-lg btn-danger button-addon remove-input" type="button"><?= $this->lang->line("admin_remove_hidden_word"); ?></button>
					</span>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<button class="btn btn-lg btn-primary btn-block" type="submit"><?= $this->lang->line("admin_save"); ?></button>
		</div>
	</div>
</form>