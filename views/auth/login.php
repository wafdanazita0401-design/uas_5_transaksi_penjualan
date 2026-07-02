<?php

session_start();

if (isset($_SESSION['id_user'])) {
    header("Location: ../dashboard/index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | SIPEN</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/login.css">

</head>

<body>

<div class="login-container">

    <div class="login-card">

        <div class="text-center mb-4">

            <i class="bi bi-cart-check-fill logo-icon"></i>

            <h2 class="mt-3">SIPEN</h2>

            <p class="text-muted">
                Sistem Informasi Data Transaksi Penjualan
            </p>

        </div>

        <?php if (isset($_SESSION['success'])) : ?>

            <div class="alert alert-success">

                <?= $_SESSION['success']; ?>

            </div>

            <?php unset($_SESSION['success']); ?>

        <?php endif; ?>

        <?php if (isset($_SESSION['error'])) : ?>

            <div class="alert alert-danger">

                <?= $_SESSION['error']; ?>

            </div>

            <?php unset($_SESSION['error']); ?>

        <?php endif; ?>

        <form action="../../controllers/AuthController.php" method="POST">

            <div class="mb-3">

                <label class="form-label">

                    Username

                </label>

                <input
                    type="text"
                    name="username"
                    class="form-control"
                    required>

            </div>

            <div class="mb-4">

                <label class="form-label">

                    Password

                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required>

            </div>

            <button
                type="submit"
                name="login"
                class="btn btn-primary w-100">

                <i class="bi bi-box-arrow-in-right"></i>

                Login

            </button>

        </form>

        <div class="text-center mt-4">

            Belum punya akun?

            <a href="register.php">

                Daftar

            </a>

        </div>

    </div>

</div>

</body>

</html>