<?php
require('db.php');
try {
	$SQL_ALL_SUPERVISION = "SELECT * FROM supervision;";
	$supervisions = $conn->query($SQL_ALL_SUPERVISION);

	$SQL_ALL_TRAINING = "SELECT * FROM training;";
	$trainings = $conn->query($SQL_ALL_TRAINING);

	$SQL_CURRENT_COURSES = "SELECT * FROM course WHERE end_date = '1900-01-01';";
	$current_courses = $conn->query($SQL_CURRENT_COURSES);

	$SQL_FORMER_COURSES = "SELECT * FROM course WHERE end_date > '1900-01-01';";
	$former_courses = $conn->query($SQL_FORMER_COURSES);
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
		<h1><i class="fa-solid fa-chalkboard-user"></i> Courses</h1>
		<ul>
		<?php 
			while($course = $current_courses->fetch_assoc()): ?>
			<li>
				<?= $course["title"] ?> (<?= $course["language"] ?>)
			</li>
        <?php endwhile; ?> 
		</ul>

		<details>
		<summary>Former courses</summary>
		<ul>
		<?php 
			while($course = $former_courses->fetch_assoc()): ?>
			<li>
				<?= $course["title"] ?> (<?= $course["language"] ?>)
			</li>
        <?php endwhile; ?> 
		</ul>
		</details>

		<hr>
		
		<h1 style="text-align: center;"><i class="fa-solid fa-graduation-cap"></i> Student supervision</h1>
		<h2>Current students</h2>
		<ul>
		<?php 
			while($supervision = $supervisions->fetch_assoc()): ?>
			<li>
				<?= $supervision["topic"] ?> (<?= $supervision["school"] ?>)
			</li>
        <?php endwhile; ?> 
		</ul>

		<details>
		<summary>Former students</summary>
		<ul>
		<?php 
			while($supervision = $supervisions->fetch_assoc()): ?>
			<li>
				<?= $supervision["topic"] ?> (<?= $supervision["school"] ?>)
			</li>
        <?php endwhile; ?> 
		</ul>
		</details>

		<hr>

		<h1>Training activities</h1>
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