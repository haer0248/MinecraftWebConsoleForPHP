<?php

require("class/logger.class.php");
require("class/eventLogger.class.php");
header("Content-Type: text/html; charset=big5");
if (isset ($_POST["status"]) && isset ($_POST["lld"])) {
    $logger = new logger($_POST["status"], $_POST["lld"]);
    echo $logger->run();
	  if ($_POST["status"] == "gh") {
        $elog = new eventLogger();
	      $elog->elog("Log history request recieved.");
	  }
}

?>
