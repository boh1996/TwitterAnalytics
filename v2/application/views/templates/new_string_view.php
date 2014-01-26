<div class="form-group string-object" style="min-width:600px;" data-category-id="<?= $cat_id; ?>">
	<label class="col-sm-2 control-label"><?= $this->lang->line("admin_add_string"); ?></label>
	<div class="col-sm-10">
		<div class="input-group">
			<input type="text" data-category-id="<?= $cat_id; ?>" class="form-control create-string add-string" placeholder="<?= $this->lang->line("admin_add_string"); ?>" >
			<span class="input-group-btn">
				<button data-category-id="<?= $cat_id; ?>" class="btn btn-lg btn-danger button-addon remove-string" type="button"><?= $this->lang->line("admin_remove_item"); ?></button>
			</span>
		</div>
	</div>
</div>