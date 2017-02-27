<?php

function DisplayUpdate(){

?>

<div class="row">
  <div class="col-lg-12">
  <div class="panel panel-primary">
  <div class="panel-heading"><i class="fa fa-exchange fa-fw"></i> Update</div>
  <div class="panel-body">

<?php

  $ini_array = parse_ini_file("update_info.ini", TRUE);

  if(!isset($_POST["update_now"])) {

    if(isset($_POST["check_update"])) {
      $json_update_info = file_get_contents("http://getveloce/wifi_portal/includes/update_info.php");
      $data_update_info = json_decode($json_update_info, TRUE);

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

    echo '<div class="row">
          <div class="col-md-6">
          <div class="panel panel-default">
          <div class="panel-body">
            <h4>Release Information</h4>
            <div class="info-item">Wifi Portal Revision</div>';
    echo $ini_array["revision"]["wifi_portal_revision"];
    echo '  </br>
            <div class="info-item">Workspace Revision</div>';
    echo $ini_array["revision"]["workspace_revision"];
    echo '  </br>
            <div class="info-item">JSPS Revision</div>';
    echo $ini_array["revision"]["jsps_revision"];
    echo '  </br>
          </div><!-- /.panel-body -->
          </div><!-- /.panel-default -->
          </div><!-- /.col-md-6 -->
          </div><!-- /.row -->

            <form action="?page=update_info" method="POST">';

                if(isset($update_available)) {
                  echo '<input type="submit" class="btn btn-warning" name="update_now" value="Update" />';
                }

    echo '    <input type="submit" class="btn btn-warning" name="check_update" value="Check for Updates" />
              <input type="button" class="btn btn-outline btn-primary" value="Refresh" onclick="document.location.reload(true)" />
            </form>';
  }

  if(isset($_POST["update_now"])) {
    $json_update_info = file_get_contents("http://getveloce/wifi_portal/includes/update_info.php");
    $data_update_info = json_decode($json_update_info, TRUE);
    $cmd = "sudo /var/sudowebscript.sh update_wifi_portal " . $data_update_info["wifi_portal_url"];

    $descriptorspec = array(
       0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
       1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
       2 => array("pipe", "w")    // stderr is a pipe that the child will write to
    );
    flush();
    ob_flush();
    $process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());
    echo "<pre>";
    if (is_resource($process)) {
        while ($s = fgets($pipes[1])) {
            print $s;
            flush();
            ob_flush();
        }
        while ($s = fgets($pipes[2])) {
            print $s;
            flush();
            ob_flush();
        }
    }
    echo "</pre>";
    echo '  <form action="?page=update_info" method="POST">
              <input type="button" class="btn btn-outline btn-primary" value="OK" onclick="document.location.reload(true)" />
            </form>';
  }
   ?>

  </div><!-- /.panel-body -->
  </div><!-- /.panel-primary -->
  </div><!-- /.col-lg-12 -->
  </div><!-- /.row -->

<?php
}
?>
