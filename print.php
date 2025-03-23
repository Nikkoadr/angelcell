<?php
session_start();
require_once 'dbangelconnect.php';

if(!isset($_SESSION['user'])) {
	header("Location: searchbarang.php");
	exit;
}

require __DIR__ . '/epson/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
//use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\EscposImage;

//variabel dari php
$notaterpilih    = $conn->real_escape_string($_POST['notaterpilih']);
$idjenispenjualan    = $conn->real_escape_string($_POST['idjenispenjualan']);
$iddataservis    = $conn->real_escape_string($_POST['iddataservis']);
$subtotal    = $conn->real_escape_string($_POST['subtotal']);
$subtotalakhir    = $conn->real_escape_string($_POST['subtotal']);
$diskon    = $conn->real_escape_string($_POST['diskon']);
$tunai    = $conn->real_escape_string($_POST['tunai']);
$namakasir    = $conn->real_escape_string($_POST['namauser']);
$printnota    = $conn->real_escape_string($_POST['printnota']);
$kembali = $tunai - ($subtotal - $diskon);

//TRIM SPACE
$notaterpilih = rtrim($notaterpilih);
$subtotal = rtrim($subtotal);
$subtotalakhir = rtrim($subtotalakhir);
$diskon = rtrim($diskon);
$tunai = rtrim($tunai);
$namakasir = rtrim($namakasir);
$printnota = rtrim($printnota);

//SANITIZING
$namakasir = checkString($namakasir);

$notaterpilih = checkNumber($notaterpilih);
$subtotal = checkNumber($subtotal);
$subtotalakhir = checkNumber($subtotalakhir);
$printnota = checkNumber($printnota);

function checkString($string){
	$string = strip_tags($string);
	$string = htmlspecialchars($string);
	$string = filter_var($string, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	return $string;
}
function  checkNumber($number){
	$number = strip_tags($number);
	$number = htmlspecialchars($number);
	$number = filter_var($number, FILTER_VALIDATE_INT);
	return $number;
}

echo "<div align='center'><span style ='font-size:35px;color:#FFF'>";

if($kembali < 0){
	include "pesanerror.php";
	echo "Tidak boleh hutang<br>";
	echo "Hubungi ADMIN";
	header ("Refresh: 2;URL='notapenjualan.php'");
	exit;
}

//global variabel
date_default_timezone_set("Asia/Jakarta");
$tanggal = date("d M Y H:i:s");

if ($printnota == '0'){
	include "pesanterimakasih.php";
	echo "<br>Tanpa Nota, Terimakasih!<br>";
}

else{
	//$connector = new WindowsPrintConnector("smb://192.168.1.77/EPSON TM-T88V Archen");
	//$connector = new WindowsPrintConnector("smb://User:mai@192.168.1.77/EPSON TM-T88V Archen");
	//$connector = new WindowsPrintConnector("//user@DESKTOP-DBAM230/EPSON TM-T88V Archen");
	//$connector = new WindowsPrintConnector("smb://FooUser:user@DESKTOP-DBAM230/workgroup/EPSON TM-T88V Archen");
	//$connector = new WindowsPrintConnector("EPSON TM-T88V Archen");

	$connector = new WindowsPrintConnector("pos58");
	//$connector = new NetworkPrintConnector("192.168.7.177", 9100);
	$printer = new Printer($connector);

	// barang awal
	if($printnota == '1'){
		$getbarang=mysqli_query($conn,
			"SELECT * FROM keranjangbelanja kb
			INNER JOIN keranjangrinci kr ON kb.nonota = kr.nonota
			WHERE kr.nonota = $notaterpilih
			ORDER BY kr.idkeranjangrinci ASC");

		$nama    = $conn->real_escape_string($_POST['nama']);
		$merk    = $conn->real_escape_string($_POST['merk']);
		$nohp    = $conn->real_escape_string($_POST['nohp']);
		$tipe    = $conn->real_escape_string($_POST['tipe']);
	}
	else{
		$getbarang=mysqli_query($conn,
			"SELECT * FROM arsippenjualan ap
			INNER JOIN arsippenjualanrinci arp ON ap.nonota = arp.nonota
			WHERE arp.nonota = $notaterpilih
			ORDER BY arp.idarsippenjualanrinci ASC");

		$gettanggal=mysqli_query($conn,
			"SELECT * FROM arsippenjualan ap
			INNER JOIN arsippenjualanrinci arp ON ap.nonota = arp.nonota
			WHERE arp.nonota = $notaterpilih
			ORDER BY arp.idarsippenjualanrinci ASC");

		$resulttanggal = mysqli_fetch_array($gettanggal);
		$tanggal = date("d F Y H:i", strtotime($resulttanggal['tanggalselesai']));
	}
	$total = 0;

	/* Initialize */
	$logo = EscposImage::load("image/angelcellprint.png", false);
	$printer -> initialize();
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer -> bitImage($logo);
	$printbaris = $printer -> feed();
	$printer -> text("Desa Lelea depan Pegadaian");
	$printer -> feed();
	$printer -> text("Kecamatan Lelea");
	$printer -> feed();
	$printer -> text("WhatsApp :  087781715535");
	$printer -> feed();
	$printer -> text($tanggal);
	$printer -> feed();
	$printer -> text("--------------------------------");
	//$printer -> text("——————————————————————————————————————————");
	$printer -> feed();
	$printer -> setJustification(0);
	$printer -> text("Kasir  : ".$namakasir);
	
	$pjg = strlen($namakasir);
	$pjgm = strlen($idjenispenjualan);

	if($pjgm >= 9){
		$ipjg = 10;
	}
	else{
		$ipjg = 15;
	}
	for($i=$ipjg; $i >= $pjg; $i--){
		$printer -> text(" ");
	}

$printer -> feed();
	if($idjenispenjualan == '1'){
		$printer -> text("Jenis : Eceran");
		$printer -> feed();
	}
	else if($idjenispenjualan == '2'){
		$printer -> text("Jenis   : Grosir");
		$printer -> feed();
		
		$namamember    = $conn->real_escape_string($_POST['namamember']);
		$alamatgrosir    = $conn->real_escape_string($_POST['alamatgrosir']);
		
		if (strlen($namamember) > 12){
			$namamember = substr($namamember, 0, 12) . '..';
		}
		$printer -> text("Nama   : ".$namamember);

		$pjg = strlen($namamember);
		for($i=$ipjg; $i >= $pjg; $i--){
			$printer -> text(" ");
		}

		$printer -> text("Alamat  : ".$alamatgrosir);
		$printer -> feed();
	}
	else{
		$printer -> text("Jenis : Servis");
		$printer -> feed();

		$nama    = $conn->real_escape_string($_POST['nama']);
		$merk    = $conn->real_escape_string($_POST['merk']);
		$nohp    = $conn->real_escape_string($_POST['nohp']);
		$tipe    = $conn->real_escape_string($_POST['tipe']);
		$kondisi    = $conn->real_escape_string($_POST['kondisi']);
		$kerusakan    = $conn->real_escape_string($_POST['kerusakan']);
		$alamat    = $conn->real_escape_string($_POST['alamat']);

		if (strlen($tipe) > 12){
			$tipe = substr($tipe, 0, 12) . '..';
		}
		$printer -> text("Tipe   : ".$tipe);

		$pjg = strlen($tipe);
		for($i=$ipjg; $i >= $pjg; $i--){
			$printer -> text(" ");
		}

		$printer -> text("Merk  : ".$merk);
		$printer -> feed();

		$printer -> text("No HP  : ".$nohp);

		$pjg = strlen($nohp);
		for($i=$ipjg; $i >= $pjg; $i--){
			$printer -> text(" ");
		}

		$printer -> text("Nama  : ".$nama);
		$printer -> feed();
		
		$printer -> text("Alamat : ".$alamat);
		$printer -> feed();
	}
	$printer -> setJustification(1);
	$printer -> text("--------------------------------");
	//$printer -> text("——————————————————————————————————————————");
	$printer -> feed();
	$qtypcs=0;

	$printer -> setJustification(0);
	if($idjenispenjualan == '3'){

		$getbarang=mysqli_query($conn,
			"SELECT * FROM keranjangbelanja ap
			INNER JOIN keranjangrinci arp ON ap.nonota = arp.nonota
			WHERE arp.nonota = $notaterpilih AND arp.namabarang NOT LIKE 'Jasa%'");
		$totalgetbarang = mysqli_num_rows($getbarang);

		$getjasa=mysqli_query($conn,
			"SELECT * FROM keranjangbelanja ap
			INNER JOIN keranjangrinci arp ON ap.nonota = arp.nonota
			WHERE arp.nonota = $notaterpilih AND arp.namabarang LIKE 'Jasa%'");
		$totalgetjasa = mysqli_num_rows($getjasa);

		$printer -> text("Kondisi    : ".$kondisi);
		$printer -> feed();

		$numbers = explode(',', $kerusakan);
		$lines = array_chunk($numbers, 1);
		$formattedLines = array_map(function ($row) { return implode(',', $row); }, $lines);
		$output = implode("\n            ", $formattedLines);

		$printer -> text("Kerusakan  : ".$output);
		$printer -> feed();
		$tambahbaris = $tambahbaris.' ';

		$printer -> text("Jasa       : ");
		$hitungjasa = 1;
		$hitungkarakter = 0;
		while($rowkasir = mysqli_fetch_assoc($getjasa)){
			$namabarang = $rowkasir['namabarang'];
			$idbarang = $rowkasir['idbarang'];
			$hargajual = $rowkasir['hargajual'];
			$qtyjual = $rowkasir['qtyjual'];
			$tanggalselesai = $tanggal;
			$subtotal = $hargajual * $qtyjual;

		//hitung qty pcs
			if($idbarang != 0){
				$qtypcs += 1;
			}

			$totaljasa = $totaljasa + $subtotal;

			if (strlen($namabarang) > 27){
				$namabarang = substr($namabarang, 0, 27) . '...';
			}
			$printer -> text($namabarang);

			if($hitungjasa < $totalgetjasa){
				$printer -> feed();
				$printer -> text("             ");
			}
			$hitungjasa++;
			$hitungkarakter = $hitungkarakter + strlen($namabarang);
		}

		$printer -> feed();

		$hitungbarang = 1;
		$printer -> text("Sparepart  : ");
		while($rowkasir = mysqli_fetch_assoc($getbarang)){
			$namabarang = $rowkasir['namabarang'];
			$idbarang = $rowkasir['idbarang'];
			$hargajual = $rowkasir['hargajual'];
			$qtyjual = $rowkasir['qtyjual'];
			$tanggalselesai = $tanggal;
			$subtotal = $hargajual * $qtyjual;

		//hitung qty pcs
			if($idbarang != 0){
				$qtypcs += 1;
			}

			$total = $total + $subtotal;

			if (strlen($namabarang) > 27){
				$namabarang = substr($namabarang, 0, 27) . '...';
			}
			$printer -> text($namabarang);

			if($hitungbarang < $totalgetbarang){
				$printer -> feed();
				$printer -> text("             ");
			}
			$hitungbarang++;
		}
		$printer -> feed();

		$total = $total + $totaljasa;
		$grandtotal = $total - $diskon;
	}
	else{
		while($rowkasir = mysqli_fetch_assoc($getbarang)){
			$namabarang = $rowkasir['namabarang'];
			$idbarang = $rowkasir['idbarang'];
			$hargajual = $rowkasir['hargajual'];
			$qtyjual = $rowkasir['qtyjual'];
			$tanggalselesai = $tanggal;
			$subtotal = $hargajual * $qtyjual;

		//hitung qty pcs
			if($idbarang != 0){
				$qtypcs += 1;
			}

			$total = $total + $subtotal;

			$printer -> setJustification(0);

			if (strlen($namabarang) > 34){
				$namabarang = substr($namabarang, 0, 34) . '...';
			}
			$printer -> text($namabarang);

			if($idjenispenjualan != 3){
				$printer -> feed();
			}
			$printer -> setJustification(2);

			$printer -> text(" ");

		//kalo bukan servis tampilin harga
			if($idjenispenjualan != 3){
				$pjg = strlen($hargajual);
				for($i=3; $i >= $pjg; $i--){
					$printer -> text(" ");
				}

				if($hargajual == 0){
					for($i=2; $i >= $pjg; $i--){
						$printer -> text(" ");
					}
					$printer -> text("0");
				}
				else{
					$shargajual = number_format($hargajual,0,'.','.');
					$printer -> text($shargajual);
				}
				for($i=10; $i >= 5; $i--){
					$printer -> text(" ");
				}

				$printer -> text("x " . $qtyjual);
				$pjg = strlen($subtotal);
				for($i=7; $i >= $pjg; $i--){
					$printer -> text(" ");
				}
				if($subtotal == 0){
					for($i=4; $i >= $pjg; $i--){
						$printer -> text(" ");
					}
					$printer -> text("0");
				}
				else{
					$subtotal2 = number_format($subtotal,0,'.','.');
					$printer -> text($subtotal2);
				}
			}
			$printer -> feed();
		}

		$grandtotal = $total - $diskon;
	}

	$kembali = $tunai - $grandtotal;

	$printer -> setJustification(2);
	$printer -> text("---------------------------------");
	$printer -> feed();

	if($diskon != 0){ //JIKA ADA DISKON
		$printer -> text("Total : ");
		$pjg = strlen($total);
		for($i=5; $i >= $pjg; $i--){
			$printer -> text(" ");
		}
		$total2 = number_format($total,0,'.','.');
		$printer -> text($total2);
		$printer -> feed();

		$printer -> text("Diskon : ");
		$pjg = strlen($diskon);
		for($i=5; $i >= $pjg; $i--){
			$printer -> text(" ");
		}
		$diskon2 = number_format($diskon,0,'.','.');
		$printer -> text($diskon2);
		$printer -> feed();
	}
	$printer -> setTextSize(1,2);
	$printer -> setEmphasis(true);
	$printer -> text("Grand Total : ");
	$pjg = strlen($grandtotal);
	for($i=5; $i >= $pjg; $i--){
		$printer -> text(" ");
	}
	$grandtotal2 = number_format($grandtotal,0,'.','.');
	$printer -> text($grandtotal2);
	$printer -> feed();
	$printer -> feed();
	// $printer -> setEmphasis(false);

	$printer -> text("Tunai : ");
	$pjg = strlen($tunai);
	for($i=5; $i >= $pjg; $i--){
		$printer -> text(" ");
	}
	$tunai2 = number_format($tunai,0,'.','.');
	$printer -> text($tunai2);
	$printer -> feed();
	$printer -> feed();

	$printer -> setTextSize(1,2);
	$printer -> setEmphasis(true);
	$printer -> text("Kembali : ");
	$pjg = strlen($kembali);
	for($i=5; $i >= $pjg; $i--){
		$printer -> text(" ");
	}
	if($kembali == 0){
		for($i=5; $i >= 0; $i--){
			$printer -> text(" ");
		}
	}
	$kembali = number_format($kembali,0,'.','.');
	$printer -> text($kembali);
	if($kembali != 0){
		$printer -> text("");
	}
	$printer -> setTextSize(1,1);
	$printer -> setEmphasis(false);
	$printer -> feed();

	$printer -> setJustification(1);
	$printer -> feed();
	$printer -> text("            TERIMAKASIH               ");
	$printer -> feed();
	$printer -> text("Kami tunggu kedatangan Anda berikutnya");
	$printer -> feed();
	$printer -> text("Barang yang sudah dibeli");
	$printer -> feed();
	$printer -> text("Tidak dapat ditukar / dikembalikan");
	$printer -> feed();
	$printer -> text("                                      ");
	$printer -> feed();

	$printer -> cut();
	$printer -> close();

	echo "<div align='center'><span style ='font-size:35px;color:#FFF'>";
	include "pesanterimakasih.php";
	echo "Sudah Print Nota, Terimakasih!<br>";
}
if($kembali == 0){
	echo "<br>Kembali Rp " . $kembali;
}
else{
	echo "<br>Kembali Rp " . $kembali . "<br>";
}

if($printnota != 2){

	$tanggal = date("Y-m-d H:i:s");
// ARSIP PENJUALAN
	$getkeranjang=mysqli_query($conn,
		"SELECT * FROM keranjangbelanja
		WHERE nonota = $notaterpilih LIMIT 1");

	while($rownota = mysqli_fetch_assoc($getkeranjang)){
		$arsipnonota = $rownota['nonota'];
		$arsipidmember = $rownota['idmember'];
		$arsipiddataservis = $rownota['iddataservis'];
		$arsiptanggalmasuk = $rownota['tanggalmasuk'];
		$arsiptanggalselesai = $tanggal;
	}

	$pindaharsip = "INSERT INTO arsippenjualan (idjenispenjualan,nonota,idmember,iddataservis,tanggalmasuk,tanggalselesai,namakasir,subtotal,diskon,tunai)
	VALUES('" . $idjenispenjualan . "','" . $notaterpilih . "','" . $arsipidmember . "','" . $arsipiddataservis . "','" . $arsiptanggalmasuk . "','" . $arsiptanggalselesai . "','" . $namakasir . "','" . $subtotalakhir . "','" . $diskon . "','" . $tunai . "')";
	$success = $conn->query($pindaharsip);

	// ARSIP RINCI PENJUALAN
	$getkeranjangrinci=mysqli_query($conn,
		"SELECT * FROM keranjangrinci
		WHERE nonota = $notaterpilih");

	while($rownota = mysqli_fetch_assoc($getkeranjangrinci)){

		$idbarang = $rownota['idbarang'];
		$namabarang = $rownota['namabarang'];
		$hargajual = $rownota['hargajual'];
		$hargamodal = $rownota['hargamodal'];
		$qtyjual = $rownota['qtyjual'];

		$pindaharsiprinci = "INSERT INTO arsippenjualanrinci (nonota,idbarang,namabarang,hargajual,hargamodal,qtyjual)
		VALUES('" . $notaterpilih . "','" . $idbarang . "','" . $namabarang . "','" . $hargajual . "','" . $hargamodal . "','" . $qtyjual . "')";
		$success = $conn->query($pindaharsiprinci);

		if($idbarang != '0'){
			$querykurangistok   = ("UPDATE barang SET stok = stok - $qtyjual WHERE idbarang = '$idbarang'");
			$successkurangistok = $conn->query($querykurangistok);
		}
	}
}

$querykurangistok   = ("UPDATE dataservis SET status = 'sudah diambil', tanggaldiambil = NOW() WHERE iddataservis = '$iddataservis'");
$successkurangistok = $conn->query($querykurangistok);

$queryhapus   = ("DELETE FROM keranjangbelanja WHERE nonota = $notaterpilih");
$successhapuskb = $conn->query($queryhapus);

$queryhapus2   = ("DELETE FROM keranjangrinci WHERE nonota = $notaterpilih");
$successhapuskbr = $conn->query($queryhapus2);

if (!$successhapuskb && !$successhapuskbr) {
	include "pesanerror.php";
	echo "Terjadi Kesalahan hapus keranjang<br>";
	echo "Hubungi ADMIN";
	die("Error: ".$conn->error);
}
header ("Refresh: 1;URL='pilihnota.php'");

