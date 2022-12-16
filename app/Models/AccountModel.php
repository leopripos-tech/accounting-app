<?php

namespace App\Models;

use App\Entities\AccountEntity;
use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'accounts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = AccountEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'code',
        'name',
        'full_name',
        'description',
        "parent_id",
        "level",
        "created_by",
        "updated_by",
        "deleted_by"
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
    protected $beforeInsert = ["fillLevel", "fillCreatedBy"];
    protected $afterInsert = [];
    protected $beforeUpdate = ["fillUpdatedBy"];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = ["fillDeletedBy"];
    protected $afterDelete = [];

    protected function fillLevel($context)
    {
        if (empty($context['data']['parent_id'])) {
            $context['data']['level'] = 0;
        } else {
            $context['data']['level'] = $this->find($context['data']['parent_id'])->level + 1;
        }

        return $context;
    }

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

    public function withFullDetail()
    {
        return $this->join('accounts as account1', 'account1.id = accounts.parent_id')
            ->join('accounts as account0', 'account0.id = account1.parent_id')
            ->select("accounts.*, CONCAT(account1.name, ' - ', accounts.name) as name");
    }

    public function getWorkSheet($startDate, $endDate)
    {
        $items = $this
            ->join('transaction_items', 'accounts.id = transaction_items.account_id', 'left')
            ->join('transactions', 'transaction_items.transaction_id = transactions.id', 'left')
            ->join('adjustment_items', 'accounts.id = adjustment_items.account_id', 'left')
            ->join('adjustments', 'adjustment_items.adjustment_id = adjustments.id', 'left')
            ->where("
                accounts.level = 2
                AND (
                    transactions.date is null
                    OR transactions.date >= '$startDate'
                )
                AND (
                    transactions.date is null
                    OR transactions.date <= '$endDate'
                )
                AND (
                    adjustments.date is null
                    OR adjustments.date >= '$startDate'
                )
                AND (
                    adjustments.date is null
                    OR adjustments.date <= '$endDate'
                )
            ")
            ->groupBy('accounts.id')
            ->select(
                [
                    'accounts.code as account_code',
                    'accounts.name as account_name',
                    'SUM(transaction_items.debit) as transaction_debit',
                    'SUM(transaction_items.credit) as transaction_credit',
                    'SUM(adjustment_items.debit) as adjustment_debit',
                    'SUM(adjustment_items.credit) as adjustment_credit',
                ]
            )
            ->orderBy('accounts.code', 'ASC')
            ->findAll();

        foreach ($items as $index => $item) {
            $balance = 0;
            $balance += $items[$index]->transaction_debit ?? 0;
            $balance -= $items[$index]->transaction_credit ?? 0;

            if ($balance > 0) {
                $items[$index]->balance_debit = $balance;
                $items[$index]->balance_credit = 0;
            } else {
                $items[$index]->balance_debit = 0;
                $items[$index]->balance_credit = abs($balance);
            }

            $balance += $items[$index]->adjustment_debit ?? 0;
            $balance -= $items[$index]->adjustment_credit ?? 0;

            if ($balance > 0) {
                $items[$index]->adjusted_balance_debit = $balance;
                $items[$index]->adjusted_balance_credit = 0;
            } else {
                $items[$index]->adjusted_balance_debit = 0;
                $items[$index]->adjusted_balance_credit = abs($balance);
            }

            if ($items[$index]->account_code[0] < 3 && $balance > 0) {
                $items[$index]->sheet_balance_debit += $items[$index]->adjusted_balance_debit;
            } else {
                $items[$index]->sheet_balance_debit = 0;
            }

            if ($items[$index]->account_code[0] < 3 && $balance < 0) {
                $items[$index]->sheet_balance_credit += $items[$index]->adjusted_balance_credit;
            } else {
                $items[$index]->sheet_balance_credit = 0;
            }

            if ($items[$index]->account_code[0] <= 3 && $balance > 0) {
                $items[$index]->cash_debit += $items[$index]->adjusted_balance_debit;
            } else {
                $items[$index]->cash_debit = 0;
            }

            if ($items[$index]->account_code[0] <= 3 && $balance < 0) {
                $items[$index]->cash_credit += $items[$index]->adjusted_balance_credit;
            } else {
                $items[$index]->cash_credit = 0;
            }

            if ($items[$index]->account_code[0] == 3 && $balance > 0) {
                $items[$index]->capital_debit += $items[$index]->adjusted_balance_debit;
            } else {
                $items[$index]->capital_debit = 0;
            }

            if ($items[$index]->account_code[0] == 3 && $balance < 0) {
                $items[$index]->capital_credit += $items[$index]->adjusted_balance_credit;
            } else {
                $items[$index]->capital_credit = 0;
            }

            if ($items[$index]->account_code[0] == '4') {
                $items[$index]->revenue_debit = $items[$index]->adjusted_balance_credit;
            } else {
                $items[$index]->revenue_debit = 0;
            }

            if ($items[$index]->account_code[0] == '5') {
                $items[$index]->revenue_credit = $items[$index]->adjusted_balance_debit;
            } else {
                $items[$index]->revenue_credit = 0;
            }
        }

        return $items;
    }
}
