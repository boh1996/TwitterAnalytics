<div class="bs-example">
	<p class="lead text-center">
		<?= $this->lang->line("user_alerts"); ?>
	</p>

	<?php if ( isset($alert_words) && count($alert_words) > 0 ): ?>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th><?= $this->lang->line("user_word"); ?></th>
						<th><?= $this->lang->line("user_count"); ?></th>
					</tr>
				</thead>

				<tbody>
					<?php $index = 0; ?>
					<?php foreach ( $alert_words as $word ) : ?>
						<?php $index = $index + 1; ?>
						<tr>
							<td><?= $index ?></td>
							<td><?= $word->value; ?></td>
							<td><?= $word->count; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>

				<tfoot>
					<th>#</th>
					<th><?= $this->lang->line("user_word"); ?></th>
					<th><?= $this->lang->line("user_count"); ?></th>
				</tfoot>
			</table>
		</div>
	<?php else: ?>
		<p class="text-center text-muted">
			<?= $this->lang->line("user_no_words_found"); ?>
		</p>
	<?php endif; ?>
</div>