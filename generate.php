<?php
require('db.php');
require('utils.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);


function generate_header($the_latex, $conn) {
	$the_latex .= "\\noindent {\Huge Nelly Barret}<br/><br/>";
	$the_latex .= "\\noindent {\huge Assistant professor in computer science}<br/><br/>";
	$the_latex .= "\\noindent {\Large LIRIS $\cdot$ INSA Lyon}<br/><br/>";
	$the_latex .= "\\noindent \\faMapMarker\ Blaise Pascal building, 7 Avenue Jean Capelle, 69100 Villeurbanne, France<br/><br/>";
	$the_latex .= "\\noindent \\faBuilding\ Office 502.3.21 $|$ \\faEnvelope\ nelly.barret@insa-lyon.fr $|$ \\faLaptop\ https://perso.liris.cnrs.fr/nbarret/ $|$ \orcidlink{0000-0002-3469-4149} \href{https://orcid.org/0000-0002-3469-4149}{0000-0002-3469-4149}<br/><br/>";
	return $the_latex;
}

function generate_research_interests($the_latex, $conn) {
	$the_latex .= generate_section("Research interests", "\\faHeart");
	$the_latex .= "\\noindent My research themes lie in the broad area of heterogeneous data integration and exploitation, including heterogeneous and multi-modal data as well as warehouse, data lake and lakehouse architectures.<br/><br/>\\noindent The general scientific questions that are driving me every day include:<br/>
	\begin{itemize}<br/>
		\item How to effectively and efficiently collect, organize and store heterogeneous data produced by various actors?<br/>
		\item How to explore and exploit large amounts of data, especially for domain experts?<br/>
		\item How to clean, join, merge, and sementically enrich raw data for better decision making?<br/>
	\\end{itemize}<br/>
	My research applies to various domains including sustainable cities, media, and healthcare, with a strong interest in sustainable cities.";
	return $the_latex;
}

function generate_academic_positions($the_latex, $conn) {
	$SQL_POSITIONS = "SELECT * FROM job j LEFT JOIN job_description jd ON j.jid = jd.job_id ORDER BY start_date DESC, jd.jdid ASC;";
	$positions = $conn->query($SQL_POSITIONS);

	$the_latex .= generate_section("Academic positions", "\\faBriefcase");
	
	$previous_jid = -1;
	$first = true;
	$first2 = true;
	while($position = $positions->fetch_assoc()) {
		if($previous_jid != $position["jid"]) {
			if($first == true) {
				$first = false;
			} else {
				$the_latex .= "\\end{itemize}<br/>";
			}
			$the_latex .= generate_title($position["title"], $position["location"], $position["start_date"], $position["end_date"], $first2);
			$the_latex .= "\\begin{itemize}<br/>";
			$first2 = false;
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

	$the_latex .= generate_section("Education", "\\faGraduationCap");
	
	$first = true;
	while($edu = $education->fetch_assoc()) {
		$the_latex .= generate_title($edu["title"], $edu["location"], $edu["start_date"], $edu["end_date"], $first);
		if($edu["specialty"] != "") {
			$the_latex .= generate_subtitle(["Track" => $edu["track"].", ".$edu["specialty"]]);
		} else {
			// only the track
			$the_latex .= generate_subtitle(["Track" => $edu["track"]]);
		}
		$first = false;
	}

	return $the_latex;
}

function generate_awards($the_latex, $conn) {
	$SQL_AWARDS = "SELECT * FROM award ORDER BY date DESC;";
	$awards = $conn->query($SQL_AWARDS);

	$the_latex .= generate_section("Awards", "\\faTrophy");
	
	$first = true;
	while($award = $awards->fetch_assoc()) {
		$the_latex .= generate_title($award["title"], $award["location"], $award["date"], "", $first);
		$first = false;
		if($award["webpage"] != "") {
			$the_latex .= generate_subtitle(["Website" => $award["webpage"]]);
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

	$the_latex .= generate_section("Research projects", "\\faLightbulbO ");

	$first = true;
	while($project = $projects->fetch_assoc()) {
		$the_latex .= generate_title($project["short_title"].": ".$project["long_title"], "", $project["start_date"], $project["end_date"], $first);
		$first = false;
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
			// if there is no result yet, nothing to do
			// $the_latex .= "\\newline<br/>";
		}
	}

	return $the_latex;
}

function generate_tools($the_latex, $conn) {
	$SQL_TOOLS = "SELECT * FROM tool ORDER BY end_date DESC, start_date DESC;";
	$tools = $conn->query($SQL_TOOLS);

	$the_latex .= generate_section("Research tools", "\\faCode");

	$first = true;
	while($tool = $tools->fetch_assoc()) {
		$the_latex .= generate_title($tool["title"], "", $tool["start_date"], $tool["end_date"], $first);
		$the_latex .= generate_subtitle(["Role" => $tool["involvement"], "Language" => $tool["language"], "LOC" => $tool["loc"], "Repository" => $tool["repository"]]);
		$first = false;
	}

	return $the_latex;
}

function generate_wgs($the_latex, $conn) {
	$SQL_WGS = "SELECT * FROM working_group wg LEFT JOIN working_group_description wgd ON wg.wgid = wgd.wg_id ORDER BY wg.end_date DESC, wg.start_date DESC, wgd.wgdid ASC;";
	$wgs = $conn->query($SQL_WGS);

	$the_latex .= generate_section("Working groups", "\\faGroup ");

	$first = true;
	while($wg = $wgs->fetch_assoc()) {
		$the_latex .= generate_title($wg["title"], $wg["location"], $wg["start_date"], $wg["end_date"], $first);
		$the_latex .= generate_subtitle(["Role" => $wg["involvement"], "Website" => $wg["webpage"]]);
		// assuming there is only one text description per WG (true as of Aug. 2026)
		$the_latex .= "\\begin{itemize}<br/>";
		$the_latex .= "\\item ".$wg["text"]."<br/>";
		$the_latex .= "\\end{itemize}<br/>";
		$first = false;
	}

	return $the_latex;
}

function generate_dissemination($the_latex, $conn) {
	$the_latex .= generate_section("Talks and Dissemination", "\\faMicrophone");
	$categories = ["Seminar", "Panel", "Vulgarization", "Female empowerment"];

	foreach($categories as $category) {
		$the_latex .= generate_subsection($category);
		$SQL_TALKS = "SELECT * FROM dissemination WHERE category = '".$category."' ORDER BY date DESC, did ASC;";
		$talks = $conn->query($SQL_TALKS);
	
		$the_latex .= "\\begin{itemize}<br/>";
		while($talk = $talks->fetch_assoc()) {
			if($talk["resource"] != "") {
				$the_latex .= "\\item \\href{".$talk["resource"]."}{".$talk["title"]."}. ".date('M Y', strtotime($talk["date"])).", ".get_entity_from_logo($talk["logo_filepath"]).", ".$talk["location"].".<br/>";
			} else {
				$the_latex .= "\\item ".$talk["title"].". ".date('M Y', strtotime($talk["date"])).", ".$talk["location"].".<br/>";
			}
		}
		$the_latex .= "\\end{itemize}<br/>";
	}

	return $the_latex;
}

function generate_teaching($the_latex, $conn) {
	$the_latex .= generate_section("Teaching", "\\faSlideshare");
	$categories = ["'course' AND end_date='2222-01-01'" => "Reccuring courses", "'guest'" => "Guest lectures", "'service'" => "Teaching service", "'course' AND end_date < '2222-01-01'" => "Previous courses"];

	foreach($categories as $category => $pretty_category) {
		$the_latex .= generate_subsection($pretty_category);
		$SQL_TEACHING = "SELECT * FROM teaching WHERE category = ".$category." ORDER BY start_date DESC, end_date DESC;";
		$teaching = $conn->query($SQL_TEACHING);
	
		$the_latex .= "\\begin{itemize}<br/>";
		while($teach = $teaching->fetch_assoc()) {
			if($category == "'service'") {
				// do not print the number of hours for teaching service (only for real courses) nor the level
				$hours = "";
				$level = "";
			} else {
				$hours = $teach["hours"]."h, ";
				$level = ", ".$teach["level"];
			}
			if($teach["end_date"] > "2222-01-01") {
				$years = date('Y', strtotime($teach["end_date"])).", ";
			} else {
				$years = "";
			}
			$the_latex .= "\\item ".$teach["title"]." (".$years.$hours.$teach["school"].$level."): ".$teach["contents"]."<br/>";
		}
		$the_latex .= "\\end{itemize}<br/>";
	}

	return $the_latex;
}

function generate_training($the_latex, $conn) {
	$SQL_TRAININGS = "SELECT * FROM training t LEFT JOIN training_description td ON t.trid = td.training_id ORDER BY date DESC, td.trdid ASC;";
	$trainings = $conn->query($SQL_TRAININGS);

	$the_latex .= generate_section("Training", "\\faWpforms");
	
	$previous_tid = -1;
	$first = true;
	$first2 = true;
	$first3 = true;
	while($training = $trainings->fetch_assoc()) {
		if($previous_tid != $training["trid"]) {
			$first2 = true;
			if($first == true) {
				$first = false;
			} else {
				//remove last additional comma
				$the_latex = substr($the_latex, 0, strlen($the_latex)-2); // remove the space and the comma 
				$the_latex .= "<br/><br/>"; // specifically for training, we need two newlines because there is no itemize to separate the text form the next title
			}
			$the_latex .= generate_title($training["title"]." (".$training["duration"].")", "", $training["date"], "", $first3);
			$first3 = false;
			if($training["webpage"] != "") {
				$the_latex .= generate_subtitle(["Website" => $training["webpage"]]);
			}
			// $the_latex .= "\\begin{itemize}<br/>";
		}
		// $the_latex .= "\\item ".$training["text"]."<br/>";
		if($first2 == true) {
			$the_latex .= "<br/>"; // specifically for training, we need one more newline because there is no itemize to separate the title form the text
			$the_latex .= "\\noindent ";
			$first2 = false;
		}
		
		$the_latex .= $training["text"]."; ";
		$previous_tid = $training["trid"];
		
	}

	//remove last additional comma
	$the_latex = substr($the_latex, 0, strlen($the_latex)-2); // remove the space and the comma 
	// last text to sperate from next section
	$the_latex .= "<br/>";

	return $the_latex;
}

function generate_visits($the_latex, $conn) {
	$SQL_VISITS = "SELECT * FROM visit v LEFT JOIN visit_description vd ON v.viid = vd.research_visit_id ORDER BY start_date DESC, start_date DESC, vd.vidid ASC;";
	$visits = $conn->query($SQL_VISITS);

	$the_latex .= generate_section("Research visits", "\\faCalendar");
	
	$previous_vid = -1;
	$first = true;
	while($visit = $visits->fetch_assoc()) {
		// if($previous_vid != $visit["viid"]) {
		// 	if($first == true) {
		// 		$first = false;
		// 	} else {
			// 		$the_latex .= "\\end{itemize}<br/>";
			// 	}
		$the_latex .= generate_title($visit["location"], "", $visit["start_date"], $visit["end_date"], $first);
			// $the_latex .= "\\begin{itemize}<br/>";
			// }
			// $the_latex .= "\\item ".$visit["text"]."<br/>";
			// $previous_vid = $visit["viid"];
		$first = false;
		
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
	

	$the_latex .= generate_section("Service", "\\faGroup");
	$the_latex .= generate_subsection("Leadership");

	foreach($SQL_LEADERSHIP as $category => $SQL) {
		if($category == "Journals") {
			// stop the Leadership section and start the Reviewing section
			$the_latex .= generate_subsection("Review responsabilities");
		}
		$the_latex .= generate_subsubsection($category);
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

	$the_latex .= generate_section("Institutional responsabilities", "\\faUniversity");

	$first = true;
	while($respo = $institutional_respos->fetch_assoc()) {
		$the_latex .= generate_title($respo["title"], "", $respo["start_date"], $respo["end_date"], $first);
		$the_latex .= generate_subtitle(["Role" => $respo["involvement"], "Website" => $respo["webpage"]]);
		// assuming there is only one text description per reponsability (true as of Aug. 2026)
		$the_latex .= "\\begin{itemize}<br/>";
		$the_latex .= "\\item ".$respo["content"]."<br/>";
		$the_latex .= "\\end{itemize}<br/>";
		$first = false;
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

	$the_latex .= generate_section("Publications", "\\faBook");
	
	foreach($CATEGORIES as $category => $pretty_category) {
		$the_latex .= generate_subsection($pretty_category);
		$the_latex .= "\\begin{enumerate}[resume]<br/>";
		$SQL = "SELECT pu.*, v.*, GROUP_CONCAT(CONCAT(pe.first_name, ' ', pe.last_name) ORDER BY author_position ASC SEPARATOR ', ') AS the_authors FROM publication pu LEFT JOIN venue v ON pu.venue = v.vid LEFT JOIN publication_author pa ON pa.publication_id = pu.puid LEFT JOIN person pe ON pa.author_id = pe.peid WHERE category = '".$category."' GROUP BY pa.publication_id ORDER BY pu.year DESC, v.acronym ASC, pa.publication_id ASC, pa.author_position ASC";
		$the_publications = $conn->query($SQL);
		while($publication = $the_publications->fetch_assoc()) {
			$authors = $publication["the_authors"];
			if($publication["main_author"]) {
				$authors = str_replace("Nelly Barret", "\underline{Nelly Barret}", $authors);
			}
			$the_latex .= "\\item ".$authors.". \\href{".$publication["paper_url"]."}{".$publication["title"]."}. ".$publication["name"].". ".$publication["year"]."<br/>";
		}
		$the_latex .= "\\end{enumerate}<br/>";
	}

	return $the_latex;
}

function generate_advising($the_latex, $conn) {
	$the_latex .= generate_section("Student supervision", "\\faCommentsO");

	$GROUP_CONCAT_ADVISORS = "GROUP_CONCAT(CONCAT(pe2.first_name, ' ', pe2.last_name, ' (', ss.supervisor_role, ')') ORDER BY person_position ASC SEPARATOR ', ') AS the_team";
	$JOINS_FOR_GROUP_CONCAT = "LEFT JOIN internship_supervisor ss ON s.iid = ss.internship_id LEFT JOIN person pe2 ON ss.supervisor_id = pe2.peid ";

	$SQL_ADVISING = [
		"Engineer students" => "SELECT s.*, p.*, CONCAT(p.first_name, ' ', p.last_name) AS the_student, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status, ".$GROUP_CONCAT_ADVISORS." FROM internship s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level LIKE '%Engineer%' GROUP BY s.iid ORDER BY s.year DESC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');",
		"Master students" => "SELECT s.*, p.*, CONCAT(p.first_name, ' ', p.last_name) AS the_student, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status, ".$GROUP_CONCAT_ADVISORS." FROM internship s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level LIKE '%Master%' GROUP BY s.iid ORDER BY s.year DESC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');",
		"Bachelor students" => "SELECT s.*, p.*, CONCAT(p.first_name, ' ', p.last_name) AS the_student, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status, ".$GROUP_CONCAT_ADVISORS." FROM internship s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level  LIKE '%Bachelor%' GROUP BY s.iid ORDER BY s.year DESC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');"
	];

	foreach($SQL_ADVISING as $category => $SQL) {
		$the_latex .= generate_subsection($category);
		$the_latex .= "\\begin{itemize}<br/>";
		$internships = $conn->query($SQL);
		while($internship = $internships->fetch_assoc()) {
			$the_latex .= "\\item ".$internship["the_student"]." on ``".$internship["topic"]."'' (".$internship["semester"]." ".$internship["year"].", ".$internship["school"].")<br/>";
		}
		$the_latex .= "\\end{itemize}<br/>";
	}

	return $the_latex;
}

function generate_footer($the_latex, $conn) {
	$the_latex .= "<br/><br/>\\vspace{3em}\\noindent\centering\\textcolor{gray}{Last update: \\today}<br/><br/>";
	return $the_latex;
}

function generate_section($title, $icon) {
	// \\includegraphics[width=1cm]{images/".$icon."}
	$the_string = "\\section*{".$icon."\\ ".$title."}<br/>";
	return $the_string;
}

function generate_subsection($title) {
	$the_string = "\\subsection*{".$title."}<br/>";
	return $the_string;
}

function generate_subsubsection($title) {
	$the_string = "\\subsubsection*{".$title."}<br/>";
	return $the_string;
}

function generate_title($title, $location, $start_date, $end_date, $first) {
	if($first) {
		// no vspace for the first title after the section to avoid large blank spaces
		$the_string = "\\noindent\\textbf{".$title."}";
	} else {
		$the_string = "\\vspace{1em}\\noindent\\textbf{".$title."}";
	}
	if($location != "") {
		$the_string .= " $\cdot$ ".str_replace('&', '\\&', $location);
	}
	$the_string .= " \hfill \\textbf{";
	if($end_date != "") {
		if($end_date == "2222-01-01") {
			$the_string .= date('M Y', strtotime($start_date))." - now";
		} else {
			$the_string .= date('M Y', strtotime($start_date))." - ".date('M Y', strtotime($end_date));
		}
	} else {
		$the_string .= date('M Y', strtotime($start_date));
	}
	$the_string .= "}<br/>";
	return $the_string;
}

function generate_subtitle($the_assocative_array) {
	// $the_assocative_array is a "map" with the key being the keyword (role, website, grant_type, ...) and the valeu being the actual value (e.g., contributor, ANR Sources Says, ...)
	$the_string = "<br/><br/>\\noindent";
	$first = true;
	foreach($the_assocative_array as $key => $value) {
		// preprocess the value
		// a. if this is a LOC number, add k to the number
		if($key == "LOC") {
			$value .= "k";
		}
		// b. if this is a url, add a href with the http in the url name
		if(strpos($value, "http") !== false) {
			$value = "\\href{".$value."}{".str_replace("https://", "", $value)."}";
		}
		if($value != "") {
			if($first) {
				$the_string .= "\\textit{".$key."}: ".$value;
				$first = false;
			} else {
				$the_string .= " $|$ "."\\textit{".$key."}: ".$value;
			}
		}
	}
	$the_string .= "<br/><br/>";
	return $the_string;
}

function get_entity_from_logo($logo_filepath) {
	if(strpos($logo_filepath, "/") !== false && strpos($logo_filepath, ".") !== false) {
		return sanitize_logo(substr($logo_filepath, strrpos($logo_filepath, "/")+1, strrpos($logo_filepath, ".")-strrpos($logo_filepath, "/")-1));
	} else if(strpos($logo_filepath, ".") !== false) {
		// the image is not in a fodler, so no slash at the beginning
		return sanitize_logo(substr($logo_filepath, 0, strrpos($logo_filepath, ".")+1));
	} else {
		return sanitize_logo($logo_filepath);
	}
}

function sanitize_logo($logo_name) {
	$logo_name = str_replace("-", " ", $logo_name);
	if(substr_count($logo_name, " ") > 2) {
		// this is very likely to be a long name, so we only capitalize the first letter of the first word
		return ucfirst($logo_name);
	} else if (substr_count($logo_name, " ") == 2) {
		// this is very likely to be a lab/school with a city name, so we capitalize the first word and the first letter of the second word
		return ucwords($logo_name);
	} else {
		// this is very likely to be an acronym, so we capitalize it
		return strtoupper($logo_name);
	}
}

try {
	// echo "Current working directory: " . getcwd() . "<br/>";
	
	$the_latex = "\documentclass{article}<br/>
	\usepackage{graphicx}<br/>
	\usepackage{url}<br/>
	\usepackage{hyperref}<br/>
	\hypersetup{colorlinks=true,urlcolor=blue}<br/>
	\usepackage{enumitem}<br/>
	\usepackage{geometry}<br/>
	\geometry{left =2cm, right=2cm, top=2cm,bottom=2cm}<br/>
	\usepackage{xcolor}<br/>
	\definecolor{myorange}{RGB}{255, 128, 0}<br/>
	\usepackage{titlesec}<br/>
	\\newcommand{\underlinedtitle}[1]{\color{myorange}#1\par\\nobreak\\noindent\\rule{\\textwidth}{1pt}}<br/>
	\\titleformat{\section}{\\normalfont\Large\bfseries}{}{0em}{\underlinedtitle}<br/>
	\\titlespacing\section{0pt}{12pt plus 4pt minus 2pt}{5pt plus 2pt minus 2pt}<br/>
	\\titlespacing\subsection{0pt}{12pt plus 4pt minus 2pt}{5pt plus 2pt minus 2pt}<br/>
	\\titlespacing\subsubsection{0pt}{12pt plus 4pt minus 2pt}{5pt plus 2pt minus 2pt}<br/>
	\usepackage{enumitem}<br/>
	\setlist[itemize]{noitemsep, topsep=0pt}<br/>
	\usepackage{fontawesome}<br/>
	\usepackage{orcidlink}<br/>
	\\renewcommand{\\familydefault}{\sfdefault}<br/><br/>
	
	\begin{document}<br/>";

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