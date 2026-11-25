<?php
require_once __DIR__."/kelas-auction.php";
post();
role('admin'); $a=new Auction(); try { $ok=$a->pengajuanDiterima(ident('id')); } catch(PDOException $e) { if ($e->getCode()==='23000') fail('Data masih terhubung dengan transaksi.'); throw $e; } if (!$ok) fail('Operasi gagal.'); go('../frontend/view-verif-pengajuan-barang.php');
