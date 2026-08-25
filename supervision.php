<?php
require('db.php');
require('utils.php');

try {
	// GROUP CONCAT to create the list of advisors
	$GROUP_CONCAT_ADVISORS = "GROUP_CONCAT(CONCAT(pe2.first_name, ' ', pe2.last_name, ' (', ss.supervisor_role, ')') ORDER BY person_position ASC SEPARATOR ', ') AS the_team";
	$JOINS_FOR_GROUP_CONCAT = "LEFT JOIN supervision_supervisor ss ON s.suid = ss.supervision_id LEFT JOIN person pe2 ON ss.supervisor_id = pe2.peid ";

	$SQL_ENGINEER_STUDENTS = "SELECT s.*, p.*, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status, ".$GROUP_CONCAT_ADVISORS." FROM supervision s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level LIKE '%Engineer%' GROUP BY s.suid ORDER BY s.year DESC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');";
	$engineer_supervisions = $conn->query($SQL_ENGINEER_STUDENTS);

	$SQL_MASTER_STUDENTS = "SELECT s.*, p.*, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status, ".$GROUP_CONCAT_ADVISORS." FROM supervision s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level LIKE '%Master%' GROUP BY s.suid ORDER BY s.year DESC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');";
	$master_supervisions = $conn->query($SQL_MASTER_STUDENTS);

	$SQL_BACHELOR_STUDENTS = "SELECT s.*, p.*, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status, ".$GROUP_CONCAT_ADVISORS." FROM supervision s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level  LIKE '%Bachelor%' GROUP BY s.suid ORDER BY s.year DESC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');";
	$bachelor_supervisions = $conn->query($SQL_BACHELOR_STUDENTS);

	$SQL_COUNT_BACHELOR_STUDENTS = "SELECT COUNT(DISTINCT person_id) AS nb_bachelors FROM supervision WHERE level LIKE '%Bachelor%';"; // count the distinct number of people
	$nb_bachelors = $conn->query($SQL_COUNT_BACHELOR_STUDENTS);
	$nb_bachelor = $nb_bachelors->fetch_assoc(); // fetch the first (and only) row with the count

	$SQL_COUNT_MASTER_STUDENTS = "SELECT COUNT(DISTINCT person_id) AS nb_masters FROM supervision WHERE level LIKE '%Master%' OR level LIKE '%Engineer%';"; // count the distinct number of people
	$nb_masters = $conn->query($SQL_COUNT_MASTER_STUDENTS);
	$nb_master = $nb_masters->fetch_assoc(); // fetch the first (and only) row with the count
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
		<h1 class="section-title page-nav-section">Summary</h1>
		I supervise student projects and theses in the areas of heterogeneous data management, data integration, data exploration and their applications, notably sustainable cities. So far, I had the pleasure to co-supervise <b><?= $nb_bachelor["nb_bachelors"]; ?> Bachelor</b> students and <b><?= $nb_master["nb_masters"]; ?> Master/Engineer</b> students. I always look for motivated interns and PhD students, so feel free to contact me!<br/><br/>

		<h1 class="section-title page-nav-section">Student supervision</h1>
		<b>Legend:</b> <i class="fa-solid fa-file-pdf"></i> PDF internship report, <i class="fa-solid fa-file-powerpoint"></i> PDF defense slides

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