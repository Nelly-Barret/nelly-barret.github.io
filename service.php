<?php
require('db.php');
try {
	$SQL_RESPONSABILITIES = "SELECT * FROM responsability ORDER BY end_date ASC, start_date DESC;";
	$responsabilities = $conn->query($SQL_RESPONSABILITIES);

	$TEMPLATE_SERVICE_SELECT = "SELECT s.id, s.category, v.acronym, v.name, v.rank, s.role, GROUP_CONCAT(CASE WHEN s.role <> '' THEN CONCAT(s.year, ' (', s.role, ')') ELSE s.year END ORDER BY year DESC SEPARATOR ', ') AS years FROM service s LEFT JOIN venue v ON s.venue_id = v.id";
	$TEMPLATE_SERVICE_SELECT_WITHOUT_ROLE = "SELECT s.id, s.category, v.acronym, v.name, v.rank, s.role, GROUP_CONCAT(s.year ORDER BY year DESC SEPARATOR ', ') AS years FROM service s LEFT JOIN venue v ON s.venue_id = v.id";
	$TEMPLATE_SERVICE_GROUP_SORT = "GROUP BY category, venue_id ORDER BY s.category, FIELD (v.rank, 'Q1', 'A*', 'A', 'Q2', 'B', 'Q3', 'C', 'Q4', 'D', 'N/A'), v.acronym;";

	$SQL_ORGA_SERVICES = $TEMPLATE_SERVICE_SELECT_WITHOUT_ROLE." WHERE category = 'organizer' ".$TEMPLATE_SERVICE_GROUP_SORT;
	$SQL_CHAIR_SERVICES = $TEMPLATE_SERVICE_SELECT." WHERE category = 'chair' ".$TEMPLATE_SERVICE_GROUP_SORT;
	$SQL_PC_SERVICES = $TEMPLATE_SERVICE_SELECT." WHERE category = 'pc' ".$TEMPLATE_SERVICE_GROUP_SORT;
	$SQL_JOURNAL_REVIEW_SERVICES = $TEMPLATE_SERVICE_SELECT_WITHOUT_ROLE." WHERE role = 'journal reviewer' ".$TEMPLATE_SERVICE_GROUP_SORT;
	$SQL_CONFERENCE_REVIEW_SERVICES = $TEMPLATE_SERVICE_SELECT." WHERE category = 'reviewer' AND role = '' ".$TEMPLATE_SERVICE_GROUP_SORT;

	
	$pc_services = $conn->query($SQL_PC_SERVICES);
	$review_services = $conn->query($SQL_REVIEW_SERVICES);
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
		
		<h2>Journal and conference responsabilities</h2>
		<!-- Organisation duties -->
		<?php $services = $conn->query($SQL_ORGA_SERVICES); ?>
		<h3>Conference organization</h3>
		<?php include("service-item.php"); ?>

		<!-- Chair duties -->
		<?php $services = $conn->query($SQL_CHAIR_SERVICES); ?>
		<h3>Chair</h3>
		<?php include("service-item.php"); ?>
		
		<!-- PC duties -->
		<?php $services = $conn->query($SQL_PC_SERVICES); ?>
		<h3>PC responsabilities</h3>
		<?php include("service-item.php"); ?>
		
		<!-- journal review duties -->
		<h3>Review responsabilities</h3>
		<?php $services = $conn->query($SQL_JOURNAL_REVIEW_SERVICES); ?>
		<h4>Journals</h4>
		<?php include("service-item.php"); ?>
		
		<!-- conference review duties -->
		<?php $services = $conn->query($SQL_CONFERENCE_REVIEW_SERVICES); ?>
		<h4>Conferences</h4>
		<?php include("service-item.php"); ?>


		<h2>Institutional responsabilities</h2>
		<ul>
		<?php 
			while($responsability = $responsabilities->fetch_assoc()): ?>
			<?php if($responsability["end_date"] == "1900-01-01"): ?>
				<li>
					Since <?=date('F Y', strtotime($responsability["start_date"])) ?>: <?= $responsability["title"] ?> (<?= $responsability["involvement"] ?>)
				</li>
			<?php else: ?>
				<li style="color: gray;">
					Since <?=date('F Y', strtotime($responsability["start_date"])) ?>: <?= $responsability["title"] ?> (<?= $responsability["involvement"] ?>)
				</li>
			<?php endif; ?>
        <?php endwhile; ?> 
		</ul>
    </section>
</body>
</html>
