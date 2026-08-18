<table style="border: solid 1px;">
	<thead>
		<tr>
			<th>Projet</th>
			<th>Institution</th>
			<th>Début</th>
			<th>Fin</th>
			<th>Leader</th>
			<th>Complétion</th>
			<th>Manuscrit rendu</th>
			<th>Soutenance faite</th>
			<th>Evaluation rendue</th>
			<th>Notes</th>
	</thead>
	<tbody>
		<?php while($internship = $internships->fetch_assoc()): ?>
			<tr style="border: solid 1px;">
				<td style="border: solid 1px;"><?= $internship["short_title"] ?></td>
				<td style="border: solid 1px;"><?= $internship["school"] ?></td>
				<td style="border: solid 1px;"><?= $internship["start_date"] ?></td>
				<td style="border: solid 1px;"><?= $internship["end_date"] ?></td>
				<td style="border: solid 1px;"><?= $internship["completion"] ?></td>
				<td style="border: solid 1px;"><?= $internship["manuscript"] ?></td>
				<td style="border: solid 1px;"><?= $internship["defense"] ?></td>
				<td style="border: solid 1px;"><?= $internship["grade"] ?></td>
				<td style="border: solid 1px;"><?= $internship["notes"] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>