<?php 

// $sql = "THE SQL QUERY WITH ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("si", $v1, $v2);
// $stmt->execute();

// // for select
// $projects = $stmt->bind_result();
// while($project = $projects->fetch_assoc()) {
// 	// TODO
// }

// // for updates, create, delete
// print_r("Affected rows: ".$stmt->affected_rows . "\n");
// print_r("Matched rows: ".$conn->info . "\n");



/// ------------------

function compute_date_difference($start_date, $end_date) {
	// compute the number of days between the two dates
	return date_diff(new DateTime($start_date), new DateTime($end_date))->days;
}

$day_difference = compute_date_difference("2021-01-01", "2024-03-31");
print_r($day_difference);
print_r(gettype($day_difference));

if($day_difference < 364) {
	// < 1 year
	print_r("< 1 year");
} else if ($day_difference == 365 || $day_difference == 365) {
	print_r("1 year");
} else {
	$diff_years = round($day_difference / 365.0, 1);
	if($diff_years >= 2) {
		// 2+ years
		print_r($diff_years." years");
	} else {
		// 1.1 to 1.9 year
		print_r($diff_years." year");
	}
}



/// ------------------

// $start_date = "2026-02-04";
// $end_date = "2026-12-31";
// $today = date_create(date('m/d/Y h:i:s a', time()));

// $date1=date_create($start_date);
// var_dump($date1);

// $date2=date_create($end_date);
// var_dump($date2);

// $total=date_diff($date1,$date2);
// var_dump($total);
// var_dump($total->days);

// $diff=date_diff($date1,$today);
// var_dump($diff);
// var_dump($diff->days);

// $percentage=$diff->days/$total->days * 100;
// var_dump($percentage);
// var_dump(round($percentage));

?>