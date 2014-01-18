<form class="form-signin form-horizontal list-input-form" role="form" data-array-name="list" data-placeholder-text="<?= $this->lang->line("admin_add_hidden_word"); ?>" data-item-endpoint="admin/hide/word/" data-save-endpoint="admin/hide/words/save">
	<div class="col-sm-10 col-sm-offset-3">
		<div class="page-header">
			<h1><?= $this->lang->line("admin_hidden_words_title"); ?><small> <?= $this->lang->line("admin_hidden_words_description"); ?></small></h1>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-8" id="errors">
		</div>
	</div>

	<?php foreach ( $objects as $object ) : ?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-6">
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
			<div class="col-sm-offset-4 col-sm-6">
				<div class="input-group">
					<input type="text" class="form-control list-input" placeholder="<?= $this->lang->line("admin_add_hidden_word"); ?>">
					<span class="input-group-btn">
							<button class="btn btn-lg btn-danger button-addon remove-input" type="button"><?= $this->lang->line("admin_remove_hidden_word"); ?></button>
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