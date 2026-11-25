<?php
require_once __DIR__."/kelas-auction.php";
post();
$name=trim(val('txtNama')); $pw=val('txtPassword'); $n=trim(val('txtNorek'));
if (!preg_match('/^[\p{L}\p{N} _.-]{1,50}$/uD',$name) || strlen($pw)<12 || strlen($pw)>72 || !preg_match('/^[0-9]{1,10}$/D',$n)) fail('Nama, rekening simulasi, atau password tidak valid (password 12–72 byte).');
$a=new Auction(); try { $a->simpanLogin($name,$pw,$n); } catch(PDOException $e) { if ($e->getCode()==='23000') fail('Nama sudah digunakan.'); throw $e; } go('../frontend/view-form-login.php');
