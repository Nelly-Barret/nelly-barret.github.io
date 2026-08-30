<?php if(compute_date_difference($TODAY, $task["deadline"]) <= 7): ?>
	<div class="alert alert-danger" role="alert">
		<div class="alert-container">
			<div>
				<i class="bi bi-exclamation-triangle"></i>
				<b><?=$task["title"]?>: </b> <?=$task["task"]?>
			</div>
			<div>
				<span class="deadline">August 31, 2026</span>
				<input type="checkbox" <?= $task['done'] == 1 ? 'checked' : '' ?>/>
			</div>
		</div>
	</div>
<?php elseif(compute_date_difference($TODAY, $task["deadline"]) <= 14): ?>
	<div class="alert alert-warning" role="alert">
		<b><?=$task["title"]?>: </b> <?=$task["task"]?>
	</div>
<?php else: ?>
	<div class="alert alert-success" role="alert">
		<b><?=$task["title"]?>: </b> <?=$task["task"]?>
	</div>
<?php endif; ?>