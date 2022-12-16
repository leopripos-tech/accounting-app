<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$title = "Jurnal Penyesuaian $startDate hingga $endDate";

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Jurnal Penyesuaian");

$sheet->setCellValue('A1', $title);
$sheet->getStyle("A1:F1")->getFont()->setBold(true);
$sheet->mergeCells("A1:F1");

$sheet->getStyle("A3:F3")->getFont()->setBold(true);
$sheet->setCellValue('A3', "Kode");
$sheet->setCellValue('B3', "Nama");
$sheet->setCellValue('C3', "Debit");
$sheet->setCellValue('D3', "Credit");

$anchor = 4;
foreach ($items as $index => $item) {
    $sheet->setCellValue('A' . ($index + $anchor), $item->account_code);
    $sheet->setCellValue('B' . ($index + $anchor), $item->account_name);
    $sheet->setCellValue('C' . ($index + $anchor), $item->debit);
    $sheet->setCellValue('D' . ($index + $anchor), $item->credit);
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
