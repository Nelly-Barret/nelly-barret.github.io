<?php
require('../db.php');
try {
	$SQL_TESTS = "SELECT * FROM test;";
	$tests = $conn->query($SQL_TESTS);
	
	$SQL_PROJECTS = "SELECT * FROM project;";
	$projects = $conn->query($SQL_PROJECTS);

	$SQL_INTERNSHIPS = "SELECT * FROM supervision;";
	$internships = $conn->query($SQL_INTERNSHIPS);

	$SQL_REVIEWS = "SELECT * FROM service;";
	$reviews = $conn->query($SQL_REVIEWS);

	$SQL_SERVICE = "SELECT * FROM service;";
	$services = $conn->query($SQL_SERVICE);

	$SQL_INSTITUTIONAL = "SELECT * FROM responsability;";
	$admins = $conn->query($SQL_INSTITUTIONAL);

	$SQL_WG = "SELECT * FROM working_group;";
	$wgs = $conn->query($SQL_WG);
} catch (Exception $e) {
	var_dump($e);
}

?>

<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <title>Nelly Barret</title>

    <!--JQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <section class="anchor light">
		<h1>Insert</h1>
		<form id="insertform">
			<label for="myfield">Entrez le texte:</label>
			<input id="myfield" name="myfield" type="text" required />
			<input type="submit" value="insérer"/>
		</form>	

		<h1 class="dashboard-section">Test</h1>
		<?php include("test-table.php"); ?>

		<dialog id="modif_test" style="display:none">
			<div class="modal-content">
				<span class="close-button" onclick="$('#modif_test').hide();">x</span>
				<h4 class="modal-title">Modifier le test</h4>
				
				<form id="updateform">
					<input id="modal_test_id" type="text" value="" />
					<label for="dialname">Champ</label>
					<input name="dialname" type="text" value="" />
					<button>Sauvegarder</button>
				</form>
			</div>
		</dialog>

			

		<h1 class="dashboard-section">Projets de recherche</h1>
		<?php include("project-table.php"); ?>

		<h1 class="dashboard-section">Stages de recherche</h1>
		<?php include("internship-table.php"); ?>

		<h1 class="dashboard-section">Reviews</h1>
		<?php include("review-table.php"); ?>

		<h1 class="dashboard-section">Conférences</h1>
		<?php include("conference-table.php"); ?>

		<h1 class="dashboard-section">Responsabilités LIRIS</h1>
		<?php include("liris-table.php"); ?>

		<h1 class="dashboard-section">Groupes de travail</h1>
		<?php include("wg-table.php"); ?>
    </section>
</body>
</html>

<script type="text/javascript">
	// insert data
	$('#insertform').on("submit", function(e){
		e.preventDefault();

		$.ajax({
			"url": "insert3.php",
			"method": "POST",
			"dataType": "json",
			"data": {
				"myfield": $("#myfield").val()
			}, 
			"success": function(response) {
				console.log(response);
			}, "error": function(response) {
				console.log(response);
			}
		});
	});

	// update data
	function modifTestVal(testVal) {
		const id = $('#test_table tr:eq(1) td').first().text(); // first is 0
		const champ = $('#test_table tr:eq(1) td').eq(1).text();
		$("#modal_test_id").val(id);
		$("input[name=dialname]").val(champ);
		$('#modif_test').show();
	}

	$('#updateform').on("submit", function(e){
		e.preventDefault();
		console.log(e);

		const myid = $("#modal_test_id").val();
		console.log(myid);
		const myfield = $("input[name=dialname]").val();
		console.log(myfield);

		$.ajax({
			"url": "update.php",
			"method": "POST",
			"dataType": "json",
			"data": {
				"myid": myid,
				"myfield": myfield
			}, "success": function(response) {
				console.log("ici");
				console.log(response);
				$('#modif_test').hide();
				window.location.reload(); // then reload the page.(3)
			}, "error": function(response) {
				console.log("la");
				console.log(response.responseText);
			}
		});
	});

</script>
