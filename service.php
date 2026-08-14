<?php
require('db.php');
try {
	$SQL_SERVICE = "SELECT * FROM service;";
	$services = $conn->query($SQL_SERVICE);
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
		<h1 class="section-title">Service</h1>

		<h2>PC member</h2>
		
    </section>
</body>
</html>