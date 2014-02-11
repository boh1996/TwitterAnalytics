<div class="bs-example bs-example-tab page-object add-page">
	<div style="display:inline-block;width:100%;">
		<div class="col-sm-offset-1 col-sm-10">

			<div class="col-sm-12">
				<h2><span class="page-name create-page" data-value="<?= $this->lang->line("admin_create_page"); ?>"><?= $this->lang->line("admin_create_page"); ?></span> <small><a href="#" class="edit-page">
					<?= $this->lang->line("admin_edit_page_name"); ?></a></small>
					<small><a href="#" class="remove-page"><?= $this->lang->line("admin_remove_page"); ?></a></small>
					<small><?= $this->lang->line("admin_page_login_control"); ?><input type="checkbox" class="checkbox access-control" /></small>
					<small><?= $this->lang->line("admin_exact_match"); ?><input type="checkbox" class="checkbox exact-match" /></small>
				</h2>
			</div>
			<div class="form-group col-sm-12">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#urls_create_new_template"><?= $this->lang->line("admin_pages_urls_tab"); ?></a></li>
				  	<li><a data-toggle="tab" href="#strings_create_template_new"><?= $this->lang->line("admin_pages_strings_tab"); ?></a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="urls_create_new_template">
						<div class="col-sm-offset-1 col-sm-5 list-container">
							<!-- New URL Start -->
								<?= $this->user_control->LoadTemplate("new_url_view"); ?>
							<!-- New URL End -->

						</div>
					</div>

					<div class="tab-pane" id="strings_create_template_new">
						<div class="col-sm-offset-1 col-sm-10 list-container strings-container">
							<?php foreach ( $this->config->item("categories") as $cat_id => $category ) : ?>
								<h3><?= $this->lang->line($category["name"]); ?></h3>
								<div class="category" data-category-id="<?= $cat_id; ?>">
									<!-- New String -->
										<?= $this->user_control->LoadTemplate("new_string_view"); ?>
									<!-- End new string -->
								</div>

								<hr>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="col-sm-12">
						<hr>

						<h3><?= $this->lang->line("admin_embed_title"); ?></h3>

						<textarea class="embed form-control"></textarea>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>