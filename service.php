<?php
require('db.php');
require('utils.php');
require('functions.php');

try {

	// SUMMARY
	$counts = [
		"organizer" => ["Q1" => 0, "Q2" => 0, "Q3" => 0, "Q4" => 0, "N/A" => 0], 
		"chair" => ["A*" => 0, "A" => 0, "B" => 0, "C" => 0, "D" => 0, "N/A" => 0], 
		"pc" => ["Q1" => 0, "A*" => 0, "A" => 0, "Q2" => 0, "B" => 0, "Q3" => 0, "C" => 0, "Q4" => 0, "D" => 0, "N/A" => 0], 
		"reviewer" => ["Q1" => 0, "A*" => 0, "A" => 0, "Q2" => 0, "B" => 0, "Q3" => 0, "C" => 0, "Q4" => 0, "D" => 0, "N/A" => 0],
	];

	$SQL_SUMMARY = "SELECT s.category, v.rank, COUNT(s.seid) AS count FROM service s LEFT JOIN venue v ON s.venue_id=v.vid GROUP BY s.category, v.rank";
	$summary = $conn->query($SQL_SUMMARY);
	while($row = $summary->fetch_assoc()) {
		$counts[$row["category"]][$row["rank"]] = $row["count"];
	}

	$COLORS_RANKS = [
		"A*" => "#fc4e03",
		"A" => "#fc4e03",
		"Q1" => "#fc4e03",
		"B" => "#fcba03",
		"Q2" => "#fcba03",
		"C" => "#a5fc03",
		"Q3" => "#a5fc03",
		"D" => "#03f4fc",
		"Q4" => "#03f4fc",
		"N/A" => "#d203fc",
	];
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
		<h1 class="section-title page-nav-section">Summary</h1>

		<p>
			I contribute to the research community through conference organization, workshop chairing, program committees, and peer review. Specifically, I have <b>co-organized <?=get_total_count_for_category("organizer")?> conference</b> and served as <b>chair for <?=get_total_count_for_category("chair")?> venues</b>. I have served on <b><?=get_total_count_for_category("pc")?> program committees</b> and as <b>a reviewer for <?=get_total_count_for_category("reviewer")?> venues</b>, including 8 journals and 6 conferences.
		</p>
		
		<h1 class="section-title page-nav-section">Leadership</h1>
		
		<h2 class="subsection-title">Conference & workshop organization</h2>
		<!-- Organisation duties -->
		<?php $items = get_service_organization($conn); ?>
		<?php include("service-table.php"); ?>

		<h2 class="subsection-title">Conference & workshop chairing</h2>
		<!-- Chair duties -->
		<?php $items = get_service_chair($conn); ?>
		<?php include("service-table.php"); ?>

		<!-- PC duties -->
		<?php $items = get_service_pc($conn); ?>
		<h2 class="subsection-title">PC responsabilities</h2>
		<?php include("service-table.php"); ?>
		
		<!-- journal review duties -->
		<h1 class="section-title page-nav-section">Review responsabilities</h1>
		
		<h2 class="subsection-title">Journals</h2>
		<?php $items = get_service_journal_review($conn); ?>
		<?php include("service-table.php"); ?>
		
		<!-- conference review duties -->
		<h2 class="subsection-title">Conferences</h2>
		<?php $items = get_service_conf_review($conn); ?>
		<?php include("service-table.php"); ?>
    </section>
	<?php include('footer.php'); ?>
</body>
</html>
