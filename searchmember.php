<?php
 goto YFvwc; h6hU_: ?>
<meta content="width=device-width,initial-scale=1"name="viewport"><meta charset="UTF-8"><link href="image\favicon.ico"rel="icon"><html><head><title>Pencarian Member</title><link href="css/main.css"rel="stylesheet"></head><header><div class="container"><?php  goto SW7ap; Nd1U7: $sql = "\x53\105\114\x45\x43\124\x20\52\40\106\x52\117\x4d\x20\x6d\x65\x6d\142\x65\x72\x20\x57\x48\105\122\105\40\x61\153\164\x69\146\75\47\61\47\40\117\x52\x44\x45\x52\40\x42\131\40\x6e\141\x6d\141\155\x65\x6d\x62\145\x72\x20\x41\x53\x43"; goto E6_h1; SW7ap: include "\154\157\147\x6f\56\160\150\x70"; goto E6o5m; YFvwc: session_start(); goto Y5kRg; QlUfj: include "\x68\145\141\144\x65\x72\56\x70\x68\x70"; goto qSU2O; N9RUe: if (!isset($_SESSION["\165\163\x65\162"])) { header("\x4c\157\143\141\164\151\x6f\156\x3a\x20\x6c\x6f\147\151\x6e\56\x70\x68\x70"); die; } goto h6hU_; E6_h1: $query = mysqli_query($conn, $sql); goto Zl65A; Y5kRg: require_once "\x64\142\141\x6e\x67\145\x6c\x63\x6f\x6e\x6e\145\143\164\x2e\160\150\160"; goto N9RUe; qSU2O: ?>
</ul></nav></div></header><link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"rel="stylesheet"type="text/css"><script type="text/javascript"src="https://code.jquery.com/jquery-3.5.1.js"></script><script type="text/javascript"src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script><div class="limiter"><div class="container-table100"><div class="wrap-table100"><br><div class="m-b-110 table100 ver3"><table border="0"class="display"data-vertable="ver3"id="example"style="width:100%"><thead class="sticky-stuff"><tr><th style="text-align:center">Nama</th><th style="text-align:center">Alamat</th><th style="text-align:center">No HP</th><th style="text-align:center">Tanggal</th><?php  goto thvK1; HW2l2: ob_end_flush(); goto Mw023; thvK1: if ($_SESSION["\x75\x73\145\x72"] == "\x61\144\155\x69\x6e") { ?>
<th style="text-align:center">Rubah</th><?php  } goto Zmi4d; E6o5m: ?>
<nav><ul><?php  goto QlUfj; R4Dz2: $conn = null; goto HW2l2; Zmi4d: ?>
</tr></thead><tbody><?php  goto Nd1U7; grZkh: ?>
</tbody><script type="text/javascript">$(document).ready(function(){$("#example").DataTable()})</script></table></div></div></div></div></html><?php  goto R4Dz2; Zl65A: while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) { $idmember = $result["\x69\x64\x6d\x65\x6d\142\145\162"]; $namamember = $result["\x6e\x61\x6d\141\x6d\145\155\x62\145\x72"]; $alamat = $result["\141\154\141\155\x61\x74"]; $nohp = $result["\x6e\x6f\150\160"]; $tanggal = $result["\x74\x61\156\147\147\x61\x6c"]; ?>
<tr><td class="column100 column2"data-column="column2"><?php  echo $namamember; ?>
</td><td class="column100 column2"data-column="column2"><?php  echo $alamat; ?>
</td><td class="column100 column2"data-column="column2"><?php  echo $nohp; ?>
</td><td class="column100 column2"data-column="column2"><?php  echo date("\144\x20\x4d\40\x59", strtotime($tanggal)); ?>
</td><?php  if ($_SESSION["\x75\163\x65\162"] == "\141\144\x6d\x69\x6e") { ?>
<td class="column100 column8"class="edit"data-column="column8"><form action="editmember.php"method="post"><input name="destination"type="hidden"value="<?php  echo $_SERVER["\x52\105\x51\x55\x45\x53\124\137\125\122\111"]; ?>
"> <input name="idmember"type="hidden"value="<?php  echo $idmember; ?>
"> <input name="namamember"type="hidden"value="<?php  echo $namamember; ?>
"> <input name="alamat"type="hidden"value="<?php  echo $alamat; ?>
"> <input name="nohp"type="hidden"value="<?php  echo $nohp; ?>
"> <input name="tanggal"type="hidden"value="<?php  echo $tanggal; ?>
"> <input name="submit"type="image"class="gambartabel"src="image/edit.png"></form></td><?php  } ?>
</tr><?php  } goto grZkh; Mw023: ?>