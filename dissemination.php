<?php
require('db.php');
try {
	$SQL_TALKS = "SELECT * FROM dissemination WHERE category = 'Seminar' ORDER BY date DESC, did ASC;";
	$talks = $conn->query($SQL_TALKS);

	$SQL_PANELS = "SELECT * FROM dissemination WHERE category = 'Panel' ORDER BY date DESC, did ASC;";

	$SQL_VULGARIZATION = "SELECT * FROM dissemination WHERE category = 'Vulgarization' ORDER BY date DESC, did ASC;";
	

	$SQL_EMPOWERMENT = "SELECT * FROM dissemination WHERE category = 'Female empowerment' ORDER BY date DESC, did ASC;";
	
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
		<h1 class="section-title page-nav-section">Invited talks</h1>
		<?php include("dissemination-table.php"); ?>

		<h1 class="section-title page-nav-section">Panels</h1>
		<?php $talks = $conn->query($SQL_PANELS); ?>
		<?php include("dissemination-table.php"); ?>

		<h1 class="section-title page-nav-section">Vulgarization talks</h1>
		<?php $talks = $conn->query($SQL_VULGARIZATION); ?>
		<?php include("dissemination-table.php"); ?>

		<h1 class="section-title page-nav-section">Female empowerment talks</h1>
		<?php $talks = $conn->query($SQL_EMPOWERMENT); ?>
		<?php include("dissemination-table.php"); ?>
    </section>
	<?php include('footer.php'); ?>
</body>
</html>