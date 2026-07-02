<?php

session_start();

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private User $user;

    // Constructor
    public function __construct()
    {
        $this->user = new User();
    }

    // Login
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            header('Location: ../views/auth/login.php');
            exit;

        }

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $hasil = $this->user->login(
            $username,
            $password
        );

        if ($hasil['status']) {

            $_SESSION['id_user'] = $hasil['data']['id'];
            $_SESSION['nama'] = $hasil['data']['nama'];
            $_SESSION['username'] = $hasil['data']['username'];

            header('Location: ../views/dashboard/index.php');
            exit;

        }

        $_SESSION['error'] = $hasil['pesan'];

        header('Location: ../views/auth/login.php');
        exit;
    }

    // Register
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            header('Location: ../views/auth/register.php');
            exit;

        }

        $nama = trim($_POST['nama_lengkap']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $konfirmasiPassword = trim($_POST['konfirmasi_password']);

        if (
            empty($nama) ||
            empty($username) ||
            empty($password) ||
            empty($konfirmasiPassword)
        ) {

            $_SESSION['error'] = 'Semua data wajib diisi.';

            header('Location: ../views/auth/register.php');
            exit;

        }

        if ($password !== $konfirmasiPassword) {

            $_SESSION['error'] = 'Konfirmasi password tidak sama.';

            header('Location: ../views/auth/register.php');
            exit;

        }

        $hasil = $this->user->register(

            $nama,

            $username,

            $password

        );

        if ($hasil['status']) {

            $_SESSION['success'] = $hasil['pesan'];

            header('Location: ../views/auth/login.php');
            exit;

        }

        $_SESSION['error'] = $hasil['pesan'];

        header('Location: ../views/auth/register.php');
        exit;
    }

    // Logout
    public function logout()
    {
        session_unset();

        session_destroy();

        header('Location: ../views/auth/login.php');
        exit;
    }
}

// Routing

$authController = new AuthController();

if (isset($_POST['login'])) {

    $authController->login();

}

if (isset($_POST['register'])) {

    $authController->register();

}

if (isset($_GET['logout'])) {

    $authController->logout();

}