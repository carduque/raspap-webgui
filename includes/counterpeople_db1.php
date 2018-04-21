<?php

/**
* Counter People db
*
*/
$type = "";
if (isset($_GET['type'])) {
	$type = $_GET['type'];
}else{
	$type = "PIR";
}

// get contents of a file into a string
$filename = "/opt/FeerBoxClient/feerbox-admin-web/pir.txt";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$query='SELECT count(*) FROM counterpeople where type="'.$type.'"';
if($contents != ""){
	//$time = strtotime($contents);
	$query='SELECT count(*) as total FROM counterpeople where type="'.$type.'" and distance=1 and time>="'.$contents.'"';
}

$db = new SQLite3('/opt/FeerBoxClient/FeerBoxClient/db/feerboxclient.db');

$results = $db->query($query);
while ($row = $results->fetchArray()) {
    echo $row['total'];
}
 
?>