<?php
require('db.php');
require('utils.php');
try {
	$SQL_COURSES = "SELECT *, ".$CURRENT_STATUS_SQL." FROM teaching WHERE category = 'course' ORDER BY status ASC, end_date DESC, start_date DESC;";
	$courses = $conn->query($SQL_COURSES);
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
		<h1 class="section-title">Recurrent courses</h1>
		<?php include("teaching-table.php"); ?>

		<h1 class="section-title">Guest Lectures</h1>
		<?php 
			$SQL_GUEST_COURSES = "SELECT *, ".$CURRENT_STATUS_SQL." FROM teaching WHERE category = 'guest' ORDER BY status ASC, end_date ASC, start_date DESC;";
			$courses = $conn->query($SQL_GUEST_COURSES);
		?>
		<?php include("teaching-table.php"); ?>

		<h1 class="section-title">Teaching service</h1>
		<?php 
			$SQL_CURRENT_SERVICE = "SELECT * FROM teaching WHERE category = 'service' ORDER BY start_date DESC;";
			$courses = $conn->query($SQL_CURRENT_SERVICE);
		?>
		<?php include("teaching-table.php"); ?>
    </section>
	<?php include('footer.php'); ?>
</body>
</html>