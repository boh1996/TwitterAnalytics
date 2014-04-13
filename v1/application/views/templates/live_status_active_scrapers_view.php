<?php if ( count($active) > 0 ): ?>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<th>#</th>
				<th><?= $this->lang->line("admin_scaper_started_at"); ?></th>
				<th><?= $this->lang->line("admin_item_status"); ?></th>
			</thead>

			<?php $index = 0; ?>
			<?php foreach ( $active as $item ): ?>
				<?php $index = $index+1; ?>
				<tr>
					<td><strong><?= $index; ?></strong></th>
					<td><i><time datetime="<?= strftime( "%Y-%m-%dT%H:%M:%SZ" , $item->created_at) ?>"><?= strftime( "%d / %m / %Y - %H:%M:%S" , $item->created_at) ?></time></i></td>
					<td><?= $item->max_item_number . "/".$item->item_count; ?></td>
				</tr>
			<?php endforeach; ?>

			<tfoot>
				<th>#</th>
				<th><?= $this->lang->line("admin_scaper_started_at"); ?></th>
				<th><?= $this->lang->line("admin_item_status"); ?></th>
			</tfoot>
		</table>
	</div>
<?php else: ?>
	<p class="text-muted"><?= $this->lang->line("admin_status_no_active_scrapers"); ?><p>
<?php endif; ?>