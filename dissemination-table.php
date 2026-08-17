<table class="table table-striped table-hover my-table-four">
	<tbody>
	<?php while($talk = $talks->fetch_assoc()): ?>
		<tr>
			<td><img src="<?=$talk["logo_filepath"]?>" class="logo"></img><?=$talk["location"]?></td>
			<td><?=date('F Y', strtotime($talk["date"])) ?></td>
			<td><?=$talk["title"] ?> <?= $talk["language"] == "FR" ? "&#x1f1eb;&#x1f1f7;" : "&#x1f1ec;&#x1f1e7;" ?><br/><span class="badge text-bg-secondary"><?=$talk["crowd"] ?></span></td>
			<?php if($talk["resource"] != ""): ?>
				<?php if(strpos($talk["resource"], 'youtube') !== false): ?>
					<td><a href="<?=$talk["resource"]?>" target="_blank">video</a></td>
				<?php elseif(strpos($talk["resource"], 'zenodo') !== false): ?>
					<td><a href="<?=$talk["resource"]?>" target="_blank">PDF slides</a></td>
				<?php else: ?>
					<td><a href="<?=$talk["resource"]?>" target="_blank">website</a></td>
				<?php endif; ?>
			<?php else: ?>
				<td></td>
			<?php endif; ?>
		</tr>
	<?php endwhile; ?> 
	</tbody>
</table>