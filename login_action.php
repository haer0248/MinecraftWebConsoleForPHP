<?php 
session_start();
/**** 
*
*   網頁有啟用驗證系統，如果您不需要請自行移除
*   請至 index.php 查看移除辦法
*
****/
$db_server = "localhost";
$db_user = ""; //使用者帳號
$db_passwd = ""; //使用者密碼
$dashboard = "`authme`.`account`"; //Authme資料庫
if(!@mysql_connect($db_server, $db_user, $db_passwd))
        die('<div class="alert alert-danger">無法對資料庫連線</div>');
mysql_query("SET NAMES utf8");

$Username = strtolower($_POST['Username']);
$password = $_POST['Password'];
if ( $Username != null && $password != null){
    $result = mysql_query("SELECT * FROM $dashboard WHERE `username` = '$Username'");
    $row = mysql_fetch_row($result);
    if ($row[0] == null){
        $_SESSION['msg'] = '無此帳號資料!';
        $_SESSION['type'] = 'negative';
        Header('Location: ../../login.php');
        exit;
    }else{
		$sha_info = explode("$",$row[3]);
		if( $sha_info[1] === "SHA" ) {
            $salt = $sha_info[2];
            $sha256_password = hash('sha256', $password);
            $sha256_password .= $sha_info[2];;
            if( strcasecmp(trim($sha_info[3]),hash('sha256', $sha256_password) ) == 0 ) {
                if ($Username == 'username' OR $Username == 'username'){ //username為管理員帳號
                    $_SESSION['admin'] = $row[2];
                    $_SESSION['msg'] = $row[2].' 登入成功!';
                    $_SESSION['type'] = 'success';
                    Header('Location: ../../index');
                    exit;
                }else{
                    $_SESSION['msg'] = '帳號密碼錯誤，請重新輸入!';
                    $_SESSION['type'] = 'error';
                    Header('Location: ../../login.php');
                    exit;
                }
            }else{
                $_SESSION['msg'] = '帳號密碼錯誤，請重新輸入!';
                $_SESSION['type'] = 'error';
                Header('Location: ../../login.php');
                exit;
            }
        }
    }
}else{
    $_SESSION['msg'] = '資料空白! 請重新輸入!';
    $_SESSION['type'] = 'negative';
    Header('Location: ../../login.php');
    exit;
}
?>