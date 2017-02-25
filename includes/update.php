<?php

/**
*
*
*/
function DisplayUpdate(){
  ?>
  <div class="row">
  <div class="col-lg-12">
  <div class="panel panel-primary">
  <div class="panel-heading"><i class="fa fa-exchange fa-fw"></i> Update</div>
  <div class="panel-body">

    <?php
    if (isset($_POST['check_update'])) {
      echo '<div class="alert alert-warning">Checking for updates Now!</div>';
      $json_update_info = file_get_contents("update_info.php");
      $data_update_info = json_decode($json_update_info, true);
    }
    ?>

    <div class="row">
    <div class="col-md-6">
    <div class="panel panel-default">
    <div class="panel-body">
      <h4>Release Information</h4>
      <div class="info-item">Wifi Portal Revision</div> v 1.0.1</br>
      <div class="info-item">Workspace Revision</div> v 1.0.1</br>
      <div class="info-item">JSPS Revision</div> v 1.88</br>
    </div><!-- /.panel-body -->
    </div><!-- /.panel-default -->
    </div><!-- /.col-md-6 -->
    </div><!-- /.row -->

    <div class="info-item"><?php echo $json_update_info; echo " blubb "; var_dump($data_update_info); echo dirname(__FILE__); ?></div></br>

    <form action="?page=update_info" method="POST">
      <input type="submit" class="btn btn-warning" name="check_update" value="Check for Updates" />
      <input type="button" class="btn btn-outline btn-primary" value="Refresh" onclick="document.location.reload(true)" />
    </form>

  </div><!-- /.panel-body -->
  </div><!-- /.panel-primary -->
  </div><!-- /.col-lg-12 -->
  </div><!-- /.row -->
  <?php
}
?>
