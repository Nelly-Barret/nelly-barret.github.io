<?php
require('db.php');
try {
	$counts = [];

	// SELECT p.category, v.rank, COUNT(p.id) FROM publication p LEFT JOIN venue v ON p.venue=v.id GROUP BY p.category, v.rank

	$SQL_SUMMARY = "SELECT p.category, v.rank, COUNT(p.id) AS count FROM publication p LEFT JOIN venue v ON p.venue=v.id GROUP BY p.category, v.rank";
	$summary = $conn->query($SQL_SUMMARY);
	while($row = $summary->fetch_assoc()) {
		if (!array_key_exists($row["category"], $counts)) {
			$counts[$row["category"]] = [];
			if(!array_key_exists($row["rank"], $counts[$row["category"]])) {
				$counts[$row["category"]][$row["rank"]] = 0;
			}
		}
		$counts[$row["category"]][$row["rank"]] = $row["count"];
	}

	$SQL_PUBLICATIONS = "SELECT * FROM publication";
	$publications = $conn->query($SQL_PUBLICATIONS);
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
					<td>Journals</td>
					<td><?=$counts["int_journal"]["Q1"]?></td>
					<td><?=$counts["int_journal"]["Q2"]?></td>
					<td><?=$counts["int_journal"]["Q3"]?></td>
					<td><?=$counts["int_journal"]["Q4"]?></td>
					<td><?=$counts["int_journal"]["N/A"]?></td>
				</tr>
				<tr>
					<td>International peer-reviewed conferences</td>
					<td><?=$counts["int_conf"]["A*"] + $counts["int_conf"]["A"]?></td>
					<td><?=$counts["int_conf"]["B"]?></td>
					<td><?=$counts["int_conf"]["C"]?></td>
					<td><?=$counts["int_conf"]["D"]?></td>
					<td><?=$counts["int_conf"]["N/A"]?></td>
				</tr>
				<tr>
					<td>International peer-reviewed workshops</td>
					<td><?=$counts["int_workshop"]["A*"] + $counts["int_workshop"]["A"]?></td>
					<td><?=$counts["int_workshop"]["B"]?></td>
					<td><?=$counts["int_workshop"]["C"]?></td>
					<td><?=$counts["int_workshop"]["D"]?></td>
					<td><?=$counts["int_workshop"]["N/A"]?></td>
				</tr>
				<tr>
					<td>International peer-reviewed demonstrations</td>
					<td><?=$counts["demo"]["A*"] + $counts["demo"]["A"]?></td>
					<td><?=$counts["demo"]["B"]?></td>
					<td><?=$counts["demo"]["C"]?></td>
					<td><?=$counts["demo"]["D"]?></td>
					<td><?=$counts["demo"]["N/A"]?></td>
				</tr>
				<tr>
					<td>National peer-reviewed conferences</td>
					<td><?=$counts["nat_conf"]["A*"] + $counts["nat_conf"]["A"]?></td>
					<td><?=$counts["nat_conf"]["B"]?></td>
					<td><?=$counts["nat_conf"]["C"]?></td>
					<td><?=$counts["nat_conf"]["D"]?></td>
					<td><?=$counts["nat_conf"]["N/A"]?></td>
				</tr>
				<tr>
					<td>Manuscripts</td>
					<td><?=$counts["manuscript"]["A*"] + $counts["manuscript"]["A"]?></td>
					<td><?=$counts["manuscript"]["B"]?></td>
					<td><?=$counts["manuscript"]["C"]?></td>
					<td><?=$counts["manuscript"]["D"]?></td>
					<td><?=$counts["manuscript"]["N/A"]?></td>
				</tr>
			</tbody>
		</table>
		
		<h1 class="section-title">Publication list</h1>
		
		<ol>
		<?php while($publication = $publications->fetch_assoc()): ?>
			<li><?=$publication["title"]?></li>
		<?php endwhile; ?> 
		</ol>
    </section>
</body>

</html>