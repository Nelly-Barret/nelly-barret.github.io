<table class="table table-striped table-hover my-table-four">
	<tbody>
		<?php foreach($items as $item): ?>
		<tr>
			<td><img src="<?=$item["logo_filepath"]?>" class="logo" title="<?= $item['school']?>"/></td>
			<td><?= $item["end_date"] == "2222-01-01" ? $item["semester"]." (since ".date('Y', strtotime($item["start_date"])).")" : $item["semester"]." ".date('Y', strtotime($item["start_date"]))?></td>
			<td><p data-status="<?=$item['status']?>"><?=$item["title"] ?></p> <?=$item["level"] ?>, <?=$item["hours"] ?>h, <?= $item["language"] == "FR" ? "&#x1f1eb;&#x1f1f7;" : "&#x1f1ec;&#x1f1e7;" ?><p class="description"><?=$item["contents"] ?></p></td>
			<td><?= status_badge($item["status"]) ?></td>
		</tr>
	<?php endforeach; ?> 
	</tbody>
</table>