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
						<th><?= $this->lang->line("user_connected_words"); ?></th>
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
							<td>
								<?php if ( ! empty($string->connected) ): ?>
									<?php $connected = array(); ?>
									<?php foreach ( $string->connected as $row ): ?>
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
					<th>#</th>
					<th><?= $this->lang->line("user_word"); ?></th>
					<th><?= $this->lang->line("user_count"); ?></th>
					<th><?= $this->lang->line("user_connected_words"); ?></th>
				</tfoot>
			</table>
		</div>
	<?php else: ?>
		<p class="text-center text-muted">
			<?= $this->lang->line("user_no_words_found"); ?>
		</p>
	<?php endif; ?>
</div>