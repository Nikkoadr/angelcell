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
use Mike42\Escpos\EscposImage;

//variabel dari php
$notaterpilih    = $conn->real_escape_string($_POST['nonota']);
$destination     = $conn->real_escape_string($_POST['destination']);

//KHUSUS SERVIS
$sqlservis = "SELECT * FROM keranjangbelanja kb 
              INNER JOIN dataservis ds ON kb.iddataservis = ds.iddataservis 
              WHERE kb.nonota = $notaterpilih";
$queryservis = mysqli_query($conn,$sqlservis);

$resultservis = mysqli_fetch_array($queryservis, MYSQLI_ASSOC);

$nama = $resultservis["nama"]?? '';
$merk = $resultservis["merk"]?? '';
$tipe = $resultservis["tipe"]?? '';
$kerusakan = $resultservis["kerusakan"]?? '';
$iddataservis = $resultservis["iddataservis"]?? '';
$nohp = $resultservis["nohp"]?? '';
$alamat = $resultservis["alamat"]?? '';
$kondisi = $resultservis["kondisi"]?? '';
$pin = $resultservis["pin"]?? '';
$sandi = $resultservis["sandi"]?? '';
$pola = $resultservis["pola"]?? '';
$idjenispenjualan = $resultservis["idjenispenjualan"] ?? '3';

$namakasir = $_SESSION['namauser'];

function checkString($string){
    return htmlspecialchars(strip_tags(trim($string)));
}

$nama = checkString($nama);
$nohp = checkString($nohp);
$alamat = checkString($alamat);
$merk = checkString($merk);
$tipe = checkString($tipe);
$kerusakan = checkString($kerusakan);
$kondisi = checkString($kondisi);

date_default_timezone_set("Asia/Jakarta");
$tanggal = date("d M Y H:i:s");

// =======================
// PRINT
// =======================
$printer = null;

try {
    $connector = new WindowsPrintConnector("FK80 Printer");
    $printer = new Printer($connector);

    // Ambil data barang
    $getjasa = mysqli_query($conn, "SELECT * FROM keranjangrinci WHERE nonota = $notaterpilih AND namabarang LIKE 'Jasa%'");
    $getbarang = mysqli_query($conn, "SELECT * FROM keranjangrinci WHERE nonota = $notaterpilih AND namabarang NOT LIKE 'Jasa%'");

    // LOOP CETAK 2x (IDENTIK)
    for ($cetak = 1; $cetak <= 2; $cetak++) {

        $printer -> initialize();

        // LOGO AMAN
        $logoPath = "image/angelcellprint.png";
        if(file_exists($logoPath)){
            try{
                $logo = EscposImage::load($logoPath,false);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> bitImage($logo);
            }catch(Exception $e){
                $printer -> text("ANGEL CELL\n");
            }
        }

        $printer -> feed();
        $printer -> text("Jalan Jangga-Terisi Desa jangga");
        $printer -> feed();
        $printer -> text("Kecamatan Losarang");
        $printer -> feed();
        $printer -> text("");
        $printer -> feed();
        $printer -> text($tanggal);
        $printer -> feed();

        $printer -> text("----------------------------------------------");
        $printer -> feed();

        $printer -> setJustification(0);
        $printer -> text("Kasir  : ".$namakasir);

        $pjg = strlen($namakasir);
        $ipjg = 15;
        for($i=$ipjg; $i >= $pjg; $i--){ $printer -> text(" "); }

        $printer -> text("Jenis : Servis");
        $printer -> feed();

        if (strlen($tipe) > 12){ $tipe = substr($tipe, 0, 12) . '..'; }
        $printer -> text("Tipe   : ".$tipe);
        for($i=$ipjg; $i >= strlen($tipe); $i--){ $printer -> text(" "); }
        $printer -> text("Merk  : ".$merk);
        $printer -> feed();

        $printer -> text("No HP  : ".$nohp);
        for($i=$ipjg; $i >= strlen($nohp); $i--){ $printer -> text(" "); }
        $printer -> text("Nama  : ".$nama);
        $printer -> feed();

        $printer -> text("Alamat : ".$alamat);
        for($i=$ipjg; $i >= strlen($alamat); $i--){ $printer -> text(" "); }
        $printer -> text("PIN   : ".$pin);
        $printer -> feed();

        $printer -> text("Sandi  : ".$sandi);
        for($i=$ipjg; $i >= strlen($sandi); $i--){ $printer -> text(" "); }
        $printer -> text("Pola : ".$pola);
        $printer -> feed();

        $printer -> setJustification(1);
        $printer -> text("----------------------------------------------");
        $printer -> feed();

        $printer -> setJustification(0);
        $printer -> text("Kondisi    : ".$kondisi);
        $printer -> feed();

        $printer -> text("Kerusakan  : ".str_replace(",", "\n            ", $kerusakan));
        $printer -> feed();

        // JASA
        $printer -> text("Jasa       : ");
        $totaljasa = 0;
        $getjasa->data_seek(0);

        while($rowj = mysqli_fetch_assoc($getjasa)){
            $nm = (strlen($rowj['namabarang']) > 27) ? substr($rowj['namabarang'], 0, 27) . '...' : $rowj['namabarang'];
            $printer -> text($nm);
            $totaljasa += ($rowj['hargajual'] * $rowj['qtyjual']);
            $printer -> feed();
            $printer -> text("             ");
        }
        $printer -> feed();

        // SPAREPART
        $printer -> text("Sparepart  : ");
        $totalspare = 0;
        $getbarang->data_seek(0);

        while($rowb = mysqli_fetch_assoc($getbarang)){
            $nm = (strlen($rowb['namabarang']) > 27) ? substr($rowb['namabarang'], 0, 27) . '...' : $rowb['namabarang'];
            $printer -> text($nm);
            $totalspare += ($rowb['hargajual'] * $rowb['qtyjual']);
            $printer -> feed();
            $printer -> text("             ");
        }
        $printer -> feed();

        $grandtotal = $totaljasa + $totalspare;

        $printer -> setJustification(2);
        $printer -> text("------------------------------");
        $printer -> feed();
        $printer -> setTextSize(1,2);
        $printer -> setEmphasis(true);
        $printer -> text("ESTIMASI TOTAL : ".number_format($grandtotal,0,'.','.'));
        $printer -> feed();
        $printer -> setEmphasis(false);
        $printer -> setTextSize(1,1);

        // FOOTER
        $printer -> setJustification(1);
        $printer -> feed();
        $printer -> text("!! PERHATIAN !!\n");
        $printer -> text("Nota wajib di bawa saat pengambilan handphone.\n");
        $printer -> text("Jika nota hilang,\n");
        $printer -> text("wajib meninggalkan foto copy ktp\n");
        $printer -> text("untuk pengambilan handphone.\n");
        $printer -> text("Dalam jangka 1 bulan handphone tidak di ambil,\n");
        $printer -> text("di luar tanggung jawab kami.\n");
        $printer -> feed();
        $printer -> text("TERIMA KASIH\n");

        $printer -> feed(3);
        $printer -> cut();
    }

    $printer -> close();

    include "pesanterimakasih.php";
    echo "Sudah Print Nota, Terimakasih!<br>";

} catch (Exception $e) {

    if ($printer) { $printer -> close(); }

    echo "<div style='background:red;color:white;padding:20px'>";
    echo "<h2>PRINT GAGAL</h2>";
    echo "Error: ".$e->getMessage()."<br><br>";
    echo "Solusi:<br>
          1. Cek printer nyala<br>
          2. Cek nama printer<br>
          3. Restart spooler";
    echo "</div>";
}

header("Refresh: 1;URL='$destination'");
?>
