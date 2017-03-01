<?php
$cmd = "sudo /var/sudowebscript.sh update_wifi_portal https://github.com/getveloce/raspap-webgui.git";

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
?>
