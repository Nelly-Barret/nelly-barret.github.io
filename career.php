<?php
require('db.php');
try {
	$SQL_CURRENT_COURSES = "SELECT * FROM course WHERE end_date = '1900-01-01';";
	$current_courses = $conn->query($SQL_CURRENT_COURSES);

	$SQL_FORMER_COURSES = "SELECT * FROM course WHERE end_date > '1900-01-01';";
	$former_courses = $conn->query($SQL_FORMER_COURSES);

	

	$SQL_ALL_TRAINING = "SELECT * FROM training;";
	$trainings = $conn->query($SQL_ALL_TRAINING);
} catch (Exception $e) {
	var_dump($e);
}

?>

<!DOCTYPE html>

<html lang="fr">
<?php include 'head.php'; ?>
    
<body>
	<?php include 'navbar.php'; ?>
    
    <section class="anchor light">
		<h1 class="section-title">Education</h1>
		<p class="todo">TODO</p>

		<h1 class="section-title">Awards</h1>
		<p class="todo">TODO</p>
	
		<h1 class="section-title">Training activities</h1>
		<table class="table table-striped table-hover">
			<tbody>
			<?php while($training = $trainings->fetch_assoc()): ?>
				<tr>
					<td><img src="<?=$training["logo_filepath"]?>" width="50px"></img></td>
					<td><?=$training["title"] ?></td>
					<td><?=$training["duration"] ?></td>
					<?php if($training["webpage"] != ""): ?>
						<td><a href="<?=$training["webpage"]?>" target="_blank">website</a></td>
					<?php endif; ?>
				</tr>
			<?php endwhile; ?> 
			</tbody>
		</table>
		<ul>
		<?php 
			while($training = $trainings->fetch_assoc()): ?>
			<li>
				<?= $training["title"] ?> (<?= $training["duration"] ?>)
			</li>
        <?php endwhile; ?> 
		</ul>
    </section>
</body>
</html>