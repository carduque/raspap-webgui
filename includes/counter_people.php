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
    }
	else {
    error_log('CSRF violation');
  	}
  }
 
  ?>
   <script type="text/javascript">
        $(document).ready(function(){
            setInterval(function(){
                $.get("includes/counterpeople_db.php<?php if(isset($_POST)){echo "?type=".$_POST['counter_type'];}?>", function(data){
                    $("#pir").html(data);
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
          CounterPeople PIR: <div id="pir" style="font-size:xx-large;">0</div>
          <br/><br/><br/>
          <form role="form" action="?page=counter_people" method="POST">
            <?php CSRFToken() ?>
            <input type="hidden" name="counter_people" ?>
	        <!-- <input type="text" name="time" value="<?=date('Y-m-d H:i:s')?>">-->
	        <select name="counter_type">
	        	<option value="PIR" <?php if(isset($_POST) && $_POST['counter_type']=="PIR"){echo "selected";}?>>PIR</option>
	        	<option value="DISTANCE_SENSOR" <?php if(isset($_POST) && $_POST['counter_type']=="DISTANCE_SENSOR"){echo "selected";}?>>DISTANCE_SENSOR</option>
	        	<option value="LASER" <?php if(isset($_POST) && $_POST['counter_type']=="LASER"){echo "selected";}?>>LASER</option>
	        </select>
	         <div class="btn-group btn-block">
                    <input type="submit" class="col-md-6 btn btn-warning" value="Update" id="update" name="Reset to zero" />
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
