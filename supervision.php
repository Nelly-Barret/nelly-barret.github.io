<?php
require('db.php');
require('utils.php');

try {
	$SQL_ENGINEER_STUDENTS = "SELECT s.*, p.*, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status FROM supervision s LEFT JOIN person p ON s.person_id = p.peid WHERE s.grade LIKE '%Engineer%';";
	$engineer_supervisions = $conn->query($SQL_ENGINEER_STUDENTS);

	$SQL_MASTER_STUDENTS = "SELECT s.*, p.*, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status FROM supervision s LEFT JOIN person p ON s.person_id = p.peid WHERE s.grade  LIKE '%Master%';";
	$master_supervisions = $conn->query($SQL_MASTER_STUDENTS);

	$SQL_BACHELOR_STUDENTS = "SELECT s.*, p.*, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status FROM supervision s LEFT JOIN person p ON s.person_id = p.peid WHERE s.grade  LIKE '%Bachelor%';";
	$bachelor_supervisions = $conn->query($SQL_BACHELOR_STUDENTS);
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
		<h1 class="section-title">Summary</h1>
		I supervise student projects and theses in the areas of heterogeneous data management, data integration, data exploration and their applications, notably sustainable cities. So far, I had the pleasure to co-supervise <b>X Bachelor</b> students and <b>X Master</b> students.

		I always look for motivated interns and PhD students, so feel free to contact me!

		<h1 class="section-title">Student supervision</h1>

		<!-- Engineer -->
		<h2 class="subsection-title">Engineer students</h2>
		<?php $students = $engineer_supervisions ?>
		<?php include("supervision-table.php"); ?>

		<!-- Master -->
		<h2 class="subsection-title">Master students</h2>
		<?php $students = $master_supervisions ?>
		<?php include("supervision-table.php"); ?>

		<!-- Bachelor -->
		<h2 class="subsection-title">Bachelor students</h2>
		<?php $students = $bachelor_supervisions ?>
		<?php include("supervision-table.php"); ?>
	</section>
	<?php include('footer.php'); ?>
</body>
</html>