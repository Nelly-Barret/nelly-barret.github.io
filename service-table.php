<table class="table table-striped table-hover">
	<tbody>
	<?php while($service = $services->fetch_assoc()): ?>
		<tr>
			<td><?= $service["name"]?>&nbsp;<span class="badge text-bg-secondary" style="background-color: <?=$COLORS_RANKS[$service['rank']]?> !important"><?=$service["acronym"]?> [<?=$service["rank"]?>]</span></td>
			<td><?= $service["years"] ?></td>
		</tr>
	<?php endwhile; ?> 
	</tbody>
</table>