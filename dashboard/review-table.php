<table style="border: solid 1px;">
	<thead>
		<tr>
			<th>Venue</th>
			<th>Role</th>
			<th>Total long</th>
			<th>Total court/demo</th>
			<th>Done long</th>
			<th>Done court/demo</th>
			<th>Système</th>
			<th>Deadline review</th>
			<th>Date conference</th>
			<th>Complétion</th>
			<th>Taux acceptation</th>
			<th>Rang</th>
			<th>Notes</th>
	</thead>
	<tbody>
		<?php while($review = $reviews->fetch_assoc()): ?>
			<tr style="border: solid 1px;">
				<td style="border: solid 1px;"><?= $review["venue"] ?></td>
				<td style="border: solid 1px;"><?= $review["role"] ?></td>
				<td style="border: solid 1px;"><?= $review["total_longs"] ?></td>
				<td style="border: solid 1px;"><?= $review["total_shorts"] ?></td>
				<td style="border: solid 1px;"><?= $review["done_longs"] ?></td>
				<td style="border: solid 1px;"><?= $review["done_shorts"] ?></td>
				<td style="border: solid 1px;"><?= $review["system"] ?></td>
				<td style="border: solid 1px;"><?= $review["deadline_review"] ?></td>
				<td style="border: solid 1px;"><?= $review["conf_date"] ?></td>
				<td style="border: solid 1px;"><?= $review["completion"] ?></td>
				<td style="border: solid 1px;"><?= $review["rate"] ?></td>
				<td style="border: solid 1px;"><?= $review["rank"] ?></td>
				<td style="border: solid 1px;"><?= $review["notes"] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>