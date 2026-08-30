<table class="table table-striped table-hover my-table-four">
	<tbody>
	<?php while($student = $students->fetch_assoc()): ?>
		<tr>
			<td><img src="<?=$student["logo_filepath"]?>" class="logo" title="<?= $student['school']?>"></img></td>
			<td><?= $student["semester"]." ".$student["year"]?></td>
			<td>
				<?= $student["status"] == 'Current' ? "<b>" : ""?><?=$student["topic"] ?><?=$student["status"] == 'Current' ? "</b>" : ""?>
				<?php if($student["manuscript"] != ""): ?>
					<a href="<?=$student["manuscript"]?>" target="_blank"><i class="fa-solid fa-file-pdf black-fa"></i></a>
				<?php endif; ?>
				<?php if($student["slides"] != ""): ?>
					<a href="<?=$student["slides"]?>" target="_blank"><i class="fa-solid fa-file-powerpoint black-fa"></i></a>
				<?php endif; ?>
				</br/>
				<p class="description">
					<u>Student:</u> <?=$student["first_name"]." ".$student["last_name"] ?> (<?=$student["level"]?>)
					<br/>
					<u>Supervision team:</u> <?=$student["the_team"]?>
				</p>
			</td>
			<td><?=$student["status"] == 'Finished' ? "<span class='badge text-bg-secondary status'>Finished</span>" : "<span class='badge text-bg-success status'>Current</span>"?></td>
		</tr>
	<?php endwhile; ?> 
	</tbody>
</table>