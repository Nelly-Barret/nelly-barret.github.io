<table class="table table-striped table-hover my-table-four">
	<tbody>
	<?php foreach($items as $item): ?>
		<tr>
			<td><img src="<?=$item["logo_filepath"]?>" class="logo"></img></td>
			<td><?=date('F Y', strtotime($item["date"])) ?>, <?=$item["location"]?></td>
			<td><?=$item["title"] ?> <?= $item["language"] == "FR" ? "&#x1f1eb;&#x1f1f7;" : "&#x1f1ec;&#x1f1e7;" ?>&nbsp;<span class="badge text-bg-secondary"><?=$item["crowd"] ?></span></td>
			<?php if($item["resource"] != ""): ?>
				<?php if(strpos($item["resource"], 'youtube') !== false): ?>
					<td><a href="<?=$item["resource"]?>" target="_blank">video</a></td>
				<?php elseif(strpos($item["resource"], 'zenodo') !== false): ?>
					<td><a href="<?=$item["resource"]?>" target="_blank">PDF slides</a></td>
				<?php else: ?>
					<td><a href="<?=$item["resource"]?>" target="_blank">website</a></td>
				<?php endif; ?>
			<?php else: ?>
				<td></td>
			<?php endif; ?>
		</tr>
	<?php endforeach; ?> 
	</tbody>
</table>