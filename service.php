<?php
require('db.php');
require('utils.php');
try {

	// SUMMARY
	$counts = [
		"organizer" => ["Q1" => 0, "Q2" => 0, "Q3" => 0, "Q4" => 0, "N/A" => 0], 
		"chair" => ["A*" => 0, "A" => 0, "B" => 0, "C" => 0, "D" => 0, "N/A" => 0], 
		"pc" => ["Q1" => 0, "A*" => 0, "A" => 0, "Q2" => 0, "B" => 0, "Q3" => 0, "C" => 0, "Q4" => 0, "D" => 0, "N/A" => 0], 
		"reviewer" => ["Q1" => 0, "A*" => 0, "A" => 0, "Q2" => 0, "B" => 0, "Q3" => 0, "C" => 0, "Q4" => 0, "D" => 0, "N/A" => 0],
	];

	// SELECT p.category, v.rank, COUNT(p.id) FROM publication p LEFT JOIN venue v ON p.venue=v.id GROUP BY p.category, v.rank

	$SQL_SUMMARY = "SELECT s.category, v.rank, COUNT(s.id) AS count FROM service s LEFT JOIN venue v ON s.venue_id=v.id GROUP BY s.category, v.rank";
	$summary = $conn->query($SQL_SUMMARY);
	while($row = $summary->fetch_assoc()) {
		$counts[$row["category"]][$row["rank"]] = $row["count"];
	}

	// DETAILED LIST OF SERVICES
	$TEMPLATE_SERVICE_SELECT = "SELECT s.id, s.category, v.acronym, v.name, v.rank, s.role, GROUP_CONCAT(CASE WHEN s.role <> '' THEN CONCAT(s.year, ' (', s.role, ')') ELSE s.year END ORDER BY year DESC SEPARATOR ', ') AS years FROM service s LEFT JOIN venue v ON s.venue_id = v.id";
	$TEMPLATE_SERVICE_SELECT_WITHOUT_ROLE = "SELECT s.id, s.category, v.acronym, v.name, v.rank, s.role, GROUP_CONCAT(s.year ORDER BY year DESC SEPARATOR ', ') AS years FROM service s LEFT JOIN venue v ON s.venue_id = v.id";
	$TEMPLATE_SERVICE_GROUP_SORT = "GROUP BY category, venue_id ORDER BY s.category, FIELD (v.rank, 'Q1', 'A*', 'A', 'Q2', 'B', 'Q3', 'C', 'Q4', 'D', 'N/A'), s.year DESC, v.acronym ASC;";

	$SQL_ORGA_SERVICES = $TEMPLATE_SERVICE_SELECT_WITHOUT_ROLE." WHERE category = 'organizer' OR category = 'chair' ".$TEMPLATE_SERVICE_GROUP_SORT;
	$SQL_PC_SERVICES = $TEMPLATE_SERVICE_SELECT." WHERE category = 'pc' ".$TEMPLATE_SERVICE_GROUP_SORT;
	$SQL_JOURNAL_REVIEW_SERVICES = $TEMPLATE_SERVICE_SELECT_WITHOUT_ROLE." WHERE role = 'journal reviewer' ".$TEMPLATE_SERVICE_GROUP_SORT;
	$SQL_CONFERENCE_REVIEW_SERVICES = $TEMPLATE_SERVICE_SELECT." WHERE category = 'reviewer' AND role = '' ".$TEMPLATE_SERVICE_GROUP_SORT;

	
	$pc_services = $conn->query($SQL_PC_SERVICES);
	$review_services = $conn->query($SQL_REVIEW_SERVICES);

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
		<h1 class="section-title">Summary</h1>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<td></td>
					<td>Q1/A*-A</td>
					<td>Q2/B</td>
					<td>Q3/C</td>
					<td>Q4/D</td>
					<td>N/A</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><b><?=get_total_count_for_category("organizer")?> Organizer</b></td>
					<td><?=echo_count("organizer", "A*", "A*")?></td>
					<td><?=echo_count("organizer", "B")?></td>
					<td><?=echo_count("organizer", "C")?></td>
					<td><?=echo_count("organizer", "D")?></td>
					<td><?=echo_count("organizer", "N/A")?></td>
				</tr>
				<tr>
					<td><b><?=get_total_count_for_category("chair")?> Chair</b></td>
					<td><?=echo_count("chair", "A*", "A")?></td>
					<td><?=echo_count("chair", "B")?></td>
					<td><?=echo_count("chair", "C")?></td>
					<td><?=echo_count("chair", "D")?></td>
					<td><?=echo_count("chair", "N/A")?></td>
				</tr>
				<tr>
					<td><b><?=get_total_count_for_category("pc")?> PC member</b></td>
					<td><?=echo_count("pc", "A*", "A", "Q1")?></td>
					<td><?=echo_count("pc", "B", "Q2")?></td>
					<td><?=echo_count("pc", "C", "Q3")?></td>
					<td><?=echo_count("pc", "D", "Q4")?></td>
					<td><?=echo_count("pc", "N/A")?></td>
				</tr>
				<tr>
					<td><b><?=get_total_count_for_category("reviewer")?> Reviewer</b></td>
					<td><?=echo_count("reviewer", "A*", "A", "Q1")?></td>
					<td><?=echo_count("reviewer", "B", "Q2")?></td>
					<td><?=echo_count("reviewer", "C", "Q3")?></td>
					<td><?=echo_count("reviewer", "D", "Q4")?></td>
					<td><?=echo_count("reviewer", "N/A")?></td>
				</tr>
			</tbody>
		</table>
		
		<h1 class="section-title">Leadership</h1>
		<h2>Conference & workshop organization</h2>
		<!-- Organisation and chair duties -->
		<?php $services = $conn->query($SQL_ORGA_SERVICES); ?>
		<?php include("service-table.php"); ?>

		<!-- PC duties -->
		<?php $services = $conn->query($SQL_PC_SERVICES); ?>
		<h2>PC responsabilities</h2>
		<?php include("service-table.php"); ?>
		
		<!-- journal review duties -->
		<h1 class="section-title">Review responsabilities</h1>
		<?php $services = $conn->query($SQL_JOURNAL_REVIEW_SERVICES); ?>
		<h2>Journals</h2>
		<?php include("service-table.php"); ?>
		
		<!-- conference review duties -->
		<?php $services = $conn->query($SQL_CONFERENCE_REVIEW_SERVICES); ?>
		<h2>Conferences</h2>
		<?php include("service-table.php"); ?>
    </section>
</body>
</html>
