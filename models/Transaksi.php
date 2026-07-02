<?php

require_once __DIR__ . '/../config/Database.php';

class Transaksi extends Database
{
    // Constructor
    public function __construct()
    {
        parent::__construct();
    }

    // Menampilkan semua transaksi
    public function getAllTransaksi()
    {
        $query = "SELECT *
                  FROM transaksi
                  ORDER BY id DESC";

        return $this->koneksi->query($query);
    }

    // Menampilkan transaksi berdasarkan ID
    public function getTransaksiById($id)
    {
        $query = "SELECT *
                  FROM transaksi
                  WHERE id = ?";

        $statement = $this->koneksi->prepare($query);

        $statement->bind_param("i", $id);

        $statement->execute();

        return $statement->get_result()->fetch_assoc();
    }

    // Membuat nomor transaksi otomatis
    public function generateNoTransaksi()
    {
        $query = "SELECT MAX(id) AS id_terakhir
                  FROM transaksi";

        $hasil = $this->koneksi->query($query);

        $data = $hasil->fetch_assoc();

        $idBaru = ($data['id_terakhir'] ?? 384) + 1;

        return "TRX" . $idBaru;
    }

    // Menambah transaksi
    public function tambahTransaksi(
        $noTransaksi,
        $namaPelanggan,
        $namaProduk,
        $jumlah,
        $hargaSatuan,
        $total,
        $metodePembayaran,
        $bayar,
        $kembalian,
        $tanggal,
        $buktiPembayaran,
        $status
    ) {

        $query = "INSERT INTO transaksi
        (
            no_transaksi,
            nama_pelanggan,
            nama_produk,
            jumlah,
            harga_satuan,
            total,
            metode_pembayaran,
            bayar,
            kembalian,
            tanggal,
            bukti_pembayaran,
            status
        )

        VALUES

        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $statement = $this->koneksi->prepare($query);

        $statement->bind_param(

            "sssiddsddsss",

            $noTransaksi,
            $namaPelanggan,
            $namaProduk,
            $jumlah,
            $hargaSatuan,
            $total,
            $metodePembayaran,
            $bayar,
            $kembalian,
            $tanggal,
            $buktiPembayaran,
            $status

        );

        return $statement->execute();
    }

    // Mengubah transaksi
    public function editTransaksi(
        $id,
        $namaPelanggan,
        $namaProduk,
        $jumlah,
        $hargaSatuan,
        $total,
        $metodePembayaran,
        $bayar,
        $kembalian,
        $tanggal,
        $buktiPembayaran,
        $status
    ) {

        $query = "UPDATE transaksi SET

                    nama_pelanggan = ?,
                    nama_produk = ?,
                    jumlah = ?,
                    harga_satuan = ?,
                    total = ?,
                    metode_pembayaran = ?,
                    bayar = ?,
                    kembalian = ?,
                    tanggal = ?,
                    bukti_pembayaran = ?,
                    status = ?

                  WHERE id = ?";

        $statement = $this->koneksi->prepare($query);

        $statement->bind_param(

            "ssiddsddsssi",

            $namaPelanggan,
            $namaProduk,
            $jumlah,
            $hargaSatuan,
            $total,
            $metodePembayaran,
            $bayar,
            $kembalian,
            $tanggal,
            $buktiPembayaran,
            $status,
            $id

        );

        return $statement->execute();
    }

    // Menghapus transaksi
    public function hapusTransaksi($id)
    {
        $query = "DELETE
                  FROM transaksi
                  WHERE id = ?";

        $statement = $this->koneksi->prepare($query);

        $statement->bind_param("i", $id);

        return $statement->execute();
    }

    // Mencari transaksi
    public function cariTransaksi($keyword)
    {
        $keyword = "%" . $keyword . "%";

        $query = "SELECT *

                  FROM transaksi

                  WHERE

                  no_transaksi LIKE ?

                  OR nama_pelanggan LIKE ?

                  OR nama_produk LIKE ?

                  ORDER BY id DESC";

        $statement = $this->koneksi->prepare($query);

        $statement->bind_param(

            "sss",

            $keyword,
            $keyword,
            $keyword

        );

        $statement->execute();

        return $statement->get_result();
    }

    // Total transaksi
    public function totalTransaksi()
    {
        $query = "SELECT COUNT(*) AS total
                  FROM transaksi";

        $hasil = $this->koneksi->query($query);

        return $hasil->fetch_assoc()['total'];
    }

    // Total pendapatan
    public function totalPendapatan()
    {
        $query = "SELECT SUM(total) AS total
                  FROM transaksi
                  WHERE status = 'Berhasil'";

        $hasil = $this->koneksi->query($query);

        return $hasil->fetch_assoc()['total'] ?? 0;
    }

    // Total produk terjual
    public function totalProduk()
    {
        $query = "SELECT SUM(jumlah) AS total
                  FROM transaksi
                  WHERE status = 'Berhasil'";

        $hasil = $this->koneksi->query($query);

        return $hasil->fetch_assoc()['total'] ?? 0;
    }

    // Transaksi hari ini
    public function transaksiHariIni()
    {
        $query = "SELECT COUNT(*) AS total
                  FROM transaksi
                  WHERE tanggal = CURDATE()";

        $hasil = $this->koneksi->query($query);

        return $hasil->fetch_assoc()['total'];
    }

    // Pendapatan hari ini
    public function pendapatanHariIni()
    {
        $query = "SELECT SUM(total) AS total
                  FROM transaksi
                  WHERE tanggal = CURDATE()
                  AND status = 'Berhasil'";

        $hasil = $this->koneksi->query($query);

        return $hasil->fetch_assoc()['total'] ?? 0;
    }
}