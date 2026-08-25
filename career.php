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

	<nav class="career-toc">

    <span class="career-toc-title">
        On this page:
    </span>

    <a href="#academic-positions">
        Academic positions
    </a>

    <a href="#awards">
        Awards
    </a>

    <a href="#training">
        Training activities
    </a>

</nav>

	
		<h1 class="section-title" id="academic-positions">Academic positions</h1>
		<div class="academic-timeline">
			<div class="academic-timeline-item">
				<div class="academic-timeline-date">Since Sept. 2025</div>

				<div class="academic-timeline-line">
					<span class="academic-timeline-dot current"></span>
				</div>

				<div class="academic-timeline-content">
					<h3>Assistant Professor <span class="badge bg-success">Current</span></h3>
					<div class="academic-timeline-institution">LIRIS&nbsp;&#183;&nbsp;INSA Lyon &#x1f1eb;&#x1f1f7;</div>
					<div class="description">
						<u>Research</u>: part of the DRIM team, focusing on document engineering and distributed systems.<br/>
						<u>Teaching</u>: 1st and 2nd year courses at the engineer school INSA Lyon.
					</div>
				</div>
			</div>

			<div class="academic-timeline-item">
				<div class="academic-timeline-date">Apr. 2024 – July 2025</div>

				<div class="academic-timeline-line">
					<span class="academic-timeline-dot"></span>
				</div>

				<div class="academic-timeline-content">
					<h3>Postdoctoral Researcher</h3>
					<div class="academic-timeline-institution">
						Politecnico di Milano 🇮🇹
					</div>

					<div class="description">
						<u>Horizon Europe project</u>: "Better real-world health-data distributed analytics research platform".<br/>
						<u>Close collaborators</u>: Pietro Pinoli (associate professor, Politecnico di Milano, IT), Anna Bernasconi (assistant professor, Politecnico di Milano, IT), Boris Bikbov (medical doctor, Politecnico di Milano, IT)
					</div>
				</div>
			</div>

			<div class="academic-timeline-item">
				<div class="academic-timeline-date">Jan. 2021 – Mar. 2024</div>

				<div class="academic-timeline-line">
					<span class="academic-timeline-dot"></span>
				</div>

				<div class="academic-timeline-content">
					<h3>PhD Student</h3>
					<div class="academic-timeline-institution">
					Inria  &amp; Institut Polytechnique de Paris &#x1f1eb;&#x1f1f7;
					</div>

					<div class="description">
						<u>PhD thesis title</u>: "User-oriented exploration of semi-structured datasets"<br/>
						<u>PhD advisors</u>: Ioana Manolescu (advisor) and Karen Bastien (co-advisor – WeDoData CEO)<br/>
						<u>PhD defense jury</u>: Fatiha Sais (president – professor, Univ. Paris-Saclay and LISN), Jean-Marc Petit (rapporteur – professor, at INSA Lyon and LIRIS), Olivier Teste (rapporteur – professor, Univ. Toulouse Jean Jaurès and IRIT), Katja Hose (examinator – professor, TU Wien, AT), Stefano Ceri (examinator – professor, Politecnico di Milano, IT), Fatemeh Nargesian (examinator – associate professor, Univ. Rochester, USA)
					</div>
				</div>
			</div>

			<div class="academic-timeline-item">
				<div class="academic-timeline-date">Feb. 2020 – July 2020</div>

				<div class="academic-timeline-line">
					<span class="academic-timeline-dot"></span>
				</div>

				<div class="academic-timeline-content">
					<h3>Master Research Intern</h3>
					<div class="academic-timeline-institution">
						LIRIS &#x1f1eb;&#x1f1f7;
					</div>

					<div class="description">
						<u>Master thesis title (in French)</u>: "Prédiction de l'environnement d'un quartier"<br/>
						<u>Advisors</u>: Fabien Duchateau, Franck Favetta<br/>
						<u>Other collaborators involved in the project</u>: Nelly Duong (CEO, Home in Love), Behnaz Jullien (intern in psychology, Univ. Lyon 2), Wissame Laddada (post-doctoral researcher, LIRIS), Ludovic Moncla (associate professor, computer science at INSA Lyon)
					</div>
				</div>
			</div>

			<div class="academic-timeline-item">
				<div class="academic-timeline-date">Feb. 2020 – July 2020</div>

				<div class="academic-timeline-line">
					<span class="academic-timeline-dot"></span>
				</div>

				<div class="academic-timeline-content">
					<h3>Bachelor Research Intern</h3>
					<div class="academic-timeline-institution">
						LIRIS &#x1f1eb;&#x1f1f7;
					</div>

					<div class="description">
						<u>Bachelor thesis title (in French)</u>: "Intégration de données géographiques pour la recommandation de quartiers"<br/>
						<u>Advisors</u>: Fabien Duchateau, Franck Favetta<br/>
						<u>Other collaborators involved in the project</u>: Nelly Duong (CEO, Home in Love), Loïc Bonneval (associate professor in sociology, Univ. Lyon 2), Aurélien Gentil (PhD student in sociology, Univ. Lyon 2)
					</div>
				</div>
			</div>
		</div>

		<h1 class="section-title" id="awards">Awards</h1>
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
	
		<h1 class="section-title" id="training">Training activities</h1>

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