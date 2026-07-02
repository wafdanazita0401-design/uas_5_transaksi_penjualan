<div class="sidebar">

    <div>

        <div class="sidebar-header">

            <i class="bi bi-cart-check-fill logo-icon"></i>

            <h3>SIPEN</h3>

            <p>
                Sistem Informasi Data
                Transaksi Penjualan
            </p>

        </div>

        <?php
        $folder = basename(dirname($_SERVER['PHP_SELF']));
        ?>

        <ul class="sidebar-menu">

            <li>

                <a href="../dashboard/index.php" class="<?= ($folder == 'dashboard') ? 'active' : ''; ?>">

                    <i class="bi bi-grid-fill"></i>

                    Dashboard

                </a>

            </li>

            <li>

                <a href="../transaksi/index.php" class="<?= ($folder == 'transaksi') ? 'active' : ''; ?>">

                    <i class="bi bi-receipt"></i>

                    Transaksi

                </a>

            </li>

            <li>

                <a href="../laporan/index.php" class="<?= ($folder == 'laporan') ? 'active' : ''; ?>">

                    <i class="bi bi-file-earmark-bar-graph"></i>

                    Laporan

                </a>

            </li>

        </ul>

    </div>

    <div class="sidebar-bottom">

        <div class="user-info">

            <i class="bi bi-person-circle"></i>

            <div>

                <h6><?= htmlspecialchars($_SESSION['nama']); ?></h6>

                <span>Administrator</span>

            </div>

        </div>

        <a href="../../controllers/AuthController.php?logout=true" class="logout-btn">

            <i class="bi bi-box-arrow-right"></i>

            Logout

        </a>

    </div>

</div>