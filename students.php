<?php
require('db.php');

try {
	$SQL_CURRENT_SUPERVISION = "SELECT * FROM supervision WHERE year >= YEAR(CURDATE());";
	$current_supervisions = $conn->query($SQL_CURRENT_SUPERVISION);

	$SQL_FORMER_SUPERVISION = "SELECT * FROM supervision WHERE year < YEAR(CURDATE());";
	$former_supervisions = $conn->query($SQL_FORMER_SUPERVISION);
} catch (Exception $e) {
	var_dump($e);
}

?>

<!DOCTYPE html>

<html lang="fr">
<?php include 'head.php'; ?>
    
<body>
	<?php include 'navbar.php'; ?>
    
    <!-- SECTION TALKS -->
    <section class="anchor light">
		<h1 class="section-title">Student supervision</h1>
		<h2 class="subsection-title">Current students</h2>
		<ul>
		<?php 
			while($supervision = $current_supervisions->fetch_assoc()): ?>
			<li>
				<?= $supervision["topic"] ?> (<?= $supervision["school"] ?>)
			</li>
        <?php endwhile; ?> 
		</ul>

		<h2 class="subsection-title">Former students</h2>
		<ul>
		<?php 
			while($supervision = $former_supervisions->fetch_assoc()): ?>
			<li>
				<?= $supervision["topic"] ?> (<?= $supervision["school"] ?>)
			</li>
        <?php endwhile; ?> 
		</ul>

</body>
</html>