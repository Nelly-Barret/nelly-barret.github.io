<?php
require('db.php');
require('functions.php');
?>

<!DOCTYPE html>

<html lang="fr">
<?php include 'head.php'; ?>
    
<body>
	<?php include 'navbar.php'; ?>
    
    <section class="anchor light">
		<h1 class="section-title page-nav-section">Invited talks</h1>
		<?php $items = get_invited_talks($conn); ?>
		<?php include("dissemination-table.php"); ?>

		<h1 class="section-title page-nav-section">Panels</h1>
		<?php $items = get_panels($conn); ?>
		<?php include("dissemination-table.php"); ?>

		<h1 class="section-title page-nav-section">Vulgarization talks</h1>
		<?php $items = get_vulgarization($conn); ?>
		<?php include("dissemination-table.php"); ?>

		<h1 class="section-title page-nav-section">Female empowerment talks</h1>
		<?php $items = get_female_talks($conn); ?>
		<?php include("dissemination-table.php"); ?>
    </section>
	<?php include('footer.php'); ?>
</body>
</html>