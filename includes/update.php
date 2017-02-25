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
  <div class="panel-heading"><i class="fa fa-cube fa-fw"></i> System</div>
  <div class="panel-body">

    <form action="?page=system_info" method="POST">
      <input type="submit" class="btn btn-warning" name="system_reboot"   value="Reboot" />
      <input type="submit" class="btn btn-warning" name="system_shutdown" value="Shutdown" />
      <input type="button" class="btn btn-outline btn-primary" value="Refresh" onclick="document.location.reload(true)" />
    </form>

  </div><!-- /.panel-body -->
  </div><!-- /.panel-primary -->
  </div><!-- /.col-lg-12 -->
  </div><!-- /.row -->
  <?php
}
?>
