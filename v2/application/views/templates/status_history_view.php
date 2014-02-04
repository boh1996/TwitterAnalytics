<?php if ( count($history) > 0 ): ?>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<th>#</th>
				<th><?= $this->lang->line("admin_error_created_time"); ?></th>
				<th><?= $this->lang->line("admin_tweets_created"); ?></th>
				<th><?= $this->lang->line("admin_tweets_fetched"); ?></th>
				<th><?= $this->lang->line("admin_item_count"); ?></th>
				<th><?= $this->lang->line("admin_scaper"); ?></th>
			</thead>

			<?php $index = 0; ?>
			<?php foreach ( $history as $item ): ?>
				<?php $index = $index+1; ?>
				<tr <?= ( ! empty($item->error_string) ) ? 'class="danger"' : "" ?> >
					<td><strong><?= $index; ?></strong></th>
					<td><i><time datetime="<?= strftime( "%Y-%m-%dT%H:%M:%SZ" , $item->created_at) ?>"><?= strftime( "%d / %m / %Y - %H:%M:%S" , $item->created_at) ?></time></i></td>
					<td><?= $item->tweets_created; ?></td>
					<td><?= $item->tweets_fetched; ?></td>
					<td><?= $item->item_count; ?></td>
					<td><?= $item->scraper; ?></td>
				</tr>
			<?php endforeach; ?>

			<tfoot>
				<th>#</th>
				<th><?= $this->lang->line("admin_error_created_time"); ?></th>
				<th><?= $this->lang->line("admin_tweets_created"); ?></th>
				<th><?= $this->lang->line("admin_tweets_fetched"); ?></th>
				<th><?= $this->lang->line("admin_item_count"); ?></th>
				<th><?= $this->lang->line("admin_scaper"); ?></th>
			</tfoot>
		</table>
	</div>
<?php else: ?>
	<p class="text-muted"><?= $this->lang->line("admin_status_no_history"); ?><p>
<?php endif; ?>