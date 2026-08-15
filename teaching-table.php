<table class="table table-striped table-hover my-table-four">
	<tbody>
	<?php while($course = $courses->fetch_assoc()): ?>
		<tr>
			<td><img src="<?=$course["logo_filepath"]?>" class="logo" title="<?= $course['school']?>"></img></td>
			<td><?= $course["end_date"] == "1900-01-01" ? $course["semester"]." (since ".date('Y', strtotime($course["start_date"])).")" : $course["semester"]." ".date('Y', strtotime($course["start_date"]))?></td>
			<td><?=$course["status"] == 'Current' ? "<b>" : ""?><?=$course["title"] ?><?=$course["status"] == 'Current' ? "</b>" : ""?> (<?=$course["hours"] ?>h, <?= $course["language"] == "FR" ? "&#x1f1eb;&#x1f1f7;" : "&#x1f1ec;&#x1f1e7;" ?>)</br/><p class="description"><?=$course["contents"] ?></p></td>
			<td><?=$course["status"] == 'Finished' ? "<span class='badge text-bg-secondary'>Finished</span>" : "<span class='badge text-bg-secondary' style='background-color: green !important'>Current</span>"?></td>
		</tr>
	<?php endwhile; ?> 
	</tbody>
</table>