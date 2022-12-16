<?php

namespace App\Controllers;

use App\Entities\AdjustmentEntity;
use App\Entities\AdjustmentItemEntity;
use App\Models\AdjustmentModel;
use App\Models\AdjustmentItemModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\RESTful\ResourceController;

class AdjustmentRestController extends ResourceController
{
    protected $model;

    function __construct()
    {
        $this->model = new AdjustmentModel();
    }

    public function index()
    {
        $data = [
            'adjustments' => $this->model->findAll(),
        ];

        return $this->respond($data);
    }

    public function create()
    {
        $adjustment = new AdjustmentEntity();
        $adjustment->date = date("Y-m-d");
        $items = [];

        $adjustment->date = $this->request->getVar("date");
        $adjustment->description = $this->request->getVar("description");
        $adjustment->value = $this->request->getVar("value");
        $adjustment->time = $this->request->getVar("time");
        $adjustment->total = $adjustment->value / $adjustment->time;

        $this->model->save($adjustment);

        $accountIds = $this->request->getVar("account_id");
        $credits = $this->request->getVar("credit");
        $debits = $this->request->getVar("debit");
        $statusIds = $this->request->getVar("status_id");

        $itemModel = model(AdjustmentItemModel::class);
        foreach ($accountIds as $index => $accountId) {
            $item = new AdjustmentItemEntity();
            $item->adjustment_id = $this->model->getInsertID();
            $item->account_id = $accountIds[$index];
            $item->credit = $credits[$index];
            $item->debit = $debits[$index];
            $item->status_id = $statusIds[$index];

            $itemModel->save($item);

            $items[] = $item;
        }

        $data = [
            'adjustment' => $adjustment,
            'items' => $items,
        ];

        return $this->respond($data);
    }

    public function show($id = null)
    {
        $adjustment = $this->model->find($id);

        if (is_null($adjustment)) {
            return $this->failNotFound();
        }

        $items = model(AdjustmentItemModel::class)->where(['adjustment_id' => $id])
            ->join('transaction_statuses', 'adjustment_items.status_id = transaction_statuses.id')
            ->join('accounts', 'adjustment_items.account_id = accounts.id')
            ->select(['*', 'accounts.code as account_code', 'accounts.name as account_name', 'transaction_statuses.name as status_name'])
            ->findAll();


        $data = [
            'adjustment' => $adjustment,
            'items' => $items,
        ];

        return $this->respond($data);
    }

    public function update($id = null)
    {
        $adjustment = $this->model->find($id);

        if (is_null($adjustment)) {
            return $this->failNotFound();
        }

        $itemModel = model(AdjustmentItemModel::class);
        $items = $itemModel->where(['adjustment_id' => $id])->findAll();

        $adjustment->date = $this->request->getVar("date");
        $adjustment->description = $this->request->getVar("description");
        $adjustment->value = $this->request->getVar("value");
        $adjustment->time = $this->request->getVar("time");
        $adjustment->total = $adjustment->value / $adjustment->time;

        try {
            $this->model->save($adjustment);
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
        $itemModel->where(['adjustment_id' => $id])
            ->whereNotIn('id', empty($keptIds) ? ['-1'] : $keptIds)
            ->delete();

        foreach ($accountIds as $index => $accountId) {
            $item = new AdjustmentItemEntity();
            $item->id = $itemIds[$index];
            $item->adjustment_id = $adjustment->id;
            $item->account_id = $accountIds[$index];
            $item->credit = $credits[$index];
            $item->debit = $debits[$index];
            $item->status_id = $statusIds[$index];

            $itemModel->save($item);
        }

        $data = [
            'adjustment' => $adjustment,
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
