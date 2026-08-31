<?php
require('db.php');
require('utils.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);


function generate_academic_positions($the_latex, $conn) {
	$SQL_POSITIONS = "SELECT * FROM job j LEFT JOIN job_description jd ON j.jid = jd.job_id ORDER BY start_date DESC, jd.jdid ASC;";
	$positions = $conn->query($SQL_POSITIONS);

	$the_latex .= generate_section("Academic positions", "briefcase.png");
	
	$previous_jid = -1;
	$first = true;
	while($position = $positions->fetch_assoc()) {
		if($previous_jid != $position["jid"]) {
			if($first == true) {
				$first = false;
			} else {
				$the_latex .= "\\end{itemize}<br/>";
			}
			$the_latex .= generate_title($position["title"], $position["location"], $position["start_date"], $position["end_date"]);
			$the_latex .= "\\begin{itemize}<br/>";
		}
		$the_latex .= "\\item ".$position["text"]."<br/>";
		$previous_jid = $position["jid"];
		
	}
	// last list to close
	$the_latex .= "\\end{itemize}<br/>";

	return $the_latex;
}

function generate_education($the_latex, $conn) {
	$SQL_EDUCATION = "SELECT * FROM education ORDER BY start_date DESC;";
	$education = $conn->query($SQL_EDUCATION);

	$the_latex .= generate_section("Education", "graduation-cap.png");
	
	while($edu = $education->fetch_assoc()) {
		$the_latex .= generate_title($edu["title"], $edu["location"], $edu["start_date"], $edu["end_date"]);
		if($edu["specialty"] != "") {
			$the_latex .= "\\noindent Track: ".$edu["track"].", ".$edu["specialty"]."\\newline<br/>";
		} else {
			// only the track
			$the_latex .= "\\noindent Track: ".$edu["track"]."\\newline<br/>";
		}
	}

	return $the_latex;
}

function generate_awards($the_latex, $conn) {
	$SQL_AWARDS = "SELECT * FROM award ORDER BY date DESC;";
	$awards = $conn->query($SQL_AWARDS);

	$the_latex .= generate_section("Awards", "award.png");
	
	while($award = $awards->fetch_assoc()) {
		$the_latex .= generate_title($award["title"], $award["location"], $award["date"], "");
		if($award["webpage"] != "") {
			$the_latex .= "Website: \\url{".$award["webpage"]."}\\newline<br/>";
		}
		if($award["contents"] != "") {
			$the_latex .= "\\begin{itemize}<br/>";
			$the_latex .= "\item ".$award["contents"]."<br/>";
			$the_latex .= "\\end{itemize}<br/>";
		}
	}

	return $the_latex;
}

function generate_projects($the_latex, $conn) {
	$SQL_PROJECTS = "SELECT * FROM project ORDER BY end_date DESC, start_date DESC;";
	$projects = $conn->query($SQL_PROJECTS);

	$the_latex .= generate_section("Research projects", "idea.png");

	while($project = $projects->fetch_assoc()) {
		$the_latex .= generate_title($project["short_title"].": ".$project["long_title"], "", $project["start_date"], $project["end_date"]);
		$the_latex .= generate_subtitle(["Role" => $project["involvement"], "Grant" => $project["grant_type"], "Parnters" => $project["company"], "Website" => $project["webpage"]]);
		if($project["scientific"] != "" || $project["practical"] != "" || $project["collaboration"] != "") {
			//if at leadt one of them is non-empty, we start the list
			// otherwise, there are no scientific, no practical, not collaboration outcome yet, so we don't start the list
			$the_latex .= "\\begin{itemize}<br/>";
			if($project["scientific"] != "") {
				$the_latex .= "\\item \\textbf{Scientific outcomes:} ".$project["scientific"]."<br/>";
			}
			if($project["practical"] != "") {
				$the_latex .= "\\item \\textbf{Practical outcomes:} ".$project["practical"]."<br/>";
			}
			if($project["collaboration"] != "") {
				$the_latex .= "\\item \\textbf{Collaboration:} ".$project["collaboration"]."<br/>";
			}
			$the_latex .= "\\end{itemize}<br/>";
		} else {
			// if there is no result yet
			$the_latex .= "\\newline";
		}
	}

	return $the_latex;
}

function generate_tools($the_latex, $conn) {
	$SQL_TOOLS = "SELECT * FROM tool ORDER BY end_date DESC, start_date DESC;";
	$tools = $conn->query($SQL_TOOLS);

	$the_latex .= generate_section("Research tools", "terminal.png");

	while($tool = $tools->fetch_assoc()) {
		$the_latex .= generate_title($tool["title"], "", $tool["start_date"], $tool["end_date"]);
		$the_latex .= generate_subtitle(["Role" => $tool["involvement"], "Language" => $tool["language"], "LOC" => $tool["loc"], "Repository" => $tool["repository"]]);
		$the_latex .= "\\newline";
	}

	return $the_latex;
}

function generate_wgs($the_latex, $conn) {
	$SQL_WGS = "SELECT * FROM working_group wg LEFT JOIN working_group_description wgd ON wg.wgid = wgd.wg_id ORDER BY wg.end_date DESC, wg.start_date DESC, wgd.wgdid ASC;";
	$wgs = $conn->query($SQL_WGS);

	$the_latex .= generate_section("Working groups", "collaboration.png");

	while($wg = $wgs->fetch_assoc()) {
		$the_latex .= generate_title($wg["title"], $wg["location"], $wg["start_date"], $wg["end_date"]);
		$the_latex .= generate_subtitle(["Role" => $wg["involvement"], "Website" => $wg["webpage"]]);
		$the_latex .= "\\newline";
		// assuming there is only one text description per WG (true as of Aug. 2026)
		$the_latex .= "\\begin{itemize}";
		$the_latex .= "\\item ".$wg["text"];
		$the_latex .= "\\end{itemize}";
	}

	return $the_latex;
}

function generate_dissemination($the_latex, $conn) {
	$the_latex .= generate_section("Dissemination", "presentation.png");
	$categories = ["Seminar", "Panel", "Vulgarization", "Female empowerment"];

	foreach($categories as $category) {
		$the_latex .= generate_subsection($category, "");
		$SQL_TALKS = "SELECT * FROM dissemination WHERE category = '".$category."' ORDER BY date DESC, did ASC;";
		$talks = $conn->query($SQL_TALKS);
	
		$the_latex .= "\\begin{itemize}";
		while($talk = $talks->fetch_assoc()) {
			if($talk["resource"] != "") {
				$the_latex .= "\\item \\href{".$talk["resource"]."}{".$talk["title"]."}. ".$talk["location"].". ".$talk["date"];
			} else {
				$the_latex .= "\\item ".$talk["title"].". ".$talk["location"].". ".$talk["date"];
			}
		}
		$the_latex .= "\\end{itemize}";
	}

	return $the_latex;
}

function generate_teaching($the_latex, $conn) {
	$the_latex .= generate_section("Teaching", "teaching.png");
	$categories = ["course" => "Reccurent courses", "guest" => "Guest lectures", "service" => "Teaching service"];

	foreach($categories as $category => $pretty_category) {
		$the_latex .= generate_subsection($pretty_category, "");
		$SQL_TEACHING = "SELECT * FROM teaching WHERE category = '".$category."' ORDER BY start_date DESC, end_date DESC;";
		$teaching = $conn->query($SQL_TEACHING);
	
		$the_latex .= "\\begin{itemize}";
		while($teach = $teaching->fetch_assoc()) {
			$the_latex .= "\\item ".$teach["title"]." (".$teach["hours"].", ".$teach["school"].", ".$teach["level"]."): ".$teach["contents"].".<br/>";
		}
		$the_latex .= "\\end{itemize}";
	}

	return $the_latex;
}

function generate_training($the_latex, $conn) {
	$SQL_TRAININGS = "SELECT * FROM training t LEFT JOIN training_description td ON t.trid = td.training_id ORDER BY date DESC, td.trdid ASC;";
	$trainings = $conn->query($SQL_TRAININGS);

	$the_latex .= generate_section("Training", "training.png");
	
	$previous_tid = -1;
	$first = true;
	while($training = $trainings->fetch_assoc()) {
		if($previous_tid != $training["trid"]) {
			if($first == true) {
				$first = false;
			} else {
				$the_latex .= "\\end{itemize}<br/>";
			}
			$the_latex .= generate_title($training["title"], "", $training["date"], "");
			$the_latex .= "\\begin{itemize}<br/>";
		}
		$the_latex .= "\\item ".$training["text"]."<br/>";
		$previous_tid = $training["trid"];
		
	}
	// last list to close
	$the_latex .= "\\end{itemize}<br/>";

	return $the_latex;
}

function generate_visits($the_latex, $conn) {
	$SQL_VISITS = "SELECT * FROM visit v LEFT JOIN visit_description vd ON v.viid = vd.research_visit_id ORDER BY start_date DESC, start_date DESC, vd.vidid ASC;";
	$visits = $conn->query($SQL_VISITS);

	$the_latex .= generate_section("Research visits", "globe.png");
	
	$previous_vid = -1;
	$first = true;
	while($visit = $visits->fetch_assoc()) {
		// if($previous_vid != $visit["viid"]) {
		// 	if($first == true) {
		// 		$first = false;
		// 	} else {
		// 		$the_latex .= "\\end{itemize}<br/>";
		// 	}
			$the_latex .= generate_title($visit["location"], "", $visit["start_date"], $visit["end_date"]);
			// $the_latex .= "\\begin{itemize}<br/>";
		// }
		// $the_latex .= "\\item ".$visit["text"]."<br/>";
		// $previous_vid = $visit["viid"];
		
	}
	// last list to close
	// $the_latex .= "\\end{itemize}<br/>";

	return $the_latex;
}

function generate_research_service($the_latex, $conn) {

	$TEMPLATE_SERVICE_SELECT = "SELECT s.seid, s.category, v.acronym, v.name, v.rank, s.role, GROUP_CONCAT(CASE WHEN s.role <> '' THEN CONCAT(s.year, ' (', s.role, ')') ELSE s.year END ORDER BY year DESC SEPARATOR ', ') AS years FROM service s LEFT JOIN venue v ON s.venue_id = v.vid";
	$TEMPLATE_SERVICE_SELECT_WITHOUT_ROLE = "SELECT s.seid, s.category, v.acronym, v.name, v.rank, s.role, GROUP_CONCAT(s.year ORDER BY year DESC SEPARATOR ', ') AS years FROM service s LEFT JOIN venue v ON s.venue_id = v.vid";
	$TEMPLATE_SERVICE_GROUP_SORT = "GROUP BY category, venue_id ORDER BY s.category, FIELD (v.rank, 'Q1', 'A*', 'A', 'Q2', 'B', 'Q3', 'C', 'Q4', 'D', 'N/A'), s.year DESC, v.acronym ASC;";

	$SQL_LEADERSHIP = [
		"Conference and workshop organizer" => $TEMPLATE_SERVICE_SELECT." WHERE category = 'organizer' ".$TEMPLATE_SERVICE_GROUP_SORT,
		"Conference and workshop chair" => $SQL_CHAIR_SERVICES = $TEMPLATE_SERVICE_SELECT." WHERE category = 'chair' ".$TEMPLATE_SERVICE_GROUP_SORT,
		"PC responsabilities" => $SQL_PC_SERVICES = $TEMPLATE_SERVICE_SELECT." WHERE category = 'pc' ".$TEMPLATE_SERVICE_GROUP_SORT,
		"Journals" => $SQL_JOURNAL_REVIEW_SERVICES = $TEMPLATE_SERVICE_SELECT_WITHOUT_ROLE." WHERE role = 'journal reviewer' ".$TEMPLATE_SERVICE_GROUP_SORT,
		"Conferences" => $SQL_CONFERENCE_REVIEW_SERVICES = $TEMPLATE_SERVICE_SELECT." WHERE category = 'reviewer' AND role <> 'journal reviewer' ".$TEMPLATE_SERVICE_GROUP_SORT
	];
	

	$the_latex .= generate_section("Service", "responsibilities.png");
	$the_latex .= generate_subsection("Leadership", "responsibilities.png");

	foreach($SQL_LEADERSHIP as $category => $SQL) {
		if($category == "Journals") {
			// stop the Leadership section and start the Reviewing section
			$the_latex .= generate_subsection("Review responsabilities", "responsibilities.png");
		}
		$the_latex .= generate_subsubsection($category, "responsibilities.png");
		$the_latex .= "\\begin{itemize}<br/>";
		$the_leadership = $conn->query($SQL);
		while($leadership = $the_leadership->fetch_assoc()) {
			$the_latex .= "\\item $[$".$leadership["rank"]."$]$ ".$leadership["acronym"]." (".$leadership["name"]."): ".$leadership["years"]."<br/>";
		}
		$the_latex .= "\\end{itemize}<br/>";
	}

	return $the_latex;
}

function generate_institutional($the_latex, $conn) {
	$SQL_INSTITUTIONAL = "SELECT * FROM responsability r ORDER BY end_date DESC, start_date DESC;";
	$institutional_respos = $conn->query($SQL_INSTITUTIONAL);

	$the_latex .= generate_section("Working groups", "collaboration.png");

	while($respo = $institutional_respos->fetch_assoc()) {
		$the_latex .= generate_title($respo["title"], "", $respo["start_date"], $respo["end_date"]);
		$the_latex .= generate_subtitle(["Role" => $respo["involvement"], "Website" => $respo["webpage"]]);
		$the_latex .= "\\newline";
		// assuming there is only one text description per WG (true as of Aug. 2026)
		$the_latex .= "\\begin{itemize}";
		$the_latex .= "\\item ".$respo["content"];
		$the_latex .= "\\end{itemize}";
	}

	return $the_latex;
}

function generate_publications($the_latex, $conn) {
	$CATEGORIES = [
		"int_journal" => "International journals", 
		"int_conf" => "International conferences", 
		"int_workshop" => "International workshops", 
		"demo" => "Demonstrations",
		"nat_conf" => "National conferences",
		"manuscript" => "Manuscripts"
	];

	$the_latex .= generate_section("Publications", "book.png");
	
	foreach($CATEGORIES as $category => $pretty_category) {
		$the_latex .= generate_subsection($pretty_category, "responsibilities.png");
		$the_latex .= "\\begin{enumerate}[resume]<br/>";
		$SQL = "SELECT pu.*, v.*, GROUP_CONCAT(CONCAT(pe.first_name, ' ', pe.last_name) ORDER BY author_position ASC SEPARATOR ', ') AS the_authors FROM publication pu LEFT JOIN venue v ON pu.venue = v.vid LEFT JOIN publication_author pa ON pa.publication_id = pu.puid LEFT JOIN person pe ON pa.author_id = pe.peid WHERE category = '".$category."' GROUP BY pa.publication_id ORDER BY pu.year DESC, v.acronym ASC, pa.publication_id ASC, pa.author_position ASC";
		$the_publications = $conn->query($SQL);
		while($publication = $the_publications->fetch_assoc()) {
			$the_latex .= "\\item ".$publication["the_authors"].". \\href{".$publication["paper_url"]."}{".$publication["title"]."}. ".$publication["name"].". ".$publication["year"]."<br/>";
		}
		$the_latex .= "\\end{enumerate}<br/>";
	}

	return $the_latex;
}

function generate_advising($the_latex, $conn) {
	$the_latex .= generate_section("Advising", "responsibilities.png");

	$GROUP_CONCAT_ADVISORS = "GROUP_CONCAT(CONCAT(pe2.first_name, ' ', pe2.last_name, ' (', ss.supervisor_role, ')') ORDER BY person_position ASC SEPARATOR ', ') AS the_team";
	$JOINS_FOR_GROUP_CONCAT = "LEFT JOIN internship_supervisor ss ON s.iid = ss.internship_id LEFT JOIN person pe2 ON ss.supervisor_id = pe2.peid ";

	$SQL_ADVISING = [
		"Engineer students" => "SELECT s.*, p.*, CONCAT(p.first_name, ' ', p.last_name) AS the_student, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status, ".$GROUP_CONCAT_ADVISORS." FROM internship s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level LIKE '%Engineer%' GROUP BY s.iid ORDER BY s.year DESC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');",
		"Master students" => "SELECT s.*, p.*, CONCAT(p.first_name, ' ', p.last_name) AS the_student, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status, ".$GROUP_CONCAT_ADVISORS." FROM internship s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level LIKE '%Master%' GROUP BY s.iid ORDER BY s.year DESC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');",
		"Bachelor students" => "SELECT s.*, p.*, CONCAT(p.first_name, ' ', p.last_name) AS the_student, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status, ".$GROUP_CONCAT_ADVISORS." FROM internship s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level  LIKE '%Bachelor%' GROUP BY s.iid ORDER BY s.year DESC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');"
	];

	foreach($SQL_ADVISING as $category => $SQL) {
		$the_latex .= generate_subsection($category, "student-management.png");
		$the_latex .= "\\begin{itemize}<br/>";
		$internships = $conn->query($SQL);
		while($internship = $internships->fetch_assoc()) {
			$the_latex .= "\\item ".$internship["the_student"]." on ``".$internship["topic"]."'' (".$internship["semester"]." ".$internship["year"].", ".$internship["school"].")<br/>";
		}
		$the_latex .= "\\end{itemize}<br/>";
	}

	return $the_latex;
}

function generate_section($title, $icon) {
	$the_string = "\\section*{\\includegraphics[width=1cm]{images/".$icon."}".$title."}<br/>";
	return $the_string;
}

function generate_subsection($title, $icon) {
	$the_string = "\\subsection*{".$title."}<br/>";
	return $the_string;
}

function generate_subsubsection($title, $icon) {
	$the_string = "\\subsubsection*{".$title."}<br/>";
	return $the_string;
}

function generate_title($title, $location, $start_date, $end_date) {
	$the_string = "\\noindent\\textbf{".$title."}";
	if($location != "") {
		$the_string .= " | ".str_replace('&', '\\&', $location);
	}
	$the_string .= " \hfill ";
	if($end_date != "") {
		if($end_date == "1900-01-01") {
			$end_date = "now";
		}
		$the_string .= date('M Y', strtotime($start_date))." - ".date('M Y', strtotime($end_date));
	} else {
		$the_string .= date('M Y', strtotime($start_date));
	}
	$the_string .= "\\newline<br/>";
	return $the_string;
}

function generate_subtitle($the_assocative_array) {
	// $the_assocative_array is a "map" with the key being the keyword (role, website, grant_type, ...) and the valeu being the actual value (e.g., contributor, ANR Sources Says, ...)
	$the_string = "";
	$first = true;
	foreach($the_assocative_array as $key => $value) {
		if($value != "") {
			if($first) {
				$the_string .= "\\textit{".$key."}: ".(strpos($value, "http") !== false ? "\\url{".$value."}" : $value);
				$first = false;
			} else {
				$the_string .= " $|$ "."\\textit{".$key."}: ".(strpos($value, "http") !== false ? "\\url{".$value."}" : $value);
			}
		}
	}
	return $the_string;
}

try {
	// echo "Current working directory: " . getcwd() . "<br/>";
	
	$the_latex = "\documentclass{article}<br/>
	\usepackage{graphicx}<br/>
	\usepackage{url}<br/>
	\usepackage{hyperref}<br/>
	\usepackage{enumitem}<br/>
	\usepackage{geometry}<br/>
	\geometry{left =2cm, right=2cm, top=2cm,bottom=2cm}<br/>
	\usepackage{titlesec}<br/>
	\\titleformat{\section}{\\normalfont\Large\bfseries}{\\thesection}{1em}{}[{\\titlerule[0.8pt]}]<br/>
	\usepackage{xcolor}<br/>
	\usepackage{sectsty}<br/>
	\sectionfont{\color{orange}}<br/>
	\\title{CV}<br/>
	\author{nelly.barret }<br/>
	\date{August 2026}<br/>
	
	\begin{document}<br/>
	
	\maketitle<br/>";

	// generate research interests

	// generate academic positions
	$the_latex = generate_academic_positions($the_latex, $conn);
	
	// generate education
	$the_latex = generate_education($the_latex, $conn);
	
	// generate research visits
	$the_latex = generate_visits($the_latex, $conn);
	
	// generate awards
	$the_latex = generate_awards($the_latex, $conn);
	
	// generate research projects
	$the_latex = generate_projects($the_latex, $conn);
	
	// generate research tools
	$the_latex = generate_tools($the_latex, $conn);
	
	// generate research working groups
	$the_latex = generate_wgs($the_latex, $conn);
	
	// generate publications
	$the_latex = generate_publications($the_latex, $conn);
	
	// generate research service
	$the_latex = generate_research_service($the_latex, $conn);
	
	// generate institutional responsabilities
	$the_latex = generate_institutional($the_latex, $conn);
	
	// generate talks
	$the_latex = generate_dissemination($the_latex, $conn);
	
	// generate teaching responsabilities
	$the_latex = generate_teaching($the_latex, $conn);

	// generate training
	$the_latex = generate_training($the_latex, $conn);
	
	// generate advising
	$the_latex = generate_advising($the_latex, $conn);
	$the_latex .= "\\end{document}";

	print_r($the_latex);

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