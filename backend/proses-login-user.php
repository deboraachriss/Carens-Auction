<?php
require_once __DIR__."/kelas-auction.php";
post();
$name=trim(val('user')); $pw=val('password');
if (strlen($name)>200 || strlen($pw)>72) fail('Login tidak valid.');
if (($_SESSION['blocked_until']??0)>time()) fail('Terlalu banyak percobaan login.',429);
$a=new Auction(); $row=$a->cekLoginUser($name,$pw);
if (!$row) { $_SESSION['attempts']=($_SESSION['attempts']??0)+1; if ($_SESSION['attempts']>=5) { $_SESSION['blocked_until']=time()+60; $_SESSION['attempts']=0; } fail('Username atau password salah.',401); }
login_session('user',(int)$row['id']); go('../frontend/view-page-barang-user.php');
