<?php
require('db.php');
require('utils.php');
require('functions.php');
try {
	$current_projects = get_projects($conn, "current", true);
	$former_projects = get_projects($conn, "former", true);
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
		
		
		<h2 class="subsection-title">Current and future projects</h2>
		<?php foreach($current_projects as $project): ?>
			<?php include("research-card.php") ?>
		<?php endforeach; ?> 
		</div>


		<h2 class="subsection-title">Previous projects</h2>
		<!-- <h2 data-bs-toggle="collapse" href="#collapsePastProjects" role="button" aria-expanded="false" aria-controls="collapsePastProjects">Past projects</h2> -->
  		
		<!-- <div class="collapse" id="collapsePastProjects"> -->
			<div class="row">
		<?php foreach($former_projects as $project): ?>
  		<div class="col-sm-6 mb-3 mb-sm-0">
			<?php include("research-card.php") ?>
		</div>
		<?php endforeach; ?> 
	</div>
    </section>
	<?php include('footer.php'); ?>
</body>
</html>