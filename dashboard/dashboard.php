<?php
require('../db.php');
require('constants.php');
require('../utils.php');
try {
	$SQL_PROJECTS = "SELECT *, CONCAT(pe.first_name, ' ', pe.last_name) AS the_leader, GROUP_CONCAT(CONCAT(pe2.first_name, ' ', pe2.last_name) ORDER BY prc.person_position ASC SEPARATOR ', ') AS the_team FROM project pr LEFT JOIN person pe ON pr.leader = pe.peid LEFT JOIN project_consortium prc ON prc.project_id = pr.prid LEFT JOIN person pe2 ON prc.person_id = pe2.peid WHERE pr.start_date >= ? OR pr.start_date IS NULL GROUP BY pr.prid;";
	$stmt = $conn->prepare($SQL_PROJECTS);
	$stmt->bind_param("s", $MINIMUM_DATE);
	$stmt->execute();
	$projects = $stmt->get_result();

	$SQL_PROJECT_TASKS = "SELECT * FROM project_task pt LEFT JOIN project p ON pt.project_id = p.prid;";
	$project_tasks = $conn->query($SQL_PROJECT_TASKS);

	
	$SQL_PROJECT_STATUS = "SELECT SUBSTRING(COLUMN_TYPE,5) AS the_enum FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='nbarret' AND TABLE_NAME='project' AND COLUMN_NAME='status'"; 
	$status_query = $conn->query($SQL_PROJECT_STATUS); // this returns a column the_enum with a unique value ('A', 'B', ..., '')
	$row = $status_query->fetch_assoc(); // fetch the first row
	$project_statuses = substr($row["the_enum"], 1, -1); // remove parenthesis
	$project_statuses = str_replace("'", "", $project_statuses); // remove single quotes
    $project_statuses = explode(",", $project_statuses); // get an array of the enum project status values

	$SQL_INTERNSHIPS = "SELECT *, CONCAT(pe.first_name, ' ', pe.last_name) AS the_intern, GROUP_CONCAT(CONCAT(pe2.first_name, ' ', pe2.last_name) ORDER BY ss.person_position ASC SEPARATOR ', ') AS the_team FROM supervision su LEFT JOIN person pe ON su.person_id = pe.peid LEFT JOIN supervision_supervisor ss ON ss.supervision_id = su.suid LEFT JOIN person pe2 ON ss.supervisor_id = pe2.peid WHERE start_date >= ? OR start_date IS NULL GROUP BY su.suid";
	$stmt = $conn->prepare($SQL_INTERNSHIPS);
	$stmt->bind_param("s", $MINIMUM_DATE);
	$stmt->execute();
	$internships = $stmt->get_result();

	$SQL_REVIEWS = "SELECT * FROM service se LEFT JOIN venue v ON se.venue_id = v.vid WHERE (se.category = 'reviewer' OR se.category = 'pc') AND year >= ? OR year IS NULL;";

	// GROUP_CONCAT(CASE WHEN s.role <> '' THEN CONCAT(s.year, ' (', s.role, ')') ELSE s.year END ORDER BY year DESC SEPARATOR ', ') AS years
	$stmt = $conn->prepare($SQL_REVIEWS);
	$stmt->bind_param("s", $MINIMUM_DATE);
	$stmt->execute();
	$reviews = $stmt->get_result();

	$SQL_SERVICE = "SELECT * FROM service se LEFT JOIN venue v ON se.venue_id = v.vid WHERE category <> 'reviewer' AND se.category = 'pc' AND year >= ? OR year IS NULL;";
	$stmt = $conn->prepare($SQL_REVIEWS);
	$stmt->bind_param("s", $MINIMUM_DATE);
	$stmt->execute();
	$services = $stmt->get_result();

	$SQL_INSTITUTIONAL = "SELECT * FROM responsability WHERE start_date >= ? OR start_date IS NULL;";
	$stmt = $conn->prepare($SQL_INSTITUTIONAL);
	$stmt->bind_param("s", $MINIMUM_DATE);
	$stmt->execute();
	$admins = $stmt->get_result();

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

	<!-- Bootstrap -->
	<link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
	<div class="container">
		<h1>Insert</h1>
		<form id="insertform">
			<label for="myfield">Entrez le texte:</label>
			<input id="myfield" name="myfield" type="text" required />
			<input type="submit" value="insérer"/>
		</form>	

		<div class="row">
			<h1 class="dashboard_section">Tâches</h1>
			<?php include("task_page.php"); ?>
		</div>

		<div class="row">
			<h1 class="dashboard_section">Projets de recherche</h1>
			<?php include("project_table.php"); ?>
		</div>
		
		<div class="row">
			<h1 class="dashboard_section">Stages de recherche</h1>
			<?php include("internship_table.php"); ?>
		</div>

		<div class="row">
			<h1 class="dashboard_section">Reviews</h1>
			<?php include("review_table.php"); ?>
		</div>

		<div class="row">
			<h1 class="dashboard_section">Conférences</h1>
			<?php include("conference_table.php"); ?>
		</div>

		<div class="row">
			<h1 class="dashboard_section">Responsabilités LIRIS</h1>
			<?php include("liris_table.php"); ?>
		</div>

		<div class="row">
			<h1 class="dashboard_section">Groupes de travail</h1>
			<?php include("wg_table.php"); ?>
		</div>
    </section>
</body>
</html>

<script type="text/javascript">
	// insert data
	$('#insertform').on("submit", function(e){
		e.preventDefault();

		$.ajax({
			"url": "insert.php",
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

	make_cells_editable('#project_table', "update_project.php", "project_id");
	make_cells_editable('#internship_table', "update_internship.php", "internship_id");

	function make_cells_editable(table_selector, php_page, key_id) {
		$(document).on('click', table_selector + ' .editable', function () {
			const cell = $(this);
			if (cell.find('input').length > 0) {
				return;
			}

			const oldValue = cell.text().trim();
			const id = cell.data('id');
			const field = cell.data('field');

			const input = $('<input>', {
				type: 'text',
				value: oldValue
			}).css({
				width: '95%',
				boxSizing: 'border-box'
			});

			cell.empty().append(input);

			input.focus().select();

			let saving = false;

			function save() {
				if (saving) {
					return;
				}
				saving = true;
				const newValue = input.val().trim();

				// Nothing changed
				if (newValue === oldValue) {
					cell.text(oldValue);
					return;
				}

				$.ajax({
					url: php_page,
					type: 'POST',
					dataType: 'json',
					data: {
						[key_id]: id, // the key name whould be encompassed with brackets when the key name is a variable (in order to interpret it, otherwise without the brackets it would be the string "key_id", even without the quotes)
						field: field,
						value: newValue
					}, success: function (response) {
						if (response.success) {
							cell.text(newValue);
						} else {
							alert(response.message || 'Could not save the change.');
							cell.text(oldValue);
						}
					}, error: function (xhr) {
						console.log('Server response:', xhr.responseText);
						alert(
							'Error while saving project.\n\n' +
							'HTTP status: ' + xhr.status
						);
						cell.text(oldValue);
					}
				});
			}

			// Save when clicking outside
			input.on('blur', save);

			// Enter = save
			input.on('keydown', function (e) {
				if (e.key === 'Enter') {
					e.preventDefault();
					input.blur();
				}

				// Escape = cancel
				if (e.key === 'Escape') {
					e.preventDefault();
					saving = true;
					cell.text(oldValue);
				}
			})
		});
	}


</script>
