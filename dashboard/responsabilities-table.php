<table class="table table-striped">
	<thead>
		<tr>
			<th>Titre</th>
			<th>Date</th>
			<th>Complétion</th>
			<th>Notes</th>
	</thead>
	<tbody>
		<?php while($admin = $admins->fetch_assoc()): ?>
			<tr>
				<td><?= $admin["title"] ?></td>
				<td><?= $admin["date"] ?></td>
				<td><?= $admin["completion"] ?></td>
				<td><?= $admin["notes"] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>