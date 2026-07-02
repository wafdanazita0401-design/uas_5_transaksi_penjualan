<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../models/Transaksi.php';

class TransaksiController
{
    private Transaksi $transaksi;

    // Constructor
    public function __construct()
    {
        $this->transaksi = new Transaksi();
    }

    // Menampilkan semua transaksi
    public function index()
    {
        return $this->transaksi->getAllTransaksi();
    }

    // Detail transaksi
    public function detail($id)
    {
        return $this->transaksi->getTransaksiById($id);
    }

    // Nomor transaksi otomatis
    public function generateNoTransaksi()
    {
        return $this->transaksi->generateNoTransaksi();
    }

    // Statistik
    public function totalTransaksi()
    {
        return $this->transaksi->totalTransaksi();
    }

    public function totalPendapatan()
    {
        return $this->transaksi->totalPendapatan();
    }

    public function totalProduk()
    {
        return $this->transaksi->totalProduk();
    }

    public function transaksiHariIni()
    {
        return $this->transaksi->transaksiHariIni();
    }

    public function pendapatanHariIni()
    {
        return $this->transaksi->pendapatanHariIni();
    }

    // Search
    public function cari($keyword)
    {
        return $this->transaksi->cariTransaksi($keyword);
    }

    // Upload gambar
    private function uploadBukti()
    {
        if ($_FILES['bukti_pembayaran']['error'] == 4) {
            return "";
        }

        $namaFile = time() . "_" . basename($_FILES['bukti_pembayaran']['name']);

        $tujuan = "../assets/uploads/bukti_pembayaran/" . $namaFile;

        move_uploaded_file(
            $_FILES['bukti_pembayaran']['tmp_name'],
            $tujuan
        );

        return $namaFile;
    }

    // Tambah transaksi
    public function tambah()
    {
        $metode = $_POST['metode_pembayaran'];

        $total = $_POST['total'];

        if ($metode == "Tunai") {

            $bayar = $_POST['bayar'];

            if ($bayar < $total) {

                $_SESSION['error'] = "Nominal pembayaran kurang.";

                header("Location: ../views/transaksi/tambah.php");

                exit;
            }

            $kembalian = $bayar - $total;

        } else {

            $bayar = $total;

            $kembalian = 0;

        }

        $bukti = $this->uploadBukti();

        $hasil = $this->transaksi->tambahTransaksi(

            $_POST['no_transaksi'],

            $_POST['nama_pelanggan'],

            $_POST['nama_produk'],

            $_POST['jumlah'],

            $_POST['harga_satuan'],

            $total,

            $metode,

            $bayar,

            $kembalian,

            $_POST['tanggal'],

            $bukti,

            $_POST['status']

        );

        if ($hasil) {

            $_SESSION['success'] = "Transaksi berhasil ditambahkan.";

        } else {

            $_SESSION['error'] = "Transaksi gagal ditambahkan.";

        }

        header("Location: ../views/transaksi/index.php");

        exit;
    }

    // Edit transaksi
    public function edit()
    {
        $dataLama = $this->transaksi->getTransaksiById($_POST['id']);

        $bukti = $dataLama['bukti_pembayaran'];

        if ($_FILES['bukti_pembayaran']['error'] != 4) {

            if (
                !empty($bukti)
                &&
                file_exists("../assets/uploads/bukti_pembayaran/" . $bukti)
            ) {

                unlink("../assets/uploads/bukti_pembayaran/" . $bukti);

            }

            $bukti = $this->uploadBukti();
        }

        $metode = $_POST['metode_pembayaran'];

        $total = $_POST['total'];

        if ($metode == "Tunai") {

            $bayar = $_POST['bayar'];

            if ($bayar < $total) {

                $_SESSION['error'] = "Nominal pembayaran kurang.";

                header("Location: ../views/transaksi/edit.php?id=" . $_POST['id']);

                exit;
            }

            $kembalian = $bayar - $total;

        } else {

            $bayar = $total;

            $kembalian = 0;

        }

        $hasil = $this->transaksi->editTransaksi(

            $_POST['id'],

            $_POST['nama_pelanggan'],

            $_POST['nama_produk'],

            $_POST['jumlah'],

            $_POST['harga_satuan'],

            $total,

            $metode,

            $bayar,

            $kembalian,

            $_POST['tanggal'],

            $bukti,

            $_POST['status']

        );

        if ($hasil) {

            $_SESSION['success'] = "Transaksi berhasil diubah.";

        } else {

            $_SESSION['error'] = "Transaksi gagal diubah.";

        }

        header("Location: ../views/transaksi/index.php");

        exit;
    }

    // Hapus transaksi
    public function hapus($id)
    {
        $data = $this->transaksi->getTransaksiById($id);

        if (
            !empty($data['bukti_pembayaran'])
            &&
            file_exists("../assets/uploads/bukti_pembayaran/" . $data['bukti_pembayaran'])
        ) {

            unlink("../assets/uploads/bukti_pembayaran/" . $data['bukti_pembayaran']);

        }

        $hasil = $this->transaksi->hapusTransaksi($id);

        if ($hasil) {

            $_SESSION['success'] = "Transaksi berhasil dihapus.";

        } else {

            $_SESSION['error'] = "Transaksi gagal dihapus.";

        }

        header("Location: ../views/transaksi/index.php");

        exit;
    }
}

// Routing

$controller = new TransaksiController();

if (isset($_POST['tambah'])) {

    $controller->tambah();

}
elseif (isset($_POST['edit'])) {

    $controller->edit();

}
elseif (isset($_GET['hapus'])) {

    $controller->hapus($_GET['hapus']);

}