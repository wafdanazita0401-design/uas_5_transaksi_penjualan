<?php

session_start();

if (!isset($_SESSION['id_user'])) {

    header("Location: ../auth/login.php");

    exit;
}

require_once "../../controllers/TransaksiController.php";

$controller = new TransaksiController();

$noTransaksi = $controller->generateNoTransaksi();

include "../layout/header.php";
include "../layout/sidebar.php";

?>

<div class="main-content">

    <?php include "../layout/navbar.php"; ?>

    <div class="content">

        <div class="table-card">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h3 class="fw-bold">

                        Tambah Transaksi

                    </h3>

                    <p class="text-muted mb-0">

                        Tambahkan data transaksi baru.

                    </p>

                </div>

            </div>

            <form

                action="../../controllers/TransaksiController.php"

                method="POST"

                enctype="multipart/form-data"

            >

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Nomor Transaksi

                        </label>

                        <input

                            type="text"

                            name="no_transaksi"

                            class="form-control"

                            value="<?= $noTransaksi; ?>"

                            readonly

                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Tanggal

                        </label>

                        <input

                            type="date"

                            name="tanggal"

                            class="form-control"

                            value="<?= date('Y-m-d'); ?>"

                            readonly

                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Nama Pelanggan

                        </label>

                        <input

                            type="text"

                            name="nama_pelanggan"

                            class="form-control"

                            required

                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Nama Produk

                        </label>

                        <input

                            type="text"

                            name="nama_produk"

                            class="form-control"

                            required

                        >

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Jumlah

                        </label>

                        <input

                            type="number"

                            id="jumlah"

                            name="jumlah"

                            class="form-control"

                            min="1"

                            required

                        >

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Harga Satuan

                        </label>

                        <input

                            type="number"

                            id="harga"

                            name="harga_satuan"

                            class="form-control"

                            required

                        >

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Total

                        </label>

                        <input

                            type="number"

                            id="total"

                            name="total"

                            class="form-control"

                            readonly

                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Metode Pembayaran

                        </label>

                        <select

                        id="metode_pembayaran"

                        name="metode_pembayaran"

                        class="form-select"

                        required
                    >

                            <option value="">Pilih</option>

                            <option value="Tunai">Tunai</option>

                            <option value="Transfer Bank">Transfer Bank</option>

                            <option value="QRIS">QRIS</option>

                            <option value="E-Wallet">E-Wallet</option>

                        </select>

                    </div>

                        <div id="tunaiArea" class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Bayar

                                </label>

                                <input

                                    type="number"

                                    id="bayar"

                                    name="bayar"

                                    class="form-control"

                                >

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Kembalian

                                </label>

                                <input

                                    type="number"

                                    id="kembalian"

                                    name="kembalian"

                                    class="form-control"

                                    readonly

                                >

                            </div>

                        </div>

                        <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Bukti Pembayaran

                        </label>

                        <input

                            type="file"

                            id="bukti"

                            name="bukti_pembayaran"

                            class="form-control"

                            accept="image/*"

                        >

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Status

                        </label>

                        <select

                            name="status"

                            class="form-select"

                            required

                        >

                            <option value="Berhasil">

                                Berhasil

                            </option>

                            <option value="Dibatalkan">

                                Dibatalkan

                            </option>

                        </select>

                    </div>

                </div>

                <div class="mb-4 text-center">

                    <img

                        id="preview"

                        src="../../assets/img/no-image.png"

                        class="img-thumbnail"

                        style="max-width:220px; display:none;"

                    >

                </div>

                <div class="d-flex justify-content-end gap-3">

                    <a

                        href="index.php"

                        class="btn btn-secondary"

                    >

                        <i class="bi bi-arrow-left-circle"></i>

                        Kembali

                    </a>

                    <button

                        type="submit"

                        name="tambah"

                        class="btn btn-primary"

                    >

                        <i class="bi bi-save-fill"></i>

                        Simpan Transaksi

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="../../assets/js/transaksi.js"></script>

<?php

include "../layout/footer.php";

?>

