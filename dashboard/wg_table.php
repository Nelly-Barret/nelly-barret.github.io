<table class="table table-striped">
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
			<tr>
				<td><?= $wg["title"] ?></td>
				<td><?= $wg["adhesion_start"] ?></td>
				<td><?= $wg["adhesion_end"] ?></td>
				<td><?= $wg["role"] ?></td>
				<td><?= $wg["completion"] ?></td>
				<td><?= $wg["notes"] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>