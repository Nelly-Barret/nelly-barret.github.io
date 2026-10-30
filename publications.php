<?php
require('db.php');
require('utils.php');
require('functions.php');

try {
	// SUMMARY RECORD

	$counts = get_summary_publications($conn, false);

	// DETAILED LIST OF PUBLICATIONS WITH PREFERED ORDRED

	if($_POST["sort-publis"] == "year") {
		// there is a parameter, we ask for a specific sort
		$sort = "pu.year DESC, FIELD(v.rank, 'Q1', 'A*', 'A', 'Q2', 'B', 'Q3', 'C', 'Q4', 'D', 'N/A')";
	} else { // if($_POST["sort_variable"] != "category") {
		// TODO: sort_in_order = ["journal", "int_conf", "int_work", "nat_conf", "demo", "manuscript"]
		$sort = "FIELD(pu.category, 'int_journal', 'int_conf', 'int_workshop', 'nat_conf', 'demo', 'manuscript'), pu.year DESC, FIELD(v.rank, 'Q1', 'A*', 'A', 'Q2', 'B', 'Q3', 'C', 'Q4', 'D', 'N/A')";
	}

	$publications = get_all_publications($conn, $sort);

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

	foreach($publications as $publi) {
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
	
	// print_r($the_publications);
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
			I regularly publish in peer-reviewed and recognized venues. Specifically, I have published in <b><?=get_total_count_for_category("int_journal")?> journals</b>, including <?= echo_count("int_journal", "Q1") ?> Q1 venues, and in <b><?=get_total_count_for_category("int_conf")?> international conferences</b>, <?= echo_count("int_conf", "A*", "A") ?> of which are ranked A* or A. I have also published <b><?=get_total_count_for_category("int_workshop")?> international workshop</b> papers and <b><?=get_total_count_for_category("demo")?> demonstration</b> papers, as well as <b><?=get_total_count_for_category("nat_conf")?> national conference</b> papers. In addition, I have authored <b><?=get_total_count_for_category("manuscript")?> manuscripts</b> as part of my research work.
		</p>
		
		<h1 class="section-title page-nav-section">Publication list</h1>

		<!-- <b>Legend:</b> <i class="fa-solid fa-file-pdf"></i> PDF paper, <i class="fa-solid fa-file-powerpoint"></i> PDF slides, <i class="fa-solid fa-file-invoice"></i> PDF poster, <i class="fa-brands fa-tex"></i> TeX citation -->
		<!-- <br/> -->
		<form action="publications.php" method="post">
			<b>Sort by:</b> <select name="sort-publis" id="sort-publis" onchange="this.form.submit();">
			<option value="category" <?= $_POST["sort-publis"] != "year" ? "selected" : ""?>>Publication type, then year</option>
			<option value="year" <?= $_POST["sort-publis"] == "year" ? "selected" : ""?>>Year, then CORE rank</option>
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
