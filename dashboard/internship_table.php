<table id="internship_table" class="table table-striped">
	<thead>
		<tr>
			<th>Id</th>
			<th>Titre</th>
			<th>Equipe encadrante</th>
			<th>Date soutenance</th>
			<th>Manuscrit</th>
			<th>Slides</th>
			<th>Evaluation rendue</th>
			<th>Notes</th>
		</tr>
	</thead>
	<tbody>
		<?php while($internship = $internships->fetch_assoc()): ?>
			<tr>
				<td><?= $internship["iid"] ?></td>
				<td><?= $internship["the_intern"] ?> (<?= $internship["level"] ?>, <?= $internship["school"] ?>)<br/><?= $internship["start_date"] ?> - <?= $internship["end_date"] ?><p style="color: grey;"><?= $internship["topic"] ?></p><input type="range" name="progressInternship" min="0" max="100" value="<?= computeProgress($internship["start_date"], $internship["end_date"]); ?>" step="1"/><?= computeProgress($internship["start_date"], $internship["end_date"]); ?>%</td>
				<td><?= $internship["the_team"] ?></td>
				<td class="editable" data-id="<?= $internship["iid"] ?>" data-field="defense_date"><?= $internship["defense_date"] ?></td>
				<td class="editable" data-id="<?= $internship["iid"] ?>" data-field="manuscript"><?= $internship["manuscript"] ?></td>
				<td class="editable" data-id="<?= $internship["iid"] ?>" data-field="slides"><?= $internship["slides"] ?></td>
				<td class="editable" data-id="<?= $internship["iid"] ?>" data-field="grade"><?= $internship["grade"] ?></td>
				<td class="editable" data-id="<?= $internship["iid"] ?>" data-field="notes"><?= $internship["notes"] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>