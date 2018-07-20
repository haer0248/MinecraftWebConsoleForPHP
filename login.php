<?php
session_start();
/**** 
*
*   網頁有啟用驗證系統，如果您不需要請自行移除
*   請至 index.php 查看移除辦法
*
****/
if (@$_SESSION['admin'] == null){
?>
    <!DOCTYPE html>
    <html lang="zh_TW">
    <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-title" content="網頁控制台">
    <title>網頁控制台</title>

    <script src="js/jQuery.min.js"></script>

    <!-- Tocas UI：CSS 與元件 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tocas-ui/2.3.3/tocas.css">
    <!-- Tocas JS：模塊與 JavaScript 函式 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tocas-ui/2.3.3/tocas.js"></script>


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
    body {
        font-family: 'Montserrat', sans-serif;
        font-family: 'Microsoft JhengHei';
    }
    </style>
    </head>
    <body>
    <style>
        :root {
          --input-padding-x: .75rem;
          --input-padding-y: .75rem;
        }

        html,
        body {
          height: 100%;
        }

        body {
          display: -ms-flexbox;
          display: flex;
          -ms-flex-align: center;
          align-items: center;
          padding-top: 40px;
          padding-bottom: 40px;
          background-color: #f5f5f5;
        }

        .form-signin {
          width: 100%;
          max-width: 500px;
          padding: 15px;
          margin: auto;
        }

        .form-label-group {
          position: relative;
          margin-bottom: 1rem;
        }

        .form-label-group > input,
        .form-label-group > label {
          padding: var(--input-padding-y) var(--input-padding-x);
        }

        .form-label-group > label {
          position: absolute;
          top: 0;
          left: 0;
          display: block;
          width: 100%;
          margin-bottom: 0; /* Override default `<label>` margin */
          line-height: 1.5;
          color: #495057;
          border: 1px solid transparent;
          border-radius: .25rem;
          transition: all .1s ease-in-out;
        }

        .form-label-group input::-webkit-input-placeholder {
          color: transparent;
        }

        .form-label-group input:-ms-input-placeholder {
          color: transparent;
        }

        .form-label-group input::-ms-input-placeholder {
          color: transparent;
        }

        .form-label-group input::-moz-placeholder {
          color: transparent;
        }

        .form-label-group input::placeholder {
          color: transparent;
        }

        .form-label-group input:not(:placeholder-shown) {
          padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
          padding-bottom: calc(var(--input-padding-y) / 3);
        }

        .form-label-group input:not(:placeholder-shown) ~ label {
          padding-top: calc(var(--input-padding-y) / 3);
          padding-bottom: calc(var(--input-padding-y) / 3);
          font-size: 12px;
          color: #777;
        }

        </style>
        <form class="form-signin" action="login_action.php" method="POST">
            <?php 
            if (!empty($_SESSION['msg'])) {
                echo '
                    <div class="ts '.$_SESSION['type'].' message">
                        <div class="header">系統通知</div>
                        <p>'.$_SESSION['msg'].'</p>
                    </div>
                ';
            }
            unset($_SESSION['msg']);
            unset($_SESSION['type']);?>
                <h1 class="h3 mb-3 font-weight-normal">管理後台</h1>
            <div class="ts labeled fluid underlined input">
            <div class="ts label">帳號</div>
                <input type="text" name="Username" required="required">
            </div>
            <br>
            <div class="ts labeled fluid underlined input">
            <div class="ts label">密碼</div>
                <input type="Password" name="Password" required="required">
            </div>
            <button class="ts positive basic button" type="submit">登入</button>
        <p class="mt-5 mb-3 text-muted text-center">Copyright &copy; 網頁控制台 2018 All Rights Reserved.</p>
        </form>
<?php    
}else{
    Header('Location: index');
    exit;
}
?>