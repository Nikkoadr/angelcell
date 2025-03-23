<?php
 goto COs6x; RHsA8: ?>
<meta content="width=device-width,initial-scale=1"name="viewport"><meta charset="UTF-8"><link href="image\admin.ico"rel="icon"><html><head><title>Pencarian Barang</title><link href="css/main.css"rel="stylesheet"></head><header><div class="container"><?php  goto d33ok; sBb4t: include "\x67\x61\155\142\141\162\142\141\167\x61\150\x72\141\156\x64\x6f\155\x2e\x70\x68\160"; goto yB602; EWBmq: $query = mysqli_query($conn, $sql); goto pHhPB; bW4lc: ?>
</tbody><script type="text/javascript">$(document).ready(function(){$("#example").DataTable()})</script></table><div class="boxeswhite"><div class="diterimaselesai"><div class="buttonpilihnota"><?php  goto sBb4t; sI42T: ?>
<nav><ul><?php  goto VQ7Qu; rWpDs: if (!isset($_SESSION["\165\x73\145\x72"])) { header("\114\157\x63\x61\x74\x69\157\x6e\x3a\40\154\x6f\x67\x69\156\x2e\x70\150\x70"); die; } goto RHsA8; COs6x: session_start(); goto RVawa; NSf9u: $conn = null; goto lfFig; yB602: ?>
</div></div></div></html><?php  goto NSf9u; kPaIo: ?>
</ul></nav></div></header><link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"rel="stylesheet"type="text/css"><script type="text/javascript"src="https://code.jquery.com/jquery-3.5.1.js"></script><script type="text/javascript"src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script><div class="limiter"><div class="container-table100"><div class="wrap-table100"><br><div class="m-b-110 table100 ver3"><table border="0"class="display"data-vertable="ver3"id="example"style="width:100%"><thead class="sticky-stuff"><tr><th style="text-align:center">Nama</th><th style="text-align:center">Ecer</th><th style="text-align:center">Grosir</th><th style="text-align:center">Stok</th><th style="text-align:center">Rubah</th><th style="display:none">Kode</th><th style="display:none">Tags</th></tr></thead><tbody><?php  goto A7aFe; VQ7Qu: include "\x68\145\141\x64\145\x72\56\160\x68\160"; goto kPaIo; pHhPB: while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) { $idbarang = $result["\151\x64\142\141\x72\x61\x6e\147"]; $kodebarang = $result["\x6b\x6f\144\x65\x62\141\x72\x61\x6e\147"]; $namabarang = $result["\156\x61\x6d\141\142\141\x72\x61\156\x67"]; $hargaecer = $result["\x68\141\162\x67\x61\145\x63\145\x72"]; $hargagrosir = $result["\150\x61\x72\x67\x61\147\x72\157\163\x69\x72"]; $stok = $result["\163\164\157\153"]; $hargamodal = $result["\150\141\162\x67\141\x6d\x6f\144\x61\x6c"]; $tags = $result["\164\x61\x67\163"]; $sqlpb = "\x53\x45\114\x45\103\124\x20\160\x62\56\x69\144\142\141\162\x61\156\x67\54\x20\163\x2e\156\x61\155\141\163\165\160\160\154\x69\145\x72\x2c\40\160\x62\56\x74\141\x6e\x67\x67\141\x6c\142\145\154\x69\x20\x46\122\117\x4d\x20\x70\x65\155\x62\x65\154\x69\x61\156\142\x61\x72\x61\x6e\x67\x20\160\x62\x20\x49\x4e\x4e\x45\x52\40\112\117\x49\116\x20\163\165\x70\x70\154\151\145\x72\x20\163\40\x4f\116\40\160\x62\56\151\x64\x73\165\x70\160\x6c\151\145\162\40\75\40\163\x2e\x69\x64\163\x75\160\160\154\x69\145\x72\40\x57\x48\x45\122\105\x20\x70\142\56\x69\144\142\x61\x72\x61\156\147\40\x3d\40\x27{$idbarang}\47\x20\x4f\x52\x44\105\122\x20\x42\131\40\160\142\56\151\144\x70\x65\155\x62\145\x6c\151\x61\x6e\142\141\162\141\156\x67\x20\104\x45\123\103"; $querypb = mysqli_query($conn, $sqlpb); $resultpb = mysqli_fetch_array($querypb); $namasupplier = $resultpb["\x6e\141\155\141\163\x75\160\x70\x6c\151\145\x72"] ?? null; $tanggalbeli = $resultpb["\x74\141\156\147\x67\141\154\142\x65\x6c\151"] ?? null; $shargaecer = number_format($hargaecer, 0, '', "\56"); $shargagrosir = number_format($hargagrosir, 0, '', "\56"); $sstok = number_format($stok, 0, '', "\x2e"); ?>
<tr><td class="column100 column2"data-column="column2"><?php  echo $namabarang; ?>
</td><td class="column100 column2"data-column="column2"><?php  echo $shargaecer; ?>
</td><td class="column100 column2"data-column="column2"><?php  echo $shargagrosir; ?>
</td><td class="column100 column2"data-column="column2"><?php  echo $sstok; ?>
</td><td class="column100 column2"data-column="column2"style="display:none"><?php  echo $tags; ?>
</td><td class="column100 column2"data-column="column2"style="display:none"><?php  echo $kodebarang; ?>
</td><?php  if ($_SESSION["\165\x73\x65\x72"] == "\x61\x64\x6d\151\x6e") { ?>
<td class="column100 column8"class="edit"data-column="column8"><form action="editbarang.php"method="post"><input name="destination"type="hidden"value="<?php  echo $_SERVER["\122\x45\121\x55\x45\x53\124\x5f\125\x52\111"]; ?>
"> <input name="idbarang2"type="hidden"value="<?php  echo $idbarang; ?>
"> <input name="kodebarang2"type="hidden"value="<?php  echo $kodebarang; ?>
"> <input name="namabarang2"type="hidden"value="<?php  echo $namabarang; ?>
"> <input name="hargaecer2"type="hidden"value="<?php  echo $hargaecer; ?>
"> <input name="hargagrosir2"type="hidden"value="<?php  echo $hargagrosir; ?>
"> <input name="hargamodal2"type="hidden"value="<?php  echo $hargamodal; ?>
"> <input name="tags2"type="hidden"value="<?php  echo $tags; ?>
"> <input name="stok2"type="hidden"value="<?php  echo $stok; ?>
"> <input name="namasupplier2"type="hidden"value="<?php  echo $namasupplier; ?>
"> <input name="tanggalbeli2"type="hidden"value="<?php  echo $tanggalbeli; ?>
"> <input name="submit"type="image"class="gambartabel"src="image/edit.png"></form></td><?php  } else { ?>
<td class="column100 column8"class="edit"data-column="column8"><form action="editbarangkaryawan.php"method="post"><input name="destination"type="hidden"value="<?php  echo $_SERVER["\x52\105\121\125\x45\123\x54\x5f\x55\x52\111"]; ?>
"> <input name="idbarang2"type="hidden"value="<?php  echo $idbarang; ?>
"> <input name="kodebarang2"type="hidden"value="<?php  echo $kodebarang; ?>
"> <input name="namabarang2"type="hidden"value="<?php  echo $namabarang; ?>
"> <input name="hargaecer2"type="hidden"value="<?php  echo $hargaecer; ?>
"> <input name="hargagrosir2"type="hidden"value="<?php  echo $hargagrosir; ?>
"> <input name="hargamodal2"type="hidden"value="<?php  echo $hargamodal; ?>
"> <input name="tags2"type="hidden"value="<?php  echo $tags; ?>
"> <input name="stok2"type="hidden"value="<?php  echo $stok; ?>
"> <input name="submit"type="image"class="gambartabel"src="image/edit.png"></form></td><?php  } ?>
</tr><?php  } goto bW4lc; lfFig: ob_end_flush(); goto D5orb; A7aFe: $sql = "\x53\105\114\105\x43\124\40\x2a\x20\x46\122\x4f\x4d\40\142\141\x72\141\156\147\40\127\x48\105\122\105\x20\x61\153\x74\x69\146\x3d\x27\x31\x27\40\x4f\122\104\105\x52\40\102\x59\40\x6e\141\155\x61\x62\x61\162\x61\x6e\147\40\x41\x53\103"; goto EWBmq; RVawa: require_once "\144\142\141\x6e\x67\145\154\143\157\156\x6e\145\143\x74\x2e\x70\x68\x70"; goto rWpDs; d33ok: include "\154\x6f\x67\157\56\x70\150\x70"; goto sI42T; D5orb: ?>