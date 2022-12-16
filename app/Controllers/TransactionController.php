<?php

namespace App\Controllers;

use App\Entities\TransactionEntity;
use App\Entities\TransactionItemEntity;
use App\Models\AccountModel;
use App\Models\TransactionItemModel;
use App\Models\TransactionModel;
use App\Models\TransactionStatusModel;
use CodeIgniter\Database\Exceptions\DataException;

class TransactionController extends BaseController
{
    private $model;

    function __construct()
    {
        $this->model = new TransactionModel();
    }

    public function index()
    {
        $data = [
            'transactions' => $this->model->orderBy('date ASC')->findAll(),
        ];

        return view('transaction/index', $data);
    }

    public function create()
    {
        $transaction = new TransactionEntity();
        $accounts = model(AccountModel::class)->withFullDetail()->where(['accounts.level' => 2])->findAll();

        $statuses = model(TransactionStatusModel::class)->findAll();

        $transaction->date = date("Y-m-d");

        if ($this->isPost()) {
            $transaction->date = $this->request->getVar("date");
            $transaction->description = $this->request->getVar("description");
            $transaction->journal_description = $this->request->getVar("journal_description");

            $this->model->save($transaction);

            $accountIds = $this->request->getVar("account_id");
            $credits = $this->request->getVar("credit");
            $debits = $this->request->getVar("debit");
            $statusIds = $this->request->getVar("status_id");

            $itemModel = model(TransactionItemModel::class);
            foreach ($accountIds as $index => $accountId) {
                $item = new TransactionItemEntity();
                $item->transaction_id = $this->model->getInsertID();
                $item->account_id = $accountIds[$index];
                $item->credit = $credits[$index];
                $item->debit = $debits[$index];
                $item->status_id = $statusIds[$index];

                $itemModel->save($item);
            }

            return redirect("transactions")
                ->with('success', "Transaksi $transaction->id berhasil ditambahkan.");
        }

        $data = [
            'transaction' => $transaction,
            'accounts' => $accounts,
            'statuses' => $statuses,
            'items' => [[]],
        ];

        return view('transaction/create', $data);
    }

    public function view($id)
    {
        $transaction = $this->model->find($id);

        if (is_null($transaction)) {
            return $this->notFound();
        }

        $items = model(TransactionItemModel::class)->where(['transaction_id' => $id])
            ->join('transaction_statuses', 'transaction_items.status_id = transaction_statuses.id')
            ->join('accounts', 'transaction_items.account_id = accounts.id')
            ->select(['*', 'accounts.code as account_code', 'accounts.name as account_name', 'transaction_statuses.name as status_name'])
            ->findAll();


        $data = [
            'transaction' => $transaction,
            'items' => $items,
        ];

        return view('transaction/view', $data);
    }

    public function update($id)
    {
        $transaction = $this->model->find($id);

        if (is_null($transaction)) {
            return $this->notFound();
        }

        $itemModel = model(TransactionItemModel::class);

        $accounts = model(AccountModel::class)->withFullDetail()->where(['accounts.level' => 2])->findAll();
        $statuses = model(TransactionStatusModel::class)->findAll();
        $items = $itemModel->where(['transaction_id' => $id])->findAll();

        if ($this->isPost()) {
            $transaction->date = $this->request->getVar("date");
            $transaction->description = $this->request->getVar("description");
            $transaction->journal_description = $this->request->getVar("journal_description");

            try {
                $this->model->save($transaction);
            } catch (DataException $e) {}

            $itemIds = $this->request->getVar("id");
            $accountIds = $this->request->getVar("account_id");
            $credits = $this->request->getVar("credit");
            $debits = $this->request->getVar("debit");
            $statusIds = $this->request->getVar("status_id");

            $keptIds = array_filter($itemIds, function ($item) {
                return !empty($item);
            });
            $itemModel->where(['transaction_id' => $id])
                ->whereNotIn('id', empty($keptIds) ? ['-1'] : $keptIds)
                ->delete();

            foreach ($accountIds as $index => $accountId) {
                $item = new TransactionItemEntity();
                $item->id = $itemIds[$index];
                $item->transaction_id = $transaction->id;
                $item->account_id = $accountIds[$index];
                $item->credit = $credits[$index];
                $item->debit = $debits[$index];
                $item->status_id = $statusIds[$index];

                $itemModel->save($item);
            }

            return redirect()->to(site_url(['transactions', $id]))
                ->with('success', "Transaksi $transaction->receipt_no berhasil diperbaharui.");
        }

        $data = [
            'transaction' => $transaction,
            'accounts' => $accounts,
            'statuses' => $statuses,
            'items' => $items,
        ];

        return view('transaction/update', $data);
    }

    public function delete($id)
    {
        $this->model->delete($id);

        return redirect("transactions")
            ->with('success', "Transaksi berhasil dihapus.");
    }
}
