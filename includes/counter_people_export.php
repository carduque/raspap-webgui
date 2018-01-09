<?php

/**
* Counter People viewer
*
*/
function DisplayCounterPeopleExport(){
	$db = new SQLite3('/opt/FeerBoxClient/FeerBoxClient/db/feerboxclient.db');
	//Select min value from db
	$month_ini = new DateTime("first day of -3 months");
	$month_ini ->setTime(0,0,0);
	$query='SELECT min(time) as min_time FROM counterpeople where time>="'.date_format($month_ini,'Y-m-d H:i:s').'"';
	$results = $db->query($query);
	while ($row = $results->fetchArray()) {
		$min_time = $row['min_time'];
	}
	if($min_time == ""){
		$now = new DateTime();
		$min_time = date_format($now,'Y-m-d H:i:s');
	}                                                   
	//Select max value from db
	/*$query='SELECT max(time) as max_time FROM counterpeople where type="PIR"';
	$results = $db->query($query);
	while ($row = $results->fetchArray()) {
		$max_time = $row['max_time'];
	}*/
	
	//How many weeks?
	$datefrom = strtotime($min_time, 0);
	//$dateto = strtotime($max_time, 0);
	$dateto = new DateTime();
	$difference = $dateto->getTimestamp() - $datefrom; // Difference in seconds
	$weeks = ceil($difference / 604800);
	
	//create link and on click export to csv
	
	
 
  ?>
  
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-users fa-fw"></i> Counter People export - files from first day of last month</div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <br/><br/><br/>
          <?php
          for($i=0;$i<$weeks;$i++){
          		echo "<a href='includes/counter_people_export_cvs.php?week=".$i."'>Export week ".$i."</a><br/>";
          }
          ?>
        </div><!-- /.panel-primary -->
        <br />
      <div class="panel-footer"></div>
    </div><!-- /.col-lg-12 -->
  </div><!-- /.row -->
<?php 
}

?>
