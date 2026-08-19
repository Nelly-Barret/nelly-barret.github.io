<table style="border: solid 1px;">
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
			<tr style="border: solid 1px;">
				<td style="border: solid 1px;"><?= $service["name"] ?></td>
				<td style="border: solid 1px;"><?= $service["duty_date"] ?></td>
				<td style="border: solid 1px;"><?= $service["conf_date"] ?></td>
				<td style="border: solid 1px;"><?= $service["role"] ?></td>
				<td style="border: solid 1px;"><?= $service["completion"] ?></td>
				<td style="border: solid 1px;"><?= $service["rank"] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>