<?php
require('db.php');
require('utils.php');
try {
	$SQL_CURRENT_PROJECTS = "SELECT * FROM project  WHERE end_date = '2222-01-01' OR end_date >= CURDATE()";
	$current_projects = $conn->query($SQL_CURRENT_PROJECTS);

	$SQL_FORMER_PROJECTS = "SELECT * FROM project WHERE end_date < CURDATE();";
	$former_projects = $conn->query($SQL_FORMER_PROJECTS);
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
		<h1 class="section-title page-nav-section">Research themes</h1>
		
		My research themes lie in the broad area of <b>heterogeneous data integration and exploitation</b>, including heterogeneous and multi-modal data as well as warehouse, data lake and lakehouse architectures.

		<br/><br/>

		The general scientific questions that are driving me every day include: 
		<ul>
			<li>How to effectively and efficiently collect, organize and store heterogeneous data produced by various actors?</li>
			<li>How to explore and exploit large amounts of data, especially for domain experts?</li>
			<li>How to clean, join, merge, and sementically enrich raw data for better decision making?
		</ul>

		My research applies to various domains including sustainable cities, media, and healthcare, with a strong interest in <b>sustainable cities</b>.
		
		<h1 class="section-title page-nav-section">Projects and tools</h1>
		
		
		<h2 class="subsection-title">Current projects</h2>
		<?php while($project = $current_projects->fetch_assoc()): ?>
			<?php include("research-card.php") ?>
		<?php endwhile; ?> 
		</div>


		<h2 class="subsection-title">Previous projects</h2>
		<!-- <h2 data-bs-toggle="collapse" href="#collapsePastProjects" role="button" aria-expanded="false" aria-controls="collapsePastProjects">Past projects</h2> -->
  		
		<!-- <div class="collapse" id="collapsePastProjects"> -->
			<div class="row">
		<?php while($project = $former_projects->fetch_assoc()): ?>
  		<div class="col-sm-6 mb-3 mb-sm-0">
			<?php include("research-card.php") ?>
		</div>
		<?php endwhile; ?> 
	</div>
    </section>
	<?php include('footer.php'); ?>
</body>
</html>