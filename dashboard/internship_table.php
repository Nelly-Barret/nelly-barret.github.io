<table id="internship_table" class="table table-striped">
	<thead>
		<tr>
			<th>Id</th>
			<th>Titre</th>
			<th>Equipe encadrante</th>
			<th>Dates</th>
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
				<td><?= $internship["suid"] ?></td>
				<td><?= $internship["the_intern"] ?> (<?= $internship["level"] ?>, <?= $internship["school"] ?>)<br/><p style="color: grey;"><?= $internship["topic"] ?></p><br/><input type="range" name="progressInternship" min="0" max="100" value="<?= computeProgress($internship["start_date"], $internship["end_date"]); ?>" step="1"/><?= computeProgress($internship["start_date"], $internship["end_date"]); ?>%</td>
				<td><?= $internship["the_team"] ?></td>
				<td class="editable" data-id="<?= $internship["suid"] ?>" data-field="start_date"><?= $internship["start_date"] ?><br/><?= $internship["end_date"] ?></td>
				<td class="editable" data-id="<?= $internship["suid"] ?>" data-field="defense_date"><?= $internship["defense_date"] ?></td>
				<td class="editable" data-id="<?= $internship["suid"] ?>" data-field="manuscript"><?= $internship["manuscript"] ?></td>
				<td class="editable" data-id="<?= $internship["suid"] ?>" data-field="slides"><?= $internship["slides"] ?></td>
				<td class="editable" data-id="<?= $internship["suid"] ?>" data-field="grade"><?= $internship["grade"] ?></td>
				<td class="editable" data-id="<?= $internship["suid"] ?>" data-field="notes"><?= $internship["notes"] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>