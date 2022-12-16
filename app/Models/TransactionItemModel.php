<?php

namespace App\Models;

use App\Entities\TransactionItemEntity;
use CodeIgniter\Model;

class TransactionItemModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'transaction_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = TransactionItemEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        "transaction_id",
        "account_id",
        "status_id",
        "debit",
        "credit"
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ["fillCreatedBy"];
    protected $afterInsert = [];
    protected $beforeUpdate = ["fillUpdatedBy"];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = ["fillDeletedBy"];
    protected $afterDelete = [];

    protected function fillCreatedBy($context)
    {
        $context['data']['created_by'] = auth()->user()->id;

        return $context;
    }

    protected function fillUpdatedBy($context)
    {
        $context['data']['updated_by'] = auth()->user()->id;

        return $context;
    }

    protected function fillDeletedBy($context)
    {
        $context['data']['deleted_by'] = auth()->user()->id;

        return $context;
    }

    public function getJournal($startDate, $endDate)
    {
        $items = $this->join('transaction_statuses', 'transaction_items.status_id = transaction_statuses.id')
            ->join('transactions', 'transaction_items.transaction_id = transactions.id')
            ->join('accounts', 'transaction_items.account_id = accounts.id')
            ->where([
                'transactions.date >=' => $startDate,
                'transactions.date <=' => $endDate,
            ])->select(
                [
                    'transaction_items.*',
                    'transactions.date as transaction_date',
                    'transactions.journal_description as transaction_journal_description',
                    'accounts.code as account_code',
                    'accounts.name as account_name',
                    'transaction_statuses.name as status_name',
                ])
            ->orderBy('transactions.date ASC, transactions.id, transaction_items.debit DESC')
            ->findAll();

        return $items;
    }

    public function getPosting($accountId, $startDate, $endDate)
    {
        $items = $this->join('transaction_statuses', 'transaction_items.status_id = transaction_statuses.id')
            ->join('transactions', 'transaction_items.transaction_id = transactions.id')
            ->join('accounts', 'transaction_items.account_id = accounts.id')
            ->where([
                'transaction_items.account_id' => $accountId,
                'transactions.date >=' => $startDate,
                'transactions.date <=' => $endDate,
            ])->select(
                [
                    'transaction_items.*',
                    'transactions.date as transaction_date',
                    'transactions.journal_description as transaction_journal_description',
                    'accounts.code as account_code',
                    'accounts.name as account_name',
                    'transaction_statuses.name as status_name',
                ])
            ->orderBy('transactions.date', 'ASC')
            ->findAll();

        $balance = 0;
        foreach ($items as $index => $item) {
            if ($items[$index]->debit > 0) {
                $balance += $items[$index]->debit;
            } else {
                $balance -= $items[$index]->credit;
            }

            if ($balance > 0) {
                $items[$index]->balance_debit = $balance;
                $items[$index]->balance_credit = 0;
            } else {
                $items[$index]->balance_debit = 0;
                $items[$index]->balance_credit = abs($balance);
            }
        }

        return $items;
    }

    public function getBalanceSheet($startDate, $endDate)
    {
        $items = $this->join('transactions', 'transaction_items.transaction_id = transactions.id')
            ->join('accounts', 'transaction_items.account_id = accounts.id')
            ->where([
                'transactions.date >=' => $startDate,
                'transactions.date <=' => $endDate,
            ])->orWhere([
                'transactions.date is null',
                'transactions.date is null',
            ])
            ->groupBy('transaction_items.account_id')
            ->select(
                [
                    'SUM(transaction_items.debit) as debit',
                    'SUM(transaction_items.credit) as credit',
                    'accounts.code as account_code',
                    'accounts.name as account_name',
                ])
            ->orderBy('accounts.code', 'ASC')
            ->findAll();

        return $items;
    }
}
