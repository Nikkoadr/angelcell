<?php
 goto yGXIe; JzJPE: include "\x71\165\x65\162\x79\163\145\x72\166\151\163\x2e\x70\150\x70"; goto MIcio; NAdb7: $query = mysqli_query($conn, $sql); goto HkSIB; yGXIe: session_start(); goto ckop1; xT70u: include "\x6c\157\147\x6f\x2e\x70\150\160"; goto dF52Z; J6Txl: $conn = null; goto APqSu; G0WB5: ?>
</ul></nav></div></header><?php  goto JzJPE; HJ1nN: if ($_SESSION["\x75\x73\x65\162"] == "\141\x64\155\x69\x6e") { ?>
<th style="text-align:center">Pilih</th><?php  } goto Kr40P; HkSIB: while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) { $nonota = $result["\156\157\x6e\x6f\164\x61"]; $iddataservis = $result["\x69\144\144\x61\x74\141\163\x65\x72\x76\151\163"]; $tanggalmasuk = $result["\x74\x61\156\147\x67\x61\154\155\x61\x73\x75\153"]; $nama = $result["\156\141\x6d\141"]; $nohp = $result["\156\x6f\150\160"]; $alamat = $result["\141\154\x61\x6d\x61\x74"]; $merk = $result["\x6d\145\x72\x6b"]; $tipe = $result["\x74\x69\160\145"]; $kerusakan = $result["\x6b\x65\162\165\x73\x61\153\x61\x6e"]; $kondisi = $result["\153\x6f\156\144\x69\163\x69"]; $pin = $result["\x70\151\x6e"]; $sandi = $result["\x73\x61\x6e\x64\151"]; $pola = $result["\x70\157\x6c\x61"]; ?>
<tr><td class="column100 column2"data-column="column2"><?php  echo date("\x64\x20\115\40\131", strtotime($tanggalmasuk)); ?>
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
"> <input name="submit"type="image"class="gambartabel"src="image/print.png"> <input name="destination"type="hidden"value="<?php  echo $_SERVER["\122\x45\121\x55\x45\123\x54\x5f\125\x52\x49"]; ?>
"></form></td><?php  if ($_SESSION["\x75\163\145\x72"] == "\x61\144\x6d\x69\x6e") { ?>
<td class="column100 column8"class="edit"data-column="column8"><form action="prosesservisdikerjakan.php"method="post"><input name="nonota"type="hidden"value="<?php  echo $nonota; ?>
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
"> <input name="submit"type="image"class="gambartabel"src="image/check.png"></form></td><?php  } ?>
</tr><?php  } goto l6BOM; p11WI: ?>
<meta content="width=device-width,initial-scale=1"name="viewport"><meta charset="UTF-8"><link href="image\favicon.ico"rel="icon"><html><head><title>Servis Dikerjakan</title><link href="css/main.css"rel="stylesheet"></head><header><div class="container"><?php  goto xT70u; IIeU6: if (!isset($_SESSION["\165\163\145\x72"])) { header("\114\157\143\141\164\x69\157\x6e\72\x20\154\x6f\147\x69\x6e\56\x70\150\x70"); die; } goto p11WI; SpMaD: include "\150\x65\x61\144\145\162\x2e\160\150\160"; goto G0WB5; APqSu: ob_end_flush(); goto DFG28; ckop1: require_once "\x64\x62\141\x6e\147\x65\154\143\157\x6e\156\145\143\164\x2e\160\x68\x70"; goto IIeU6; l6BOM: ?>
</tbody><script type="text/javascript">$(document).ready(function(){$("#example").DataTable()})</script></table></div></div></div></div></html><?php  goto J6Txl; dF52Z: ?>
<nav><ul><?php  goto SpMaD; LUThg: $sql = "\123\105\114\x45\x43\x54\x20\x2a\x20\106\122\x4f\x4d\x20\x6b\x65\x72\x61\156\x6a\x61\156\147\x62\145\154\141\156\152\141\x20\153\x62\x20\111\116\116\105\122\40\112\x4f\x49\116\x20\x64\x61\164\x61\x73\145\162\x76\x69\x73\40\144\x73\40\117\116\40\x6b\x62\56\x69\x64\x64\141\x74\x61\x73\x65\162\166\151\x73\x20\75\40\144\x73\56\x69\144\144\x61\164\141\x73\145\162\166\151\x73\40\x57\x48\x45\122\105\40\153\142\56\151\144\x6a\145\156\151\x73\160\145\156\152\165\x61\x6c\141\156\40\x3d\40\47\x33\47\x20\x41\x4e\104\x20\x64\163\56\163\164\x61\164\x75\x73\x20\x3d\40\47\144\151\153\x65\162\152\141\153\x61\156\47"; goto NAdb7; MIcio: include "\x62\165\164\x74\157\x6e\x73\x65\x72\x76\151\163\x2e\160\x68\x70"; goto KGnYA; Kr40P: ?>
</tr></thead><tbody><?php  goto LUThg; KGnYA: ?>
<div class="diterimaselesai"><h1><span class="highlight">Servis </span>Dikerjakan</h1></div><link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"rel="stylesheet"type="text/css"><script type="text/javascript"src="https://code.jquery.com/jquery-3.5.1.js"></script><script type="text/javascript"src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script><div class="limiter"><div class="container-table100"><div class="wrap-table100"><br><div class="m-b-110 table100 ver3"><table border="0"class="display"data-vertable="ver3"id="example"style="width:100%"><thead class="sticky-stuff"><tr><th style="text-align:center">Tanggal</th><th style="text-align:center">Nama</th><th style="text-align:center">Tipe</th><th style="text-align:center">Kerusakan</th><th style="text-align:center">Print</th><?php  goto HJ1nN; DFG28: ?>