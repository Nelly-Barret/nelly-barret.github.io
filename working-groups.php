<?php
require('db.php');
require('utils.php');
try {
	$SQL_WG = "SELECT *, ".$CURRENT_STATUS_SQL.", GROUP_CONCAT(wgd.text SEPARATOR ' ') AS content FROM working_group wg LEFT JOIN working_group_description wgd ON wg.id = wgd.wg_id GROUP BY wg.id ORDER BY status ASC, end_date ASC, start_date DESC;";
	$wgs = $conn->query($SQL_WG);
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
		<h1 class="section-title">Working groups</h1>
		
		<?php include("wg-table.php"); ?>
    </section>
</body>
</html>