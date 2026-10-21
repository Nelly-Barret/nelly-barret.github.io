<?php
require('db.php');
require('utils.php');
require('functions.php');

try {
	$SQL_COUNT_BACHELOR_STUDENTS = "SELECT COUNT(DISTINCT person_id) AS nb_bachelors FROM internship WHERE level LIKE '%Bachelor%';"; // count the distinct number of people
	$nb_bachelors = $conn->query($SQL_COUNT_BACHELOR_STUDENTS);
	$nb_bachelor = $nb_bachelors->fetch_assoc(); // fetch the first (and only) row with the count

	$SQL_COUNT_MASTER_STUDENTS = "SELECT COUNT(DISTINCT person_id) AS nb_masters FROM internship WHERE level LIKE '%Master%' OR level LIKE '%Engineer%';"; // count the distinct number of people
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
		I supervise student projects and theses in the areas of heterogeneous data management, data integration, data exploration and their applications, notably sustainable cities. So far, I had the pleasure to co-supervise <b><?= $nb_bachelor["nb_bachelors"]; ?> Bachelor</b> students and <b><?= $nb_master["nb_masters"]; ?> Master/Engineer</b> students.<br/><br/>

		<div class="alert alert-info" role="alert">
		I'm always looking for motivated students, so <b>feel free to reach out!</b><br/>
		<b>Research areas in which I can supervise you</b>: heterogeneous data management, data integration, data exploration, data lakes and lakehouses. 
		</div>

		<h1 class="section-title page-nav-section">Student supervision</h1>
		<b>Legend:</b> <i class="fa-solid fa-file-pdf"></i> PDF internship report, <i class="fa-solid fa-file-powerpoint"></i> PDF defense slides

		<!-- Engineer -->
		<h2 class="subsection-title">Engineer students</h2>
		<?php $items = get_engineer_students($conn); ?>
		<?php include("internship-table.php"); ?>

		<!-- Master -->
		<h2 class="subsection-title">Master students</h2>
		<?php $items = get_master_students($conn); ?>
		<?php include("internship-table.php"); ?>

		<!-- Bachelor -->
		<h2 class="subsection-title">Bachelor students</h2>
		<?php $items = get_bachelor_students($conn); ?>
		<?php include("internship-table.php"); ?>
	</section>
	<?php include('footer.php'); ?>
</body>
</html>