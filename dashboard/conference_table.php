<table class="table table-striped">
	<thead>
		<tr>
			<th>Venue</th>
			<th>Début respo</th>
			<th>Date conférence</th>
			<th>Rôle</th>
			<th>Complétion</th>
			<th>Rang</th>
			<th>Notes</th>
	</thead>
	<tbody>
		<?php while($service = $services->fetch_assoc()): ?>
			<tr>
				<td><?= $service["acronym"] ?></td>
				<td><?= $service["year"] ?></td>
				<td><?= $service["conf_date"] ?></td>
				<td><?= $service["role"] ?></td>
				<td><?= $service["completion"] ?></td>
				<td><?= $service["rank"] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>