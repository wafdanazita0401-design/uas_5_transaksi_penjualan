<?php

require_once __DIR__ . '/../config/Database.php';

class User extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function cekUsername($username)
    {
        $query = "SELECT id FROM users WHERE username = ?";

        $statement = $this->koneksi->prepare($query);

        $statement->bind_param("s", $username);

        $statement->execute();

        $hasil = $statement->get_result();

        return $hasil->num_rows > 0;
    }

    public function register($nama, $username, $password)
    {
        if ($this->cekUsername($username)) {

            return [
                "status" => false,
                "pesan" => "Username sudah digunakan."
            ];

        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users
                  (
                    nama,
                    username,
                    password
                  )
                  VALUES
                  (
                    ?,
                    ?,
                    ?
                  )";

        $statement = $this->koneksi->prepare($query);

        $statement->bind_param(

            "sss",

            $nama,

            $username,

            $passwordHash

        );

        if ($statement->execute()) {

            return [

                "status" => true,

                "pesan" => "Registrasi berhasil."

            ];

        }

        return [

            "status" => false,

            "pesan" => "Registrasi gagal."

        ];
    }

    public function login($username, $password)
    {
        $query = "SELECT * FROM users WHERE username = ?";

        $statement = $this->koneksi->prepare($query);

        $statement->bind_param("s", $username);

        $statement->execute();

        $hasil = $statement->get_result();

        if ($hasil->num_rows == 1) {

            $user = $hasil->fetch_assoc();

            if (password_verify($password, $user['password'])) {

                return [

                    "status" => true,

                    "data" => $user

                ];

            }

        }

        return [

            "status" => false,

            "pesan" => "Username atau password salah."

        ];
    }
}