<div class="bs-example">
	<?php if ( isset($words) && count($words) > 0 ): ?>
		<div class='wrapper'>
			<p><i><b><?= str_replace("{{number}}", $tweet_count, $this->lang->line("user_words_from_tweets")); ?></b></i></p>
			<div class="table-responsive">
				<table class="table table-striped table-hover table-scroll-header">
					<thead>
						<tr class="table-header">
							<th>#</th>
							<th><?= $this->lang->line("user_word"); ?></th>
							<th><?= $this->lang->line("user_count"); ?></th>
							<th><?= $this->lang->line("user_type"); ?></th>
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
								<td><?= $this->lang->line($word->type); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>

					<tfoot>
						<tr class="table-header">
							<th>#</th>
							<th><?= $this->lang->line("user_word"); ?></th>
							<th><?= $this->lang->line("user_count"); ?></th>
							<th><?= $this->lang->line("user_type"); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	<?php else: ?>
		<?= $this->lang->line("user_no_words_found"); ?>
		<p><i><b><?= str_replace("{{number}}", $tweet_count, $this->lang->line("user_words_from_tweets")); ?></b></i></p>
	<?php endif; ?>
</div>