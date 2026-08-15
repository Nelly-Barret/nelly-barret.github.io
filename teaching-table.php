<table class="table table-striped table-hover">
	<tbody>
	<?php while($course = $courses->fetch_assoc()): ?>
		<tr>
			<td><img src="<?=$course["logo_filepath"]?>" width="50px" title="<?= $course['school']?>"></img></td>
			<td><?= $course["end_date"] == "1900-01-01" ? "Since ".date('M. Y', strtotime($course["start_date"])) : date('M. Y', strtotime($course["start_date"]))." - ".date('M. Y', strtotime($course["end_date"])) ?></td>
			<td><?=$course["title"] ?></br/><p style="color: grey"><?=$course["contents"] ?></p></td>
			<td><?=$course["hours"] ?>h</td>
			<td><?= $course["language"] == "FR" ? "&#x1f1eb;&#x1f1f7;" : "&#x1f1ec;&#x1f1e7;" ?></td>
		</tr>
	<?php endwhile; ?> 
	</tbody>
</table>