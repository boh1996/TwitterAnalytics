<?php if ( count($history) > 0 ): ?>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<th>#</th>
				<th><?= $this->lang->line("admin_tweets_created"); ?></th>
				<th><?= $this->lang->line("admin_tweets_fetched"); ?></th>
				<th><?= $this->lang->line("admin_item_count"); ?></th>
			</thead>

			<?php $index = 0; ?>
			<?php foreach ( $history as $item ): ?>
				<?php $index = $index+1; ?>
				<tr <?= ( ! empty($item->error_string) ) ? 'class="danger"' : "" ?> >
					<td><strong><?= $index; ?></strong></th>
					<td><?= $item->tweets_created; ?></td>
					<td><?= $item->tweets_fetched; ?></td>
					<td><?= $item->item_count; ?></td>
				</tr>
			<?php endforeach; ?>

			<tfoot>
				<th>#</th>
				<th><?= $this->lang->line("admin_tweets_created"); ?></th>
				<th><?= $this->lang->line("admin_tweets_fetched"); ?></th>
				<th><?= $this->lang->line("admin_item_count"); ?></th>
			</tfoot>
		</table>
	</div>
<?php else: ?>
	<p class="text-muted"><?= $this->lang->line("admin_status_no_history"); ?><p>
<?php endif; ?>