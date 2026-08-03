<?php
require('db.php');
try {
	$SQL_CURRENT_PROJECTS = "SELECT * FROM project  WHERE end_date = '1900-01-01' OR end_date > CURDATE()";
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
		<h1 class="section-title">Research themes</h1>
		
		<p style="color: red;">TODO</p>
		
		<h1 class="section-title">Projects</h1>
		
		
		<h2>Current projects</h2>
		<div class="row row-cols-3">
			<?php 
				while($project = $current_projects->fetch_assoc()): ?>
					<div class="col">
						<?php include("project_card.php") ?>
					</div>
				<?php endwhile; ?> 
		</div>


		<details>
		<summary>Past projects</summary>
		<div class="row row-cols-3">
			<?php 
				while($project = $former_projects->fetch_assoc()): ?>
					<div class="col">
						<?php include("project_card.php") ?>
					</div>
			<?php endwhile; ?> 
		</div>
		</details>

		<hr>
    </section>
</body>
</html>