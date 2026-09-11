<table class="table table-striped table-hover my-table-four">
	<tbody>
	<?php foreach($items as $item): ?>
		<tr>
			<td><img src="<?=$item["logo_filepath"]?>" class="logo"></img></td>
			<?php if($item["end_date"] == "2222-01-01"): ?>
				<td><?= date('M. Y', strtotime($item["start_date"]))." - now"?></td>
			<?php else: ?>
				<td><?= date('M. Y', strtotime($item["start_date"]))." - ".date('M. Y', strtotime($item["end_date"])) ?></td>
			<?php endif; ?>
			<td><p data-status="<?=$item['status']?>"><?=$item["title"] ?></p><p class="description"><?=$item["content"] ?></p></td>
			<td><?= status_badge($item["status"]) ?></td>
		</tr>
	<?php endforeach; ?> 
	</tbody>
</table>