<?php

function parse_properties($txtProperties) {
	$result = array();
	$lines = explode("\n", trim(file_get_contents($txtProperties)));
	$key = "";
	$isWaitingOtherLine = false;
	foreach ($lines as $i => $line) {
		if (empty($line) || (!$isWaitingOtherLine && strpos($line, "#") === 0))
			continue;
			
			if (!$isWaitingOtherLine) {
				$key = substr($line, 0, strpos($line, '='));
				$value = substr($line, strpos($line, '=')+1, strlen($line));
			}
			else {
				$value .= $line;
			}
			/* Check if ends with single '\' */
			if (strrpos($value, "\\") === strlen($value)-strlen("\\")) {
				$value = substr($value,0,strlen($value)-1)."\n";
				$isWaitingOtherLine = true;
			}
			else {
				$isWaitingOtherLine = false;
			}
			
			$result[$key] = $value;
			unset($lines[$i]);
	}
	
	return $result;
}
$properties_file = parse_properties('/opt/FeerBoxClient/FeerBoxClient/target/classes/config.properties');
$fh = fopen('/opt/FeerBoxClient/FeerBoxClient/config/version.txt','r');
while ($line = fgets($fh)) {
	$feerbox_version = $line;
}
fclose($fh);

$config = array(
  'admin_user' => 'admin',
  'admin_pass' => '$2y$10$YKIyWAmnQLtiJAy6QgHQ.eCpY4m.HCEbiHaTgN6.acNC6bDElzt.i',
  'client_reference' => $properties_file['reference'],
  'version'=>'2.0.4',
  'feerbox_version'=>$feerbox_version
);

if(file_exists(RASPI_CONFIG.'/raspap.auth')) {
    if ( $auth_details = fopen(RASPI_CONFIG.'/raspap.auth', 'r') ) {
      $config['admin_user'] = trim(fgets($auth_details));
      $config['admin_pass'] = trim(fgets($auth_details));
      fclose($auth_details);
    }
}

?>
