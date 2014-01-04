<div class="bs-example">
	<p class="lead text-center">
		<?= $this->lang->line("user_alerts"); ?>
	</p>

	<?php if ( isset($alert_strings) && count($alert_strings) > 0 ): ?>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th><?= $this->lang->line("user_word"); ?></th>
						<th><?= $this->lang->line("user_count"); ?></th>
						<th><?= $this->lang->line("user_unique_tweets"); ?></th>
					</tr>
				</thead>

				<tbody>
					<?php $index = 0; ?>
					<?php foreach ( $alert_strings as $string ) : ?>
						<?php $index = $index + 1; ?>
						<tr>
							<td><?= $index ?></td>
							<td><?= $string->word; ?></td>
							<td><?= $string->word_count; ?></td>
							<td><?= $string->unique_tweets; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>

				<tfoot>
					<th>#</th>
					<th><?= $this->lang->line("user_word"); ?></th>
					<th><?= $this->lang->line("user_count"); ?></th>
					<th><?= $this->lang->line("user_unique_tweets"); ?></th>
				</tfoot>
			</table>
		</div>
	<?php else: ?>
		<p class="text-center text-muted">
			<?= $this->lang->line("user_no_words_found"); ?>
		</p>
	<?php endif; ?>
</div>