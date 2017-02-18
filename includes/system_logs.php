<?php


/**
*
*
*/

//Default mode is tail
$logMode = "tail";

function readLog($logFile, $logMode) {

  //By default, it's syslog
  $filepath = "/var/log/syslog";
  $addSudo = "sudo";

  if ($logFile === "syslog") {
    $filepath = "/var/log/syslog";
  } elseif ($logFile === "daemon") {
    $filepath = "/var/log/daemon.log";
  } elseif ($logFile === "other") {
    $filepath = "/home/pi/test.log";
    $addSudo = "";
  }

  if ($logMode === "tail") {
    exec("$addSudo tail -25 $filepath", $result);
    $syslog = $result;
  } else {
    if ($logFile === "other") {
      //cat mode by default
      exec("$addSudo cat $filepath", $result);
      $syslog = $result;
    } else {
      //cat of big system log file crashes
      exec("$addSudo tail -2000 $filepath", $result);
      $syslog = $result;
    }
  }
  echo implode("\n", $syslog);
}

function DisplayLogs(){
  global $logMode;

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
              <li class="active"><a href="#syslog" data-toggle="tab">Syslog</a></li>
              <li><a href="#daemon" data-toggle="tab">Daemon.log</a></li>
              <li><a href="#other" data-toggle="tab">Other</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane fade in active" id="syslog">

                <h4>Syslog file</h4>
                <div class="row">
                  <div class="form-group col-md-12">
                    <div class="form-group">
                      <label for="comment">Contents:</label>
                      <textarea class="form-control" rows="20" id="comment"><?php readLog("syslog", $logMode) ?></textarea>
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
                      <textarea class="form-control" rows="20" id="comment"><?php readLog("daemon", $logMode) ?></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade" id="other">
                <h4>Custom logfile</h4>
                <div class="row">
                  <div class="form-group col-md-12">
                    <div class="form-group">
                      <label for="comment">Contents:</label>
                      <textarea class="form-control" rows="20" id="comment"><?php readLog("other", $logMode) ?></textarea>
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
