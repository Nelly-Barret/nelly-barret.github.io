<?php
require('db.php');
require('utils.php');
try {
	$SQL_RESPONSABILITIES = "SELECT *, ".$CURRENT_STATUS_SQL." FROM responsability ORDER BY status ASC, end_date ASC, start_date DESC;";
	$responsabilities = $conn->query($SQL_RESPONSABILITIES);
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
		<h1 class="section-title">Institutional responsabilities</h1>
		<?php include("institutional-table.php"); ?>
    </section>
	<?php include('footer.php'); ?>
</body>
</html>
