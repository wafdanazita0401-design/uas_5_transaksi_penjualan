<?php

session_start();

if (!isset($_SESSION['id_user'])) {

    header("Location: ../auth/login.php");

    exit;

}

require_once "../../controllers/TransaksiController.php";

$controller = new TransaksiController();

if (!isset($_GET['id'])) {

    header("Location: index.php");

    exit;

}

$data = $controller->detail($_GET['id']);

include "../layout/header.php";
include "../layout/sidebar.php";

?>

<div class="main-content">

<?php include "../layout/navbar.php"; ?>

<div class="content">

<div class="table-card">

<h3 class="mb-4 fw-bold">

Edit Transaksi

</h3>

<form
action="../../controllers/TransaksiController.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id"
value="<?= $data['id']; ?>">

<input
type="hidden"
name="bukti_lama"
value="<?= $data['bukti_pembayaran']; ?>">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

No Transaksi

</label>

<input
type="text"
class="form-control"
value="<?= $data['no_transaksi']; ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Tanggal

</label>

<input
type="date"
name="tanggal"
class="form-control"
value="<?= $data['tanggal']; ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Nama Pelanggan

</label>

<input
type="text"
name="nama_pelanggan"
class="form-control"
value="<?= htmlspecialchars($data['nama_pelanggan']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Nama Produk

</label>

<input
type="text"
name="nama_produk"
class="form-control"
value="<?= htmlspecialchars($data['nama_produk']); ?>">

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
value="<?= $data['jumlah']; ?>">

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
value="<?= $data['harga_satuan']; ?>">

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
value="<?= $data['total']; ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Metode Pembayaran

</label>

<select
id="metode"
name="metode_pembayaran"
class="form-select">

<option <?= $data['metode_pembayaran']=="Tunai"?"selected":""; ?>>

Tunai

</option>

<option <?= $data['metode_pembayaran']=="Transfer Bank"?"selected":""; ?>>

Transfer Bank

</option>

<option <?= $data['metode_pembayaran']=="QRIS"?"selected":""; ?>>

QRIS

</option>

<option <?= $data['metode_pembayaran']=="E-Wallet"?"selected":""; ?>>

E-Wallet

</option>

</select>

</div>

<div class="col-md-3 mb-3">

<label class="form-label">

Bayar

</label>

<input
type="number"
id="bayar"
name="bayar"
class="form-control"
value="<?= $data['bayar']; ?>">

</div>

<div class="col-md-3 mb-3">

<label class="form-label">

Kembalian

</label>

<input
type="number"
id="kembalian"
name="kembalian"
class="form-control"
value="<?= $data['kembalian']; ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Bukti Pembayaran

</label>

<input
type="file"
id="bukti"
name="bukti_pembayaran"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Status

</label>

<select
name="status"
class="form-select">

<option <?= $data['status']=="Berhasil"?"selected":""; ?>>

Berhasil

</option>

<option <?= $data['status']=="Dibatalkan"?"selected":""; ?>>

Dibatalkan

</option>

</select>

</div>

</div>

<div class="mb-4 text-center">

<?php

if(!empty($data['bukti_pembayaran'])){

?>

<img
id="preview"
src="../../assets/uploads/bukti_pembayaran/<?= $data['bukti_pembayaran']; ?>"
class="img-thumbnail"
style="max-width:220px;">

<?php

}else{

?>

<img
id="preview"
src="../../assets/images/no-image.png"
class="img-thumbnail"
style="max-width:220px;">

<?php

}

?>

</div>

<div class="d-flex justify-content-end gap-2">

<a
href="index.php"
class="btn btn-secondary">

Kembali

</a>

<button
type="submit"
name="edit"
class="btn btn-warning">

Update Transaksi

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