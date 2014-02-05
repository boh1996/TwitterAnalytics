<h4 class='text-center'><?= $this->lang->line("user_categories"); ?></h4>
<table class='table table-striped'>
	<thead>
		<th>#</th>
		<th><?= $this->lang->line("user_string_category"); ?></th>
		<th><?= $this->lang->line("user_count_string"); ?></th>
	</thead>

	<tbody>
		<?php $index = 0; ?>
		<?php foreach ( $strings["categories"] as $key => $count ): ?>
		<?php $index++; ?>
			<tr>
				<td><?= $index; ?></td>
				<td><?= $key; ?></td>
				<td><?= $count; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>

	<tfoot>
		<th>#</th>
		<th><?= $this->lang->line("user_string_category"); ?></th>
		<th><?= $this->lang->line("user_count_string"); ?></th>
	</tfoot>
</table>

<h4 class='text-center'><?= $this->lang->line("user_strings"); ?></h4>
<table class='table table-striped'>
	<thead>
		<th>#</th>
		<th><?= $this->lang->line("user_string"); ?></th>
		<th><?= $this->lang->line("user_string_category"); ?></th>
		<th><?= $this->lang->line("user_count_string"); ?></th>
	</thead>

	<tbody>
		<?php $index = 0; ?>
		<?php foreach ( $strings["strings"] as $key => $row ): ?>
		<?php $index++; ?>
			<tr>
				<td><?= $index; ?></td>
				<td><?= $row->value; ?></td>
				<td><?= $row->category; ?></td>
				<td><?= $row->string_count; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>

	<tfoot>
		<th>#</th>
		<th><?= $this->lang->line("user_string"); ?></th>
		<th><?= $this->lang->line("user_string_category"); ?></th>
		<th><?= $this->lang->line("user_count_string"); ?></th>
	</tfoot>
</table>