<?php foreach ( $objects as $object ): ?>
<div class="bs-example bs-example-tab page-object" data-page-object-id="<?= $object->id; ?>">
	<div style="display:inline-block;width:100%;">
		<div class="col-sm-offset-1 col-sm-10">
			<div class="col-sm-12">
				<h2><span class="page-name create-page" data-value="<?= $object->name ?>"><?= $object->name ?></span> <small><a href="#" data-page-id="<?= $object->id; ?>" class="edit-page"><?= $this->lang->line("admin_edit_page_name"); ?></a></small>
					<small><a href="#" class="remove-page" data-page-id="<?= $object->id; ?>"><?= $this->lang->line("admin_remove_page"); ?></a></small>
					<small><?= $this->lang->line("admin_page_login_control"); ?><input type="checkbox" class="checkbox access-control" <?= ( $object->login == "true" ) ? 'checked="checked"' : "" ?> /></small>
				</h2>
			</div>
			<div class="form-group col-sm-12">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#urls_<?= $object->id ?>"><?= $this->lang->line("admin_pages_urls_tab"); ?></a></li>
				  	<li><a data-toggle="tab" href="#strings_<?= $object->id ?>"><?= $this->lang->line("admin_pages_strings_tab"); ?></a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="urls_<?= $object->id ?>">
						<div class="col-sm-offset-1 col-sm-5 list-container">
							<?php foreach ( $object->urls as $url ): ?>
								<div class="form-group url-object" style="min-width:600px;" data-object-id="<?= $url["id"]; ?>">
									<label for="url_<?= $object->id; ?>_<?= $url['id']; ?>" class="col-sm-2 control-label"><?= $this->lang->line("admin_page_url"); ?></label>
									<div class="col-sm-10">
										<div class="input-group">
											<input id="url_<?= $object->id; ?>_<?= $url['id']; ?>" type="text" class="form-control create-url" value="<?= $url["url"]; ?>" >
											<span class="input-group-btn">
												<button data-object-id="<?= $url["id"]; ?>" class="btn btn-lg btn-danger button-addon remove-url" type="button"><?= $this->lang->line("admin_remove_item"); ?></button>
											</span>
										</div>
									</div>
								</div>
							<?php endforeach; ?>

							<!-- New URL Start -->
								<?= $this->user_control->LoadTemplate("new_url_view"); ?>
							<!-- New URL End -->

						</div>
					</div>
					<div class="tab-pane" id="strings_<?= $object->id ?>">
						<div class="col-sm-offset-1 col-sm-10 list-container strings-container">
							<?php foreach ( $object->strings as $cat_id =>$category ) : ?>
								<h3><?= $this->lang->line($category["config"]["name"]); ?></h3>
								<div class="category" data-category-id="<?= $cat_id; ?>">
									<?php foreach ( $category["strings"] as $string ): ?>
										<div class="form-group string-object" style="min-width:600px;" data-category-id="<?= $category["config"]["key"]; ?>" data-object-id="<?= $string["id"]; ?>">
											<label for="string_<?= $object->id; ?>_<?= $string['id']; ?>" class="col-sm-2 control-label"><?= $this->lang->line("admin_page_string"); ?></label>
											<div class="col-sm-10">
												<div class="input-group">
													<input data-category-id="<?= $category["config"]["key"]; ?>" data-object-id="<?= $string["id"]; ?>" id="string_<?= $object->id; ?>_<?= $string['id']; ?>" type="text" class="form-control create-string" value="<?= $string["value"]; ?>" >
													<span class="input-group-btn">
														<button data-category-id="<?= $category["config"]["key"]; ?>" data-object-id="<?= $string["id"]; ?>" class="btn btn-lg btn-danger button-addon remove-string" type="button"><?= $this->lang->line("admin_remove_item"); ?></button>
													</span>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
									<!-- New String -->
										<?= $this->user_control->LoadTemplate("new_string_view", array(
											"cat_id" => $cat_id
										)); ?>
									<!-- End new string -->
								</div>

								<hr>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="col-sm-12">
						<hr>

						<h3><?= $this->lang->line("admin_embed_title"); ?></h3>

						<textarea class="embed form-control"><?= $object->embed; ?></textarea>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<?php endforeach; ?>