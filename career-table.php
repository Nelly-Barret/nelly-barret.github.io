<table class="table table-striped table-hover my-table-three">
	<tbody>
	<?php foreach($items as $item): ?>
		<tr>
			<td><img src="<?=$item["logo_filepath"]?>" class="logo"></img></td>
			<td><b><?=$item["title"] ?></b> (<?=$item["duration"] ?>)<br/><div class="description"><?=$item["content"]?></div></td>
			<?php if($item["webpage"] != ""): ?>
				<td><a href="<?=$item["webpage"]?>" target="_blank">website</a></td>
			<?php else: ?>
				<td></td>
			<?php endif; ?>
		</tr>
	<?php endforeach; ?> 
	</tbody>
</table>