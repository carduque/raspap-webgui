<?php

/**
* DataBase viewer
*
*/
function DisplayDataBaseViewer(){
  $results = null;
  if( isset($_POST['database']) ) {
    if (CSRFValidate()) {
    	//$_POST['table']
    	$query = "";
  		if($_POST['table']=="answers"){
    		$query='SELECT id, button, time, reference, upload FROM answers order by id desc limit 100';
  		}
  		if($_POST['table']=="macs"){
  			$query='SELECT id, mac, time, reference, upload FROM macs order by id desc limit 100';
  		}
  		if($_POST['table']=="counterPeople"){
  			$query='SELECT id, type, time, reference, upload FROM CounterPeople order by id desc limit 100';
  		}
  		if($_POST['table']=="status"){
  			$query='SELECT id, internet, time, reference, upload FROM Status order by id desc limit 100';
  		}
		$db = new SQLite3('/opt/FeerBoxClient/FeerBoxClient/db/feerboxclient.db');
		$results = $db->query($query);
    	//$db = pg_connect("host=localhost port=5432 dbname=feerbox-dev user=postgres password=admin");
    	//$results = pg_query($query);
    }
	else {
    error_log('CSRF violation');
  	}
  }
 
  ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-database fa-fw"></i> DataBase viewer</div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <form role="form" action="?page=database" method="POST">
            <?php CSRFToken() ?>
            <input type="hidden" name="database" ?>
	        <select name="table">
	        	<option value="answers" <?php if($_POST['table']=="answers"){echo "selected";}?>>Answers</option>
	        	<option value="macs" <?php if($_POST['table']=="macs"){echo "selected";}?>>MACs</option>
	        	<option value="counterPeople" <?php if($_POST['table']=="counterPeople"){echo "selected";}?>>Counter People</option>
	        	<option value="status" <?php if($_POST['table']=="status"){echo "selected";}?>>Status</option>
	        </select>
	         <div class="btn-group btn-block">
                    <input type="submit" class="col-md-6 btn btn-info" value="view" id="view" name="View last inserts" />
             </div>
             <div id="viewtable" style="overflow-x:auto;">
             <?php
             	if($results!=null){
             		echo "<table border=1>";
             		echo "<tr>";
             		addTableHeader($_POST['table']);
             		echo "</tr>";
             		while ($row = $results->fetchArray()) {
			    		echo "<tr>";
			    		addColumns($_POST['table'], $row);
			    		echo "</tr>";
             		}
             		echo "</table>";
             	}
             	?>
             </div>  
           </form>
        </div><!-- /.panel-primary -->
        <br />
      <div class="panel-footer"></div>
    </div><!-- /.col-lg-12 -->
  </div><!-- /.row -->
<?php 
}
function addTableHeader($table){
	if($table=="answers"){
		echo "<th>id</th><th>button</th><th>time</th><th>reference</th><th>upload</th>";
	}
	if($table=="macs"){
		echo "<th>id</th><th>mac</th><th>time</th><th>reference</th><th>upload</th>";
	}
	if($table=="counterPeople"){
		echo "<th>id</th><th>type</th><th>time</th><th>reference</th><th>upload</th>";
	}
	if($table=="status"){
		echo "<th>id</th><th>internet</th><th>time</th><th>reference</th><th>upload</th>";
	}
}
function addColumns($table, $row){
	if($table=="answers"){
		echo "<td>".$row['id']."</td><td>".$row['button']."</td><td>".$row['time']."</td><td>".$row['reference']."</td><td>".$row['upload']."</td>";
	}
	if($table=="macs"){
		echo "<td>".$row['id']."</td><td>".$row['mac']."</td><td>".$row['time']."</td><td>".$row['reference']."</td><td>".$row['upload']."</td>";
	}
	if($table=="counterPeople"){
		echo "<td>".$row['id']."</td><td>".$row['type']."</td><td>".$row['time']."</td><td>".$row['reference']."</td><td>".$row['upload']."</td>";
	}
	if($table=="status"){
		echo "<td>".$row['id']."</td><td>".$row['internet']."</td><td>".$row['time']."</td><td>".$row['reference']."</td><td>".$row['upload']."</td>";
	}
}
?>
