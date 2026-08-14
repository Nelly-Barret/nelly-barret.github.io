<table class="table table-striped table-hover">
	<tbody>
	<?php while($course = $courses->fetch_assoc()): ?>
		<tr>
			<td><img src="<?=$course["logo_filepath"]?>" width="50px"></img></td>
			<td><?=date('F Y', strtotime($course["date"])) ?></td>
			<td><?=$course["title"] ?></td>
			<td><?= $course["language"] ?></td>
		</tr>
	<?php endwhile; ?> 
	</tbody>
</table>