<table class="table table-striped">
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
			<th>Rang</th>
			<th>Notes</th>
	</thead>
	<tbody>
		<?php while($review = $reviews->fetch_assoc()): ?>
			<tr>
				<td><?= $review["acronym"] ?></td> <!-- venue name -->
				<td><?= $review["role"] == "" ? "reviewer" : $review["role"] ?></td>
				<td><?= $review["total_longs"] ?></td>
				<td><?= $review["total_shorts"] ?></td>
				<td><?= $review["done_longs"] ?></td>
				<td><?= $review["done_shorts"] ?></td>
				<td><?= $review["system"] ?></td>
				<td><?= $review["year"] ?></td>
				<td><?= $review["conf_date"] ?></td>
				<td><?= $review["completion"] ?></td>
				<td><?= $review["rank"] ?> (<?= $review["rate"] ?>)</td>
				<td><?= $review["notes"] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>