<?php
require('db.php');
require('utils.php');

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

	$SQL_SUMMARY = "SELECT p.category, v.rank, COUNT(p.puid) AS count FROM publication p LEFT JOIN venue v ON p.venue=v.vid GROUP BY p.category, v.rank";
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

	$SQL_PUBLICATIONS = "SELECT pu.*, v.* FROM publication pu LEFT JOIN venue v ON pu.venue = v.vid ORDER BY ".$sort;
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
		"int_journal" => "International journals", 
		"int_conf" => "International conferences", 
		"int_workshop" => "International workshops", 
		"demo" => "Demonstrations",
		"nat_conf" => "National conferences",
		"manuscript" => "Manuscripts"
	];

	// process the SQL result to obtain an arry of the form
	// ["int_journal": [1, 2, 3], 
	//    "int_conf": [4, 5], ...] or with keys being years when sorting by years
	$the_publications = [];
	$the_sort = $_POST["sort-publis"] == null ? "category" : $_POST["sort-publis"];

	while($publi = $publications->fetch_assoc()) {
		if($the_sort == "category") {
			$the_category = $publi["category"];
			if(!array_key_exists($the_category, $the_publications)) {
				$the_publications[$the_category] = [];
			}
			$the_publications[$the_category][] = $publi;
		} else {
			// sort by year
			$the_year = $publi["year"];
			if(!array_key_exists($the_year, $the_publications)) {
				$the_publications[$the_year] = [];
			}
			$the_publications[$the_year][] = $publi;
		}
	}
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

		<p>
			I regularly publish in peer-reviewed and recognized venues. Specifically, I have published in <b><?=get_total_count_for_category("int_journal")?> journals</b>, including <?= echo_count("int_journal", "Q1") ?> Q1 venues, and in <b><?=get_total_count_for_category("int_conf")?> international conferences</b>, <?= echo_count("int_conf", "A*", "A") ?> of which are ranked A* or A. I have also published <b><?=get_total_count_for_category("int_workshop")?> international workshop</b> papers and <b><?=get_total_count_for_category("demo")?> demonstration</b> papers, as well as <b><?=get_total_count_for_category("nat_conf")?> national conference</b> papers. In addition, I have authored <b><?=get_total_count_for_category("manuscript")?> manuscripts</b> as part of my research work.
		</p>
		
		<h1 class="section-title">Publication list</h1>

		<form action="publications.php" method="post">
		<b>Legend:</b> <i class="fa-solid fa-file-pdf"></i> PDF paper, <i class="fa-solid fa-file-powerpoint"></i> PDF slides, <i class="fa-solid fa-file-invoice"></i> PDF poster, <i class="fa-brands fa-tex"></i> TeX citation
		<br/>
		<b>Sort by:</b> <select name="sort-publis" id="sort-publis" onchange="this.form.submit();">
			<option value="category" <?= $_POST["sort-publis"] != "year" ? "selected" : ""?>>Publication type</option>
			<option value="year" <?= $_POST["sort-publis"] == "year" ? "selected" : ""?>>Year</option>
		</select>
		<!-- <input type="submit"> -->
		<!-- <noscript><input type="submit" value="Submit"></noscript> -->
		</form>

		<?php foreach(array_keys($the_publications) as $key): ?>
			<?php if($the_sort == "category"): ?>
				<h2 class="subsection-title"><?=$CATEGORIES[$key]?></h2> <!-- the readable publication category -->
			<?php else: ?>
				<h2 class="subsection-title"><?=$key?></h2> <!-- the year -->
			<?php endif; ?>
			<ol class="publications">
			<?php foreach($the_publications[$key] as $publication): ?>
				<?php include("publication-item.php") ?>
			<?php endforeach; ?> 
			</ol>
		<?php endforeach; ?> 
    </section>
	<?php include('footer.php'); ?>
</body>
</html>
