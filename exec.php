<?php
require_once 'class/rcon.php';

$host = 'localhost';
$port = 25575; //RCON端口
$password = ''; //RCON密碼
$timeout = 3;
/******** 以下不會的請不要變動 ********/
use Thedudeguy\Rcon;

$rcon = new Rcon($host, $port, $password, $timeout);
$cmd = $_POST['cmd'];
if ($rcon->connect()){
    $rcon->sendCommand($cmd);
    echo "<i class='fa fa-check-circle notification-success'></i> <div class='notification-content'> <div class='notification-header notification-success'>Success</div> 指令$cmd 傳送成功.</div>";
}
?>
