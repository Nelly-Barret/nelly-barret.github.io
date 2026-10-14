<?php 

require('functions.php');

function generate_preambule($the_latex, $conn) {
	$the_latex .= "\documentclass{article}\n
	\usepackage{graphicx}\n
	\usepackage{url}\n
	\usepackage{hyperref}\n
	\hypersetup{colorlinks=true,urlcolor=blue}\n
	\usepackage{enumitem}\n
	\usepackage{geometry}\n
	\geometry{left =2cm, right=2cm, top=2cm,bottom=2cm}\n
	\usepackage{xcolor}\n
	\definecolor{myorange}{RGB}{255, 128, 0}\n
	\usepackage{titlesec}\n
	\\newcommand{\underlinedtitle}[1]{\color{myorange}#1\par\\nobreak\\noindent\\rule{\\textwidth}{1pt}}\n
	\\titleformat{\section}{\\normalfont\Large\bfseries}{}{0em}{\underlinedtitle}\n
	\\titlespacing\section{0pt}{12pt plus 4pt minus 2pt}{5pt plus 2pt minus 2pt}\n
	\\titlespacing\subsection{0pt}{12pt plus 4pt minus 2pt}{5pt plus 2pt minus 2pt}\n
	\\titlespacing\subsubsection{0pt}{12pt plus 4pt minus 2pt}{5pt plus 2pt minus 2pt}\n
	\usepackage{enumitem}\n
	\setlist[itemize]{noitemsep, topsep=0pt}\n
	\usepackage{fontawesome}\n
	\usepackage{orcidlink}\n
	\\renewcommand{\\familydefault}{\sfdefault}\n\n
	
	\begin{document}\n";

	return $the_latex;
}

function generate_header($the_latex, $conn) {
	$the_latex .= "\\noindent {\Huge Nelly Barret}\n\n";
	$the_latex .= "\\noindent {\huge Associate professor in computer science}\n\n";
	$the_latex .= "\\noindent {\Large LIRIS $\cdot$ INSA Lyon}\n\n";
	$the_latex .= "\\noindent \\faMapMarker\ Blaise Pascal building, 7 Avenue Jean Capelle, 69100 Villeurbanne, France\n\n";
	$the_latex .= "\\noindent \\faBuilding\ Office 502.3.21 $|$ \\faEnvelope\ nelly.barret@insa-lyon.fr $|$ \\faLaptop\ https://perso.liris.cnrs.fr/nbarret/ $|$ \orcidlink{0000-0002-3469-4149} \href{https://orcid.org/0000-0002-3469-4149}{0000-0002-3469-4149}\n\n";
	return $the_latex;
}

function generate_research_interests($the_latex, $conn) {
	$the_latex .= generate_section("Research interests", "\\faHeart");
	$the_latex .= "\\noindent My research themes lie in the broad area of heterogeneous data integration and exploitation, including heterogeneous and multi-modal data as well as warehouse, data lake and lakehouse architectures.\n\n\\noindent The general scientific questions that are driving me every day include:\n
	\begin{itemize}\n
		\item How to effectively and efficiently collect, organize and store heterogeneous data produced by various actors?\n
		\item How to explore and exploit large amounts of data, especially for domain experts?\n
		\item How to clean, join, merge, and sementically enrich raw data for better decision making?\n
	\\end{itemize}\n
	My research applies to various domains including sustainable cities, media, and healthcare, with a strong interest in sustainable cities.";
	return $the_latex;
}

function generate_academic_positions($the_latex, $conn) {
	$positions = get_academic_positions($conn);

	$the_latex .= generate_section("Academic positions", "\\faBriefcase");
	
	$previous_jid = -1;
	$first = true;
	$first2 = true;
	foreach($positions as $position) {
		if($previous_jid != $position["jid"]) {
			if($first == true) {
				$first = false;
			} else {
				$the_latex .= "\\end{itemize}\n";
			}
			$the_latex .= generate_title($position["title"], $position["location"], $position["start_date"], $position["end_date"], $first2);
			$the_latex .= "\\begin{itemize}\n";
			$first2 = false;
		}
		$the_latex .= "\\item ".$position["text"]."\n";
		$previous_jid = $position["jid"];
		
	}
	// last list to close
	$the_latex .= "\\end{itemize}\n";

	return $the_latex;
}

function generate_education($the_latex, $conn) {
	$educations = get_education($conn);

	$the_latex .= generate_section("Education", "\\faGraduationCap");
	
	$first = true;
	foreach($educations as $edu) {
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
	$awards = get_awards($conn);

	$the_latex .= generate_section("Awards", "\\faTrophy");
	
	$first = true;
	foreach($awards as $award) {
		$the_latex .= generate_title($award["title"], $award["location"], $award["date"], "", $first);
		$first = false;
		if($award["webpage"] != "") {
			$the_latex .= generate_subtitle(["Website" => $award["webpage"]]);
		}
		if($award["contents"] != "") {
			$the_latex .= "\\begin{itemize}\n";
			$the_latex .= "\item ".$award["contents"]."\n";
			$the_latex .= "\\end{itemize}\n";
		}
	}

	return $the_latex;
}

function generate_projects($the_latex, $conn) {
	$projects = get_projects($conn);

	$the_latex .= generate_section("Research projects", "\\faLightbulbO ");

	$first = true;
	foreach($projects as $project) {
		$the_latex .= generate_title($project["short_title"].": ".$project["long_title"], "", $project["start_date"], $project["end_date"], $first);
		$first = false;
		$the_latex .= generate_subtitle(["Role" => $project["involvement"], "Grant" => $project["grant_type"], "Parnters" => $project["company"], "Website" => $project["webpage"]]);
		if($project["scientific"] != "" || $project["practical"] != "" || $project["collaboration"] != "") {
			//if at leadt one of them is non-empty, we start the list
			// otherwise, there are no scientific, no practical, not collaboration outcome yet, so we don't start the list
			$the_latex .= "\\begin{itemize}\n";
			if($project["scientific"] != "") {
				$the_latex .= "\\item \\textbf{Scientific outcomes:} ".$project["scientific"]."\n";
			}
			if($project["practical"] != "") {
				$the_latex .= "\\item \\textbf{Practical outcomes:} ".$project["practical"]."\n";
			}
			if($project["collaboration"] != "") {
				$the_latex .= "\\item \\textbf{Collaboration:} ".$project["collaboration"]."\n";
			}
			$the_latex .= "\\end{itemize}\n";
		} else {
			// if there is no result yet, nothing to do
			// $the_latex .= "\\newline\n";
		}
	}

	return $the_latex;
}

function generate_tools($the_latex, $conn) {
	$tools = get_tools($conn);

	$the_latex .= generate_section("Research tools", "\\faCode");

	$first = true;
	foreach($tools as $tool) {
		$the_latex .= generate_title($tool["title"], "", $tool["start_date"], $tool["end_date"], $first);
		$the_latex .= generate_subtitle(["Role" => $tool["involvement"], "Language" => $tool["language"], "LOC" => $tool["loc"], "Repository" => $tool["repository"]]);
		$first = false;
	}

	return $the_latex;
}

function generate_wgs($the_latex, $conn) {
	$wgs = get_wg($conn);

	$the_latex .= generate_section("Working groups", "\\faGroup ");

	$first = true;
	foreach($wgs as $wg) {
		$the_latex .= generate_title($wg["title"], $wg["location"], $wg["start_date"], $wg["end_date"], $first);
		$the_latex .= generate_subtitle(["Role" => $wg["involvement"], "Website" => $wg["webpage"]]);
		// assuming there is only one text description per WG (true as of Aug. 2026)
		$the_latex .= "\\begin{itemize}\n";
		$the_latex .= "\\item ".$wg["text"]."\n";
		$the_latex .= "\\end{itemize}\n";
		$first = false;
	}

	return $the_latex;
}

function generate_dissemination($the_latex, $conn) {
	$the_latex .= generate_section("Talks and Dissemination", "\\faMicrophone");

	$categories = [
		"Seminar" => get_invited_talks($conn), 
		"Panel" => get_panels($conn), 
		"Vulgarization" => get_vulgarization($conn), 
		"Female empowerment" => get_female_talks($conn)
	];

	foreach($categories as $category => $talks) {
		$the_latex .= generate_subsection($category);
	
		$the_latex .= "\\begin{itemize}\n";
		foreach($talks as $talk) {
			if($talk["resource"] != "") {
				$the_latex .= "\\item \\href{".$talk["resource"]."}{".$talk["title"]."}. ".date('M Y', strtotime($talk["date"])).", ".get_entity_from_logo($talk["logo_filepath"]).", ".$talk["location"].".\n";
			} else {
				$the_latex .= "\\item ".$talk["title"].". ".date('M Y', strtotime($talk["date"])).", ".get_entity_from_logo($talk["logo_filepath"]).", ".$talk["location"].".\n";
			}
		}
		$the_latex .= "\\end{itemize}\n";
	}

	return $the_latex;
}

function generate_summary_dissemination($the_latex, $conn) {
	$the_latex .= generate_section("Talks and Dissemination", "\\faMicrophone");
	return $the_latex;
}

function generate_teaching($the_latex, $conn) {
	$the_latex .= generate_section("Teaching", "\\faSlideshare");
	$categories = [
		"Recurring courses (in French)" => get_recurrent_courses($conn), 
		"Guest lectures" => get_guest_courses($conn), 
		"Teaching service" => get_teaching_service($conn)
	];

	foreach($categories as $category => $teaching) {
		$the_latex .= generate_subsection($category);
	
		$the_latex .= "\\begin{itemize}\n";
		foreach($teaching as $teach) {
			if($category == "Teaching service") {
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
			$the_latex .= "\\item ".$teach["title"]." (".$years.$hours.$teach["school"].$level."): ".$teach["contents"]."\n";
		}
		$the_latex .= "\\end{itemize}\n";
	}

	return $the_latex;
}

function generate_training($the_latex, $conn) {
	$CATEGORIES = [
		"For reasearch" => get_reasearch_training($conn),
		"For teaching" => get_teaching_training($conn)
	];

	$the_latex .= generate_section("Training", "\\faWpforms");
	
	foreach($CATEGORIES as $category => $trainings) {
		$the_latex .= generate_subsection($category);
		
		foreach($trainings as $training) {
			$the_latex .= generate_title($training["title"]." (".$training["duration"].")", "", $training["date"], "", true);
			if($training["webpage"] != "") {
				$the_latex .= generate_subtitle(["Website" => $training["webpage"]]);
			}
			
			$the_latex .= "\\begin{itemize}\n";
			$the_latex .= "\\item ".$training["content_cv"];
			$the_latex .= "\\end{itemize}\n";
		}
	}

	// last text to sperate from next section
	$the_latex .= "\n";

	return $the_latex;
}

function generate_visits($the_latex, $conn) {
	$visits = get_visits($conn);

	$the_latex .= generate_section("Research visits", "\\faCalendar");
	
	foreach($visits as $visit) {
		$the_latex .= generate_title($visit["location"], "", $visit["start_date"], $visit["end_date"], $first);
	}

	return $the_latex;
}

function generate_research_service($the_latex, $conn) {

	$SQL_LEADERSHIP = [
		"Conference and workshop organizer" => get_service_organization($conn),
		"Conference and workshop chair" => get_service_chair($conn),
		"PC responsabilities" => get_service_pc($conn),
		"Journals" => get_service_journal_review($conn),
		"Conferences" => get_service_conf_review($conn)
	];

	$the_latex .= generate_section("Service", "\\faGroup");
	$the_latex .= generate_subsection("Leadership");

	foreach($SQL_LEADERSHIP as $category => $services) {
		if($category == "Journals") {
			// stop the Leadership section and start the Reviewing section
			$the_latex .= generate_subsection("Review responsabilities");
		}
		$the_latex .= generate_subsubsection($category);
		$the_latex .= "\\begin{itemize}\n";
		foreach($services as $service) {
			$the_latex .= "\\item $[$".$service["rank"]."$]$ ".$service["acronym"]." (".$service["name"]."): ".$service["years"]."\n";
		}
		$the_latex .= "\\end{itemize}\n";
	}

	return $the_latex;
}

function generate_institutional($the_latex, $conn) {
	$institutional_respos = get_institutional_responsabilities($conn);

	$the_latex .= generate_section("Institutional responsabilities", "\\faUniversity");

	$first = true;
	foreach($institutional_respos as $respo) {
		$the_latex .= generate_title($respo["title"], "", $respo["start_date"], $respo["end_date"], $first);
		$the_latex .= generate_subtitle(["Role" => $respo["involvement"], "Website" => $respo["webpage"]]);
		// assuming there is only one text description per reponsability (true as of Aug. 2026)
		$the_latex .= "\\begin{itemize}\n";
		$the_latex .= "\\item ".$respo["content"]."\n";
		$the_latex .= "\\end{itemize}\n";
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
	// sort by publication category in the long CV
	$sort = "FIELD(pu.category, 'int_journal', 'int_conf', 'int_workshop', 'nat_conf', 'demo', 'manuscript'), pu.year DESC, v.acronym ASC";

	$the_latex .= generate_section("Publications", "\\faBook");
	$publications = get_all_publications($conn, $sort);
	
	// foreach($CATEGORIES as $category => $pretty_category) {
	$previous_category = "";
	$first = true;
	foreach($publications as $publication) {
		if($first && $publication["category"] != $previous_category) {
			// very first category
			$the_latex .= generate_subsection($CATEGORIES[$publication["category"]]);
			$the_latex .= "\\begin{enumerate}\n";
		} else if($publication["category"] != $previous_category) {
			// other categories
			$the_latex .= "\\end{enumerate}\n";
			$the_latex .= generate_subsection($CATEGORIES[$publication["category"]]);
			$the_latex .= "\\begin{enumerate}[resume]\n";
		}
		
		$authors = $publication["the_authors"];
		if($publication["main_author"]) {
			$authors = str_replace("Nelly Barret", "\underline{Nelly Barret}", $authors);
		}
		$the_latex .= "\\item ".$authors.". \\href{".$publication["paper_url"]."}{".$publication["title"]."}. ".$publication["name"].". ".$publication["year"]."\n";
		
		$previous_category = $publication["category"];
		$first = false;
	}
	$the_latex .= "\\end{enumerate}\n";

	return $the_latex;
}

function generate_summary_publications($the_latex, $conn) {
	$the_latex .= generate_section("Publications", "\\faBook");
	$publications = get_summary_publications($conn);
	
	// foreach($CATEGORIES as $category => $pretty_category) {
	$previous_category = "";
	$the_latex .= "\begin{tabular}{r|r|r|r|r|r}";
	$the_latex .= "& Top (A*/A, Q1) & Good (B/Q2) & Medium (C, Q3) & Low (D, Q4) & N/A \\newline <br/>";
	$first_category = true;
	foreach($publications as $category => $count_ranks) {
		$the_latex .= $category;	
		foreach($count_ranks as $rank => $count) {
			$the_latex .= " & ".$count;
		}
		$the_latex .= " \\newline <br/>";
	}
	$the_latex .= "\\end{tabular}";

	return $the_latex;
}

function generate_advising($the_latex, $conn) {
	$the_latex .= generate_section("Student supervision", "\\faCommentsO");

	$SQL_ADVISING = [
		"Engineer students" => get_engineer_students($conn), 
		"Master students" => get_master_students($conn), 
		"Bachelor students" => get_bachelor_students($conn)
	];

	foreach($SQL_ADVISING as $category => $internships) {
		$the_latex .= generate_subsection($category);
		$the_latex .= "\\begin{itemize}\n";
		foreach($internships as $internship) {
			$the_latex .= "\\item ".$internship["the_student"]." on ``".$internship["topic"]."'' with ".$internship["the_team"]." - ".$internship["semester"]." ".$internship["year"].", ".$internship["school"]."\n";
		}
		$the_latex .= "\\end{itemize}\n";
	}

	return $the_latex;
}

function generate_summary_advising($the_latex, $conn) {
	$the_latex .= generate_section("Student supervision", "\\faCommentsO");
	return $the_latex;
}

function generate_footer($the_latex, $conn) {
	$the_latex .= "\n\n\\vspace{3em}\\noindent\centering\\textcolor{gray}{Last update: \\today}\n\n";
	return $the_latex;
}

function generate_section($title, $icon) {
	// \\includegraphics[width=1cm]{images/".$icon."}
	$the_string = "\\section*{".$icon."\\ ".$title."}\n";
	return $the_string;
}

function generate_subsection($title) {
	$the_string = "\\subsection*{".$title."}\n";
	return $the_string;
}

function generate_subsubsection($title) {
	$the_string = "\\subsubsection*{".$title."}\n";
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
	$the_string .= "}\n";
	return $the_string;
}

function generate_subtitle($the_assocative_array) {
	// $the_assocative_array is a "map" with the key being the keyword (role, website, grant_type, ...) and the valeu being the actual value (e.g., contributor, ANR Sources Says, ...)
	$the_string = "\n\n\\noindent";
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
	$the_string .= "\n\n";
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
	if(substr_count($logo_name, " ") >= 1) {
		// this is very likely to be a long name or a school name, so we only capitalize the first letter of the first word
		return ucfirst($logo_name);
	} else {
		// this is very likely to be an acronym / lab name, so we capitalize it
		return strtoupper($logo_name);
	}
}

function display_for_debug($the_latex) {
	// by default, $the_latex contains \n lines (but \n do not render in HTML when printed in the navigator)
	// to debug, call print_r(display_for_debug($the_latex)) instead of print_r($the_latex) to have the <br/> replacing the \n
	return str_replace("\n", "<br/>", $the_latex);
}


?>