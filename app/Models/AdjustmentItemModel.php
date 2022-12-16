<?php

namespace App\Models;

use App\Entities\AdjustmentItemEntity;
use CodeIgniter\Model;

class AdjustmentItemModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'adjustment_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = AdjustmentItemEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "adjustment_id",
        "account_id",
        "status_id",
        "debit",
        "credit"
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ["fillCreatedBy"];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ["fillUpdatedBy"];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = ["fillDeletedBy"];
    protected $afterDelete    = [];

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
        $items = $this->join('adjustments', 'adjustment_items.adjustment_id = adjustments.id')
            ->join('accounts', 'adjustment_items.account_id = accounts.id')
            ->where([
                'adjustments.date >=' => $startDate,
                'adjustments.date <=' => $endDate,
            ])
            ->groupBy('adjustment_items.account_id')
            ->select(
                [
                    'SUM(adjustment_items.debit) as debit',
                    'SUM(adjustment_items.credit) as credit',
                    'accounts.code as account_code',
                    'accounts.name as account_name',
                ])
            ->orderBy('adjustments.date', 'ASC')
            ->findAll();

        return $items;
    }
}
