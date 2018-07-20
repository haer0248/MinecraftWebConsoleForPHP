<?php
session_start();

/**** 
*
*   網頁有啟用驗證系統，如果您不需要請自行移除
*   移除掉整個 if 驗證就可以直接顯示了!
*
****/

if (@$_SESSION['admin'] == null){
    Header('Location: /login.php');
    exit;
}else{
    header("Content-Type: text/html; charset=utf8");
?>
<!DOCTYPE html>
<html lang="zh_TW">
    <head>
        <link href="https://visage.surgeplay.com/head/96/4efb71a201364b4d86c00af99676b20b" rel="icon" type="image/x-icon" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>網頁控制台</title>
        <link rel="stylesheet" media="screen, projection" href="css/core.css" />
        <link rel="stylesheet" media="screen, projection" href="css/font-awesome.css" />
        <link rel="stylesheet" media="screen, projection" href="css/notification.css" />
        <script src="js/jQuery.min.js"></script>
        <script language="javascript" src="js/jquery.timers-1.0.0.js"></script>
        <script language="javascript" src="js/notification.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
        <style>
        html {
            font-family: 'Montserrat', sans-serif;
            font-family: 'Microsoft JhengHei';
        }
        div {
            font-family: 'Montserrat', sans-serif;
            font-family: 'Microsoft JhengHei';
        }
        </style>

        <script type="text/javascript">
        $(document).ready(function() {
        	  var status = "";
        	  var lld = "";
        	  var togglecmdi = 1;
                <?php 
                if (!empty($_SESSION['msg'])) {
                    echo 'notify("<i class=\'fa fa-check-circle notification-success\'></i> <div class=\'notification-content\'> <div class=\'notification-header notification-success\'>Success</div> '.$_SESSION['msg'].'</div>");';
                }
                unset($_SESSION['msg']);
                unset($_SESSION['type']);?>
        	  gh();

            function gh() {
                checklogs();
              	lld = "";
              	status = "gh";
              	$.post("reqman.php", {status: status, lld: lld}, function(clgh) {
              	    $("#console").html(clgh);
              			notify("<i class='fa fa-check-circle notification-success'></i> <div class='notification-content'> <div class='notification-header notification-success'>Success</div> 成功取得LOG資料.</div>");
              		  status = "lld";
              		  $.post("reqman.php", {status: status, lld: lld}, function(cllld) {
              			    lld = cllld;
              		  });
              		  status = "ilu";
              		  $.post("reqman.php", {status: status, lld: lld}, function(clilu) {
              			    $("#infologs").html(clilu);
              		  });
              	});
              	setInterval(update, 1000);
        	  }
        	  function checklogs() {
                logstatus = "check";
        	  }
            $(document).on('keydown', function(e) {
            	  var key = e.keyCode || e.charCode;
                if(key == 13) {
                	  // ENTER
                    var cmd = $("#cmd-input").val();
                    if (cmd === ''){
                        notify("<i class='fa fa-times-circle notification-error'></i> <div class='notification-content'> <div class='notification-header notification-error'>Error</div> 請輸入指令!</div>");
                    }else{
                        cmdtype = $(".cmd-type").html();
                        cmdtype = cmdtype.replace("/", "");

                        cmd = cmdtype + cmd;
                        $.post("exec.php", {cmd: cmd}, function(cmdrd) {
                              $(".cmd-input").addClass("hidden");
                              $("#cmd-input").val("");
                              $(".cmd-type").html("");
                              togglecmdi = 1;
                              notify(cmdrd);
                        });
                    }
                } else if(key == 27) {
                		// ESC
                		$(".cmd-input").addClass("hidden");
                	  $("#cmd-input").val("");
                		$(".cmd-type").html("");
                		togglecmdi = 1;
            	  } else if(key == 8) {
                		// BACKSPACE
                		if (document.getElementById('cmd-input').value.length == 0) {
                			   $(".cmd-input").addClass("hidden");
                			   $("#cmd-input").val("");
                			   $(".cmd-type").html("");
                		     togglecmdi = 1;
                		 }
            	  } else {
            	      $(".cmd-input").removeClass("hidden");
            		    $("#cmd-input").focus();
                	  if(key == 191) {
                  	    //  /<command>
                  			e.preventDefault();
                  		  if (togglecmdi == 1) {
                  		      $(".cmd-type").html("/");
                  				  togglecmdi = 0;
                  				  return false;
                  	    }
                  	} else if (togglecmdi == 1) {
                  	    //  /say <message>
                  		  $(".cmd-type").html("/");
                  	}
                  	togglecmdi = 0;
            	  }
            });
        	  function update() {
        	      status = "lld";
        	      $.post("reqman.php", {status: status, lld: lld}, function(lldrdata) {
                    //console.log(lldrdata)
            			  if (lldrdata == "error.logPermissionInvalid") {
            				    checklogs();
            				    return false;
            			  }
            		    if (lldrdata !== lld) {
            			      status = "clu";
            			      $.post("reqman.php", {status: status, lld: lld}, function(clurdata) {
            				        $("#console").append(clurdata);
            					      status = "ilu";
            	 	            $.post("reqman.php", {status: status, lld: lld}, function(clilu) {
                             	    $("#infologs").html(clilu);
                            });
            			      });
            				    lld = lldrdata;
            		    }
        	      });
        	  }
              
            $(".server-status").click(function() {
                ss();
            });
            ss();

            function ss() {
                $.post("ss.php", function(ssd) {
                    $(".server-status").html("Server is " + ssd).addClass("server-status-" + ssd);
            		    if (ssd == "online") {
            			      $(".server-status").removeClass("server-status-offline");
            		    } else {
            			      $(".server-status").removeClass("server-status-online");
            		    }
                });
            }

            function notify(content) {
                $.createNotification({
            	      content: content,
            	      duration: 10000
                });
            }
        });
        </script>
    </head>
    <body>
    <div class="update" id="console"></div>
    <div id="sd"></div>

    <!--<div id="infologs"></div>-->
    <style>
    #myBtn {
        display: block;
        position: fixed;
        bottom: 20px;
        right: 30px;
        z-index: 99;
        border: none;
        outline: none;
        background-color: #3498db;
        color: white;
        cursor: pointer;
        padding: 15px;
        padding-right: 19px;
        padding-left: 19px;
        font-size: 15px;
        transition: all .2s ease-in;
    }
    #btnSend {
        display: block;
        background-color: #0F0F0F;
        font-size: 15px;
    }
    </style>
    <script>
		function sd() {
            $('html, body').animate({ scrollTop: $('#sd').offset().top }, 'slow');
            notify("<i class='fa fa-check-circle notification-success'></i> <div class='notification-content'> <div class='notification-header notification-success'>Success</div> 已更新LOG!</div>");
        }
	</script>
	<script>
        var timer;
        function notify(content) {
            $.createNotification({
                  content: content,
                  duration: 10000
            });
        }
        $("#myBtn").click(function() {
            var theClass = $("#myBtn-2").attr("class");
            if (theClass === 'far fa-check-square'){
                document.getElementById('myBtn-2').className = 'fas fa-check-square';
                document.getElementById('myBtn-3').innerHTML = '自動';
                notify("<i class='fa fa-info-circle'></i> <div class='notification-content'> <div class='notification-header'>Tip</div> 已設定為自動.</div>");
            }else if (theClass === 'fas fa-check-square'){
                document.getElementById('myBtn-2').className = 'far fa-check-square';
                document.getElementById('myBtn-3').innerHTML = '手動';
                notify("<i class='fa fa-info-circle'></i> <div class='notification-content'> <div class='notification-header'>Tip</div> 已設定為手動.</div>");
            }
            custom();
        });
        $(document).ready(function() {
            custom();
        });
        function custom() {
            var theClass = $("#myBtn-2").attr("class");
            if (theClass === 'fas fa-check-square'){
                timer = setInterval(sd, "5000");
            }else if (theClass === 'far fa-check-square'){
                clearTimeout(timer);
            }
        }
	</script>
    <button id="myBtn"><i id="myBtn-2" class="fas fa-check-square"></i><span id="myBtn-3">自動</span></button>

    <div class="server-status"></div>
    <div class="cmd-input hidden">
        <div class="cmd-wrapper">
            <div class="cmd-type"></div>
            <input type="text" name="cmd" id="cmd-input" placeholder="敲個指令唄!" />
    	</div>
    </div>
    <div class="notification-board right top"></div>

    </body>
</html>
<?php }?>