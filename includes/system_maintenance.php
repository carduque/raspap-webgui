<?php


/**
*
*
*/
function DisplaySystemMaintenance(){

  

  ?>
  <div class="row">
  <div class="col-lg-12">
  <div class="panel panel-primary">
  <div class="panel-heading"><i class="fa fa-cube fa-fw"></i> System Maintenance</div>
  <div class="panel-body">

    <?php
    if (isset($_POST['force_hwdclock'])) {
    	$path = exec('pwd');
    	$command = escapeshellcmd("python " . $path . "/scripts/forceHardwareClock.py");
    	$result = shell_exec($command);
    	error_log($result);
    }
    ?>

    <div class="row">
    <div class="col-md-6">
    <div class="panel panel-default">
    <div class="panel-body">
      <h4>System Maintenance - Caution!</h4>
      
    </div><!-- /.panel-body -->
    </div><!-- /.panel-default -->
    </div><!-- /.col-md-6 -->
    </div><!-- /.row -->

    <form action="?page=system_info" method="POST">
      <input type="submit" class="btn btn-warning" name="force_hwdclock"   value="Force update hardware clock" />
    </form>

  </div><!-- /.panel-body -->
  </div><!-- /.panel-primary -->
  </div><!-- /.col-lg-12 -->
  </div><!-- /.row -->
  <?php
}
?>
