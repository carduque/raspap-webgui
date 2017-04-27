<?php

/**
* Counter People viewer
*
*/
function DisplayCounterPeopleViewer(){
  if( isset($_POST['counter_people']) ) {
    if (CSRFValidate()) {
     	foreach(array_keys($_POST) as $post) {
     		error_log($post);
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
                $.get("includes/counterpeople_db.php", function(data){
                    $("#pir").append(data);
                });
            }, 5000);
        });
    </script>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-smile-o fa-fw"></i> Counter People viewer</div>
        <!-- /.panel-heading -->
        <div class="panel-body">
          CounterPeople PIR: <div id="pir"></div>
          <br/><br/><br/>
          <form role="form" action="?page=counter_people" method="POST">
            <?php CSRFToken() ?>
            <input type="hidden" name="counter_people" ?>
	        <input type="text" name="time" value="<?=date('Y-m-d H:i:s')?>">
	         <div class="btn-group btn-block">
                    <input type="submit" class="col-md-6 btn btn-warning" value="Update" id="update" name="update" />
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
