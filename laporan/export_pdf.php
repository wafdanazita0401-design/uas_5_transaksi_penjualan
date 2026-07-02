<?php
session_start();

require_once __DIR__ . "/../fpdf/fpdf186/fpdf.php";
require_once __DIR__ . "/../models/Transaksi.php";

date_default_timezone_set('Asia/Jakarta');

$transaksi = new Transaksi();
$data = $transaksi->getAllTransaksi();

/* bikin PDF */
$pdf = new FPDF("L","mm","A4");
$pdf->AddPage();

$pdf->SetFont("Arial","B",16);
$pdf->Cell(0,10,"LAPORAN TRANSAKSI PENJUALAN",0,1,"C");

$pdf->SetFont("Arial","",11);
$pdf->Cell(0,8,"Tanggal Cetak: ".date("d-m-Y H:i"),0,1,"C");
$pdf->Ln(5);

/* header */
$pdf->SetFont("Arial","B",10);
$pdf->Cell(10,10,"No",1);
$pdf->Cell(30,10,"No Transaksi",1);
$pdf->Cell(40,10,"Pelanggan",1);
$pdf->Cell(40,10,"Produk",1);
$pdf->Cell(15,10,"Qty",1,0,"C");
$pdf->Cell(30,10,"Harga",1);
$pdf->Cell(30,10,"Total",1);
$pdf->Cell(35,10,"Pembayaran",1);
$pdf->Cell(25,10,"Tanggal",1);
$pdf->Cell(25,10,"Status",1,1,"C");

$pdf->SetFont("Arial","",9);

$total = 0;

while($row = $data->fetch_assoc()){

    $pdf->Cell(10,9,"",1); // dummy biar simple
    $pdf->Cell(30,9,$row['no_transaksi'],1);
    $pdf->Cell(40,9,$row['nama_pelanggan'],1);
    $pdf->Cell(40,9,$row['nama_produk'],1);
    $pdf->Cell(15,9,$row['jumlah'],1);
    $pdf->Cell(30,9,$row['harga_satuan'],1);
    $pdf->Cell(30,9,$row['total'],1);
    $pdf->Cell(35,9,$row['metode_pembayaran'],1);
    $pdf->Cell(25,9,$row['tanggal'],1);
    $pdf->Cell(25,9,$row['status'],1,1);

    if($row['status']=="Berhasil"){
        $total += $row['total'];
    }
}

/* total */
$pdf->Cell(180,10,"TOTAL",1);
$pdf->Cell(90,10,$total,1,1);

/* 1. SIMPAN KE SERVER */

$folder = __DIR__ . "/../exports/pdf/";

if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

$fileServer = $folder . "Laporan_" . date("Ymd_His") . ".pdf";
$pdf->Output("F", $fileServer);

/* 2. DOWNLOAD KE BROWSER */

$pdf->Output("D", "Laporan_Transaksi.pdf");
exit;
?>