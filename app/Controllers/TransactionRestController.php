<?php

namespace App\Controllers;

use App\Entities\TransactionEntity;
use App\Entities\TransactionItemEntity;
use App\Models\TransactionItemModel;
use App\Models\TransactionModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\RESTful\ResourceController;

class TransactionRestController extends ResourceController
{
    protected $model;

    function __construct()
    {
        $this->model = new TransactionModel();
    }

    public function index()
    {
        $data = [
            'transactions' => $this->model->orderBy('date ASC')->findAll(),
        ];

        return $this->respond($data);
    }

    public function create()
    {
        $transaction = new TransactionEntity();
        $transaction->date = date("Y-m-d");

        $items = [];

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

            $items[] = $item;
        }

        $data = [
            'transaction' => $transaction,
            'items' => $items
        ];

        return $this->respond($data);
    }

    public function show($id = null)
    {
        $transaction = $this->model->find($id);

        if (is_null($transaction)) {
            return $this->failNotFound();
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

        return $this->respond($data);
    }

    public function update($id = null)
    {
        $transaction = $this->model->find($id);
        $items = [];

        if (is_null($transaction)) {
            return $this->failNotFound();
        }

        $itemModel = model(TransactionItemModel::class);

        $transaction->date = $this->request->getVar("date");
        $transaction->description = $this->request->getVar("description");
        $transaction->journal_description = $this->request->getVar("journal_description");

        try {
            $this->model->save($transaction);
        } catch (DataException $e) {
        }

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

            $items[] = $item;
        }

        $data = [
            'transaction' => $transaction,
            'items' => $items,
        ];

        return $this->respond($data);
    }

    public function delete($id = null)
    {
        $this->model->delete($id);

        return $this->respondNoContent();
    }
}
