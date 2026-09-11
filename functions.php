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
    $SQL = "SELECT *, ".$CURRENT_STATUS_SQL." FROM teaching WHERE category = 'course' ORDER BY status ASC, end_date DESC, start_date DESC;";
    return execute_simple_query($conn, $SQL);
}

function get_guest_courses($conn) {
    global $CURRENT_STATUS_SQL;
    $SQL = "SELECT *, ".$CURRENT_STATUS_SQL." FROM teaching WHERE category = 'guest' ORDER BY status ASC, end_date ASC, start_date DESC;";
    return execute_simple_query($conn, $SQL);
}

function get_teaching_service($conn) {
    $SQL = "SELECT * FROM teaching WHERE category = 'service' ORDER BY start_date DESC;";
    return execute_simple_query($conn, $SQL);
}

function get_reasearch_training($conn) {
    $SQL = "SELECT *, CONCAT('<ul><li>', GROUP_CONCAT(td.text SEPARATOR '</li><li>'), '</li></ul>') AS content FROM training t LEFT JOIN training_description td ON t.trid=td.training_id WHERE t.category = 'research' GROUP BY t.trid;";
    return execute_simple_query($conn, $SQL);
}

function get_teaching_training($conn) {
    $SQL = "SELECT *, CONCAT('<ul><li>', GROUP_CONCAT(td.text SEPARATOR '</li><li>'), '</li></ul>') AS content FROM training t LEFT JOIN training_description td ON t.trid=td.training_id WHERE t.category = 'teaching' GROUP BY t.trid;";
    return execute_simple_query($conn, $SQL);
}

function get_awards($conn) {
    $SQL = "SELECT * FROM award;";
    return execute_simple_query($conn, $SQL);
}

function get_invited_talks($conn) {
    $SQL = "SELECT * FROM dissemination WHERE category = 'Seminar' ORDER BY date DESC, did ASC;";
    return execute_simple_query($conn, $SQL);
}

function get_panels($conn) {
    $SQL = "SELECT * FROM dissemination WHERE category = 'Panel' ORDER BY date DESC, did ASC;";
    return execute_simple_query($conn, $SQL);
}

function get_vulgarization($conn) {
    $SQL = "SELECT * FROM dissemination WHERE category = 'Vulgarization' ORDER BY date DESC, did ASC;";
	return execute_simple_query($conn, $SQL);
}

function get_female_talks($conn) {
    $SQL = "SELECT * FROM dissemination WHERE category = 'Female empowerment' ORDER BY date DESC, did ASC;";
	return execute_simple_query($conn, $SQL);
}

function get_institutional_responsabilities($conn) {
    global $CURRENT_STATUS_SQL;
    $SQL = "SELECT *, ".$CURRENT_STATUS_SQL." FROM responsability ORDER BY status ASC, end_date ASC, start_date DESC;";
	return execute_simple_query($conn, $SQL);
}

function get_engineer_students($conn) {
    global $GROUP_CONCAT_ADVISORS;
    global $JOINS_FOR_GROUP_CONCAT;
    $SQL = "SELECT s.*, p.*, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status, ".$GROUP_CONCAT_ADVISORS." FROM internship s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level LIKE '%Engineer%' GROUP BY s.iid ORDER BY s.year DESC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');";
	return execute_simple_query($conn, $SQL);
}

function get_master_students($conn) {
    global $GROUP_CONCAT_ADVISORS;
    global $JOINS_FOR_GROUP_CONCAT;
    $SQL = "SELECT s.*, p.*, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status, ".$GROUP_CONCAT_ADVISORS." FROM internship s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level LIKE '%Master%' GROUP BY s.iid ORDER BY s.year DESC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');";
	return execute_simple_query($conn, $SQL);
}

function get_bachelor_students($conn) {
    global $GROUP_CONCAT_ADVISORS;
    global $JOINS_FOR_GROUP_CONCAT;
    $SQL = "SELECT s.*, p.*, CASE WHEN s.year >= YEAR(CURDATE()) THEN 'Current' ELSE 'Finished' END AS status, ".$GROUP_CONCAT_ADVISORS." FROM internship s LEFT JOIN person p ON s.person_id = p.peid ".$JOINS_FOR_GROUP_CONCAT." WHERE s.level  LIKE '%Bachelor%' GROUP BY s.iid ORDER BY s.year DESC, FIELD (semester, 'winter', 'spring', 'summer', 'fall');";
	return execute_simple_query($conn, $SQL);
}

function get_all_publications($conn, $sort) {
    $SQL = "SELECT pu.*, v.*, GROUP_CONCAT(CONCAT(pe.last_name, ' ', pe.first_name) ORDER BY author_position ASC SEPARATOR ', ') AS the_authors, t.title as tool, t.repository as repository FROM publication pu LEFT JOIN venue v ON pu.venue = v.vid LEFT JOIN publication_author pa ON pa.publication_id = pu.puid LEFT JOIN person pe ON pe.peid = pa.author_id LEFT JOIN publication_tool pt ON pt.publication_id = pu.puid LEFT JOIN tool t ON t.toid = pt.tool_id GROUP BY pu.puid, pt.publication_id ORDER BY ".$sort;
    return execute_simple_query($conn, $SQL);
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

?>