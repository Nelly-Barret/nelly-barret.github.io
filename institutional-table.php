<table class="table table-striped table-hover">
	<tbody>
	<?php while($respo = $responsabilities->fetch_assoc()): ?>
		<tr>
			<td><img src="<?=$respo["logo_filepath"]?>" width="50px"></img></td>
			<td><?=$respo["status"] == 'Current' ? "<b>" : ""?><?= $respo["end_date"] == "1900-01-01" ? "Since ".date('M. Y', strtotime($respo["start_date"])) : date('M. Y', strtotime($respo["start_date"]))." - ".date('M. Y', strtotime($respo["end_date"])) ?><?=$respo["status"] == 'Current' ? "</b>" : ""?></td>
			<td><?=$respo["status"] == 'Current' ? "<b>" : ""?><?=$respo["title"] ?><?=$respo["status"] == 'Current' ? "</b>" : ""?></br/><p style="color: grey"><?=$respo["contents"] ?></p></td>
			<td><?=$respo["status"] == 'Current' ? "<span class='badge text-bg-secondary' style='background-color: green !important'>Current</span>" : "<span class='badge text-bg-secondary'>".$respo["status"]."</span>"?></td>
		</tr>
	<?php endwhile; ?> 
	</tbody>
</table>