<table class="table table-striped table-hover my-table-three">
	<tbody>
	<?php foreach($items as $item): ?>
		<tr>
			<?php if($item["end_date"] == "2222-01-01"): ?>
				<td><?= date('M. Y', strtotime($item["start_date"]))." - now"?></td>
			<?php else: ?>
				<td><?= date('M. Y', strtotime($item["start_date"]))." - ".date('M. Y', strtotime($item["end_date"]))?></td>
			<?php endif; ?>
			<td><p data-status="<?=$item['status']?>"><?=$item["title"] ?></p><a href="<?=$item["webpage"]?>" target="_blank"><?=$item["webpage"]?></a><br/><span class='badge text-bg-secondary'><?=$item["involvement"] ?></span><br/><p class="description"><?=$item["content"] ?></p></td>
			<td><?= status_badge($item["status"]) ?></td>
		</tr>
	<?php endforeach; ?> 
	</tbody>
</table>