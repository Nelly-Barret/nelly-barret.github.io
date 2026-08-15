<?php
require('db.php');
try {
	$SQL_CURRENT_COURSES = "SELECT * FROM teaching WHERE (end_date = '1900-01-01' OR end_date > CURDATE()) AND category = 'course' ORDER BY start_date DESC;";
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
		<?php include("teaching-table.php"); ?>

		<h2>Former courses</h2>
		<?php 
			$SQL_FORMER_COURSES = "SELECT * FROM teaching WHERE end_date > '1900-01-01' AND end_date < CURDATE() ORDER BY start_date DESC;";
			$courses = $conn->query($SQL_FORMER_COURSES);
		?>
		<?php include("teaching-table.php"); ?>


		<h1 class="section-title">Teaching service</h1>
		<?php 
			$SQL_CURRENT_SERVICE = "SELECT * FROM teaching WHERE category = 'service' ORDER BY start_date DESC;";
			$courses = $conn->query($SQL_CURRENT_SERVICE);
		?>
		<?php include("teaching-table.php"); ?>
    </section>
</body>
</html>