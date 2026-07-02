<?php

session_start();

if (isset($_SESSION['id_user'])) {
    header("Location: views/dashboard/index.php");
    exit;
}

header("Location: views/auth/login.php");
exit;