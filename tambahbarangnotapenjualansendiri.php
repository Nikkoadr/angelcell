<?php
session_start();
require_once "dbangelconnect.php";

// ================= CEK LOGIN =================
if (!isset($_SESSION["user"])) {
    header("Location: searchbarang.php");
    exit;
}

// ================= FUNCTION =================
function checkString($string)
{
    return htmlspecialchars(strip_tags($string));
}

function checkNumber($number)
{
    return (int) filter_var($number, FILTER_VALIDATE_INT);
}

// ================= AMBIL SESSION =================
$notaterpilih = $_SESSION["notaterpilih"];

// ================= AMBIL DATA =================
if (isset($_POST["kodebarang"])) {
    // ====== DARI SCANNER ======
    $kode = $conn->real_escape_string($_POST["kodebarang"]);

    // DEBUG
    echo "SCAN MASUK: " . $kode . "<br>";

    $q = mysqli_query($conn, "SELECT * FROM barang WHERE kodebarang='$kode' LIMIT 1");
    $data = mysqli_fetch_assoc($q);

    if (!$data) {
        echo "BARCODE TIDAK DITEMUKAN";
        exit;
    }

    $idbarang   = $data["idbarang"];
    $namabarang = $data["namabarang"];
    $hargajual  = $data["hargaecer"];
    $hargamodal = $data["hargamodal"];
    $qtyjual    = isset($_POST["qtyjual"]) ? (int)$_POST["qtyjual"] : 1;
} else {
    // ====== INPUT MANUAL ======
    $idbarang   = $conn->real_escape_string($_POST["idbarang"]);
    $namabarang = $conn->real_escape_string($_POST["namabarang"]);
    $hargajual  = $conn->real_escape_string($_POST["hargajual"]);
    $hargamodal = $conn->real_escape_string($_POST["hargamodal"]);
    $qtyjual    = $conn->real_escape_string($_POST["qtyjual"]);
}

// ================= VALIDASI =================
if ($hargajual == 0) {
    echo "Barang belum ada harga, tidak bisa dijual";
    exit;
}

$namabarang = checkString($namabarang);
$hargajual  = checkNumber($hargajual);
$qtyjual    = checkNumber($qtyjual);

// ================= CEK STOK =================
if ($idbarang != 0) {
    $qstok = mysqli_query($conn, "SELECT stok FROM barang WHERE idbarang='$idbarang' LIMIT 1");
    $stokdata = mysqli_fetch_assoc($qstok);
    $stok = $stokdata["stok"];

    if ($stok < $qtyjual) {
        echo "STOK TIDAK CUKUP";
        exit;
    }
}

// ================= CEK SUDAH ADA DI NOTA =================
$qcek = mysqli_query($conn, "
    SELECT * FROM keranjangrinci 
    WHERE nonota='$notaterpilih' 
    AND idbarang='$idbarang'
");
$cek = mysqli_fetch_assoc($qcek);

if ($cek) {
    // ===== UPDATE QTY =====
    $query = "
        UPDATE keranjangrinci 
        SET qtyjual = qtyjual + $qtyjual 
        WHERE idkeranjangrinci = '{$cek['idkeranjangrinci']}'
    ";
    $success = $conn->query($query);
    echo "QTY DITAMBAH";
} else {
    // ===== INSERT BARU =====
    $query = "
        INSERT INTO keranjangrinci 
        (nonota, idbarang, namabarang, hargajual, hargamodal, qtyjual)
        VALUES 
        ('$notaterpilih','$idbarang','$namabarang','$hargajual','$hargamodal','$qtyjual')
    ";
    $success = $conn->query($query);
    echo "BARANG DITAMBAHKAN";
}

// ================= ERROR HANDLING =================
if (!$success) {
    echo "TERJADI KESALAHAN";
    exit;
}

// ================= SELESAI =================
header("Location: notapenjualan.php");
exit;
