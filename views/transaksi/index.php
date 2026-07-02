<?php

session_start();

if (!isset($_SESSION['id_user'])) {

    header("Location: ../auth/login.php");

    exit;

}

require_once "../../controllers/TransaksiController.php";

$controller = new TransaksiController();

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {

    $dataTransaksi = $controller->cari(trim($_GET['search']));

} else {

    $dataTransaksi = $controller->index();

}

include "../layout/header.php";
include "../layout/sidebar.php";

?>

<div class="main-content">

    <?php include "../layout/navbar.php"; ?>

    <div class="content">

        <div class="table-card">

            <div class="toolbar">

                <form method="GET" class="search-box">

                    <i class="bi bi-search"></i>

                    <input

                        type="text"

                        name="search"

                        placeholder="Cari nomor transaksi, pelanggan atau produk..."

                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"

                    >

                </form>

                <div class="toolbar-button">

                    <a href="tambah.php" class="btn-add">

                        <i class="bi bi-plus-circle-fill"></i>

                        Tambah

                    </a>

                    <a href="../../laporan/export_pdf.php" class="btn-pdf">

                        <i class="bi bi-file-earmark-pdf-fill"></i>

                        PDF

                    </a>

                    <a href="../../laporan/export_excel.php" class="btn-excel">

                        <i class="bi bi-file-earmark-excel-fill"></i>

                        Excel

                    </a>

                </div>

            </div>

            <?php if(isset($_SESSION['success'])) : ?>

                <script>

                document.addEventListener("DOMContentLoaded", function(){

                    Swal.fire({

                        icon: "success",

                        title: "Berhasil",

                        text: "<?= $_SESSION['success']; ?>",

                        confirmButtonColor: "#ff5c96"

                    });

                });

                </script>

                <?php unset($_SESSION['success']); ?>

            <?php endif; ?>

            <?php if(isset($_SESSION['error'])) : ?>

                <script>

                document.addEventListener("DOMContentLoaded", function(){

                    Swal.fire({

                        icon: "error",

                        title: "Oops...",

                        text: "<?= $_SESSION['error']; ?>",

                        confirmButtonColor: "#ff5c96"

                    });

                });

                </script>

                <?php unset($_SESSION['error']); ?>

            <?php endif; ?>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="60">No</th>

                            <th>No Transaksi</th>

                            <th>Nama Pelanggan</th>

                            <th>Nama Produk</th>

                            <th>Total</th>

                            <th>Tanggal</th>

                            <th>Status</th>

                            <th>Bukti</th>

                            <th class="aksi-column">

                                Aksi

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    if($dataTransaksi->num_rows > 0) :

                    $no = 1;

                    while($row = $dataTransaksi->fetch_assoc()) :

                    ?>

                    <tr>

                        <td><?= $no++; ?></td>

                        <td>

                            <a

                                href="detail.php?id=<?= $row['id']; ?>"

                                class="fw-bold text-decoration-none"

                            >

                                <?= htmlspecialchars($row['no_transaksi']); ?>

                            </a>

                        </td>

                        <td><?= htmlspecialchars($row['nama_pelanggan']); ?></td>

                        <td><?= htmlspecialchars($row['nama_produk']); ?></td>

                        <td class="fw-semibold text-primary">

                            Rp <?= number_format($row['total'],0,",","."); ?>

                        </td>

                        <td>

                            <?= date("d-m-Y", strtotime($row['tanggal'])); ?>

                        </td>

                        <td>

                            <?php if($row['status']=="Berhasil") : ?>

                                <span class="badge bg-success">

                                    Berhasil

                                </span>

                            <?php else : ?>

                                <span class="badge bg-danger">

                                    Dibatalkan

                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <?php if(!empty($row['bukti_pembayaran'])) : ?>

                                <img

                                    src="../../assets/uploads/bukti_pembayaran/<?= htmlspecialchars($row['bukti_pembayaran']); ?>"

                                    width="55"

                                    class="rounded shadow-sm"

                                >

                            <?php else : ?>

                                <span class="text-muted">

                                    -

                                </span>

                            <?php endif; ?>

                        </td>

                        <td class="aksi-column">

                            <div class="aksi-button">

                                <a

                                    href="detail.php?id=<?= $row['id']; ?>"

                                    class="btn-detail"

                                    title="Detail"

                                >

                                    <i class="bi bi-eye-fill"></i>

                                </a>

                                <a

                                    href="edit.php?id=<?= $row['id']; ?>"

                                    class="btn-edit"

                                    title="Edit"

                                >

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <a

                                    href="../../controllers/TransaksiController.php?hapus=<?= $row['id']; ?>"

                                    class="btn-delete"

                                    title="Hapus"

                                >

                                    <i class="bi bi-trash-fill"></i>

                                </a>

                            </div>

                        </td>

                    </tr>

                    <?php

                    endwhile;

                    else :

                    ?>

                    <tr>

                        <td colspan="9" class="text-center py-5">

                            <i class="bi bi-inbox fs-1 text-secondary"></i>

                            <br><br>

                            Belum ada data transaksi.

                        </td>

                    </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php

include "../layout/footer.php";

?>