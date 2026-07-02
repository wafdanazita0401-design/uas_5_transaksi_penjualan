<?php

class Database
{
    // Properti database
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "db_transaksi_penjualan";

    // Properti koneksi
    protected $koneksi;

    // Constructor
    public function __construct()
    {
        $this->koneksi = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->koneksi->connect_error) {
            die("Koneksi database gagal : " . $this->koneksi->connect_error);
        }

        $this->koneksi->set_charset("utf8mb4");
    }

    // Mengembalikan objek koneksi
    public function getConnection()
    {
        return $this->koneksi;
    }
}