<?php
require('db.php');
try {
	$SQL_AWARDS = "SELECT * FROM award;";
	$awards = $conn->query($SQL_AWARDS);

	$SQL_RESEARCH_TRAINING = "SELECT *, CONCAT('<ul><li>', GROUP_CONCAT(td.text SEPARATOR '</li><li>'), '</li></ul>') AS content FROM training t LEFT JOIN training_description td ON t.trid=td.training_id WHERE t.category = 'research' GROUP BY t.trid;";

	$SQL_TEACHING_TRAINING = "SELECT *, CONCAT('<ul><li>', GROUP_CONCAT(td.text SEPARATOR '</li><li>'), '</li></ul>') AS content FROM training t LEFT JOIN training_description td ON t.trid=td.training_id WHERE t.category = 'teaching' GROUP BY t.trid;";
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

	<h1 class="section-title">Academic positions</h1>
		<table class="table table-striped table-hover my-table-four">
			<tbody>
				<tr>
					<td><img src="./logo/liris.png" class="logo"></img><img src="./logo/insa-lyon.png" class="logo"></img></td>
					<td>Since Sept. 2025</td>
					<td><b>Assistant Professor</b>, LIRIS lab and INSA Lyon school (&#x1f1eb;&#x1f1f7;)<br/><div class="description">
						<u>Research</u>: part of the DRIM team, focusing on document engineering and distributed systems.<br/>
						<u>Teaching</u>: 1st and 2nd year courses at the engineer school INSA Lyon.
					</div></td>
					<td><span class="badge text-bg-success">Current</span></td>
				</tr>
				<tr>
					<td><img src="./logo/polimi.png" class="logo"></img></td>
					<td>April 2024 - July 2025</td>
					<td><b>Postdoctoral researcher</b>, Politecnico di Milano (&#x1f1ee;&#x1f1f9;)<br/><div class="description">
						<u>Horizon Europe project</u>: "Better real-world health-data distributed analytics research platform".<br/>
						<u>Close collaborators</u>: 
						<ul>
							<li>Pietro Pinoli (associate professor, Politecnico di Milano, IT)</li>
							<li>Anna Bernasconi (assistant professor, Politecnico di Milano, IT)</li>
							<li>Boris Bikbov (medical doctor, Politecnico di Milano, IT)</li>
					</ul>
					</div></td>
					<td><span class="badge text-bg-secondary">Finished</span></td>
				</tr>
				<tr>
					<td><img src="./logo/inria.png" class="logo"></img><img src="./logo/ecole-polytechnique.webp" class="logo"></img></td>
					<td>Jan. 2021 - March 2024</td>
					<td><b>PhD student</b>, Institut Polytechnique de Paris & Inria (&#x1f1eb;&#x1f1f7;)<br/><div class="description">
						<u>PhD thesis title</u>: "User-oriented exploration of semi-structured datasets"<br/>
						<u>PhD defense jury</u>: 
						<ul>
							<li>Fatiha Sais (president – professor, Univ. Paris-Saclay and LISN)</li> 
							<li>Jean-Marc Petit (rapporteur – professor, at INSA Lyon and LIRIS)</li>
							<li>Olivier Teste (rapporteur – professor, Univ. Toulouse Jean Jaurès and IRIT)</li>
							<li>Katja Hose (examinator – professor, TU Wien, AT)</li>
							<li>Stefano Ceri (examinator – professor, Politecnico di Milano, IT)</li>
							<li>Fatemeh Nargesian (examinator – associate professor, Univ. Rochester, USA)</li>
							<li>Ioana Manolescu (advisor – research director, Ecole Polytechnique and Inria Saclay)</li>
							<li>Karen Bastien (co-advisor – WeDoData CEO)</li>
						</ul>
					</div></td>
					<td><span class="badge text-bg-secondary">Finished</span></td>
				</tr>
				<tr>
					<td><img src="./logo/liris.png" class="logo"></img></td>
					<td>Feb. 2020 - July 2020</td>
					<td><b>Master intern</b>, LIRIS (&#x1f1eb;&#x1f1f7;)<br/><div class="description">
						<u>Master thesis title (in French)</u>: "Prédiction de l'environnement d'un quartier"<br/>
						<u>Advisors</u>: 
						<ul>
							<li>Fabien Duchateau (associate professor, Univ. Lyon 1 and LIRIS)</li> 
							<li>Franck Favetta (associate professor, Univ. de Lyon and LIRIS).</li>
						</ul>
						<u>Other collaborators involved in the project</u>:
						<ul>
							<li>Nelly Duong (CEO, Home in Love)</li>
							<li>Behnaz Jullien (intern in psychology, Univ. Lyon 2)</li>
							<li>Wissame Laddada (post-doctoral researcher, LIRIS)</li>
							<li>Ludovic Moncla (associate professor, computer science at INSA Lyon)</li>
						</ul>
					</div></td>
					<td><span class="badge text-bg-secondary">Finished</span></td>
				</tr><tr>
					<td><img src="./logo/liris.png" class="logo"></img></td>
					<td>Feb. 2020 - July 2020</td>
					<td><b>Bachelor intern</b>, LIRIS (&#x1f1eb;&#x1f1f7;)<br/><div class="description">
						<u>Bachelor thesis title (in French)</u>: "Intégration de données géographiques pour la recommandation de quartiers"<br/>
						<u>Advisors</u>: 
						<ul>
							<li>Fabien Duchateau (associate professor, Univ. Lyon 1 and LIRIS)</li> 
							<li>Franck Favetta (associate professor, Univ. de Lyon and LIRIS).</li>
						</ul>
						<u>Other collaborators involved in the project</u>:
						<ul>
							<li>Nelly Duong (CEO, Home in Love)</li>
							<li>Loïc Bonneval (associate professor in sociology, Univ. Lyon 2)</li>
							<li>Aurélien Gentil (PhD student in sociology, Univ. Lyon 2)</li>
						</ul>
					</div></td>
					<td><span class="badge text-bg-secondary">Finished</span></td>
				</tr>
			</tbody>
		</table>


		<h1 class="section-title">Awards</h1>
		<table class="table table-striped table-hover my-table-three">
			<tbody>
			<?php while($award = $awards->fetch_assoc()): ?>
				<tr>
					<td><?=$award["location"] ?></td>
					<td><b><?=$award["title"] ?></b> (<?=$award["date"] ?>)<br/><p class="description"><?=$award["contents"] ?></p></td>
					<?php if($award["webpage"] != ""): ?>
						<td><a href="<?=$award["webpage"]?>" target="_blank">website</a></td>
					<?php else: ?>
						<td></td>
					<?php endif; ?>
				</tr>
			<?php endwhile; ?> 
			</tbody>
		</table>
	
		<h1 class="section-title">Training activities</h1>

		<h2 class="subsection-title">For research</h2>
		<?php $trainings = $conn->query($SQL_RESEARCH_TRAINING); ?>
		<?php include("career-table.php"); ?>
		

		<h2 class="subsection-title">For teaching</h2>
		<?php $trainings = $conn->query($SQL_TEACHING_TRAINING); ?>
		<?php include("career-table.php"); ?>

    </section>

	<?php include('footer.php'); ?>
</body>
</html>