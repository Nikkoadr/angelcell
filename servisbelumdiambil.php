<?php
 goto kiMPQ; kiMPQ: session_start(); goto Ky2UY; d7qTE: include "\154\x6f\x67\157\56\160\150\160"; goto UAs_K; DcHOc: ?>
<meta content="width=device-width,initial-scale=1"name="viewport"><meta charset="UTF-8"><link href="image\favicon.ico"rel="icon"><html><head><title>Servis Belum Diambil</title><link href="css/main.css"rel="stylesheet"></head><header><div class="container"><?php  goto d7qTE; tjDot: ?>
<div class="diterimaselesai"><h1><span class="highlight">Servis Selesai </span>Belum Diambil</h1></div><link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"rel="stylesheet"type="text/css"><script type="text/javascript"src="https://code.jquery.com/jquery-3.5.1.js"></script><script type="text/javascript"src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script><div class="limiter"><div class="container-table100"><div class="wrap-table100"><br><div class="m-b-110 table100 ver3"><table border="0"class="display"data-vertable="ver3"id="example"style="width:100%"><thead class="sticky-stuff"><tr><th style="text-align:center">Tanggal</th><th style="text-align:center">Nama</th><th style="text-align:center">Tipe</th><th style="text-align:center">Kerusakan</th><th style="text-align:center">Print</th><th style="text-align:center">Ambil</th></tr></thead><tbody><?php  goto YTNYl; jvBO4: include "\x68\145\x61\x64\145\162\x2e\x70\x68\x70"; goto g7hyZ; g7hyZ: ?>
</ul></nav></div></header><?php  goto BmZ0_; kwDQL: while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) { $nonota = $result["\x6e\157\x6e\x6f\164\x61"]; $iddataservis = $result["\151\x64\x64\141\164\x61\x73\145\162\x76\151\x73"]; $tanggalmasuk = $result["\x74\141\156\147\x67\141\154\155\141\x73\165\153"]; $nama = $result["\156\141\155\x61"]; $nohp = $result["\156\157\150\160"]; $alamat = $result["\141\154\141\x6d\x61\x74"]; $merk = $result["\155\x65\x72\x6b"]; $tipe = $result["\x74\151\160\x65"]; $kerusakan = $result["\153\145\162\165\x73\x61\153\141\156"]; $kondisi = $result["\153\157\156\x64\151\163\151"]; $pin = $result["\x70\x69\156"]; $sandi = $result["\x73\141\x6e\x64\151"]; $pola = $result["\x70\157\x6c\x61"]; ?>
<tr><td class="column100 column2"data-column="column2"><?php  echo date("\x64\x20\115\x20\x59", strtotime($tanggalmasuk)); ?>
</td><td class="column100 column2"data-column="column2"><?php  echo $nama; ?>
</td><td class="column100 column2"data-column="column2"><?php  echo $tipe; ?>
</td><td class="column100 column2"data-column="column2"><?php  echo $kerusakan; ?>
</td><td class="column100 column8"class="print"data-column="column8"><form action="printservisditerima.php"method="post"><input name="nonota"type="hidden"value="<?php  echo $nonota; ?>
"> <input name="iddataservis"type="hidden"value="<?php  echo $iddataservis; ?>
"> <input name="tanggalmasuk"type="hidden"value="<?php  echo $tanggalmasuk; ?>
"> <input name="nama"type="hidden"value="<?php  echo $nama; ?>
"> <input name="nohp"type="hidden"value="<?php  echo $nohp; ?>
"> <input name="alamat"type="hidden"value="<?php  echo $alamat; ?>
"> <input name="merk"type="hidden"value="<?php  echo $merk; ?>
"> <input name="tipe"type="hidden"value="<?php  echo $tipe; ?>
"> <input name="kerusakan"type="hidden"value="<?php  echo $kerusakan; ?>
"> <input name="kondisi"type="hidden"value="<?php  echo $kondisi; ?>
"> <input name="pin"type="hidden"value="<?php  echo $pin; ?>
"> <input name="sandi"type="hidden"value="<?php  echo $sandi; ?>
"> <input name="pola"type="hidden"value="<?php  echo $pola; ?>
"> <input name="submit"type="image"class="gambartabel"src="image/print.png"> <input name="destination"type="hidden"value="<?php  echo $_SERVER["\x52\x45\121\x55\x45\x53\x54\x5f\125\122\x49"]; ?>
"></form></td><td class="column100 column8"class="edit"data-column="column8"><form action="prosesservisbelumdiambil.php"method="post"><input name="nonota"type="hidden"value="<?php  echo $nonota; ?>
"> <input name="iddataservis"type="hidden"value="<?php  echo $iddataservis; ?>
"> <input name="tanggalmasuk"type="hidden"value="<?php  echo $tanggalmasuk; ?>
"> <input name="nama"type="hidden"value="<?php  echo $nama; ?>
"> <input name="nohp"type="hidden"value="<?php  echo $nohp; ?>
"> <input name="alamat"type="hidden"value="<?php  echo $alamat; ?>
"> <input name="merk"type="hidden"value="<?php  echo $merk; ?>
"> <input name="tipe"type="hidden"value="<?php  echo $tipe; ?>
"> <input name="kerusakan"type="hidden"value="<?php  echo $kerusakan; ?>
"> <input name="kondisi"type="hidden"value="<?php  echo $kondisi; ?>
"> <input name="pin"type="hidden"value="<?php  echo $pin; ?>
"> <input name="sandi"type="hidden"value="<?php  echo $sandi; ?>
"> <input name="pola"type="hidden"value="<?php  echo $pola; ?>
"> <input name="submit"type="image"class="gambartabel"src="image/check.png"></form></td></tr><?php  } goto WzJDn; yu4IO: if (!isset($_SESSION["\x75\163\x65\x72"])) { header("\x4c\x6f\143\141\x74\151\x6f\156\72\x20\154\157\147\x69\x6e\x2e\160\x68\x70"); die; } goto DcHOc; YTNYl: $sql = "\x53\105\114\x45\x43\x54\x20\52\x20\x46\122\x4f\115\x20\x6b\x65\162\141\x6e\152\141\156\147\x62\145\x6c\141\x6e\152\141\x20\x6b\x62\x20\x49\x4e\116\x45\122\x20\x4a\x4f\x49\x4e\x20\144\x61\164\141\163\x65\x72\x76\151\163\x20\144\x73\x20\x4f\x4e\40\x6b\142\x2e\151\144\x64\141\164\x61\163\x65\x72\166\x69\163\40\75\x20\x64\x73\56\151\x64\144\x61\x74\141\x73\x65\162\166\151\x73\40\x57\110\x45\122\105\x20\153\x62\56\151\144\x6a\145\x6e\151\x73\x70\x65\x6e\x6a\165\141\x6c\141\156\40\x3d\40\47\63\x27\x20\x41\x4e\x44\x20\x64\x73\56\163\x74\141\164\165\163\40\75\x20\x27\142\x65\154\165\155\x20\x64\151\141\155\142\x69\154\x27"; goto i8FWo; nj3I8: ob_end_flush(); goto qtdHI; WzJDn: ?>
</tbody><script type="text/javascript">$(document).ready(function(){$("#example").DataTable()})</script></table></div></div></div></div></html><?php  goto nChok; i8FWo: $query = mysqli_query($conn, $sql); goto kwDQL; nChok: $conn = null; goto nj3I8; BmZ0_: include "\161\x75\x65\x72\x79\x73\x65\162\166\x69\x73\x2e\x70\x68\160"; goto d4KZt; UAs_K: ?>
<nav><ul><?php  goto jvBO4; Ky2UY: require_once "\144\x62\141\156\147\145\154\x63\x6f\156\156\x65\143\x74\56\160\x68\160"; goto yu4IO; d4KZt: include "\x62\165\x74\x74\x6f\156\x73\x65\162\x76\151\x73\x2e\x70\150\x70"; goto tjDot; qtdHI: ?>