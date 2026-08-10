<?php
require('db.php');
try {
	$SQL_CURRENT_COURSES = "SELECT * FROM course WHERE end_date = '1900-01-01';";
	$current_courses = $conn->query($SQL_CURRENT_COURSES);

	$SQL_FORMER_COURSES = "SELECT * FROM course WHERE end_date > '1900-01-01';";
	$former_courses = $conn->query($SQL_FORMER_COURSES);

	$SQL_CURRENT_SUPERVISION = "SELECT * FROM supervision WHERE year >= YEAR(CURDATE());";
	$current_supervisions = $conn->query($SQL_CURRENT_SUPERVISION);

	$SQL_FORMER_SUPERVISION = "SELECT * FROM supervision WHERE year < YEAR(CURDATE());";
	$former_supervisions = $conn->query($SQL_FORMER_SUPERVISION);

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
    
    <!-- SECTION TALKS -->
    <section class="anchor light">
		<h1 class="section-title">Courses</h1>
		
		<h2>Current courses</h2>
		<ul>
		<?php 
			while($course = $current_courses->fetch_assoc()): ?>
			<li>
				<?= $course["title"] ?> (<?= $course["language"] ?>)
			</li>
        <?php endwhile; ?> 
		</ul>

		<h2>Former courses</h2>
		<ul>
		<?php 
			while($course = $former_courses->fetch_assoc()): ?>
			<li>
				<?= $course["title"] ?> (<?= $course["language"] ?>)
			</li>
        <?php endwhile; ?> 
		</ul>
		</details>

		
		<h1 class="section-title"><i class="fa-solid fa-graduation-cap"></i> Student supervision</h1>
		<h2>Current students</h2>
		<ul>
		<?php 
			while($supervision = $current_supervisions->fetch_assoc()): ?>
			<li>
				<?= $supervision["topic"] ?> (<?= $supervision["school"] ?>)
			</li>
        <?php endwhile; ?> 
		</ul>

		<details>
		<summary>Former students</summary>
		<ul>
		<?php 
			while($supervision = $former_supervisions->fetch_assoc()): ?>
			<li>
				<?= $supervision["topic"] ?> (<?= $supervision["school"] ?>)
			</li>
        <?php endwhile; ?> 
		</ul>
		</details>


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