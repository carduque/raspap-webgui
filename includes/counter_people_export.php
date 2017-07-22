<?php

/**
* Counter People viewer
*
*/
function DisplayCounterPeopleExport(){
	$db = new SQLite3('/opt/FeerBoxClient/FeerBoxClient/db/feerboxclient.db');
	//Select min value from db
	$query='SELECT min(time) as min_time FROM counterpeople where type="PIR"';
	$results = $db->query($query);
	while ($row = $results->fetchArray()) {
		$min_time = $row['min_time'];
	}
	
	//Select max value from db
	$query='SELECT max(time) as max_time FROM counterpeople where type="PIR"';
	$results = $db->query($query);
	while ($row = $results->fetchArray()) {
		$max_time = $row['max_time'];
	}
	
	//How many weeks?
	$datefrom = strtotime($min_time, 0);
	$dateto = strtotime($max_time, 0);
	$difference = $dateto - $datefrom; // Difference in seconds
	$weeks = floor($difference / 604800);
	
	//create link and on click export to csv
	
	
 
  ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-users fa-fw"></i> Counter People export</div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <br/><br/><br/>
          <?php
          for($i=0;$i<$weeks;$i++){
          		echo "<a href='#'>Export week ".$i."</a><br/>";
          }
          ?>
        </div><!-- /.panel-primary -->
        <br />
      <div class="panel-footer"></div>
    </div><!-- /.col-lg-12 -->
  </div><!-- /.row -->
<?php 
}

function getOneWeek(){
	//select from min to min + 1 week
	$max_time = strtotime("+7 day", $min_time);
	$query='SELECT id, time, reference, upload FROM counterpeople where type="PIR" and time<='.$min_date.' and time>='.$max_date;
	$results = $db->query($query);
	$i = 0;
	while ($row = $results->fetchArray()) {
		$counterpeople[$i]['id'] = $row['id'];
		$counterpeople[$i]['time'] = $row['time'];
		$counterpeople[$i]['reference'] = $row['reference'];
		$counterpeople[$i]['upload'] = $row['upload'];
		$i++;
	}
}

?>
