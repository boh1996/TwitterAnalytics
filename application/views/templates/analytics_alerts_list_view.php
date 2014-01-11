<div class="bs-example">
	<?php if ( isset($alerts) && count($alerts) > 0 ): ?>
		<div class='wrapper'>
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr class="table-header">
							<th>#</th>
							<th><?= $this->lang->line("user_word"); ?></th>
							<th><?= $this->lang->line("user_count"); ?></th>
							<th><?= $this->lang->line("user_unique_tweets"); ?></th>
							<th><?= $this->lang->line("user_connected_words"); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php $index = 0; ?>
						<?php foreach ( $alerts as $alert ) : ?>
							<?php $index = $index + 1; ?>
							<tr>
								<td><?= $index ?></td>
								<td><?= $alert->word; ?></td>
								<td><?= $alert->word_count; ?></td>
								<td><?= $alert->unique_tweets; ?></td>
								<td>
									<?php if ( ! empty($alert->connected) ): ?>
										<?php $connected = array(); ?>
										<?php foreach ( $alert->connected as $row ): ?>
											<?php $connected[] = '<small><i><a href="#">' . $row->word . '</a>[' . $row->word_count . ']</i></small>'; ?>
										<?php endforeach; ?>
										<?= implode($connected, ", "); ?>
									<?php else: ?>
										<?= $this->lang->line("user_no_connected_words"); ?>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>

					<tfoot>
						<tr class="table-header">
							<th>#</th>
							<th><?= $this->lang->line("user_word"); ?></th>
							<th><?= $this->lang->line("user_count"); ?></th>
							<th><?= $this->lang->line("user_unique_tweets"); ?></th>
							<th><?= $this->lang->line("user_connected_words"); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	<?php else: ?>
		<?= $this->lang->line("user_no_words_found"); ?>
	<?php endif; ?>
</div>