
<h2>Projets de recherche</h2>
<?php while($task = $project_tasks->fetch_assoc()): ?>
	<?php include("task_item.php"); ?>
<?php endwhile; ?>


<h2>Stages de recherche</h2>
<?php while($task = $internship_tasks->fetch_assoc()): ?>
	<?php include("task_item.php"); ?>
<?php endwhile; ?>


<h2>Service</h2>
<?php while($task = $service_tasks->fetch_assoc()): ?>
	<?php include("task_item.php"); ?>
<?php endwhile; ?>

<h2>Respos institutionnelles</h2>
<?php while($task = $institutional_tasks->fetch_assoc()): ?>
	<?php include("task_item.php"); ?>
<?php endwhile; ?>
