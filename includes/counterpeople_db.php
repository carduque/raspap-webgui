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

$time = strtotime($contents);

$db = new SQLite3('/opt/Feerbox/Feerbox/db/feerbox.db');

$results = $db->query('SELECT count(*) FROM counterpeople where type="PIR" and time>="'.$time.'"');
while ($row = $results->fetchArray()) {
    echo $row;
}
 
?>