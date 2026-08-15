<?php 

$CURRENT_STATUS_SQL = "CASE WHEN end_date = '1900-01-01' OR end_date > CURDATE() THEN 'Current' ELSE 'Finished' END AS status";

function get_total_count_for_category(String $category) {
	$sum = 0;
	// $GLOBALS['counts'] because the variable counts is decalred outside the function, thus is not known inside the function
	foreach($GLOBALS['counts'][$category] as $key => $value) {
		$sum += $value;
	}
	return $sum;
}

function echo_count(String $category, String $rank, String $rank2 = null, String $rank3 = null) {
	// $GLOBALS['counts'] because the variable counts is decalred outside the function, thus is not known inside the function
	$sum = $GLOBALS['counts'][$category][$rank];
	if($rank2 != null) {
		// we want to get the counts for two ranks, typically A* and A
		$sum = $sum + $GLOBALS['counts'][$category][$rank2];
	}
	if($rank3 != null) {
		// we want to get the counts for two ranks, typically Q1, A* and A
		$sum = $sum + $GLOBALS['counts'][$category][$rank3];
	}

	if($sum <= 0) {
		return "";
	} else {
		return $sum;
	}
}

?>