<div class="form-group">
	<div class="col-sm-4 col-sm-offset-2">
		<div class="btn-group export" data-type="urls" data-category="<?= $category; ?>">
			<button type="button" class="btn btn-primary"><?= $this->lang->line("admin_export"); ?></button>
			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
				<span class="caret"></span>
				<span class="sr-only"><?= $this->lang->line("admin_export"); ?></span>
		  	</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#" data-value="csv"><?= $this->lang->line("admin_as_csv"); ?></a></li>
				<li><a href="#" data-value="json"><?= $this->lang->line("admin_as_json"); ?></a></li>
				<li><a href="#" data-value="xml"><?= $this->lang->line("admin_as_xml"); ?></a></li>
				<li><a href="#" data-value="txt"><?= $this->lang->line("admin_as_txt"); ?></a></li>
		  	</ul>
		</div>

		<div class="btn-group import" data-type="urls" data-category="<?= $category; ?>">
			<button type="button" class="btn btn-primary"><?= $this->lang->line("admin_import"); ?></button>
			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
				<span class="caret"></span>
				<span class="sr-only"><?= $this->lang->line("admin_export"); ?></span>
		  	</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#" data-value="csv"><?= $this->lang->line("admin_from_csv"); ?></a></li>
				<li><a href="#" data-value="txt"><?= $this->lang->line("admin_from_txt"); ?></a></li>
		  	</ul>
		</div>
	</div>

	<div class="col-sm-4">
		<button class="btn btn-success import-upload"><?= $this->lang->line("admin_upload"); ?></button>
	</div>
</div>
<br>

<form id="upload_form" class="form-signin form-horizontal list-input-form" data-category="<?= $category; ?>" role="form" data-array-name="list" data-placeholder-text="<?= $this->lang->line("admin_new_url"); ?>" data-item-endpoint="admin/url/" data-save-endpoint="admin/urls/save">
	<?php foreach ( $objects as $object ) : ?>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-6">
				<div class="input-group">
					<input data-id="<?= $object->id; ?>" data-value="<?= $object->value ?>" type="text" class="form-control list-input" value="<?= $object->value ?>">
					<span class="input-group-btn">
						<button class="btn btn-lg btn-danger button-addon remove-input" type="button"><?= $this->lang->line("admin_remove_string"); ?></button>
					</span>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-6">
			<div class="input-group">
				<input type="text" class="form-control list-input" placeholder="<?= $this->lang->line("admin_new_url"); ?>">
				<span class="input-group-btn">
					<button class="btn btn-lg btn-danger button-addon remove-input" type="button"><?= $this->lang->line("admin_remove_string"); ?></button>
				</span>
			</div>
		</div>
	</div>

	<hr>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-6">
			<button class="btn btn-lg btn-primary btn-block" type="submit"><?= $this->lang->line("admin_save"); ?></button>
		</div>
	</div>
</form>