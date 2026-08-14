<?php
require('db.php');
try {
	$SQL_CURRENT_COURSES = "SELECT * FROM course WHERE end_date = '1900-01-01';";
	$courses = $conn->query($SQL_CURRENT_COURSES);
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
		<h1 class="section-title">Courses</h1>
		
		<h2>Current courses</h2>
		<ul>
		<?php 
			while($course = $courses->fetch_assoc()): ?>
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
    </section>
</body>
</html>

<!DOCTYPE html>

<html lang="fr">
<?php include 'head.php'; ?>
    
<body>
	<?php include 'navbar.php'; ?>
    
    <section class="anchor light">
		<h1 class="section-title">Courses</h1>
		
		<h2>Current courses</h2>
		<?php include("teaching-table.php"); ?>

		<h2>Former courses 2</h2>
		<?php 
			$SQL_FORMER_COURSES = "SELECT * FROM course WHERE end_date > '1900-01-01';";
			$courses = $conn->query($SQL_FORMER_COURSES);
		?>
		<?php include("teaching-table.php"); ?>
    </section>
</body>
</html>