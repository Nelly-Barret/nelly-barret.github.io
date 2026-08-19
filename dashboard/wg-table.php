<table style="border: solid 1px;">
	<thead>
		<tr>
			<th>Titre</th>
			<th>Début adhésion</th>
			<th>Fin adhésion</th>
			<th>Rôle</th>
			<th>Complétion</th>
			<th>Notes</th>
	</thead>
	<tbody>
		<?php while($wg = $wgs->fetch_assoc()): ?>
			<tr style="border: solid 1px;">
				<td style="border: solid 1px;"><?= $wg["title"] ?></td>
				<td style="border: solid 1px;"><?= $wg["adhesion_start"] ?></td>
				<td style="border: solid 1px;"><?= $wg["adhesion_end"] ?></td>
				<td style="border: solid 1px;"><?= $wg["role"] ?></td>
				<td style="border: solid 1px;"><?= $wg["completion"] ?></td>
				<td style="border: solid 1px;"><?= $wg["notes"] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>