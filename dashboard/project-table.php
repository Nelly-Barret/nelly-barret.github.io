<table style="border: solid 1px;">
	<thead>
		<tr>
			<th>Projet</th>
			<th>Ouverture</th>
			<th>Deadline #1</th>
			<th>Deadline #2</th>
			<th>Debut financement</th>
			<th>Leader</th>
			<th>Complétion</th>
			<th>Résultat</th>
			<th>Notes</th>
	</thead>
	<tbody>
		<?php while($project = $projects->fetch_assoc()): ?>
			<tr style="border: solid 1px;">
				<td style="border: solid 1px;"><?= $project["short_title"] ?></td>
				<td style="border: solid 1px;"><?= $project["opening_date"] ?></td>
				<td style="border: solid 1px;"><?= $project["deadline1"] ?></td>
				<td style="border: solid 1px;"><?= $project["deadline2"] ?></td>
				<td style="border: solid 1px;"><?= $project["grant_date"] ?></td>
				<td style="border: solid 1px;"><?= $project["leader"] ?></td>
				<td style="border: solid 1px;"><?= $project["completion"] ?></td>
				<td style="border: solid 1px;"><?= $project["decision"] ?></td>
				<td style="border: solid 1px;"><?= $project["notes"] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>