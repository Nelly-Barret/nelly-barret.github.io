<table class="table table-striped table-hover my-table-three">
	<tbody>
	<?php while($training = $trainings->fetch_assoc()): ?>
		<tr>
			<td><img src="<?=$training["logo_filepath"]?>" class="logo"></img></td>
			<td><b><?=$training["title"] ?></b> (<?=$training["duration"] ?>)<br/><div class="description"><?=$training["content"]?></div></td>
			<?php if($training["webpage"] != ""): ?>
				<td><a href="<?=$training["webpage"]?>" target="_blank">website</a></td>
			<?php else: ?>
				<td></td>
			<?php endif; ?>
		</tr>
	<?php endwhile; ?> 
	</tbody>
</table>