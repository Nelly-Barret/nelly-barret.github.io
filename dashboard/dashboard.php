<?php
require('../db.php');
try {
	$SQL_PROJECTS = "SELECT * FROM project;";
	$projects = $conn->query($SQL_PROJECTS);

	$SQL_INTERNSHIPS = "SELECT * FROM supervision;";
	$internships = $conn->query($SQL_INTERNSHIPS);

	$SQL_REVIEWS = "SELECT * FROM service;";
	$reviews = $conn->query($SQL_REVIEWS);
} catch (Exception $e) {
	var_dump($e);
}

?>

<!DOCTYPE html>

<html lang="fr">
<?php include 'head.php'; ?>
    
<body>
    <section class="anchor light">
		<h1 class="dashboard-section">Projets de recherche</h1>
		<?php include("project-table.php"); ?>

		<h1 class="dashboard-section">Stages de recherche</h1>
		<?php include("internship-table.php"); ?>

		<h1 class="dashboard-section">Reviews</h1>
		<?php include("review-table.php"); ?>

		<h1 class="dashboard-section">Conférences</h1>
		<?php include("conference-table.php"); ?>

		<h1 class="dashboard-section">Responsabilités LIRIS</h1>
		<?php include("liris-table.php"); ?>

		<h1 class="dashboard-section">Groupes de travail</h1>
		<?php include("wg-table.php"); ?>
    </section>
</body>
</html>