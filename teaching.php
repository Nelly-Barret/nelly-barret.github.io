<?php
require('db.php');
require('utils.php');
require('functions.php');
?>

<!DOCTYPE html>

<html lang="fr">
<?php include 'head.php'; ?>
    
<body>
	<?php include 'navbar.php'; ?>
    
    <section class="anchor light">
		<h1 class="section-title page-nav-section">Recurring courses</h1>
		<?php $items = get_recurrent_courses($conn); ?>
		<?php include("teaching-table.php"); ?>

		<h1 class="section-title page-nav-section">Guest Lectures</h1>
		<?php $items = get_guest_courses($conn); ?>
		<?php include("teaching-table.php"); ?>

		<h1 class="section-title page-nav-section">Teaching service</h1>
		<?php $items = get_teaching_service($conn); ?>
		<?php include("teaching-table.php"); ?>
    </section>
	<?php include('footer.php'); ?>
</body>
</html>