<div class="bs-example">
	<?php if ( isset($words) && count($words) > 0 ): ?>
		<div class='wrapper'>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr class="table-header">
							<th>#</th>
							<th><?= $this->lang->line("user_word"); ?></th>
							<th><?= $this->lang->line("user_count"); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php $index = 0; ?>
						<?php foreach ( $words as $word ) : ?>
							<?php $index = $index + 1; ?>
							<tr>
								<td><?= $index ?></td>
								<td><?= $word->word; ?></td>
								<td><?= $word->word_count; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>

					<tfoot>
						<tr class="table-header">
							<th>#</th>
							<th><?= $this->lang->line("user_word"); ?></th>
							<th><?= $this->lang->line("user_count"); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	<?php else: ?>
		<?= $this->lang->line("user_no_words_found"); ?>
	<?php endif; ?>
</div>