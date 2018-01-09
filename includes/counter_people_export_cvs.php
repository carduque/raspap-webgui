<?php

/**
* Counter People export
*
*/
$week = "";
if (isset($_GET['week'])) {
	$week= $_GET['week'];
}else{
	error_log("No week set!");
}
$db = new SQLite3('/opt/FeerBoxClient/FeerBoxClient/db/feerboxclient.db');

$month_ini = new DateTime("first day of -3 months");
$month_ini ->setTime(0,0,0);
$query='SELECT min(time) as min_time FROM counterpeople where time>="'.date_format($month_ini,'Y-m-d H:i:s').'"';
$results = $db->query($query);
while ($row = $results->fetchArray()) {
	$min_time = $row['min_time'];
}
$int_week = (int) $week;
error_log($min_time);
$total_days = $int_week * 7;
$min_time = strtotime("+".$total_days." days", strtotime($min_time));
$max_time = strtotime("+7 days", $min_time);
error_log($min_time);
error_log($max_time);
$query='SELECT id, time, reference, distance, upload FROM counterpeople where time>="'.date('Y-m-d H:i:s', $min_time).'" and time<="'.date('Y-m-d H:i:s', $max_time).'"';
$results = $db->query($query);
$i = 0;
$reference = "";
$counterpeople = array();
while ($row = $results->fetchArray()) {
	$counterpeople[$i]['id'] = $row['id'];
	$counterpeople[$i]['time'] = $row['time'];
	$counterpeople[$i]['reference'] = $row['reference'];
	$reference = $row['reference'];
	$counterpeople[$i]['distance'] = $row['distance'];
	$counterpeople[$i]['upload'] = $row['upload'];
	$i++;
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="counterpeopleexport'.$week.'-'.$reference.'.csv"');
header('Pragma: no-cache');
header('Expires: 0');
$fp = fopen('php://output', 'w');
for ($i=0;$i<count($counterpeople);$i++)
{
	fputcsv($fp, array_values($counterpeople[$i]));
}

die;
?>