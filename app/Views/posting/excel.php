<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$title = "Laporan Posting $account->code $account->name $startDate hingga $endDate";

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', $title);
$sheet->getStyle("A1:F1")->getFont()->setBold(true);
$sheet->mergeCells("A1:F1");
$sheet->setTitle("Posting $account->name");

$sheet->getStyle("A3:F4")->getFont()->setBold(true);
$sheet->getStyle("A3:F4")->getFont()->setBold(true);
$sheet->setCellValue('A3', "Tanggal");
$sheet->mergeCells("A3:A4");

$sheet->setCellValue('B3', "Keterangan");
$sheet->mergeCells("B3:B4");

$sheet->setCellValue('C3', "Ref");
$sheet->mergeCells("C3:c4");

$sheet->setCellValue('D3', "Debit");
$sheet->mergeCells("D3:D4");

$sheet->setCellValue('E3', "Credit");
$sheet->mergeCells("E3:E4");

$sheet->setCellValue('F3', "Saldo");
$sheet->mergeCells("F3:G3");
$sheet->setCellValue('F4', "Debit");
$sheet->setCellValue('G4', "Credit");

$anchor = 5;
foreach ($items as $index => $item) {
    $sheet->setCellValue('A' . ($index + $anchor), $item->transaction_date);
    $sheet->setCellValue('B' . ($index + $anchor), $item->transaction_journal_description);
    $sheet->setCellValue('C' . ($index + $anchor), $item->getReceiptNo());
    $sheet->setCellValue('D' . ($index + $anchor), $item->debit);
    $sheet->setCellValue('E' . ($index + $anchor), $item->credit);
    $sheet->setCellValue('F' . ($index + $anchor), $item->balance_debit);
    $sheet->setCellValue('G' . ($index + $anchor), $item->balance_credit);
}

foreach ($sheet->getColumnIterator() as $column) {
    $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
}

$file_name = $title . ".xlsx";
$writer = new Xlsx($spreadsheet);
$writer->save($file_name);

header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length:' . filesize($file_name));
flush();
readfile($file_name);
exit;
