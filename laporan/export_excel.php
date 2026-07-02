<?php
require_once __DIR__ . "/../models/Transaksi.php";

date_default_timezone_set('Asia/Jakarta');

$transaksi = new Transaksi();
$data = $transaksi->getAllTransaksi();

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_transaksi.xls");
header("Pragma: no-cache");
header("Expires: 0");

ob_start();
?>

<h2>LAPORAN TRANSAKSI PENJUALAN</h2>
<p>Tanggal Cetak: <?= date("d-m-Y H:i"); ?></p>

<table border="1">
<tr>
    <th>No</th>
    <th>No Transaksi</th>
    <th>Pelanggan</th>
    <th>Produk</th>
    <th>Qty</th>
    <th>Harga</th>
    <th>Total</th>
    <th>Pembayaran</th>
    <th>Tanggal</th>
    <th>Status</th>
</tr>

<?php
$no = 1;
$total = 0;

while($row = $data->fetch_assoc()){
?>

<tr>
    <td><?= $no++; ?></td>
    <td><?= $row['no_transaksi']; ?></td>
    <td><?= $row['nama_pelanggan']; ?></td>
    <td><?= $row['nama_produk']; ?></td>
    <td><?= $row['jumlah']; ?></td>
    <td><?= $row['harga_satuan']; ?></td>
    <td><?= $row['total']; ?></td>
    <td><?= $row['metode_pembayaran']; ?></td>
    <td><?= $row['tanggal']; ?></td>
    <td><?= $row['status']; ?></td>
</tr>

<?php
    if($row['status'] == "Berhasil") {
        $total = $total + $row['total'];
    }
}
?>

<tr>
    <td colspan="6"><b>Total</b></td>
    <td colspan="4"><b><?= $total; ?></b></td>
</tr>

</table>

<?php
$html = ob_get_clean();

/* SAVE SERVER */
$folder = __DIR__ . "/../exports/excel/";

if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

$fileServer = $folder . "Laporan_" . date("Ymd_His") . ".xls";
file_put_contents($fileServer, $html);

/* DOWNLOAD */
echo $html;
exit;
?>