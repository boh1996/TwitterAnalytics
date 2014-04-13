<form id="import_form" method="post" enctype="multipart/form-data">
	<input type="file" name="file" id="import_file" style="visibility:hidden;position:absolute;top:0;left:0">
	<input type="text" style="visibility:hidden;position:absolute;top:0;left:0" name="url" id="url">
</form>

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

	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-3">
			<div class="btn-group export" data-type="hidden_words">
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

			<div class="btn-group import" data-type="hidden_words">
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
			<button class="btn btn-success" id="import_upload"><?= $this->lang->line("admin_upload"); ?></button>
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