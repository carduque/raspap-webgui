<?php

/**
* Counter People viewer
*
*/
function DisplayCounterPeopleViewer(){
  if( isset($_POST['counter_people']) ) {
    if (CSRFValidate()) {
		//error_log($_POST['time']);
		$filename = "/opt/FeerBoxClient/feerbox-admin-web/pir.txt";
		$handle = fopen($filename, "w");
		fwrite($handle, date('Y-m-d H:i:s'));
		fclose($handle);
		if( isset($_POST['total']) ) {
			//error_log('aqui');
			$filename = "/opt/FeerBoxClient/feerbox-admin-web/pir.txt";
			$handle = fopen($filename, "w");
			$fecha = new DateTime();
			$fecha->setDate(2001, 1, 1);
			$fecha->setTime(0, 0);
			fwrite($handle, date_format($fecha,'Y-m-d H:i:s'));
			fclose($handle);
		}
    }
	else {
    error_log('CSRF violation');
  	}
  }
 
  ?>
   <script type="text/javascript">
        $(document).ready(function(){
            setInterval(function(){
                $.get("includes/counterpeople_db1.php<?php if(isset($_POST) && isset($_POST['counter_people'])){echo "?type=".$_POST['counter_type'];}?>", function(data){
                    $("#pir1").html(data);
                });
            }, 1000);
        });
        $(document).ready(function(){
            setInterval(function(){
                $.get("includes/counterpeople_db2.php<?php if(isset($_POST) && isset($_POST['counter_people'])){echo "?type=".$_POST['counter_type'];}?>", function(data){
                    $("#pir2").html(data);
                });
            }, 1000);
        });
    </script>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-users fa-fw"></i> Counter People viewer</div>
        <!-- /.panel-heading -->
        <div class="panel-body">
        <?=date('Y-m-d H:i:s')?><br/>
          CounterPeople Enter: <div id="pir1" style="font-size:xx-large;">0</div>
          CounterPeople Exit: <div id="pir2" style="font-size:xx-large;">0</div>
          <br/><br/><br/>
          <form role="form" action="?page=counter_people" method="POST">
            <?php CSRFToken() ?>
            <input type="hidden" name="counter_people" ?>
	        <!-- <input type="text" name="time" value="<?=date('Y-m-d H:i:s')?>">-->
	        <select name="counter_type">
	        	<option value="PIR" <?php if(isset($_POST) && isset($_POST['counter_people'])&& $_POST['counter_type']=="PIR"){echo "selected";}?>>PIR</option>
	        	<option value="DISTANCE_SENSOR" <?php if(isset($_POST) && isset($_POST['counter_people']) && $_POST['counter_type']=="DISTANCE_SENSOR"){echo "selected";}?>>DISTANCE_SENSOR</option>
	        	<option value="LASER" <?php if(isset($_POST) && isset($_POST['counter_people']) && $_POST['counter_type']=="LASER"){echo "selected";}?>>LASER</option>
	        </select>
	         <div class="btn-group btn-block">
                    <input type="submit" class="col-md-6 btn btn-warning" value="Update" id="update" name="update" />
             </div>
             <div class="btn-group btn-block">
                    <input type="submit" class="col-md-6 btn btn-warning" value="Total" id="total" name="total" />
             </div>
           </form>
        </div><!-- /.panel-primary -->
        <br />
      <div class="panel-footer"></div>
    </div><!-- /.col-lg-12 -->
  </div><!-- /.row -->
<?php 
}

?>
