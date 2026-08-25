
<h2>Projets de recherche</h2>
<?php while($task = $project_tasks->fetch_assoc()): ?>
	<?php if(compute_date_difference($TODAY, $task["deadline"]) <= 7): ?>
		<div class="alert alert-danger" role="alert">
			<b><?=$task["short_title"]?>: </b> <?=$task["task"]?>
		</div>
	<?php elseif(compute_date_difference($TODAY, $task["deadline"]) <= 14): ?>
		<div class="alert alert-warning" role="alert">
			<b><?=$task["short_title"]?>: </b> <?=$task["task"]?>
		</div>
	<?php else: ?>
		<div class="alert alert-success" role="alert">
			<b><?=$task["short_title"]?>: </b> <?=$task["task"]?>
		</div>
	<?php endif; ?>
<?php endwhile; ?>