<?php
require('db.php');
try {
	$SQL_CURRENT_PROJECTS = "SELECT * FROM project  WHERE end_date = '1900-01-01' OR end_date >= CURDATE()";
	$current_projects = $conn->query($SQL_CURRENT_PROJECTS);

	$SQL_FORMER_PROJECTS = "SELECT * FROM project WHERE end_date < CURDATE();";
	$former_projects = $conn->query($SQL_FORMER_PROJECTS);
} catch (Exception $e) {
	var_dump($e);
}

try {
	function compute_duration($start_date, $end_date) {
		if($end_date == "1900-01-01") {
			// the project is not finished yet
			return "Started since ".$start_date;
		} else {
			// "normal" date difference
			$ts1 = strtotime($start_date);
			$ts2 = strtotime($end_date);
			$diff_months = ((date('Y', $ts2) - date('Y', $ts1)) * 12) + (date('m', $ts2) - date('m', $ts1));

			if($diff_months < 12) {
				// < 1 year
				return "< 1 year";
			} else if ($diff_months == 12) {
				return "1 year";
			} else {
				$diff_years = round($diff_months / 12.0, 1);
				if($diff_years >= 2) {
					// 2+ years
					return $diff_years." years";
				} else {
					// 1.1 to 1.9 year
					return $diff_years." year";
				}
			}
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
		<h1 class="section-title">Research themes</h1>
		
		My research themes lie in the broad area of <b>heterogeneous data integration and exploitation</b>, including heterogeneous and multi-modal data as well as warehouse, data lake and lakehouse architectures.

		<br/><br/>

		The general scientific questions that are driving me every day include: 
		<ul>
			<li>How to effectively and efficiently collect, organize and store heterogeneous data produced by various actors?</li>
			<li>How to explore and exploit large amounts of data, especially for domain experts?</li>
			<li>How to clean, join, merge, and sementically enrich raw data for better decision making?
		</ul>

		My research applies to various domains including sustainable cities, media, and healthcare, with a strong interest in <b>sustainable cities</b>.
		
		<h1 class="section-title">Projects and tools</h1>
		
		
		<h2>Current projects</h2>
		<?php while($project = $current_projects->fetch_assoc()): ?>
			<?php include("research-card.php") ?>
		<?php endwhile; ?> 
		</div>


		<h2>Past projects</h2>
		<!-- <h2 data-bs-toggle="collapse" href="#collapsePastProjects" role="button" aria-expanded="false" aria-controls="collapsePastProjects">Past projects</h2> -->
  		
		<!-- <div class="collapse" id="collapsePastProjects"> -->
			<div class="row">
		<?php while($project = $former_projects->fetch_assoc()): ?>
  <div class="col-sm-6 mb-3 mb-sm-0">
			<?php include("research-card.php") ?>
		</div>
		<?php endwhile; ?> 
	</div>
		<!-- </div> -->
    </section>
</body>

</html>