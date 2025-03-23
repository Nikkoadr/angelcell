<?php
 goto Wcz6b; KHfVt: include "\x6c\157\147\x6f\56\160\150\160"; goto IJ3_f; iRPc8: if ($_SESSION["\x75\163\x65\162"] == "\141\144\x6d\x69\x6e") { ?>
<th style="text-align:center">Rubah</th><?php  } goto cJLPA; q3G1u: $conn = null; goto ZNyMP; sZYC3: ?>
</ul></nav></div></header><link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"rel="stylesheet"type="text/css"><script type="text/javascript"src="https://code.jquery.com/jquery-3.5.1.js"></script><script type="text/javascript"src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script><div class="limiter"><div class="container-table100"><div class="wrap-table100"><br><div class="m-b-110 table100 ver3"><table border="0"class="display"data-vertable="ver3"id="example"style="width:100%"><thead class="sticky-stuff"><tr><th style="text-align:center">Nama</th><th style="text-align:center">Alamat</th><th style="text-align:center">Jenis</th><th style="text-align:center">Tanggal Masuk</th><?php  goto iRPc8; OFIis: ?>
<meta content="width=device-width,initial-scale=1"name="viewport"><meta charset="UTF-8"><link href="image\favicon.ico"rel="icon"><html><head><title>Pencarian User</title><link href="css/main.css"rel="stylesheet"></head><header><div class="container"><?php  goto KHfVt; ssUqX: $sql = "\123\105\x4c\x45\x43\x54\x20\x2a\x20\106\x52\x4f\115\40\x75\x73\145\162\x20\x57\110\105\122\x45\x20\x61\x6b\164\x69\x66\75\47\x31\x27\40\x4f\122\x44\105\x52\40\x42\131\x20\156\141\155\x61\x75\x73\x65\x72\40\x41\123\x43"; goto O_f5d; qoRkr: include "\x68\x65\x61\144\145\x72\x2e\x70\150\x70"; goto sZYC3; Sbo4d: while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) { $iduser = $result["\x69\x64\x75\x73\145\162"]; $namauser = $result["\x6e\141\155\141\x75\x73\x65\162"]; $alamat = $result["\141\x6c\141\x6d\141\x74"]; $nohp = $result["\156\x6f\x68\160"]; $username = $result["\x75\x73\145\x72\156\x61\x6d\x65"]; $tanggal = $result["\x74\x61\x6e\x67\147\141\154"]; $privilege = $result["\x70\x72\x69\x76\151\x6c\145\147\x65"]; ?>
<tr><td class="column100 column2"data-column="column2"><?php  echo $namauser; ?>
</td><td class="column100 column2"data-column="column2"><?php  echo $alamat; ?>
</td><td class="column100 column2"data-column="column2"><?php  echo $privilege; ?>
</td><td class="column100 column2"data-column="column2"><?php  echo date("\144\x20\115\x20\131", strtotime($tanggal)); ?>
</td><?php  if ($_SESSION["\165\x73\x65\162"] == "\141\144\155\x69\x6e") { ?>
<td class="column100 column8"class="edit"data-column="column8"><form action="edituser.php"method="post"><input name="destination"type="hidden"value="<?php  echo $_SERVER["\x52\105\121\125\105\123\x54\x5f\125\x52\111"]; ?>
"> <input name="iduser"type="hidden"value="<?php  echo $iduser; ?>
"> <input name="namauser"type="hidden"value="<?php  echo $namauser; ?>
"> <input name="alamat"type="hidden"value="<?php  echo $alamat; ?>
"> <input name="nohp"type="hidden"value="<?php  echo $nohp; ?>
"> <input name="tanggal"type="hidden"value="<?php  echo $tanggal; ?>
"> <input name="username"type="hidden"value="<?php  echo $username; ?>
"> <input name="privilege"type="hidden"value="<?php  echo $privilege; ?>
"> <input name="submit"type="image"class="gambartabel"src="image/edit.png"></form></td><?php  } ?>
</tr><?php  } goto e8MNj; LGB1o: require_once "\144\x62\141\x6e\x67\x65\154\x63\157\x6e\x6e\x65\143\x74\56\x70\150\x70"; goto zN1ba; e8MNj: ?>
</tbody><script type="text/javascript">$(document).ready(function(){$("#example").DataTable()})</script></table></div></div></div></div></html><?php  goto q3G1u; O_f5d: $query = mysqli_query($conn, $sql); goto Sbo4d; IJ3_f: ?>
<nav><ul><?php  goto qoRkr; cJLPA: ?>
</tr></thead><tbody><?php  goto ssUqX; zN1ba: if ($_SESSION["\x75\x73\145\x72"] != "\x61\x64\155\x69\156") { header("\x4c\157\x63\x61\164\151\x6f\x6e\x3a\40\x73\145\141\162\143\x68\x62\141\162\141\156\x67\x2e\x70\150\160"); die; } goto OFIis; ZNyMP: ob_end_flush(); goto U5f3d; Wcz6b: session_start(); goto LGB1o; U5f3d: ?>