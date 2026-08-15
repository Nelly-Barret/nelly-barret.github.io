<table class="table table-striped table-hover my-table-three">
	<tbody>
	<?php while($wg = $wgs->fetch_assoc()): ?>
		<tr>
			<?php if($wg["end_date"] == "1900-01-01"): ?>
				<td><?= date('M. Y', strtotime($wg["start_date"]))." - now"?></td>
			<?php else: ?>
				<td><?= date('M. Y', strtotime($wg["start_date"]))." - ".date('M. Y', strtotime($wg["end_date"]))?></td>
			<?php endif; ?>
			<td><?=$wg["status"] == 'Current' ? "<b>" : ""?><?=$wg["title"] ?><?=$wg["status"] == 'Current' ? "</b>" : ""?></br/><span class='badge text-bg-secondary'><?=$wg["involvement"] ?></span><br/><p class="description"><?=$wg["content"] ?></p></td>
			<?php if($wg["status"] == 'Finished'): ?>
				<td><span class='badge text-bg-secondary'>Finished</span></td>
			<?php else: ?>
				<td><span class='badge text-bg-secondary' style='background-color: green !important'>Current</span></td>
			<?php endif; ?>
		</tr>
	<?php endwhile; ?> 
	</tbody>
</table>