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
    if(isset($_POST["check_update"])) {
      echo '<div class="alert alert-warning">Checking for Updates Now!</div>';

      $json_update_info = file_get_contents("http://raspberrypi/includes/update_info.php");
      $data_update_info = json_decode($json_update_info, true);

      $ini_array = parse_ini_file("http://raspberrypi/includes/update_info.ini", TRUE);

      if(strcmp($data_update_info["wifi_portal_revision"], $ini_array["revision"]["wifi_portal_revision"]) != 0) {
        $update_available = TRUE;
        echo '<div class="alert alert-warning">Wifi Portal Update available.</div>';
      }

      if(strcmp($data_update_info["workspace_revision"], $ini_array["revision"]["workspace_revision"]) != 0) {
        $update_available = TRUE;
        echo '<div class="alert alert-warning">Workspace Update available.</div>';
      }

      if(strcmp($data_update_info["jsps_revision"], $ini_array["revision"]["jsps_revision"]) != 0) {
        $update_available = TRUE;
        echo '<div class="alert alert-warning">JSON Serial Port Server Update available.</div>';
      }

      if(!isset($update_available)) {
        echo '<div class="alert alert-warning">No Updates available.</div>';
      }
    }

    if(isset($_POST["update_now"])) {
      echo '<div class="alert alert-warning">Start updating Now!</div>';

      $json_update_info = file_get_contents("http://raspberrypi/includes/update_info.php");
      $data_update_info = json_decode($json_update_info, true);

      $update_output = array();
      $update_return_var;
      exec("sudo rm -rf /var/www/html", $update_output, $update_return_var);

      echo $update_return_var;
      var_dump($update_output);
      echo "<br />";

      exec("sudo git clone https://github.com/getveloce/raspap-webgui /var/www/html", $update_output, $update_return_var);

      echo $update_return_var;
      var_dump($update_output);
      echo "<br />";

      exec("sudo chown -R www-data:www-data /var/www/html", $update_output, $update_return_var);

      echo $update_return_var;
      var_dump($update_output);
      echo "<br />";
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

    <form action="?page=update_info" method="POST">
      <?php
        if(isset($update_available)) {
          echo '<input type="submit" class="btn btn-warning" name="update_now" value="Update" />';
        }
      ?>
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
