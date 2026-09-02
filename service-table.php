<table class="table table-striped table-hover my-table-two">
	<tbody>
	<?php while($service = $services->fetch_assoc()): ?>
		<tr>
			<td><span class="badge text-bg-secondary"><?=$service["rank"]?></span>&nbsp;<?= $service["name"]?> (<?= $service["acronym"]?>)</td>
			<td><?= $service["years"] ?></td>
		</tr>
	<?php endwhile; ?> 
	</tbody>
</table>