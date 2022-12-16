<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\TransactionItemModel;
use Dompdf\Dompdf;


class SheetController extends BaseController
{
    public function balance()
    {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(TransactionItemModel::class)->getBalanceSheet($startDate, $endDate);

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalDebit' => array_sum(array_map(function ($item) { return $item->debit;}, $items)),
            'totalCredit' => array_sum(array_map(function ($item) { return $item->credit;}, $items)),
        ];

        return view('sheet/balance', $data);
    }

    public function balancePdf()
    {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(TransactionItemModel::class)->getBalanceSheet($startDate, $endDate);

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalDebit' => array_sum(array_map(function ($item) { return $item->debit;}, $items)),
            'totalCredit' => array_sum(array_map(function ($item) { return $item->credit;}, $items)),
        ];

        $filename = "Neraca Saldo $startDate hingga $endDate";

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('sheet/balance_pdf', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function work()
    {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(AccountModel::class)->getWorkSheet($startDate, $endDate);

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total_transaction_debit' => array_sum(array_map(function ($item) { return $item->transaction_debit;}, $items)),
            'total_transaction_credit' => array_sum(array_map(function ($item) { return $item->transaction_credit;}, $items)),
            'total_adjustment_debit' => array_sum(array_map(function ($item) { return $item->adjustment_debit;}, $items)),
            'total_adjustment_credit' => array_sum(array_map(function ($item) { return $item->adjustment_credit;}, $items)),
        ];

        return view('sheet/work', $data);
    }

    public function workPdf()
    {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(AccountModel::class)->getWorkSheet($startDate, $endDate);

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalDebit' => array_sum(array_map(function ($item) { return $item->debit;}, $items)),
            'totalCredit' => array_sum(array_map(function ($item) { return $item->credit;}, $items)),
        ];

        $filename = "Neraca Lajur $startDate hingga $endDate";

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('sheet/work_pdf', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }
}
