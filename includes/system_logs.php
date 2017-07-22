<?php


/**
* Log tab for Raspap
*
*/

define('RASPAP_CUSTOM_LOG_PATH', '/opt/FeerBoxClient/FeerBoxClient/logs/feerbox-client.log');

//Default mode is tail
$logMode = "tail";
$customLogFile = RASPAP_CUSTOM_LOG_PATH;
$laserLogFile = '/opt/FeerBoxClient/FeerBoxClient/logs/lasercounter.log';
$adminLogFile = '/var/log/lighttpd/error.log';

function readLog($logFile) {
  global $logMode, $customLogFile, $laserLogFile;
  $filepath = "";
  $addSudo = "sudo";

  if ($logFile === "syslog") {
    $filepath = "/var/log/syslog";
  } elseif ($logFile === "daemon") {
    $filepath = "/var/log/daemon.log";
  } elseif ($logFile === "custom") {
    $filepath = $customLogFile;
    $addSudo = "";
  } elseif ($logFile === "laser") {
  	$filepath = $laserLogFile;
  	$addSudo = "";
  }

  if ($logMode === "tail") {
    exec("$addSudo tail -25 $filepath", $result);
    $logtext = $result;
  } else {
    if ($logFile === "custom") {
      //cat mode by default
      exec("$addSudo cat $filepath", $result);
      $logtext = $result;
    } else {
      //cat of big system log file crashes
      exec("$addSudo tail -2000 $filepath", $result);
      $logtext = $result;
    }
  }
  if (!empty($logtext)) {
    echo implode("\n", $logtext);
  } else {
    echo "File not found or access unauthorized";
  }
}

function DisplayLogs(){
	global $logMode, $customLogFile, $laserLogFile;

  if( isset($_POST['CustomFilePath']) ) {
    if (CSRFValidate()) {
      $customLogFile = $_POST['CustomFilePath'];
    }
  } else {
    error_log('CSRF violation');
  }
  if( isset($_POST['ShowTail']) ) {
    if (CSRFValidate()) {
      $logMode = "tail";
    } else {
      error_log('CSRF violation');
    }
  } elseif( isset($_POST['ShowCat']) ) {
    if (CSRFValidate()) {
      $logMode = "cat";
    } else {
      error_log('CSRF violation');
    }
  }
  ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-file-text fa-fw"></i> System logs</div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <form role="form" action="?page=system_logs" method="POST">
            <?php CSRFToken() ?>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
              <li class="active"><a href="#custom" data-toggle="tab">Custom</a></li>
              <li><a href="#laser" data-toggle="tab">LaserCounterPeople</a></li>
              <li><a href="#syslog" data-toggle="tab">Syslog</a></li>
              <li><a href="#daemon" data-toggle="tab">Daemon</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane in active" id="custom">
                <h4>Custom logfile</h4>
                <div class="row">
                  <div class="form-group col-md-4">
                    <label for="filepath">Log path</label>
                    <input type="text" class="form-control" name="CustomFilePath" value="<?php echo $customLogFile; ?>" />
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12">
                    <div class="form-group">
                      <label for="comment">Contents:</label>
                      <textarea class="form-control" rows="20" id="comment"><?php readLog("custom") ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
               <div class="tab-pane in active" id="laser">
                <h4>LaserCounterPeople logfile</h4>
                <div class="row">
                  <div class="form-group col-md-4">
                    <label for="filepath">Log path</label>
                    <input type="text" class="form-control" name="LaserFilePath" value="<?php echo $laserLogFile; ?>" />
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12">
                    <div class="form-group">
                      <label for="comment">Contents:</label>
                      <textarea class="form-control" rows="20" id="comment"><?php readLog("laser") ?></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade" id="syslog">

                <h4>Syslog file</h4>
                <div class="row">
                  <div class="form-group col-md-12">
                    <div class="form-group">
                      <label for="comment">Contents:</label>
                      <textarea class="form-control" rows="20" id="comment"><?php readLog("syslog") ?></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade" id="daemon">
                <h4>Daemon log file</h4>
                <div class="row">
                  <div class="form-group col-md-12">
                    <div class="form-group">
                      <label for="comment">Contents:</label>
                      <textarea class="form-control" rows="20" id="comment"><?php readLog("daemon") ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- ./ Panel body -->

            <input type="submit" class="btn btn-outline btn-primary" name="ShowTail" value="Show tail" />
            <input type="submit" class="btn btn-outline btn-primary" name="ShowCat" value="Show cat" />
          </form>
        </div><!-- /.panel-primary -->
        <br />
      <div class="panel-footer"> Information read from system logs</div>
    </div><!-- /.col-lg-12 -->
  </div><!-- /.row -->
<?php 
}

?>
