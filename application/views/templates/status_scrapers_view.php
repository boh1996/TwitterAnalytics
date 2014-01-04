<?php if ( count($scrapers) > 0 ): ?>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<th>#</th>
				<th><?= $this->lang->line("admin_scaper"); ?></th>
				<th><?= $this->lang->line("admin_url"); ?></th>
				<th><?= $this->lang->line("admin_action"); ?></th>
			</thead>

			<tbody>
				<?php $index = 0; ?>
				<?php foreach ( $scrapers as $scraper ): ?>
					<?php $index = $index+1; ?>
					<tr>
						<td><strong><?= $index; ?></strong></td>
						<td><?= $this->lang->line($scraper->language_key); ?></td>
						<td><?= $scraper->url; ?></td>
						<td><a class="btn btn-default" data-href="<?= $base_url . $scraper->url ?>"><?= $this->lang->line("admin_run"); ?></a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>

			<tfoot>
				<th>#</th>
				<th><?= $this->lang->line("admin_scaper"); ?></th>
				<th><?= $this->lang->line("admin_url"); ?></th>
				<th><?= $this->lang->line("admin_action"); ?></th>
			</tfoot>
		</table>
	</div>
<?php else: ?>
	<p class="text-muted"><?= $this->lang->line("admin_status_no_scrapers"); ?><p>
<?php endif; ?>