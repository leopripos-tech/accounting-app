<?php

namespace App\Controllers;

use App\Models\TransactionStatusModel;
use CodeIgniter\RESTful\ResourceController;

class TransactionStatusController extends ResourceController
{
    protected $model;

    function __construct()
    {
        $this->model = new TransactionStatusModel();
    }

    public function index()
    {
        $data = [
            'statuses' => $this->model->findAll(),
        ];

        return $this->respond($data);
    }
}
