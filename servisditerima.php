<?php
 goto KOBNj; yOZ9N: include "\142\x75\x74\x74\x6f\x6e\163\145\162\166\x69\163\x2e\x70\x68\160"; goto ziKgn; CttgF: require_once "\144\x62\141\156\147\x65\154\143\157\156\x6e\145\x63\164\56\x70\x68\160"; goto rAgZb; KOBNj: session_start(); goto CttgF; QbJby: include "\154\x6f\x67\x6f\56\x70\x68\x70"; goto MzGMD; XXqj8: ?>
<meta content="width=device-width,initial-scale=1"name="viewport"><meta charset="UTF-8"><link href="image\favicon.ico"rel="icon"><html><head><title>Servis Diterima</title><link href="css/main.css"rel="stylesheet"></head><header><div class="container"><?php  goto QbJby; HhBC8: include "\x68\x65\141\144\x65\162\56\x70\150\160"; goto TV9cX; ziKgn: ?>
<div class="diterimaselesai"><h1><span class="highlight">Servis </span>Diterima</h1></div><link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"rel="stylesheet"type="text/css"><script type="text/javascript"src="https://code.jquery.com/jquery-3.5.1.js"></script><script type="text/javascript"src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script><div class="limiter"><div class="container-table100"><div class="wrap-table100"><br><div class="m-b-110 table100 ver3"><table border="0"class="display"data-vertable="ver3"id="example"style="width:100%"><thead class="sticky-stuff"><tr><th style="text-align:center">Tanggal</th><th style="text-align:center">Nama</th><th style="text-align:center">Tipe</th><th style="text-align:center">Kerusakan</th><th style="text-align:center">Print</th><th style="text-align:center">Pilih</th></tr></thead><tbody><?php  goto BmGHs; wgayq: $query = mysqli_query($conn, $sql); goto wVGaF; DBO3W: $conn = null; goto AG4CL; onwIW: include "\x71\x75\x65\x72\171\163\145\162\166\151\163\x2e\160\150\x70"; goto yOZ9N; AG4CL: ob_end_flush(); goto Rkf_E; TV9cX: ?>
</ul></nav></div></header><?php  goto onwIW; MzGMD: ?>
<nav><ul><?php  goto HhBC8; rAgZb: if (!isset($_SESSION["\x75\x73\x65\x72"])) { header("\x4c\x6f\143\141\x74\151\x6f\x6e\x3a\40\154\157\147\151\x6e\x2e\160\x68\x70"); die; } goto XXqj8; Ejvvo: ?>
</tbody><script type="text/javascript">$(document).ready(function(){$("#example").DataTable()})</script></table></div></div></div></div></html><?php  goto DBO3W; wVGaF: while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) { $tanggaldikerjakan = $result["\164\141\x6e\x67\147\x61\x6c\144\x69\153\145\x72\152\x61\153\x61\x6e"]; $tanggalselesai = $result["\164\x61\x6e\x67\x67\141\154\163\145\154\x65\x73\x61\x69"]; $tanggaldiambil = $result["\x74\141\156\147\147\141\154\144\151\x61\155\x62\151\x6c"]; $nonota = $result["\156\x6f\156\x6f\164\141"]; $iddataservis = $result["\x69\144\x64\x61\x74\141\163\x65\162\166\x69\163"]; $tanggalmasuk = $result["\x74\x61\x6e\x67\147\x61\154\x6d\x61\x73\165\153"]; $nama = $result["\x6e\x61\155\141"]; $nohp = $result["\x6e\157\x68\x70"]; $alamat = $result["\141\154\x61\155\x61\164"]; $merk = $result["\155\x65\x72\x6b"]; $tipe = $result["\x74\x69\160\x65"]; $kerusakan = $result["\153\x65\x72\165\163\x61\153\141\x6e"]; $kondisi = $result["\153\x6f\156\x64\x69\x73\151"]; $pin = $result["\160\x69\156"]; $sandi = $result["\x73\141\x6e\x64\x69"]; $pola = $result["\x70\157\x6c\x61"]; ?>
<tr><td class="column100 column2"data-column="column2"><?php  echo date("\144\40\x4d\x20\x59", strtotime($tanggalmasuk)); ?>
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
"> <input name="submit"type="image"class="gambartabel"src="image/print.png"> <input name="destination"type="hidden"value="<?php  echo $_SERVER["\122\105\x51\125\105\x53\124\137\125\122\x49"]; ?>
"></form></td><td class="column100 column8"class="edit"data-column="column8"><form action="prosesservisditerima.php"method="post"><input name="nonota"type="hidden"value="<?php  echo $nonota; ?>
"> <input name="iddataservis"type="hidden"value="<?php  echo $iddataservis; ?>
"> <input name="tanggalmasuk"type="hidden"value="<?php  echo $tanggalmasuk; ?>
"> <input name="tanggaldikerjakan"type="hidden"value="<?php  echo $tanggaldikerjakan; ?>
"> <input name="tanggalselesai"type="hidden"value="<?php  echo $tanggalselesai; ?>
"> <input name="tanggaldiambil"type="hidden"value="<?php  echo $tanggaldiambil; ?>
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
"> <input name="submit"type="image"class="gambartabel"src="image/check.png"></form></td></tr><?php  } goto Ejvvo; BmGHs: $sql = "\123\105\114\105\x43\124\x20\x2a\40\x46\x52\117\115\40\153\145\162\x61\x6e\x6a\141\156\147\142\x65\154\141\x6e\152\141\x20\153\x62\x20\111\x4e\x4e\x45\122\40\x4a\117\111\x4e\40\x64\x61\x74\x61\x73\145\162\166\x69\x73\x20\144\x73\40\x4f\x4e\x20\153\142\56\x69\144\144\141\x74\141\163\x65\x72\166\x69\x73\40\75\x20\144\x73\56\x69\x64\144\x61\x74\141\163\x65\162\166\151\163\x20\x57\x48\x45\x52\x45\40\x6b\142\x2e\151\x64\152\145\x6e\151\163\160\x65\x6e\152\165\x61\x6c\141\156\x20\x3d\x20\x27\63\x27\40\x41\116\x44\40\144\163\56\x73\x74\x61\164\165\x73\x20\x3d\x20\47\144\151\164\145\x72\x69\x6d\x61\47"; goto wgayq; Rkf_E: ?>