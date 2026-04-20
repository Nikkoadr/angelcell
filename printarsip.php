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

// --- 1. Sanitasi Data ---
function checkString($string){
    $string = strip_tags($string);
    return htmlspecialchars($string);
}
function checkNumber($number){
    return filter_var($number, FILTER_VALIDATE_INT) ?: 0;
}

$notaterpilih     = checkNumber($_POST['notaterpilih']);
$idjenispenjualan = $_POST['idjenispenjualan'];
$subtotal         = checkNumber($_POST['subtotal']);
$diskon           = checkNumber($_POST['diskon'] ?? 0);
$tunai            = checkNumber($_POST['tunai']);
$namakasir        = checkString($_POST['namauser']);
$printnota        = $_POST['printnota'];

$grandtotal = $subtotal - $diskon;
$kembali    = $tunai - $grandtotal;

// Validasi pembayaran
if($kembali < 0){
    echo "<div align='center' style='padding:50px; background:red; color:white;'><h2>Gagal: Pembayaran Kurang!</h2></div>";
    header("Refresh: 2;URL='notapenjualan.php'");
    exit;
}

// --- 2. Ambil Data Database ---
$sqlgrosir = "SELECT m.namamember, m.alamat FROM arsippenjualan kb INNER JOIN member m ON kb.idmember = m.idmember WHERE kb.nonota = '$notaterpilih'";
$querygrosir = mysqli_query($conn, $sqlgrosir);
$resGrosir = mysqli_fetch_assoc($querygrosir);

$sqlservis = "SELECT ds.* FROM arsippenjualan kb INNER JOIN dataservis ds ON kb.iddataservis = ds.iddataservis WHERE kb.nonota = '$notaterpilih'";
$queryservis = mysqli_query($conn, $sqlservis);
$resServis = mysqli_fetch_assoc($queryservis);

// Cek jika tidak perlu print
if ($printnota == '0'){
    include "pesanterimakasih.php";
    echo "<div align='center'>Tanpa Nota, Terimakasih!</div>";
    header("Refresh: 1;URL='searcharsipnota.php'");
    exit;
}

// --- 3. Proses Cetak dengan Error Handling ---
$printer = null; // Inisialisasi awal agar catch bisa mengenali variabel
try {
    $connector = new WindowsPrintConnector("FK80 Printer");
    $printer = new Printer($connector);

    // Ambil detail barang
    $getbarang = mysqli_query($conn, "SELECT * FROM arsippenjualanrinci WHERE nonota = $notaterpilih");
    $resTgl = mysqli_fetch_assoc(mysqli_query($conn, "SELECT tanggalselesai FROM arsippenjualan WHERE nonota = $notaterpilih"));
    $tanggal = date("d M Y H:i", strtotime($resTgl['tanggalselesai'] ?? 'now'));

    // --- BAGIAN LOGO (DENGAN PROTEKSI ERROR) ---
    $logoPath = __DIR__ . "/image/angelcellprint.png"; // Menggunakan PATH ABSOLUT
    if (file_exists($logoPath)) {
        try {
            $logo = EscposImage::load($logoPath, false);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> bitImage($logo);
        } catch (Exception $e) {
            // Jika gambar gagal load (format salah/GD error), cetak teks saja sebagai ganti
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("ANGEL CELL\n");
        }
    } else {
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("ANGEL CELL\n");
    }

    $printer -> text("Jalan Jangga-Terisi Desa jangga\n");
    $printer -> text("Kecamatan Losarang\n");
    $printer -> text($tanggal . "\n");
    $printer -> text("------------------------------------------------\n");

    // INFO KASIR & PELANGGAN
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    $printer -> text("Kasir : " . $namakasir . "\n");

    if($idjenispenjualan == '2'){
        $printer -> text("Member: " . ($resGrosir['namamember'] ?? '-') . "\n");
    } elseif($idjenispenjualan == '3'){
        $printer -> text("Tipe  : " . ($resServis['tipe'] ?? '-') . "\n");
        $printer -> text("Nama  : " . ($resServis['nama'] ?? '-') . "\n");
    }

    $printer -> text("------------------------------------------------\n");

    // LIST BARANG
    while($row = mysqli_fetch_assoc($getbarang)){
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text(substr($row['namabarang'], 0, 45) . "\n");
        
        $printer -> setJustification(Printer::JUSTIFY_RIGHT);
        $sub = $row['hargajual'] * $row['qtyjual'];
        $printer -> text(number_format($row['hargajual'],0,'.','.') . " x " . $row['qtyjual'] . "  " . number_format($sub,0,'.','.') . "\n");
    }

    // FOOTER
    $printer -> setJustification(Printer::JUSTIFY_RIGHT);
    $printer -> text("------------------------------\n");
    if($diskon > 0) $printer -> text("Total: " . number_format($subtotal,0,'.','.') . "\n");
    if($diskon > 0) $printer -> text("Diskon: " . number_format($diskon,0,'.','.') . "\n");
    
    $printer -> setEmphasis(true);
    $printer -> text("Grand Total: " . number_format($grandtotal,0,'.','.') . "\n");
    $printer -> setEmphasis(false);
    $printer -> text("Tunai: " . number_format($tunai,0,'.','.') . "\n");
    $printer -> text("Kembali: " . number_format($kembali,0,'.','.') . "\n");

    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> feed(2);
    $printer -> text("TERIMAKASIH\n");
    $printer -> text("Barang yang sudah dibeli tidak dapat\nditukar atau dikembalikan\n");
    $printer -> feed(3);
    
    $printer -> cut();
    $printer -> close();

    echo "<div align='center' style='padding:50px;'><h1>Print Berhasil!</h1></div>";

} catch (Exception $e) {
    // Tutup koneksi printer jika error di tengah jalan agar tidak muncul "Notice"
    if ($printer) {
        $printer -> close();
    }
    
    echo "<div align='center' style='background:red; color:white; padding:40px;'>";
    echo "<h2>GAGAL MENCETAK!</h2>";
    echo "Error: " . $e->getMessage() . "<br><br>";
    echo "<b>Solusi:</b><br>1. Pastikan printer menyala.<br>2. Cek apakah nama 'FK80 Printer' sudah benar di Control Panel.";
    echo "</div>";
}

header("Refresh: 2;URL='searcharsipnota.php'");
?>
