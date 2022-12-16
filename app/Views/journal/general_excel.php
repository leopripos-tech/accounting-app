<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$title = "Jurnal Umum $startDate hingga $endDate";

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', $title);
$sheet->getStyle("A1:F1")->getFont()->setBold(true);
$sheet->mergeCells("A1:F1");
$sheet->setTitle("Jurnal Umum");

$sheet->getStyle("A3:F3")->getFont()->setBold(true);
$sheet->setCellValue('A3', "Tanggal");
$sheet->setCellValue('B3', "Akun");
$sheet->setCellValue('C3', "Ref");
$sheet->setCellValue('D3', "Keterangan");
$sheet->setCellValue('E3', "Debit");
$sheet->setCellValue('F3', "Credit");

$anchor = 4;
foreach ($items as $index => $item) {
    $sheet->setCellValue('A' . ($index + $anchor), $item->transaction_date);
    $sheet->setCellValue('B' . ($index + $anchor), $item->account_name);
    $sheet->setCellValue('C' . ($index + $anchor), $item->getReceiptNo());
    $sheet->setCellValue('D' . ($index + $anchor), $item->transaction_journal_description);
    $sheet->setCellValue('E' . ($index + $anchor), $item->debit);
    $sheet->setCellValue('F' . ($index + $anchor), $item->credit);
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
