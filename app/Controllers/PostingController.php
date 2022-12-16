<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\TransactionItemModel;
use Dompdf\Dompdf;


class PostingController extends BaseController
{
    private $model;

    function __construct()
    {
        $this->model = new TransactionItemModel();
    }

    public function index()
    {
        $accounts = model(AccountModel::class)->where(['level' => 2])->findAll();

        $accountId = $this->request->getGet('account_id');
        if (empty($accountId)) {
            $accountId = $accounts[0]->id;
        }

        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = $this->model->getPosting($accountId, $startDate, $endDate);

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
            'accounts' => $accounts,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        return view('posting/index', $data);
    }

    public function downloadPdf()
    {
        $accounts = model(AccountModel::class)->where(['level' => 2])->findAll();

        $accountId = $this->request->getGet('account_id');
        if (empty($accountId)) {
            $accountId = $accounts[0]->id;
        }

        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = $this->model->getPosting($accountId, $startDate, $endDate);

        $lastDate = null;
        foreach ($items as $index => $item) {
            if ($item->transaction_date == $lastDate) {
                $items[$index]->transaction_date = null;
            } else {
                $lastDate = $item->transaction_date;
            }
        }

        $account = model(AccountModel::class)->find($accountId);

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'account' => $account,
        ];

        $filename = "Posting $account->code $account->name $startDate hingga $endDate";

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('posting/pdf', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function downloadExcel()
    {
        $accounts = model(AccountModel::class)->where(['level' => 2])->findAll();

        $accountId = $this->request->getGet('account_id');
        if (empty($accountId)) {
            $accountId = $accounts[0]->id;
        }

        $startDate = $this->request->getGet('startDate');
        if (empty($startDate)) {
            $startDate = date('Y-01-01');
        }

        $endDate = $this->request->getGet('endDate');
        if (empty($endDate)) {
            $endDate = date('Y-m-t');
        }

        $items = $this->model->getPosting($accountId, $startDate, $endDate);

        $lastDate = null;
        foreach ($items as $index => $item) {
            if ($item->transaction_date == $lastDate) {
                $items[$index]->transaction_date = null;
            } else {
                $lastDate = $item->transaction_date;
            }
        }

        $account = model(AccountModel::class)->find($accountId);

        $data = [
            'items' => $items,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'account' => $account,
        ];

        return view('posting/excel', $data);
    }
}
