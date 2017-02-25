<?php

function _exec($cmd, $status = "") {
    $fontcolour="ffffff";
    if ($status == "OK") { $fontcolour="009900"; }
    if ($status == "ERROR") { $fontcolour="FF0000"; }
    $handle = popen("$cmd 2>&1", 'rb');
    while (!feof($handle)) {
        $line = stream_get_line($handle, 10000, "\n");
        if (empty($line)) { continue; }
        if (preg_match("/^error/i", $line)) { $fontcolour="FF0000"; }
        $line = str_replace(" ", "&nbsp;", $line);
        echo ("<font face='Arial, Helvetica, sans-serif' size='2' color='".$fontcolour."'>".$line."</font><br/>\n");
        flush();
    }
    pclose($handle);
    return;
}

/**
*
*
*/
function DisplayUpdate(){

  $ini_array = parse_ini_file("update_info.ini", TRUE);

  ?>
  <div class="row">
  <div class="col-lg-12">
  <div class="panel panel-primary">
  <div class="panel-heading"><i class="fa fa-exchange fa-fw"></i> Update</div>
  <div class="panel-body">

    <?php
    if(isset($_POST["check_update"])) {
      $json_update_info = file_get_contents("http://getveloce/includes/update_info.php");
      $data_update_info = json_decode($json_update_info, true);

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
      $json_update_info = file_get_contents("http://raspberrypi/includes/update_info.php");
      $data_update_info = json_decode($json_update_info, true);

      $update_output = array();
      $update_return_var;
      _exec("sudo /var/sudowebscript.sh rm_html_dir", $update_output, $update_return_var);

      var_dump($update_output);
      echo $update_return_var;

      _exec("sudo /var/sudowebscript.sh get_current_dir", $update_output, $update_return_var);

      var_dump($update_output);
      echo $update_return_var;

      _exec("sudo /var/sudowebscript.sh clone_wifi_portal", $update_output, $update_return_var);

      var_dump($update_output);
      echo $update_return_var;

      _exec("sudo /var/sudowebscript.sh chown_html_dir", $update_output, $update_return_var);

      var_dump($update_output);
      echo $update_return_var;

      /*exec("sudo git clone https://github.com/getveloce/raspap-webgui /var/www/html", $update_output, $update_return_var);

      echo $update_return_var;
      var_dump($update_output);
      echo "<br />";

      exec("sudo chown -R www-data:www-data /var/www/html", $update_output, $update_return_var);

      echo $update_return_var;
      var_dump($update_output);
      echo "<br />";*/
    }
    ?>

    <div class="row">
    <div class="col-md-6">
    <div class="panel panel-default">
    <div class="panel-body">
      <h4>Release Information</h4>
      <div class="info-item">Wifi Portal Revision</div> <?php echo $ini_array["revision"]["wifi_portal_revision"]; ?></br>
      <div class="info-item">Workspace Revision</div> <?php echo $ini_array["revision"]["workspace_revision"]; ?></br>
      <div class="info-item">JSPS Revision</div> <?php echo $ini_array["revision"]["jsps_revision"]; ?></br>
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
