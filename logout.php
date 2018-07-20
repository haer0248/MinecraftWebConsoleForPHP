<?php
session_start();
unset($_SESSION['admin']);
session_destroy();
session_start();
Header('Location: login');
exit;