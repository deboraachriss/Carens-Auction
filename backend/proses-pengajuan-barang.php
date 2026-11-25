<?php
require_once __DIR__."/kelas-auction.php";
post();
role('user'); $name=trim(val('txtNamaBarang')); $desc=trim(val('txtDeskripsiBarang')); $start=money('nmbHargaAwal'); $buy=money('nmbHargaBuyout');
if (!$name || strlen($name)>50 || !$desc || strlen($desc)>256 || $buy<=$start) fail('Data barang atau harga tidak valid.');
$file=$_FILES['imgFotoBarang']??[];
if (($file['error']??null)!==UPLOAD_ERR_OK || !is_string($file['tmp_name']??null) || !is_uploaded_file($file['tmp_name']) || filesize($file['tmp_name'])>5000000) fail('Unggahan tidak valid (maksimum 5 MB).');
$info=@getimagesize($file['tmp_name']); $mime=(new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']); $types=['image/jpeg'=>'jpg','image/png'=>'png','image/gif'=>'gif'];
if (!$info || !isset($types[$mime]) || $info['mime']!==$mime || $info[0]>5000 || $info[1]>5000) fail('Gambar tidak valid.');
$namefile=bin2hex(random_bytes(16)).'.'.$types[$mime]; $target=__DIR__.'/../gambar/'.$namefile;
if (!move_uploaded_file($file['tmp_name'],$target)) fail('Gagal menyimpan gambar.');
try { $a=new Auction(); if (!$a->ajukanBarang($name,$desc,$start,$buy,'../gambar/'.$namefile,'pending',(int)$_SESSION['uid'])) throw new RuntimeException('Insert failed'); } catch(Throwable $e) { unlink($target); throw $e; }
go('../frontend/view-page-barang-user.php');
