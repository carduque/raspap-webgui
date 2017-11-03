<?php
//include_once( 'java-properties.php' );

/**
* Properties configuration
*
*/

function writeValue($key, $value)
{                                                               
    $filename= '/opt/FeerBoxClient/FeerBoxClient/target/classes/config.properties';
    $ini_array = parse_ini_file($filename, false, INI_SCANNER_RAW);
    $values =  $ini_array[$key];
    
    $datareading = fopen($filename, 'r');
    $content = fread($datareading,filesize($filename));
    fclose($datareading);
    $content = str_replace($key."=".$values, $key."=".$value, $content);
    $content = str_replace($key."= ".$values, $key."=".$value, $content);
    $content = str_replace($key." =".$values, $key."=".$value, $content);
    $content = str_replace($key." = ".$values, $key."=".$value, $content);
    $fileWrite = fopen($filename, 'w');
    fwrite($fileWrite,$content);
    fclose($fileWrite);                       
}

function DisplayPropertiesConf(){
  if( isset($_POST['properties_conf']) ) {
    if (CSRFValidate()) {
     	foreach(array_keys($_POST) as $post) {
     		if (preg_match('/update(\w+)/', $post, $post_match)) {
     			$property = $_POST[$post_match[1]];
     			writeValue($post_match[1], $property);
     			error_log($post_match[1] . "="  . $property);
     		}
     	}
    }
	else {
    error_log('CSRF violation');
  	}
  }
  $properties_file = parse_properties('/opt/FeerBoxClient/FeerBoxClient/target/classes/config.properties'); 
  ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-smile-o fa-fw"></i> Configure Properties client</div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          <form role="form" action="?page=properties_conf" method="POST">
            <?php CSRFToken() ?>
            <input type="hidden" name="properties_conf" ?>
            <table class="table table-responsive table-striped">
              <tr>
                <th></th>
                <th>Property</th>
                <th>Value</th>
                <th></th>
              </tr>
            <?php $index = 0; ?>
            <?php foreach ($properties_file as $key => $value) { ?>
              <tr>
                <td>
                </td>
                <td>
                	<?=str_replace("_", " ", trim($key)); ?>
                </td>
                <td>
                	<input type="text" class="form-control" name="<?php echo trim($key) ?>" value="<?php echo $value ?>"/>
                </td>
                <td>
                  <div class="btn-group btn-block">
                    <input type="submit" class="col-md-6 btn btn-warning" value="Update" id="update<?php echo trim($key) ?>" name="update<?php echo trim($key) ?>" />
                  </div>
                </td>
              </tr>
              <?php $index += 1; ?>
            <?php } ?>
            </table>
          </form>
        </div><!-- /.panel-primary -->
        <br />
      <div class="panel-footer"> Properties file for <?php echo $config['client_reference'] ?></div>
    </div><!-- /.col-lg-12 -->
  </div><!-- /.row -->
<?php 
}

?>
