<?php
require('db.php');
require('utils.php');
require('cv-functions.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);


try {
	// echo "Current working directory: " . getcwd() . "\n";
	
	$the_latex = "";

	// generate LaTeX preambule
	$the_latex = generate_preambule($the_latex, $conn);

	// generate header
	$the_latex = generate_header($the_latex, $conn);

	// generate research interests
	$the_latex = generate_research_interests($the_latex, $conn);

	// generate academic positions
	$the_latex = generate_academic_positions($the_latex, $conn);
	
	// generate education
	$the_latex = generate_education($the_latex, $conn);
	
	// generate research projects
	$the_latex = generate_projects($the_latex, $conn);
	
	// generate research tools
	$the_latex = generate_tools($the_latex, $conn);

	// generate publications
	$the_latex = generate_publications($the_latex, $conn);

	// generate awards
	$the_latex = generate_awards($the_latex, $conn);

	// generate research working groups
	$the_latex = generate_wgs($the_latex, $conn);
	
	// // generate research visits
	// $the_latex = generate_visits($the_latex, $conn);
	
	// generate research service
	$the_latex = generate_research_service($the_latex, $conn);
	
	// generate talks
	$the_latex = generate_dissemination($the_latex, $conn);
	
	// generate institutional responsabilities
	$the_latex = generate_institutional($the_latex, $conn);
	
	// generate teaching responsabilities
	$the_latex = generate_teaching($the_latex, $conn);

	// generate advising
	$the_latex = generate_advising($the_latex, $conn);

	// generate training
	$the_latex = generate_training($the_latex, $conn);

	// generate footer
	$the_latex = generate_footer($the_latex, $conn);

	$the_latex .= "\\end{document}";

	print_r($the_latex); // BY DEFAULT
	// print_r(display_for_debug($the_latex)); // FOR DEBUG ONLY

	// $myfile = fopen("/tmp/test-nbarret.tex", "w") or die("Unable to open file!");
	// if (!$myfile) {
	// 	die("File handle is invalid!");
	// }
	// $bytes_written = fwrite($myfile, "un test");
	// fflush($myfile);
	// if ($bytes_written === false) {
	// 	die("Failed to write to file!");
	// } else {
	// 	echo "Successfully wrote $bytes_written bytes to the file.<br>";
	// }
	// fclose($myfile);

	// echo "Current working directory: " . getcwd();


	// // Debug info
	// while (ob_get_level()) ob_end_clean(); // Disable all output buffering
	// echo "Current working directory: " . getcwd() . "<br>";
	// echo "Script directory: " . __DIR__ . "<br>";

	// $filepath = "/tmp/test-nbarret.tex";
	// // $filepath = __DIR__ . "/the_test.tex";
	// echo "Attempting to write to: " . realpath($filepath) . "<br>";
	// echo "File exists: " . (file_exists($filepath) ? "Yes" : "No") . "<br>";
	// echo "Is writable: " . (is_writable($filepath) ? "Yes" : "No") . "<br>";

	// // Write to file
	// $myfile = fopen($filepath, "w") or die("Unable to open file: " . error_get_last()['message']);
	// fwrite($myfile, "Test content");
	// fflush($myfile);
	// fclose($myfile);
	

	// echo "File size after write: " . filesize($filepath) . " bytes<br>";
	// echo "File content: <pre>" . htmlspecialchars(file_get_contents($filepath)) . "</pre>";
} catch (Exception $e) {
	print_r($e);
}

	
?>