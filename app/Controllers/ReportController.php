<?php

namespace App\Controllers;

use App\Models\AccountModel;
use Dompdf\Dompdf;


class ReportController extends BaseController
{
    public function revenue()
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
        $items = array_filter($items, function ($item) {
            return $item->account_code[0] == '4' || $item->account_code[0] == '5';
        });

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total_transaction_debit' => array_sum(array_map(function ($item) {
                return $item->transaction_debit;
            }, $items)),
            'total_transaction_credit' => array_sum(array_map(function ($item) {
                return $item->transaction_credit;
            }, $items)),
            'total_adjustment_debit' => array_sum(array_map(function ($item) {
                return $item->adjustment_debit;
            }, $items)),
            'total_adjustment_credit' => array_sum(array_map(function ($item) {
                return $item->adjustment_credit;
            }, $items)),
        ];

        return view('report/revenue', $data);
    }

    public function revenuePdf()
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
        $items = array_filter($items, function ($item) {
            return $item->account_code[0] == '4' || $item->account_code[0] == '5';
        });

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total_transaction_debit' => array_sum(array_map(function ($item) {
                return $item->transaction_debit;
            }, $items)),
            'total_transaction_credit' => array_sum(array_map(function ($item) {
                return $item->transaction_credit;
            }, $items)),
            'total_adjustment_debit' => array_sum(array_map(function ($item) {
                return $item->adjustment_debit;
            }, $items)),
            'total_adjustment_credit' => array_sum(array_map(function ($item) {
                return $item->adjustment_credit;
            }, $items)),
        ];

        $filename = "Laba Rugi $startDate hingga $endDate";

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('report/revenue_pdf', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function revenueExcel() {
        return $this->revenuePdf();
    }

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

        $items = model(AccountModel::class)->getWorkSheet($startDate, $endDate);
        $items = array_filter($items, function ($item) {
            return $item->account_code[0] <= '3';
        });

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total_transaction_debit' => array_sum(array_map(function ($item) {
                return $item->transaction_debit;
            }, $items)),
            'total_transaction_credit' => array_sum(array_map(function ($item) {
                return $item->transaction_credit;
            }, $items)),
            'total_adjustment_debit' => array_sum(array_map(function ($item) {
                return $item->adjustment_debit;
            }, $items)),
            'total_adjustment_credit' => array_sum(array_map(function ($item) {
                return $item->adjustment_credit;
            }, $items)),
        ];

        return view('report/balance', $data);
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

        $items = model(AccountModel::class)->getWorkSheet($startDate, $endDate);
        $items = array_filter($items, function ($item) {
            return $item->account_code[0] <= '3';
        });

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total_transaction_debit' => array_sum(array_map(function ($item) {
                return $item->transaction_debit;
            }, $items)),
            'total_transaction_credit' => array_sum(array_map(function ($item) {
                return $item->transaction_credit;
            }, $items)),
            'total_adjustment_debit' => array_sum(array_map(function ($item) {
                return $item->adjustment_debit;
            }, $items)),
            'total_adjustment_credit' => array_sum(array_map(function ($item) {
                return $item->adjustment_credit;
            }, $items)),
        ];

        $filename = "Laba Rugi $startDate hingga $endDate";

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('report/balance_pdf', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function balanceExcel() {
        return $this->balancePdf();
    }

    public function capital() {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(AccountModel::class)->getWorkSheet($startDate, $endDate);
        $items = array_filter($items, function ($item) {
            return $item->account_code[0] == '3';
        });

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total_transaction_debit' => array_sum(array_map(function ($item) {
                return $item->transaction_debit;
            }, $items)),
            'total_transaction_credit' => array_sum(array_map(function ($item) {
                return $item->transaction_credit;
            }, $items)),
            'total_adjustment_debit' => array_sum(array_map(function ($item) {
                return $item->adjustment_debit;
            }, $items)),
            'total_adjustment_credit' => array_sum(array_map(function ($item) {
                return $item->adjustment_credit;
            }, $items)),
        ];

        return view('report/capital', $data);
    }

    public function capitalPdf() {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(AccountModel::class)->getWorkSheet($startDate, $endDate);
        $items = array_filter($items, function ($item) {
            return $item->account_code[0] == '3';
        });

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total_transaction_debit' => array_sum(array_map(function ($item) {
                return $item->transaction_debit;
            }, $items)),
            'total_transaction_credit' => array_sum(array_map(function ($item) {
                return $item->transaction_credit;
            }, $items)),
            'total_adjustment_debit' => array_sum(array_map(function ($item) {
                return $item->adjustment_debit;
            }, $items)),
            'total_adjustment_credit' => array_sum(array_map(function ($item) {
                return $item->adjustment_credit;
            }, $items)),
        ];

        $filename = "Perubahan Modal $startDate hingga $endDate";

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('report/capital_pdf', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function capitalExcel() {
        return $this->capitalPdf();
    }

    public function cashflow() {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(AccountModel::class)->getWorkSheet($startDate, $endDate);
        $items = array_filter($items, function ($item) {
            return $item->account_code[0] <= '3';
        });

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total_transaction_debit' => array_sum(array_map(function ($item) {
                return $item->transaction_debit;
            }, $items)),
            'total_transaction_credit' => array_sum(array_map(function ($item) {
                return $item->transaction_credit;
            }, $items)),
            'total_adjustment_debit' => array_sum(array_map(function ($item) {
                return $item->adjustment_debit;
            }, $items)),
            'total_adjustment_credit' => array_sum(array_map(function ($item) {
                return $item->adjustment_credit;
            }, $items)),
        ];

        return view('report/cashflow', $data);
    }

    public function cashflowPdf() {
        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = model(AccountModel::class)->getWorkSheet($startDate, $endDate);
        $items = array_filter($items, function ($item) {
            return $item->account_code[0] <= '3';
        });

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total_transaction_debit' => array_sum(array_map(function ($item) {
                return $item->transaction_debit;
            }, $items)),
            'total_transaction_credit' => array_sum(array_map(function ($item) {
                return $item->transaction_credit;
            }, $items)),
            'total_adjustment_debit' => array_sum(array_map(function ($item) {
                return $item->adjustment_debit;
            }, $items)),
            'total_adjustment_credit' => array_sum(array_map(function ($item) {
                return $item->adjustment_credit;
            }, $items)),
        ];

        $filename = "Alur Kas $startDate hingga $endDate";

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('report/cashflow_pdf', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function cashflowExcel() {
        return $this->cashflowPdf();
    }
}
