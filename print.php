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

// =======================
// 1. HELPER
// =======================
function checkString($string){
    return htmlspecialchars(strip_tags(trim($string)));
}
function checkNumber($number){
    $val = filter_var($number, FILTER_VALIDATE_INT);
    return $val === false ? 0 : $val;
}

// =======================
// 2. AMBIL DATA
// =======================
$notaterpilih     = checkNumber($_POST['notaterpilih']);
$idjenispenjualan = $_POST['idjenispenjualan'];
$iddataservis     = $_POST['iddataservis'];
$subtotal         = checkNumber($_POST['subtotal']);
$diskon           = checkNumber($_POST['diskon']);
$tunai            = checkNumber($_POST['tunai']);
$namakasir        = checkString($_POST['namauser']);
$printnota        = checkNumber($_POST['printnota']);

$grandtotal = $subtotal - $diskon;
$kembali    = $tunai - $grandtotal;

if($kembali < 0){
    die("<h2 style='color:red'>Pembayaran kurang!</h2>");
}

date_default_timezone_set("Asia/Jakarta");
$tgl_now = date("Y-m-d H:i:s");

// =======================
// 3. SIMPAN KE ARSIP (WAJIB DULU)
// =======================
$conn->begin_transaction();

try {

    // Ambil data keranjang utama
    $qK = $conn->prepare("SELECT * FROM keranjangbelanja WHERE nonota=?");
    $qK->bind_param("i", $notaterpilih);
    $qK->execute();
    $resK = $qK->get_result()->fetch_assoc();

    if(!$resK){
        throw new Exception("Keranjang tidak ditemukan!");
    }

    // Insert arsip utama
    $insA = $conn->prepare("INSERT INTO arsippenjualan 
        (idjenispenjualan, nonota, idmember, iddataservis, tanggalmasuk, tanggalselesai, namakasir, subtotal, diskon, tunai)
        VALUES (?,?,?,?,?,?,?,?,?,?)");

    $insA->bind_param("sisssssiii",
        $idjenispenjualan,
        $notaterpilih,
        $resK['idmember'],
        $resK['iddataservis'],
        $resK['tanggalmasuk'],
        $tgl_now,
        $namakasir,
        $subtotal,
        $diskon,
        $tunai
    );
    $insA->execute();

    // Ambil detail barang
    $qR = $conn->prepare("SELECT * FROM keranjangrinci WHERE nonota=?");
    $qR->bind_param("i", $notaterpilih);
    $qR->execute();
    $resR = $qR->get_result();

    if($resR->num_rows == 0){
        throw new Exception("Barang kosong!");
    }

    while($row = $resR->fetch_assoc()){

        // insert detail arsip
        $insD = $conn->prepare("INSERT INTO arsippenjualanrinci 
            (nonota,idbarang,namabarang,hargajual,hargamodal,qtyjual)
            VALUES (?,?,?,?,?,?)");

        $insD->bind_param("isssii",
            $notaterpilih,
            $row['idbarang'],
            $row['namabarang'],
            $row['hargajual'],
            $row['hargamodal'],
            $row['qtyjual']
        );
        $insD->execute();

        // update stok
        if($row['idbarang'] != 0){
            $upd = $conn->prepare("UPDATE barang SET stok = stok - ? WHERE idbarang=?");
            $upd->bind_param("is", $row['qtyjual'], $row['idbarang']);
            $upd->execute();
        }
    }

    $conn->commit();

} catch(Exception $e){
    $conn->rollback();
    die("Gagal simpan transaksi: " . $e->getMessage());
}

// =======================
// 4. PRINT (DARI ARSIP)
// =======================
if($printnota != 0){

    $printer = null;

    try {

        // delay kecil biar aman
        usleep(300000);

        $connector = new WindowsPrintConnector("FK80 Printer");
        $printer = new Printer($connector);

        // ambil data arsip
        $qPrint = $conn->prepare("SELECT * FROM arsippenjualanrinci WHERE nonota=?");
        $qPrint->bind_param("i", $notaterpilih);
        $qPrint->execute();
        $data = $qPrint->get_result();

        if($data->num_rows == 0){
            throw new Exception("Data print kosong!");
        }

        // tanggal
        $qT = $conn->prepare("SELECT tanggalselesai FROM arsippenjualan WHERE nonota=?");
        $qT->bind_param("i", $notaterpilih);
        $qT->execute();
        $tgl = $qT->get_result()->fetch_assoc();
        $tanggal = date("d M Y H:i", strtotime($tgl['tanggalselesai']));

        for($i=1;$i<=2;$i++){

            $printer->initialize();

            // logo aman
            $logoPath = __DIR__."/image/angelcellprint.png";
            if(file_exists($logoPath)){
                try{
                    $logo = EscposImage::load($logoPath,false);
                    $printer->setJustification(1);
                    $printer->bitImage($logo);
                }catch(Exception $e){
                    $printer->text("ANGEL CELL\n");
                }
            }

            $printer->text("Jalan Jangga-Terisi Desa jangga\n");
            $printer->text("Kecamatan Losarang\n");
            $printer->text($tanggal."\n");

            if($i==2) $printer->text("*** COPY NOTA ***\n");

            $printer->text("--------------------------------\n");

            $printer->setJustification(0);
            $printer->text("Kasir : ".$namakasir."\n");

            $printer->text("--------------------------------\n");

            // barang
            $total = 0;
            while($row = $data->fetch_assoc()){

                $printer->text(substr($row['namabarang'],0,40)."\n");

                $printer->setJustification(2);
                $sub = $row['hargajual'] * $row['qtyjual'];
                $total += $sub;

                $printer->text(
                    number_format($row['hargajual'],0,'.','.').
                    " x ".$row['qtyjual']." ".
                    number_format($sub,0,'.','.')."\n"
                );

                $printer->setJustification(0);
            }

            $printer->setJustification(2);
            $printer->text("--------------------------\n");

            if($diskon > 0){
                $printer->text("Total: ".number_format($total,0,'.','.')."\n");
                $printer->text("Diskon: ".number_format($diskon,0,'.','.')."\n");
            }

            $printer->setEmphasis(true);
            $printer->text("Grand Total: ".number_format($grandtotal,0,'.','.')."\n");
            $printer->setEmphasis(false);

            $printer->text("Tunai: ".number_format($tunai,0,'.','.')."\n");
            $printer->text("Kembali: ".number_format($kembali,0,'.','.')."\n");

            $printer->setJustification(1);
            $printer->feed();
            $printer->text("TERIMAKASIH\n");
            $printer->text("Barang tidak dapat dikembalikan\n");
            $printer->feed(3);
            $printer->cut();

            // reset pointer data
            $data->data_seek(0);
        }

        $printer->close();

        echo "<h2 style='color:green'>Print berhasil</h2>";

    } catch(Exception $e){

        if($printer){
            $printer->close();
        }

        // fallback jika printer error
        echo "<div style='background:red;color:white;padding:20px'>";
        echo "<h2>PRINT GAGAL</h2>";
        echo "Error: ".$e->getMessage()."<br><br>";
        echo "Solusi:<br>";
        echo "1. Cek printer nyala<br>";
        echo "2. Cek nama printer 'FK80 Printer'<br>";
        echo "3. Restart spooler Windows<br>";
        echo "</div>";

        // tetap aman karena data SUDAH MASUK ARSIP
    }
}

// =======================
// 5. CLEANUP (TERAKHIR)
// =======================
$conn->query("DELETE FROM keranjangbelanja WHERE nonota=$notaterpilih");
$conn->query("DELETE FROM keranjangrinci WHERE nonota=$notaterpilih");

echo "<br>Kembali Rp ".number_format($kembali,0,'.','.');
header("Refresh:2;URL='pilihnota.php'");
?>
