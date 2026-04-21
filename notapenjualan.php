<?php
session_start();
ob_start();
require_once "dbangelconnect.php";

// 1. PROTEKSI & AMBIL SESSION
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    die;
}

if (!isset($_SESSION["notaterpilih"])) {
    header("Refresh: 1; URL='pilihnota.php'");
    die;
}

$namauser = $_SESSION["namauser"];
$roleuser = $_SESSION["user"];
$notaterpilih = $_SESSION["notaterpilih"];

// 2. CEK APAKAH NOTA KOSONG
$q_cek = mysqli_query($conn, "SELECT COUNT(*) as totaldata FROM keranjangrinci WHERE nonota='$notaterpilih'");
$cektotnota = mysqli_fetch_assoc($q_cek);
if ($cektotnota["totaldata"] == 0) {
    header("Refresh: 0; URL='pilihnota.php'");
    die;
}

// 3. AMBIL DATA KERANJANG UTAMA
$sql_kb = "SELECT * FROM keranjangbelanja WHERE nonota = '$notaterpilih'";
$q_kb = mysqli_query($conn, $sql_kb);
$res_kb = mysqli_fetch_assoc($q_kb);

$tanggalmasuk = $res_kb["tanggalmasuk"] ?? null;
$idjenispenjualan = $res_kb["idjenispenjualan"] ?? null;
$idmember = $res_kb["idmember"] ?? null;
$iddataservis = $res_kb["iddataservis"] ?? null;

// 4. AMBIL DETAIL MEMBER ATAU SERVIS
$namamember = "-";
$alamatgrosir = "-";
$ds = [
    'nama' => '',
    'merk' => '',
    'tipe' => '',
    'kerusakan' => '',
    'status' => '',
    'nohp' => '',
    'pin' => '',
    'sandi' => '',
    'pola' => '',
    'kondisi' => '',
    'alamat' => ''
];

if ($idjenispenjualan == "2") {
    $q_m = mysqli_query($conn, "SELECT * FROM member WHERE idmember = '$idmember'");
    $res_m = mysqli_fetch_assoc($q_m);
    $namamember = $res_m["namamember"] ?? null;
    $alamatgrosir = $res_m["alamat"] ?? null;
} elseif ($idjenispenjualan == "3") {
    $q_s = mysqli_query($conn, "SELECT * FROM dataservis WHERE iddataservis = '$iddataservis'");
    $res_s = mysqli_fetch_assoc($q_s);
    if ($res_s) $ds = $res_s;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nota Penjualan - Angel Cell</title>
    <link href="image/favicon.ico" rel="icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="DataTables/datatables.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="DataTables/jquery-3.5.1.js"></script>
    <script src="DataTables/datatables.min.js"></script>
    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            @apply border border-gray-300 rounded px-2 py-1 outline-none focus:ring-2 focus:ring-blue-500;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 font-sans leading-normal">

    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center space-x-4">
                    <?php include "logo.php"; ?>
                </div>

                <div class="hidden md:flex items-center space-x-1 text-sm font-medium">
                    <a href="dashboard.php" class="px-3 py-2 hover:bg-gray-100 rounded-md">Dashboard</a>

                    <div class="relative dropdown">
                        <button class="px-3 py-2 hover:bg-gray-100 rounded-md inline-flex items-center">
                            Barang <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute hidden bg-white shadow-xl rounded-md py-2 w-48 border mt-0">
                            <?php if ($roleuser == "admin"): ?>
                                <a href="tambahbarang.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Tambah Barang</a>
                                <a href="searchbarangmasuk.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Barang Masuk</a>
                            <?php else: ?>
                                <a href="tambahbarangkaryawan.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Tambah Barang</a>
                            <?php endif; ?>
                            <a href="searchbarang.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 border-t">Cari Barang</a>
                        </div>
                    </div>

                    <div class="relative dropdown">
                        <button class="px-3 py-2 hover:bg-gray-100 rounded-md inline-flex items-center">
                            Member <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute hidden bg-white shadow-xl rounded-md py-2 w-48 border mt-0">
                            <a href="tambahmember.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Tambah Member</a>
                            <a href="searchmember.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Data Member</a>
                        </div>
                    </div>

                    <div class="relative dropdown">
                        <button class="px-3 py-2 hover:bg-gray-100 rounded-md inline-flex items-center text-blue-600">
                            Penjualan <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute hidden bg-white shadow-xl rounded-md py-2 w-48 border mt-0">
                            <a href="penjualanbaru.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Nota Baru</a>
                            <a href="pilihnota.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Pilih Nota</a>
                            <a href="searcharsipnota.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Arsip Nota</a>
                        </div>
                    </div>

                    <a href="servisditerima.php" class="px-3 py-2 hover:bg-gray-100 rounded-md">Servis</a>

                    <?php if ($roleuser == "admin"): ?>
                        <div class="relative dropdown">
                            <button class="px-3 py-2 hover:bg-gray-100 rounded-md inline-flex items-center">
                                Supplier <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="dropdown-menu absolute hidden bg-white shadow-xl rounded-md py-2 w-48 border mt-0">
                                <a href="searchsupplier.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Data Supplier</a>
                                <a href="tambahsupplier.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Tambah Baru</a>
                            </div>
                        </div>
                        <div class="relative dropdown">
                            <button class="px-3 py-2 hover:bg-gray-100 rounded-md inline-flex items-center font-bold text-red-600">
                                Laporan <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="dropdown-menu absolute hidden bg-white shadow-xl rounded-md py-2 w-48 border mt-0">
                                <a href="searchpenjualanharian.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Penjualan Harian</a>
                                <a href="searchpendapatan.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Pendapatan</a>
                                <a href="searchpembelian.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Pembelian</a>
                                <a href="searchmodal.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 text-orange-600">Modal</a>
                                <a href="searchabsen.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 border-t">Absen</a>
                                <a href="searchgajikaryawan.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Gaji</a>
                            </div>
                        </div>
                        <div class="relative dropdown">
                            <button class="px-3 py-2 hover:bg-gray-100 rounded-md inline-flex items-center">
                                User <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="dropdown-menu absolute hidden bg-white shadow-xl rounded-md py-2 w-48 border mt-0">
                                <a href="tambahuser.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Tambah User</a>
                                <a href="searchuser.php" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600">Data User</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <a href="logout.php?logout" class="ml-4 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">Keluar</a>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-6">
        <div class="flex flex-wrap gap-3 mb-6">
            <?php if ($idjenispenjualan == "3"): ?>
                <form action="prosescancelservis.php" method="post" onsubmit="return confirm('Yakin Cancel Servis?')">
                    <input name="notaterpilih" value="<?php echo $notaterpilih; ?>" type="hidden">
                    <input name="iddataservis" value="<?php echo $iddataservis; ?>" type="hidden">
                    <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow transition" type="submit uppercase">CANCEL SERVIS</button>
                </form>
            <?php else: ?>
                <form action="proseshapusnotapenjualan.php" method="post" onsubmit="return confirm('Yakin Hapus Nota?')">
                    <input name="notaterpilih" value="<?php echo $notaterpilih; ?>" type="hidden">
                    <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow transition" type="submit">HAPUS NOTA</button>
                </form>
            <?php endif; ?>

            <form action="tambahbarangnotapenjualansendiri.php" method="post">
                <input name="notaterpilih" value="<?php echo $notaterpilih; ?>" type="hidden">
                <button class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow transition" type="submit">TAMBAH BARANG MANUAL</button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md mb-8 border border-gray-200">
            <h2 class="text-xl font-bold mb-4 flex items-center text-gray-700">
                <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                Pilih Barang ke Nota
            </h2>
            <div class="overflow-x-auto">
                <input
                    type="text"
                    id="barcodeInput"
                    autofocus
                    style="position:absolute;opacity:0;height:0;width:0;">
                <table id="example" class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs border-b">
                        <tr>
                            <th class="hidden">Kode</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Harga <?php echo ($idjenispenjualan == "2") ? "Grosir" : "Ecer"; ?></th>
                            <th class="px-4 py-3">Stok</th>
                            <th class="hidden">Tags</th>
                            <th class="px-4 py-3 text-center w-32">Qty</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                        $q_brg = mysqli_query($conn, "SELECT * FROM barang WHERE aktif='1' ORDER BY namabarang ASC");
                        while ($b = mysqli_fetch_assoc($q_brg)):
                            $harga = ($idjenispenjualan == "2") ? $b["hargagrosir"] : $b["hargaecer"];
                        ?>
                            <tr class="hover:bg-blue-50 transition">
                                <td class="hidden"><?php echo $b["kodebarang"]; ?></td>
                                <td class="px-4 py-3 font-medium"><?php echo $b["namabarang"]; ?></td>
                                <td class="px-4 py-3 font-bold text-blue-600"><?php echo number_format($harga, 0, '', '.'); ?></td>
                                <td class="px-4 py-3"><?php echo number_format($b["stok"], 0, '', '.'); ?></td>
                                <td class="hidden"><?php echo $b["tags"]; ?></td>
                                <form action="prosestambahbarangnotapenjualansendiri.php" method="post">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center border rounded-lg bg-white overflow-hidden">
                                            <button type="button" class="qtyminus w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200" field="qtyjual">-</button>
                                            <input name="qtyjual" value="1" type="number" class="w-12 text-center border-none text-sm font-bold focus:ring-0" readonly>
                                            <button type="button" class="qtyplus w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200" field="qtyjual">+</button>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <input name="idbarang" value="<?php echo $b["idbarang"]; ?>" type="hidden">
                                        <input name="kodebarang" value="<?php echo $b["kodebarang"]; ?>" type="hidden">
                                        <input name="namabarang" value="<?php echo $b["namabarang"]; ?>" type="hidden">
                                        <input name="hargajual" value="<?php echo $harga; ?>" type="hidden">
                                        <input name="hargamodal" value="<?php echo $b["hargamodal"]; ?>" type="hidden">
                                        <button type="submit" class="hover:scale-110 transform transition">
                                            <i class="fa-solid fa-cart-plus text-green-600 text-xl"></i>
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md mb-8 border-t-4 border-blue-500">
            <h2 class="text-xl font-bold mb-4 text-gray-700">Isi Nota: <?php echo $notaterpilih; ?></h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-800 text-white rounded-t-lg">
                        <tr>
                            <th class="px-4 py-3">Barang</th>
                            <th class="px-4 py-3">Harga</th>
                            <th class="px-4 py-3">Qty</th>
                            <th class="px-4 py-3 text-right">Total</th>
                            <th class="px-4 py-3 text-center">Edit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php
                        $subtotal = 0;
                        $q_rinci = mysqli_query($conn, "SELECT kr.*, b.namabarang, b.hargamodal FROM keranjangrinci kr JOIN barang b ON kr.idbarang = b.idbarang WHERE kr.nonota = '$notaterpilih' ORDER BY idkeranjangrinci ASC");
                        while ($rinci = mysqli_fetch_assoc($q_rinci)):
                            $total_brg = $rinci["hargajual"] * $rinci["qtyjual"];
                            $subtotal += $total_brg;
                        ?>
                            <tr>
                                <td class="px-4 py-3"><?php echo $rinci["namabarang"]; ?></td>
                                <td class="px-4 py-3"><?php echo number_format($rinci["hargajual"], 0, '', '.'); ?></td>
                                <td class="px-4 py-3"><?php echo $rinci["qtyjual"]; ?></td>
                                <td class="px-4 py-3 text-right font-bold"><?php echo number_format($total_brg, 0, '', '.'); ?></td>
                                <td class="px-4 py-3 text-center">
                                    <form action="editnotapenjualanbarang.php" method="post">
                                        <input name="destination" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" type="hidden">
                                        <input name="idbarang" value="<?php echo $rinci['idbarang']; ?>" type="hidden">
                                        <input name="idkeranjangrinci" value="<?php echo $rinci['idkeranjangrinci']; ?>" type="hidden">
                                        <input name="namabarang" value="<?php echo $rinci['namabarang']; ?>" type="hidden">
                                        <input name="hargajual" value="<?php echo $rinci['hargajual']; ?>" type="hidden">
                                        <input name="hargamodal" value="<?php echo $rinci['hargamodal']; ?>" type="hidden">
                                        <input name="qtyjual" value="<?php echo $rinci['qtyjual']; ?>" type="hidden">
                                        <input name="notaterpilih" value="<?php echo $notaterpilih; ?>" type="hidden">
                                        <button type="submit" class="hover:scale-110 transform transition">
                                            <i class="fa-solid fa-pen text-blue-600"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-gray-900 text-white p-6 rounded-2xl shadow-xl">
                <h3 class="text-lg font-bold mb-4 text-blue-400 border-b border-gray-700 pb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Detail Informasi Nota
                </h3>
                <div class="space-y-4 text-sm">
                    <?php if ($idjenispenjualan == "1"): ?>
                        <p class="flex justify-between"><span>No Nota:</span> <span class="text-gray-300 font-mono"><?php echo $notaterpilih; ?></span></p>
                        <p class="flex justify-between"><span>Tanggal:</span> <span class="text-gray-300"><?php echo date("d M Y H:i", strtotime($tanggalmasuk)); ?></span></p>
                        <p class="flex justify-between font-bold text-emerald-400 uppercase tracking-widest"><span>Jenis:</span> <span>Eceran</span></p>
                    <?php elseif ($idjenispenjualan == "2"): ?>
                        <form action="pilihmember.php" method="post" class="space-y-3">
                            <p class="flex justify-between"><span>Tanggal:</span> <span class="text-gray-300"><?php echo date("d M Y H:i", strtotime($tanggalmasuk)); ?></span></p>
                            <p class="flex justify-between font-bold text-yellow-400 uppercase"><span>Jenis:</span> <span>Grosir</span></p>
                            <p class="flex justify-between"><span>ID Member:</span> <span class="text-gray-300"><?php echo $idmember; ?></span></p>
                            <p class="flex justify-between"><span>Nama :</span> <span class="text-gray-300"><?php echo $namamember; ?></span></p>
                            <input name="notaterpilih" value="<?php echo $notaterpilih; ?>" type="hidden">
                            <button class="w-full bg-blue-600 hover:bg-blue-700 py-2 rounded-lg font-bold mt-2" type="submit">GANTI MEMBER</button>
                        </form>
                    <?php else: ?>
                        <form action="editnotapenjualan.php" method="post" class="space-y-2">
                            <p class="flex justify-between"><span>Unit Servis:</span> <span class="text-blue-300 font-bold"><?php echo $ds['merk'] . ' ' . $ds['tipe']; ?></span></p>
                            <p class="flex justify-between"><span>Pemilik:</span> <span class="text-gray-300"><?php echo $ds['nama']; ?></span></p>
                            <div class="bg-gray-800 p-3 rounded-lg border border-gray-700">
                                <span class="text-xs text-gray-500 uppercase block mb-1">Kerusakan</span>
                                <span class="text-red-400 italic"><?php echo $ds['kerusakan']; ?></span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div class="bg-gray-800 p-2 rounded"><span>Pola:</span> <span class="text-gray-300"><?php echo $ds['pola']; ?></span></div>
                                <div class="bg-gray-800 p-2 rounded"><span>PIN:</span> <span class="text-gray-300"><?php echo $ds['pin'] . ' / ' . $ds['sandi']; ?></span></div>
                            </div>
                            <input name="notaterpilih" value="<?php echo $notaterpilih; ?>" type="hidden">
                            <input name="iddataservis" value="<?php echo $iddataservis; ?>" type="hidden">
                            <?php foreach (['nama', 'merk', 'tipe', 'nohp', 'kerusakan', 'kondisi', 'pin', 'sandi', 'pola', 'alamat'] as $fld) echo "<input name='$fld' value='{$ds[$fld]}' type='hidden'>"; ?>
                            <button class="w-full bg-blue-600 hover:bg-blue-700 py-2 rounded-lg font-bold mt-4" type="submit text-xs">PERBAHARUI DATA SERVIS</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-xl border-2 border-emerald-500">
                <?php
                $st = $ds['status'];
                $act = ($st == "dikerjakan") ? "prosesservisselesaidikerjakan.php" : (($st == "diterima") ? "prosesnotapengambilan.php" : (($st == "servis dicancel") ? "proseshapusservisdicancel.php" : "print.php"));
                ?>
                <form action="<?php echo $act; ?>" method="POST" name="myform" onkeyup="calculate()" class="space-y-4">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <img src="image/<?php echo $namauser; ?>.png" onerror="this.style.display='none'" class="w-12 h-12 rounded-full border shadow-sm">
                            <div>
                                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Operator Kasir</p>
                                <input name="namauser" value="<?php echo $namauser; ?>" readonly class="font-bold text-gray-800 outline-none w-full">
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Total Tagihan</p>
                            <input name="subtotal2" value="<?php echo number_format($subtotal, 0, '', '.'); ?>" readonly class="text-3xl font-black text-emerald-600 outline-none w-full text-right bg-transparent">
                        </div>
                    </div>

                    <hr class="border-dashed">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Diskon (Rp)</label>
                            <input name="diskon" value="0" type="number" class="w-full border-2 rounded-xl p-3 focus:border-emerald-500 outline-none font-bold text-lg">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tunai / Bayar (Rp)</label>
                            <input name="tunai" id="tunai" type="number" required class="w-full border-2 border-emerald-400 rounded-xl p-3 focus:border-emerald-600 outline-none font-black text-lg bg-emerald-50">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kembalian</label>
                        <input name="kembalian" readonly type="number" class="w-full bg-gray-100 border-none rounded-xl p-3 font-black text-2xl text-red-600">
                    </div>

                    <?php if (!in_array($st, ["dikerjakan", "diterima", "servis dicancel"])): ?>
                        <div class="bg-blue-50 p-3 rounded-xl border border-blue-100">
                            <label class="text-sm font-bold text-blue-700 block mb-2">
                                Cetak Nota Fisik?
                            </label>

                            <div class="flex items-center space-x-6">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="printnota" value="1" checked
                                        class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold text-blue-800">Ya, Cetak Printer</span>
                                </label>

                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="printnota" value="0"
                                        class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold text-blue-800">Tidak, Simpan Saja</span>
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>

                    <input name="subtotal" value="<?php echo $subtotal; ?>" type="hidden">
                    <input name="notaterpilih" value="<?php echo $notaterpilih; ?>" type="hidden">
                    <input name="nonota" value="<?php echo $notaterpilih; ?>" type="hidden">
                    <input name="idjenispenjualan" value="<?php echo $idjenispenjualan; ?>" type="hidden">
                    <input name="iddataservis" value="<?php echo $iddataservis; ?>" type="hidden">
                    <input name="idmember" value="<?php echo $idmember; ?>" type="hidden">
                    <input name="alamatgrosir" value="<?php echo $alamatgrosir; ?>" type="hidden">
                    <input name="namamember" value="<?php echo $namamember; ?>" type="hidden">
                    <input name="tanggaldikerjakan" value="<?php echo date("d M Y", strtotime($tanggalmasuk)); ?>" type="hidden">
                    <?php foreach (['nama', 'merk', 'tipe', 'nohp', 'kerusakan', 'kondisi'] as $fld) echo "<input name='$fld' value='{$ds[$fld]}' type='hidden'>"; ?>

                    <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-2xl shadow-lg transition transform active:scale-95 uppercase tracking-wider" type="submit">
                        <?php
                        if ($st == "dikerjakan") echo "✓ Konfirmasi Selesai";
                        elseif ($st == "diterima") echo "⎙ Print Pengambilan";
                        elseif ($st == "servis dicancel") echo "⚠ Ambil Cancel";
                        else echo " Proses Pembayaran";
                        ?>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            // 1. Inisialisasi DataTable
            // Simpan ke variabel global agar bisa diakses jika perlu
            var table = $('#example').DataTable({
                "pageLength": 10,
                "language": {
                    "search": "Cari Nama/Kode:"
                }
            });

            // 2. Logika Tombol QTY (Plus/Minus)
            // Menggunakan delegasi pada document agar tombol tetap berfungsi setelah filter/search/paging
            $(document).on('click', '.qtyplus', function(e) {
                e.preventDefault();
                let input = $(this).siblings('input[name="qtyjual"]');
                let val = parseInt(input.val());
                if (!isNaN(val)) input.val(val + 1);
            });

            $(document).on('click', '.qtyminus', function(e) {
                e.preventDefault();
                let input = $(this).siblings('input[name="qtyjual"]');
                let val = parseInt(input.val());
                if (!isNaN(val) && val > 1) input.val(val - 1);
            });

            // 3. ================= SCANNER LOGIC (IMPROVED) =================
            let scanBuffer = "";
            let lastTime = Date.now();

            $(document).on("keydown", function(e) {
                let now = Date.now();

                // Identifikasi target: Jika fokus di input manual (tunai/diskon), jangan jalankan scanner
                const target = e.target;
                if (target.tagName === "INPUT" && target.id !== "barcodeInput") {
                    return;
                }

                // Jika jeda antar tombol > 200ms, anggap itu ketikan manusia dan reset buffer
                if (now - lastTime > 200) {
                    scanBuffer = "";
                }
                lastTime = now;

                if (e.key === "Enter") {
                    // Jika buffer berisi kode yang cukup panjang
                    if (scanBuffer.length >= 3) {
                        e.preventDefault();
                        let kodeFinal = scanBuffer;
                        scanBuffer = ""; // Langsung kosongkan buffer
                        kirimScan(kodeFinal);
                    }
                } else if (e.key.length === 1) {
                    // Masukkan karakter ke buffer
                    scanBuffer += e.key;
                }
            });

            function kirimScan(kode) {
                $.ajax({
                    url: "prosestambahbarangnotapenjualansendiri.php",
                    method: "POST",
                    data: {
                        kodebarang: kode,
                        qtyjual: 1,
                        notaterpilih: "<?= $notaterpilih ?>"
                    },
                    success: function(response) {
                        // Gunakan window.location.href untuk refresh yang lebih bersih
                        window.location.href = window.location.href;
                    },
                    error: function(xhr, status, error) {
                        console.error("Error Scan:", error);
                        alert("Barang dengan kode " + kode + " gagal diproses atau tidak ditemukan!");
                        // Kembalikan fokus ke input barcode jika gagal
                        $("#barcodeInput").focus();
                    }
                });
            }

            // 4. Auto Fokus Scanner
            // Fokus akan kembali ke input tersembunyi jika user tidak sedang mengetik di input lain
            setInterval(() => {
                const active = document.activeElement;
                if (active.tagName !== "INPUT" && active.tagName !== "TEXTAREA") {
                    $("#barcodeInput").focus();
                }
            }, 1000);
        });

        // 5. ================= HITUNG KEMBALIAN =================
        function calculate() {
            const f = document.forms.myform;
            if (!f) return;

            // Gunakan Number() untuk konversi yang lebih aman
            let sub = parseInt(f.subtotal.value) || 0;
            let disc = parseInt(f.diskon.value) || 0;
            let cash = parseInt(f.tunai.value) || 0;

            if (f.kembalian) {
                let totalHarusDibayar = sub - disc;
                f.kembalian.value = cash - totalHarusDibayar;
            }
        }
    </script>

</body>

</html>
<?php
mysqli_close($conn);
ob_end_flush();
?>