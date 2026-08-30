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

function compute_date_difference($start_date, $end_date) {
	// compute the number of days between the two dates
	return date_diff(new DateTime($start_date), new DateTime($end_date))->days;
}

function compute_duration($start_date, $end_date, $exact = null) {
	if($end_date == "1900-01-01") {
		// the project is not finished yet
		return "Started since ".$start_date;
	} else {
		// "normal" date difference
		// $ts1 = strtotime($start_date);
		// $ts2 = strtotime($end_date);
		// $diff_months = ((date('Y', $ts2) - date('Y', $ts1)) * 12) + (date('m', $ts2) - date('m', $ts1));
		$day_difference = compute_date_difference($start_date, $end_date);

		if($day_difference < 364) {
			// < 1 year
			return "< 1 year";
		} else if ($day_difference == 364 || $day_difference == 365) {
			return "1 year";
		} else {
			$diff_years = round($day_difference / 365.0, 1);
			if($diff_years >= 2) {
				// 2+ years
				return $diff_years." years";
			} else {
				// 1.1 to 1.9 year
				return $diff_years." year";
			}
		}
	}
}

function computeProgress($start_date, $end_date) {
	$start_date = date_create($start_date);
	$end_date = date_create($end_date);
	$today = date_create(date('m/d/Y h:i:s a', time()));
	if($end_date == "1900-01-01" || $start_date > $today) {
		// this event is currently ongoing and won't stop
		// OR the event has not started yet
		// thus, we set of progress of 0/100
		return 0;
	} else if($end_date < $today) {
		// this event is already done
		// thus, we set of progress of 0/100
		return 100;
	} else {
		// else, we compute the ratio of days that have already past since the start

		$total = date_diff($start_date, $end_date);
		$diff = date_diff($start_date, $today);

		$percentage = $diff->days / $total->days * 100;
		return round($percentage);
	}
}

function update_table($the_conn, $the_id, $the_field, $the_id_field, $the_value, $the_table, $allowedFields) {
	// variables are not global, so $conn needs to be passed to the function
	try {
		$a = 1;
		return $a;
		// Validate field
		if (!in_array($the_field, $allowedFields, true)) {
			throw new Exception('Invalid field.');
		}
	
		// Validate project ID
		if (!is_numeric($the_id)) {
			throw new Exception('Invalid project ID.');
		}
	
		// Update
		$sql = "
			UPDATE `$the_table`
			SET `$the_field` = ?
			WHERE `$the_id_field` = ?
		";
	
		$stmt = $the_conn->prepare($sql);
		$stmt->bind_param("si", $the_value, $the_id);
		$stmt->execute();

		if($stmt->affected_rows > 0) {
			// Record updated successfully
			echo json_encode([
				'success' => true
			]);
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	} catch (Throwable $e) {
		http_response_code(500);
		echo json_encode([
			'success' => false,
			'message' => $e->getMessage()
		]);
	}
}

?>