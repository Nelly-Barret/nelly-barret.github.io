<?php
// to compute the badge Current / Finished
$CURRENT_STATUS_SQL = "CASE WHEN end_date = '2222-01-01' OR end_date > CURDATE() THEN 'Current' ELSE 'Finished' END AS status";
// GROUP CONCAT to create the list of advisors
$GROUP_CONCAT_ADVISORS = "GROUP_CONCAT(CONCAT(pe2.first_name, ' ', pe2.last_name, ' (', ss.supervisor_role, ')') ORDER BY person_position ASC SEPARATOR ', ') AS the_team";
$JOINS_FOR_GROUP_CONCAT = "LEFT JOIN internship_supervisor ss ON s.iid = ss.internship_id LEFT JOIN person pe2 ON ss.supervisor_id = pe2.peid ";
// for service (conference and workshop organizer, chair, pc, and reviews)
$TEMPLATE_SERVICE_SELECT = "SELECT s.seid, s.category, v.acronym, v.name, v.rank, s.role, GROUP_CONCAT(CASE WHEN s.role <> '' THEN CONCAT(s.year, ' (', s.role, ')') ELSE s.year END ORDER BY year DESC SEPARATOR ', ') AS years FROM service s LEFT JOIN venue v ON s.venue_id = v.vid";
$TEMPLATE_SERVICE_SELECT_WITHOUT_ROLE = "SELECT s.seid, s.category, v.acronym, v.name, v.rank, s.role, GROUP_CONCAT(s.year ORDER BY year DESC SEPARATOR ', ') AS years FROM service s LEFT JOIN venue v ON s.venue_id = v.vid";
$TEMPLATE_SERVICE_GROUP_SORT = "GROUP BY category, venue_id ORDER BY s.category, FIELD (v.rank, 'Q1', 'A*', 'A', 'Q2', 'B', 'Q3', 'C', 'Q4', 'D', 'N/A'), s.year DESC, v.acronym ASC;";


function execute_simple_query($conn, $sql) {
    try {
        return $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        var_dump($e);
    }
}

// sql is a SQL query with ? at right places
// value_binds is an array values to bind, e.g., [1, "Nelly", 3.14]
// type_binds is an array of the value types, e.g., ["i", "s", "d"]
function execute_binded_query($conn, $sql, $value_binds, $type_binds) {
    try {
        $stmt = $conn->prepare($sql);
		$stmt->bind_param(implode("", $type_binds), ...$value_binds);
		$stmt->execute();
		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        var_dump($e);
    }
}

function get_recurrent_courses($conn) {
    global $CURRENT_STATUS_SQL;
    $SQL = "SELECT *, ".$CURRENT_STATUS_SQL." FROM teaching WHERE category = 'course' AND `show` = 1 ORDER BY status ASC, end_date DESC, start_date DESC;";
    return execute_simple_query($conn, $SQL);
}

function get_guest_courses($conn) {
    global $CURRENT_STATUS_SQL;
    $SQL = "SELECT *, ".$CURRENT_STATUS_SQL." FROM teaching WHERE category = 'guest' AND `show` = 1 ORDER BY status ASC, end_date ASC, start_date DESC;";
    return execute_simple_query($conn, $SQL);
}

function get_teaching_service($conn) {
    $SQL = "SELECT * FROM teaching WHERE category = 'service' AND `show` = 1 ORDER BY start_date DESC;";
    return execute_simple_query($conn, $SQL);
}

function get_reasearch_training($conn) {
    $SQL = "SELECT *, CONCAT('<ul><li>', GROUP_CONCAT(td.text SEPARATOR '</li><li>'), '</li></ul>') AS content, GROUP_CONCAT(td.text SEPARATOR '; ') AS content_cv FROM training t LEFT JOIN training_description td ON t.trid=td.training_id WHERE t.category = 'research' GROUP BY t.trid;";
    return execute_simple_query($conn, $SQL);
}

function get_teaching_training($conn) {
    $SQL = "SELECT *, CONCAT('<ul><li>', GROUP_CONCAT(td.text SEPARATOR '</li><li>'), '</li></ul>') AS content, GROUP_CONCAT(td.text SEPARATOR '; ') AS content_cv FROM training t LEFT JOIN training_description td ON t.trid=td.training_id WHERE t.category = 'teaching' GROUP BY t.trid;";
    return execute_simple_query($conn, $SQL);
}

function get_awards($conn) {
    $SQL = "SELECT * FROM award ORDER BY date DESC;";
    return execute_simple_query($conn, $SQL);
}

function get_invited_talks($conn) {
    $SQL = "SELECT * FROM dissemination WHERE category = 'Seminar' AND `show` = 1 ORDER BY date DESC, did ASC;";
    return execute_simple_query($conn, $SQL);
}

function get_panels($conn) {
    $SQL = "SELECT * FROM dissemination WHERE category = 'Panel' AND `show` = 1 ORDER BY date DESC, did ASC;";
    return execute_simple_query($conn, $SQL);
}

function get_vulgarization($conn) {
    $SQL = "SELECT * FROM dissemination WHERE category = 'Vulgarization' AND `show` = 1 ORDER BY date DESC, did ASC;";
	return execute_simple_query($conn, $SQL);
}

function get_female_talks($conn) {
    $SQL = "SELECT * FROM dissemination WHERE category = 'Female empowerment' AND `show` = 1 ORDER BY date DESC, did ASC;";
	return execute_simple_query($conn, $SQL);
}

function get_summary_disseminations($conn) {
    $SQL = "";
    return execute_simple_query($conn, $SQL);
}

function get_institutional_responsabilities($conn, $show_only) {
    global $CURRENT_STATUS_SQL;
    $SQL = "SELECT *, ".$CURRENT_STATUS_SQL." FROM responsability ".($show_only ? "WHERE `show` = 1 " : "")."ORDER BY status ASC, end_date ASC, start_date DESC;";
	return execute_simple_query($conn, $SQL);
}

function get_engineer_students($conn) {
    global $GROUP_CONCAT_ADVISORS;
    global $JOINS_FOR_GROUP_CONCAT;
    global $CURRENT_STATUS_SQL;
    $SQL = "SELECT s.*, p.*, ".$CURRENT_STATUS_SQL.", CONCAT(p.first_name, ' ', p.last_name) AS the_student, ".$GROUP_CONCAT_ADVISORS." FROM internship s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level LIKE '%Engineer%' AND s.`show` = 1 GROUP BY s.iid ORDER BY status ASC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');";
	return execute_simple_query($conn, $SQL);
}

function get_master_students($conn) {
    global $GROUP_CONCAT_ADVISORS;
    global $JOINS_FOR_GROUP_CONCAT;
    global $CURRENT_STATUS_SQL;
    $SQL = "SELECT s.*, p.*, ".$CURRENT_STATUS_SQL.", CONCAT(p.first_name, ' ', p.last_name) AS the_student, ".$GROUP_CONCAT_ADVISORS." FROM internship s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level LIKE '%Master%' AND s.`show` = 1 GROUP BY s.iid ORDER BY status ASC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');";
	return execute_simple_query($conn, $SQL);
}

function get_bachelor_students($conn) {
    global $GROUP_CONCAT_ADVISORS;
    global $JOINS_FOR_GROUP_CONCAT;
    global $CURRENT_STATUS_SQL;
    $SQL = "SELECT s.*, p.*, ".$CURRENT_STATUS_SQL.", CONCAT(p.first_name, ' ', p.last_name) AS the_student, ".$GROUP_CONCAT_ADVISORS." FROM internship s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level  LIKE '%Bachelor%' AND s.`show` = 1 GROUP BY s.iid ORDER BY status ASC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');";
	return execute_simple_query($conn, $SQL);
}

function get_all_publications($conn, $sort) {
    $SQL = "SELECT pu.*, v.*, GROUP_CONCAT(CONCAT(pe.last_name, ' ', pe.first_name) ORDER BY author_position ASC SEPARATOR ', ') AS the_authors, t.title as tool, t.repository as repository FROM publication pu LEFT JOIN venue v ON pu.venue = v.vid LEFT JOIN publication_author pa ON pa.publication_id = pu.puid LEFT JOIN person pe ON pe.peid = pa.author_id LEFT JOIN publication_tool pt ON pt.publication_id = pu.puid LEFT JOIN tool t ON t.toid = pt.tool_id GROUP BY pu.puid, pt.publication_id ORDER BY ".$sort;
    return execute_simple_query($conn, $SQL);
}

function get_publications_by_type($conn, $type, $sort) {
    return "SELECT pu.*, v.*, GROUP_CONCAT(CONCAT(pe.last_name, ' ', pe.first_name) ORDER BY author_position ASC SEPARATOR ', ') AS the_authors, t.title as tool, t.repository as repository FROM publication pu LEFT JOIN venue v ON pu.venue = v.vid LEFT JOIN publication_author pa ON pa.publication_id = pu.puid LEFT JOIN person pe ON pe.peid = pa.author_id LEFT JOIN publication_tool pt ON pt.publication_id = pu.puid LEFT JOIN tool t ON t.toid = pt.tool_id WHERE category = '".$type."' GROUP BY pu.puid, pt.publication_id ORDER BY ".$sort;
}

function get_journal_publication($conn, $sort) {
    return execute_simple_query($conn, get_publications_by_type($conn, 'int_journal', $sort));
}

function get_int_conf_publication($conn, $sort) {
    return execute_simple_query($conn, get_publications_by_type($conn, 'int_conf', $sort));
}

function get_int_workshop_publication($conn, $sort) {
    return execute_simple_query($conn, get_publications_by_type($conn, 'int_workshop', $sort));
}

function get_int_demo_publication($conn, $sort) {
    return execute_simple_query($conn, get_publications_by_type($conn, 'int_demo', $sort));
}

function get_nat_conf_publication($conn, $sort) {
    return execute_simple_query($conn, get_publications_by_type($conn, 'nat_conf', $sort));
}

function get_manuscript_publication($conn, $sort) {
    return execute_simple_query($conn, get_publications_by_type($conn, 'manuscript', $sort));
}

function get_summary_publications($conn, $latex) {
    $counts = [
		"int_journal" => ["Q1" => 0, "Q2" => 0, "Q3" => 0, "Q4" => 0, "N/A" => 0], 
		"int_conf" => ["A*" => 0, "A" => 0, "B" => 0, "C" => 0, "D" => 0, "N/A" => 0], 
		"int_workshop" => ["A*" => 0, "A" => 0, "B" => 0, "C" => 0, "D" => 0, "N/A" => 0], 
		"demo" => ["A*" => 0, "A" => 0, "B" => 0, "C" => 0, "D" => 0, "N/A" => 0],
		"nat_conf" => ["A*" => 0, "A" => 0, "B" => 0, "C" => 0, "D" => 0, "N/A" => 0],
		"manuscript" => ["A*" => 0, "A" => 0, "B" => 0, "C" => 0, "D" => 0, "N/A" => 0]
	];

	$SQL = "SELECT p.category as category, v.rank, COUNT(p.puid) AS count FROM publication p LEFT JOIN venue v ON p.venue=v.vid GROUP BY p.category, v.rank";
	$summary = execute_simple_query($conn, $SQL);
	foreach($summary as $row) {
        if($latex) {
            $the_category = str_replace("_", "\\_", $row["category"]);
        } else {
            $the_category = $row["category"];
        }
		if (!array_key_exists($the_category, $counts)) {
			$counts[$the_category] = [];
			if(!array_key_exists($row["rank"], $counts[$the_category])) {
				$counts[$the_category][$row["rank"]] = 0;
			}
		}
		$counts[$the_category][$row["rank"]] = $row["count"];
	}
    return $counts;
}

function get_service_organization($conn) {
    global $TEMPLATE_SERVICE_SELECT;
    global $TEMPLATE_SERVICE_GROUP_SORT;
    $SQL = $TEMPLATE_SERVICE_SELECT." WHERE category = 'organizer' ".$TEMPLATE_SERVICE_GROUP_SORT;
    return execute_simple_query($conn, $SQL);
}

function get_service_chair($conn) {
    global $TEMPLATE_SERVICE_SELECT;
    global $TEMPLATE_SERVICE_GROUP_SORT;
    $SQL = $TEMPLATE_SERVICE_SELECT." WHERE category = 'chair' ".$TEMPLATE_SERVICE_GROUP_SORT;
    return execute_simple_query($conn, $SQL);
}

function get_service_pc($conn) {
    global $TEMPLATE_SERVICE_SELECT;
    global $TEMPLATE_SERVICE_GROUP_SORT;
    $SQL = $TEMPLATE_SERVICE_SELECT." WHERE category = 'pc' ".$TEMPLATE_SERVICE_GROUP_SORT;
    return execute_simple_query($conn, $SQL);
}

function get_service_journal_review($conn) {
    global $TEMPLATE_SERVICE_SELECT_WITHOUT_ROLE;
    global $TEMPLATE_SERVICE_GROUP_SORT;
    $SQL = $TEMPLATE_SERVICE_SELECT_WITHOUT_ROLE." WHERE role = 'journal reviewer' ".$TEMPLATE_SERVICE_GROUP_SORT;
    return execute_simple_query($conn, $SQL);
}

function get_service_conf_review($conn) {
    global $TEMPLATE_SERVICE_SELECT;
    global $TEMPLATE_SERVICE_GROUP_SORT;
    $SQL = $TEMPLATE_SERVICE_SELECT." WHERE category = 'reviewer' AND role <> 'journal reviewer' ".$TEMPLATE_SERVICE_GROUP_SORT;
    return execute_simple_query($conn, $SQL);
}

function get_wg($conn) {
    global $CURRENT_STATUS_SQL;
    $SQL = "SELECT *, ".$CURRENT_STATUS_SQL.", GROUP_CONCAT(wgd.text SEPARATOR ' ') AS content FROM working_group wg LEFT JOIN working_group_description wgd ON wg.wgid = wgd.wg_id GROUP BY wg.wgid ORDER BY status ASC, end_date ASC, start_date DESC;";
    return execute_simple_query($conn, $SQL);
}

function get_projects($conn, $type = "", $show_only) {
    // $type is "current", or "former", or "" to get all projects
    $CONDITION = "";
    if($type == "current") {
        $CONDITION = " (end_date = '2222-01-01' OR end_date >= CURDATE()) ";
    } else if($type == "former") {
        $CONDITION = " end_date < CURDATE() ";
    }
    $SQL = "SELECT * FROM project WHERE ".($show_only ? "`show` = 1 AND" : "").$CONDITION." ORDER BY end_date DESC, start_date DESC;";
    return execute_simple_query($conn, $SQL);
}

function get_tools($conn) {
    $SQL = "SELECT * FROM tool ORDER BY end_date DESC, start_date DESC;";
    return execute_simple_query($conn, $SQL);
}

function get_visits($conn) {
    $SQL = "SELECT * FROM visit v LEFT JOIN visit_description vd ON v.viid = vd.research_visit_id ORDER BY start_date DESC, start_date DESC, vd.vidid ASC;";
    return execute_simple_query($conn, $SQL);
}

function get_academic_positions($conn) {
    $SQL = "SELECT * FROM job j LEFT JOIN job_description jd ON j.jid = jd.job_id ORDER BY start_date DESC, jd.jdid ASC;";
    return execute_simple_query($conn, $SQL);
}

function get_education($conn) {
    $SQL = "SELECT * FROM education ORDER BY start_date DESC;";
    return execute_simple_query($conn, $SQL);
}

function get_items_for_research($conn, $type = "", $show_only) {
    // $type is "current", or "former", or "" to get all projects
    // $CONDITION = "";
    // if($type == "current") {
    //     $CONDITION = " (end_date = '2222-01-01' OR end_date >= CURDATE()) ";
    // } else if($type == "former") {
    //     $CONDITION = " end_date < CURDATE() ";
    // }
    // for research: project and internship data
    // the_id (project or internship id)
    // short_title
    // type (grant type for projects, or school for internships)
    // opening
    // deadline1
    // deadline2
    // start_date (grant start date / internship start date)
    // date de fin (grant end date / internship end date)
    // duration (in months)
    // pi (grant receiver)
    // student (the student on the project / internship) TODO: aggregate them if there are several students
    // involvement (involvement rate)
    // statut (writing, submitted, next phase, accepted, ongoing, finished, rejected)
    // notes
    $SQL = "SELECT pr.prid as the_id, 'project' as `type`, pr.short_title as short_title, pr.grant_type as `type`, pr.opening_date as opening, pr.deadline1 as deadline1, pr.deadline2 as deadline2, pr.start_date as `start_date`, pr.end_date as end_date, 0 as duration, CONCAT(p.first_name, ' ', p.last_name) as pi, null as student, pr.involvement_rate as involvement, null as status, pr.notes as notes FROM project pr LEFT JOIN person p ON pr.leader = p.peid WHERE pr.start_date >= '2025-09-01' UNION SELECT i.iid as the_id, 'internship' as `type`, i.topic as short_title, i.grant_type as `type`, null as opening, null as deadline1, null as deadline2, i.start_date as `start_date`, i.end_date as end_date, 0 as duration, CONCAT(p.first_name, ' ', p.last_name) as pi, CONCAT(p2.first_name, ' ', p2.last_name) as student, i.involvement_rate as involvement, null as status, i.notes as notes FROM internship i LEFT JOIN internship_supervisor isu ON i.iid = isu.internship_id AND supervisor_role = 'Advisor' LEFT JOIN person p ON isu.supervisor_id = p.peid LEFT JOIN person p2 ON i.person_id = p2.peid WHERE i.start_date >= '2025-09-01' ORDER BY end_date DESC, start_date DESC;";
    return execute_simple_query($conn, $SQL);
}

function get_tasks_for_research($conn, $type = "", $show_only) {
    // $type is "current", or "former", or "" to get all projects
    // $CONDITION = "";
    // if($type == "current") {
    //     $CONDITION = " (end_date = '2222-01-01' OR end_date >= CURDATE()) ";
    // } else if($type == "former") {
    //     $CONDITION = " end_date < CURDATE() ";
    // }
    // for research: project and internship data
    // the_id (project or internship id)
    // short_title
    // type (grant type for projects, or school for internships)
    // opening
    // deadline1
    // deadline2
    // start_date (grant start date / internship start date)
    // date de fin (grant end date / internship end date)
    // duration (in months)
    // pi (grant receiver)
    // student (the student on the project / internship) TODO: aggregate them if there are several students
    // involvement (involvement rate)
    // statut (writing, submitted, next phase, accepted, ongoing, finished, rejected)
    // notes
    $SQL = "SELECT pt.ptid as the_id, pt.prid as fk_id, pt.label as label, pt.deadline as deadline, 'project' as `type` FROM project_task pt LEFT JOIN project pr ON pr.prid = pt.prid UNION SELECT it.itid as the_id, it.iid as fk_id, it.label as label, it.deadline as deadline, 'internship' as `type` FROM internship_task it LEFT JOIN internship i ON it.iid = i.iid;";
    return execute_simple_query($conn, $SQL);
}

function insert_research_task($conn, $type, $label, $deadline) {
    if($type == "PROJECT") {
		$sql = "INSERT INTO project_task ($label, $deadline) VALUES (?, ?)";
	} else if($type == "INTERNSHIP") {
		$sql = "INSERT INTO internship_task ($label, $deadline) VALUES (?, ?)";
	} else {
		$sql = "";
	} 
	return execute_binded_query($conn, $sql, [$type, $label, $deadline], ["s", "s", "s"]);
}
?>