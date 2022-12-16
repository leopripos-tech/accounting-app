<?php

namespace App\Models;

use App\Entities\AdjustmentEntity;
use CodeIgniter\Model;

class AdjustmentModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'adjustments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = AdjustmentEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "date",
        "description",
        "value",
        "time",
        "total",
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
}
