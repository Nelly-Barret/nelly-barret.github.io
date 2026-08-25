<table id="project_table" class="table table-striped">
	<thead>
		<tr>
			<th>Id</th>
			<th>Projet</th>
			<th>Ouverture</th>
			<th>Deadline #1</th>
			<th>Deadline #2</th>
			<th>Start date</th>
			<th>End date</th>
			<th>Consortium</th>
			<th>Résultat</th>
			<th>Notes</th>
	</thead>
	<tbody>
		<?php while($project = $projects->fetch_assoc()): ?>
			<tr>
				<td><?= $project["prid"] ?></td>
				<td><?= $project["short_title"] ?><br/><input type="range" name="progress_project" min="0" max="100" value="<?= computeProgress($project["start_date"], $project["end_date"]); ?>" step="1"/><?= computeProgress($project["start_date"], $project["end_date"]); ?>%</td>
				<td class="editable" data-id="<?= $project["prid"] ?>" data-field="opening_date"><?= $project["opening_date"] ?></td>
				<td class="editable" data-id="<?= $project["prid"] ?>" data-field="deadline1"><?= $project["deadline1"] ?></td>
				<td class="editable" data-id="<?= $project["prid"] ?>" data-field="deadline2"><?= $project["deadline2"] ?></td>
				<td class="editable" data-id="<?= $project["prid"] ?>" data-field="start_date"><?= $project["start_date"] ?></td>
				<td class="editable" data-id="<?= $project["prid"] ?>" data-field="end_date"><?= $project["end_date"] ?></td>
				<td><?= $project["the_leader"] ?><br/><?= $project["the_team"] ?></td>
				<td><?= $project["status"] ?></td>
				<td class="editable" data-id="<?= $project["prid"] ?>" data-field="notes"><?= $project["notes"] ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>