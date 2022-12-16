<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TransactionItemEntity extends Entity
{
    protected $attributes = [
        'id' => null,
        'transaction_id' => null,
        'account_id' => null,
        'status_id' => null,
        'debit' => null,
        'credit' => null,
        'created_at' => null,
        'created_by' => null,
        'updated_at' => null,
        'updated_by' => null,
        'deleted_at' => null,
        'deleted_by' => null,
    ];

    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];

    public function getReceiptNo()
    {
        return str_pad($this->transaction_id, 4, "0", STR_PAD_LEFT);
    }
}
