<?php
require('db.php');
try {
	// SUMMARY RECORD

	$counts = [
		"int_journal" => ["Q1" => 0, "Q2" => 0, "Q3" => 0, "Q4" => 0, "N/A" => 0], 
		"int_conf" => ["A*" => 0, "A" => 0, "B" => 0, "C" => 0, "D" => 0, "N/A" => 0], 
		"int_workshop" => ["A*" => 0, "A" => 0, "B" => 0, "C" => 0, "D" => 0, "N/A" => 0], 
		"demo" => ["A*" => 0, "A" => 0, "B" => 0, "C" => 0, "D" => 0, "N/A" => 0],
		"nat_conf" => ["A*" => 0, "A" => 0, "B" => 0, "C" => 0, "D" => 0, "N/A" => 0],
		"manuscript" => ["A*" => 0, "A" => 0, "B" => 0, "C" => 0, "D" => 0, "N/A" => 0]
	];

	// SELECT p.category, v.rank, COUNT(p.id) FROM publication p LEFT JOIN venue v ON p.venue=v.id GROUP BY p.category, v.rank

	$SQL_SUMMARY = "SELECT p.category, v.rank, COUNT(p.id) AS count FROM publication p LEFT JOIN venue v ON p.venue=v.id GROUP BY p.category, v.rank";
	$summary = $conn->query($SQL_SUMMARY);
	while($row = $summary->fetch_assoc()) {
		$counts[$row["category"]][$row["rank"]] = $row["count"];
	}

	// DETAILED LIST OF PUBLICATIONS WITH PREFERED ORDRED

	if($_POST["sort-publis"] == "year") {
		// there is a parameter, we ask for a specific sort
		$sort = "pu.year DESC, v.acronym ASC";
	} else { // if($_POST["sort_variable"] != "category") {
		// TODO: sort_in_order = ["journal", "int_conf", "int_work", "nat_conf", "demo", "manuscript"]
		$sort = "FIELD(pu.category, 'int_journal', 'int_conf', 'int_workshop', 'nat_conf', 'demo', 'manuscript'), pu.year DESC, v.acronym ASC";
	}

	$SQL_PUBLICATIONS = "SELECT pu.*, v.*, b.id AS bib_id, b.* FROM publication pu LEFT JOIN bibcitation b ON pu.bib_citation = b.id LEFT JOIN venue v ON pu.venue = v.id ORDER BY ".$sort;
	$publications = $conn->query($SQL_PUBLICATIONS);

	$COLORS = [
		"int_journal" => "#F54927", 
		"int_conf" => "#409434", 
		"int_workshop" => "#4CADBA", 
		"demo" => "#F527BE",
		"nat_conf" => "#BFBA0B",
		"manuscript" => "#F5A327"
	];

	$CATEGORIES = [
		"int_journal" => "International journal", 
		"int_conf" => "International conference", 
		"int_workshop" => "International workshop", 
		"demo" => "Demonstration",
		"nat_conf" => "National conference",
		"manuscript" => "Manuscript"
	];

} catch (Exception $e) {
	var_dump($e);
}

function get_total_count_for_category(String $category) {
	$sum = 0;
	// $GLOBALS['counts'] because the variable counts is decalred outside the function, thus is not known inside the function
	foreach($GLOBALS['counts'][$category] as $key => $value) {
		$sum += $value;
	}
	return $sum;
}

function echo_count(String $category, String $rank, String $rank2 = null) {
	// $GLOBALS['counts'] because the variable counts is decalred outside the function, thus is not known inside the function
	if($rank2 != null) {
		// we want to get the counts for two ranks, typically A* and A
		if ($GLOBALS['counts'][$category][$rank] <= 0 && $GLOBALS['counts'][$category][$rank2] <= 0) {
			return "";
		} else if ($GLOBALS['counts'][$category][$rank] > 0 && $GLOBALS['counts'][$category][$rank2] <= 0) {
			return $GLOBALS['counts'][$category][$rank];
		} else {
			return $GLOBALS['counts'][$category][$rank] + $GLOBALS['counts'][$category][$rank2];
		}
	} else {
		if ($GLOBALS['counts'][$category][$rank] <= 0) {
			return "";
		} else {
			return $GLOBALS['counts'][$category][$rank];
		}
	}
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
					<td><b><?=get_total_count_for_category("int_journal")?> Journals</b></td>
					<td><?=echo_count("int_journal", "Q1")?></td>
					<td><?=echo_count("int_journal", "Q2")?></td>
					<td><?=echo_count("int_journal", "Q3")?></td>
					<td><?=echo_count("int_journal", "Q4")?></td>
					<td><?=echo_count("int_journal", "N/A")?></td>
				</tr>
				<tr>
					<td><b><?=get_total_count_for_category("int_conf")?> International peer-reviewed conferences</b></td>
					<td><?=echo_count("int_conf", "A*", "A")?></td>
					<td><?=echo_count("int_conf", "B")?></td>
					<td><?=echo_count("int_conf", "C")?></td>
					<td><?=echo_count("int_conf", "D")?></td>
					<td><?=echo_count("int_conf", "N/A")?></td>
				</tr>
				<tr>
					<td><b><?=get_total_count_for_category("int_workshop")?> International peer-reviewed workshops</b></td>
					<td><?=echo_count("int_workshop", "A*", "A")?></td>
					<td><?=echo_count("int_workshop", "B")?></td>
					<td><?=echo_count("int_workshop", "C")?></td>
					<td><?=echo_count("int_workshop", "D")?></td>
					<td><?=echo_count("int_workshop", "N/A")?></td>
				</tr>
				<tr>
					<td><b><?=get_total_count_for_category("demo")?> International peer-reviewed demonstrations</b></td>
					<td><?=echo_count("demo", "A*", "A")?></td>
					<td><?=echo_count("demo", "B")?></td>
					<td><?=echo_count("demo", "C")?></td>
					<td><?=echo_count("demo", "D")?></td>
					<td><?=echo_count("demo", "N/A")?></td>
				</tr>
				<tr>
					<td><b><?=get_total_count_for_category("nat_conf")?> National peer-reviewed conferences</b></td>
					<td><?=echo_count("nat_conf", "A*", "A")?></td>
					<td><?=echo_count("nat_conf", "B")?></td>
					<td><?=echo_count("nat_conf", "C")?></td>
					<td><?=echo_count("nat_conf", "D")?></td>
					<td><?=echo_count("nat_conf", "N/A")?></td>
				</tr>
				<tr>
					<td><b><?=get_total_count_for_category("manuscript")?> Manuscripts</b></td>
					<td><?=echo_count("manuscript", "A*", "A")?></td>
					<td><?=echo_count("manuscript", "B")?></td>
					<td><?=echo_count("manuscript", "C")?></td>
					<td><?=echo_count("manuscript", "D")?></td>
					<td><?=echo_count("manuscript", "N/A")?></td>
				</tr>
			</tbody>
		</table>
		
		<h1 class="section-title">Publication list</h1>

		<form action="publications.php" method="post" >
		Sort by: <select name="sort-publis" id="sort-publis">
			<option value="category" <?= $_POST["sort-publis"] != "year" ? "selected" : ""?>>Publication type</option>
			<option value="year" <?= $_POST["sort-publis"] == "year" ? "selected" : ""?>>Year</option>
		</select>
		<input type="submit">
		</form>

		<ol class="publications">
		<?php while($publication = $publications->fetch_assoc()): ?>
			<?php include("publication-item.php") ?>
		<?php endwhile; ?> 
		</ol>
    </section>
</body>

</html>
