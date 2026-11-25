<?php
require_once __DIR__."/kelas-auction.php";
post();
$_SESSION=[]; $p=session_get_cookie_params(); setcookie(session_name(),'',time()-42000,$p['path'],$p['domain'],$p['secure'],$p['httponly']); session_destroy(); go('../frontend/view-form-login.php');
