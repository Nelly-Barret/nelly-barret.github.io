<table class="table table-striped table-hover my-table-four">
	<tbody>
	<?php while($student = $students->fetch_assoc()): ?>
		<tr>
			<td><img src="<?=$student["logo_filepath"]?>" class="logo" title="<?= $student['school']?>"></img></td>
			<td><?= $student["semester"]." ".$student["year"]?></td>
			<td><?= $student["status"] == 'Current' ? "<b>" : ""?><?=$student["topic"] ?><?=$student["status"] == 'Current' ? "</b>" : ""?></br/><p class="description"><?=$student["first_name"]." ".$student["last_name"] ?> (<?=$student["grade"]?>)</p></td>
			<td><?=$student["status"] == 'Finished' ? "<span class='badge text-bg-secondary'>Finished</span>" : "<span class='badge text-bg-success'>Current</span>"?></td>
		</tr>
	<?php endwhile; ?> 
	</tbody>
</table>