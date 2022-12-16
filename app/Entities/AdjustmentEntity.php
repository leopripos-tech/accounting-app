<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AdjustmentEntity extends Entity
{
    protected $attributes = [
        'id'         => null,
        'date'      => null,
        'description'   => null,
        'value' => null,
        'time' => null,
        'total' => null,
        'created_at' => null,
        'created_by' => null,
        'updated_at' => null,
        'updated_by' => null,
        'deleted_at' => null,
        'deleted_by' => null,
    ];

    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
