<?php
require_once __DIR__."/kelas-auction.php";
post();
role('user'); $a=new Auction(); if (!$a->prosesPembayaran(ident('id_barang'),(int)$_SESSION['uid'])) fail('Simulasi pembayaran tidak diizinkan.'); go('../frontend/view-pembayaran-user.php');
