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
		<h1 class="section-title page-nav-section">Institutional responsabilities</h1>
		<?php $items = get_institutional_responsabilities($conn); ?>
		<?php include("institutional-table.php"); ?>
    </section>
	<?php include('footer.php'); ?>
</body>
</html>
