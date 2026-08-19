<table style="border: solid 1px;">
	<thead>
		<tr>
			<th>Titre</th>
			<th>Date</th>
			<th>Complétion</th>
			<th>Notes</th>
	</thead>
	<tbody>
		<?php while($admin = $admins->fetch_assoc()): ?>
			<tr style="border: solid 1px;">
				<td style="border: solid 1px;"><?= $admin["title"] ?></td>
				<td style="border: solid 1px;"><?= $admin["date"] ?></td>
				<td style="border: solid 1px;"><?= $admin["completion"] ?></td>
				<td style="border: solid 1px;"><?= $admin["notes"] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>