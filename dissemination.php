<?php
require('db.php');
try {
	$SQL_CURRENT_PROJECTS = "SELECT * FROM project WHERE end_date = '1900-01-01' OR end_date > CURDATE();";
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
		<h1 style="text-align: center;">Scientific talks</h1>

		<hr>

		<h1>Invited talks</h1>

		<hr>

		<h1>Dissemination</h1>

		<h2>Vulgarization talks</h2>

		<h2>Female empowerment talks</h2>

		<hr>

		<h1>Event organization</h1>
    </section>
</body>
</html>