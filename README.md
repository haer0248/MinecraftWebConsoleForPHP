# MinecraftWebConsoleForPHP
原作者: https://github.com/SuperPykkon/minecraft-server-web-console
##安裝說明:
1. 先至 config/config.php 變更伺服器路徑資料
2. 之後返回主目錄進入 exec.php 變更 RCON 資料

##系統要求:
PHP5.6+

##RCON啟用:
1. 到server.properties (伺服器設定檔案)
2. enable-rcon=false 改為 true
3. rcon.port=25575 埠號可以自己改(不會建議不要動)
4. rcon.password=密碼 (一定要設定 不然別人就可以操控伺服器)

##登入說明:
原本的網頁沒有驗證功能，我將它改成了可以透過Authme進行驗證
不需要的請至 index.php 查看移除方式

##與原本的變更了甚麼:
- 可以讀取中文
- 可以使用指令控制伺服器 (Windows) 使用鍵盤除了ESC跟Enter呼叫出來

##更新紀錄
- 2018/07/20 
  新增回傳顯示功能 (index.php / exec.php)

##有任何BUG請開啟issue謝謝~
