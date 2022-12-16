<?php

namespace App\Controllers;

use App\Entities\AdjustmentEntity;
use App\Entities\AdjustmentItemEntity;
use App\Models\AccountModel;
use App\Models\AdjustmentModel;
use App\Models\AdjustmentItemModel;
use App\Models\TransactionStatusModel;
use CodeIgniter\Database\Exceptions\DataException;

class AdjustmentController extends BaseController
{
    private $model;

    function __construct()
    {
        $this->model = new AdjustmentModel();
    }

    public function index()
    {
        $data = [
            'adjustments' => $this->model->findAll(),
        ];

        return view('adjustment/index', $data);
    }

    public function create()
    {
        $adjustment = new AdjustmentEntity();
        $accounts = model(AccountModel::class)->withFullDetail()->where(['accounts.level' => 2])->findAll();
        $statuses = model(TransactionStatusModel::class)->findAll();

        $adjustment->date = date("Y-m-d");

        if ($this->isPost()) {
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
            }

            return redirect("adjustments")
                ->with('success', "Penyesuaian $adjustment->id berhasil ditambahkan.");
        }

        $data = [
            'adjustment' => $adjustment,
            'accounts' => $accounts,
            'statuses' => $statuses,
            'items' => [[]],
        ];

        return view('adjustment/create', $data);
    }

    public function view($id)
    {
        $adjustment = $this->model->find($id);

        if (is_null($adjustment)) {
            return $this->notFound();
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

        return view('adjustment/view', $data);
    }

    public function update($id)
    {
        $adjustment = $this->model->find($id);

        if (is_null($adjustment)) {
            return $this->notFound();
        }

        $itemModel = model(AdjustmentItemModel::class);

        $accounts = model(AccountModel::class)->withFullDetail()->where(['accounts.level' => 2])->findAll();
        $statuses = model(TransactionStatusModel::class)->findAll();
        $items = $itemModel->where(['adjustment_id' => $id])->findAll();

        if ($this->isPost()) {
            $adjustment->date = $this->request->getVar("date");
            $adjustment->description = $this->request->getVar("description");
            $adjustment->value = $this->request->getVar("value");
            $adjustment->time = $this->request->getVar("time");
            $adjustment->total = $adjustment->value / $adjustment->time;

            try {
                $this->model->save($adjustment);
            } catch (DataException $e) {}

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

            return redirect()->to(site_url(['adjustments', $id]))
                ->with('success', "Penyesuaian $adjustment->receipt_no berhasil diperbaharui.");
        }

        $data = [
            'adjustment' => $adjustment,
            'accounts' => $accounts,
            'statuses' => $statuses,
            'items' => $items,
        ];

        return view('adjustment/update', $data);
    }

    public function delete($id)
    {
        $this->model->delete($id);

        return redirect("adjustments")
            ->with('success', "Penyesuaian berhasil dihapus.");
    }
}
