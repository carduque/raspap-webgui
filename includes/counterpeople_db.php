<?php

/**
* Counter People db
*
*/

// get contents of a file into a string
$filename = "/opt/Feerbox/feerbox-admin-web/pir.txt";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$query='SELECT count(*) FROM counterpeople where type="PIR"';
if($contents != ""){
	$time = strtotime($contents);
	$query='SELECT count(*) FROM counterpeople where type="PIR" and time>="'.$time.'"';
}

$db = new SQLite3('/opt/Feerbox/Feerbox/db/feerbox.db');

$results = $db->query($query);
while ($row = $results->fetchArray()) {
    echo $row;
}
 
?>