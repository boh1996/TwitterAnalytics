<?php if ( count($errors) > 0 ): ?>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<th>#</th>
				<th><?= $this->lang->line("admin_error_created_time"); ?></th>
				<th><?= $this->lang->line("admin_error_string"); ?></th>
				<th><?= $this->lang->line("admin_error_url"); ?></th>
				<th><?= $this->lang->line("admin_error_item_type"); ?></th>
			</thead>

			<?php $index = 0; ?>
			<?php foreach ( $errors as $error ): ?>
				<?php $index = $index+1; ?>
				<tr>
					<td><strong><?= $index; ?></strong></th>
					<td><i><time datetime="<?= strftime( "%Y-%m-%dT%H:%M:%SZ" , $error->created_at) ?>"><?= strftime( "%d / %m / %Y - %H:%M:%S" , $error->created_at) ?></time></i></td>
					<td><?= $error->error_string; ?></td>
					<td><?= $error->url; ?></td>
					<td><?= $error->item_type; ?></td>
				</tr>
			<?php endforeach; ?>

			<tfoot>
				<th>#</th>
				<th><?= $this->lang->line("admin_error_created_time"); ?></th>
				<th><?= $this->lang->line("admin_error_string"); ?></th>
				<th><?= $this->lang->line("admin_error_url"); ?></th>
				<th><?= $this->lang->line("admin_error_item_type"); ?></th>
			</tfoot>
		</table>
	</div>
<?php else: ?>
	<p class="text-muted"><?= $this->lang->line("admin_status_no_errors"); ?><p>
<?php endif; ?>