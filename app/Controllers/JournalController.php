<?php

namespace App\Controllers;

use App\Models\AdjustmentItemModel;
use App\Models\TransactionItemModel;
use Dompdf\Dompdf;


class JournalController extends BaseController
{
    public function general()
    {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(TransactionItemModel::class)->getJournal($startDate, $endDate);

        $lastDate = null;
        foreach ($items as $index => $item) {
            if ($item->transaction_date == $lastDate) {
                $items[$index]->transaction_date = null;
            } else {
                $lastDate = $item->transaction_date;
            }
        }

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        return view('journal/general', $data);
    }

    public function generalPdf()
    {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(TransactionItemModel::class)->getJournal($startDate, $endDate);

        $lastDate = null;
        foreach ($items as $index => $item) {
            if ($item->transaction_date == $lastDate) {
                $items[$index]->transaction_date = null;
            } else {
                $lastDate = $item->transaction_date;
            }
        }

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        $filename = "Jurnal Umum $startDate hingga $endDate";

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('journal/general_pdf', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function generalExcel()
    {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(TransactionItemModel::class)->getJournal($startDate, $endDate);

        $lastDate = null;
        foreach ($items as $index => $item) {
            if ($item->transaction_date == $lastDate) {
                $items[$index]->transaction_date = null;
            } else {
                $lastDate = $item->transaction_date;
            }
        }

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        return view('journal/general_excel', $data);
    }

    public function adjustment()
    {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(AdjustmentItemModel::class)->getJournal($startDate, $endDate);

        $lastDate = null;
        foreach ($items as $index => $item) {
            if ($item->transaction_date == $lastDate) {
                $items[$index]->transaction_date = null;
            } else {
                $lastDate = $item->transaction_date;
            }
        }

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalDebit' => array_sum(array_map(function ($item) { return $item->debit;}, $items)),
            'totalCredit' => array_sum(array_map(function ($item) { return $item->credit;}, $items)),
        ];

        return view('journal/adjustment', $data);
    }

    public function adjustmentPdf()
    {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(AdjustmentItemModel::class)->getJournal($startDate, $endDate);

        $lastDate = null;
        foreach ($items as $index => $item) {
            if ($item->transaction_date == $lastDate) {
                $items[$index]->transaction_date = null;
            } else {
                $lastDate = $item->transaction_date;
            }
        }

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalDebit' => array_sum(array_map(function ($item) { return $item->debit;}, $items)),
            'totalCredit' => array_sum(array_map(function ($item) { return $item->credit;}, $items)),
        ];

        $filename = "Jurnal Penyesuaian $startDate hingga $endDate";

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('journal/adjustment_pdf', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function adjustmentExcel()
    {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(AdjustmentItemModel::class)->getJournal($startDate, $endDate);

        $lastDate = null;
        foreach ($items as $index => $item) {
            if ($item->transaction_date == $lastDate) {
                $items[$index]->transaction_date = null;
            } else {
                $lastDate = $item->transaction_date;
            }
        }

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalDebit' => array_sum(array_map(function ($item) { return $item->debit;}, $items)),
            'totalCredit' => array_sum(array_map(function ($item) { return $item->credit;}, $items)),
        ];

        return view('journal/adjustment_excel', $data);
    }
}
