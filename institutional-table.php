<table class="table table-striped table-hover my-table-four">
	<tbody>
	<?php while($respo = $responsabilities->fetch_assoc()): ?>
		<tr>
			<td><img src="<?=$respo["logo_filepath"]?>" class="logo"></img></td>
			<?php if($respo["end_date"] == "1900-01-01"): ?>
				<td><?= date('M. Y', strtotime($respo["start_date"]))." - now"?></td>
			<?php else: ?>
				<td><?= date('M. Y', strtotime($respo["start_date"]))." - ".date('M. Y', strtotime($respo["end_date"])) ?></td>
			<?php endif; ?>
			<td><?=$respo["status"] == 'Current' ? "<b>" : ""?><?=$respo["title"] ?><?=$respo["status"] == 'Current' ? "</b>" : ""?></br/><p class="description"><?=$respo["content"] ?></p></td>
			<?php if($respo["status"] == "Current"): ?>
				<td><span class='badge text-bg-success'>Current</span></td>
			<?php else: ?>
				<td><span class='badge text-bg-secondary'>Finished</span></td>
			<?php endif; ?>
		</tr>
	<?php endwhile; ?> 
	</tbody>
</table>