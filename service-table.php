<table class="table table-striped table-hover my-table-two">
	<tbody>
	<?php foreach($items as $item): ?>
		<tr>
			<td><span class="badge text-bg-secondary"><?=$item["rank"]?></span>&nbsp;<?= $item["name"]?> (<?= $item["acronym"]?>)</td>
			<td><?= $item["years"] ?></td>
		</tr>
	<?php endforeach; ?> 
	</tbody>
</table>