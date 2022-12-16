<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionStatusModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Shield\Entities\User;

class TransactionStatusRestController extends BaseController
{
    private $model;

    function __construct()
    {
        $this->model = new TransactionStatusModel();
    }

    public function index()
    {
        $data = [
            'statuses' => $this->model->findAll(),
        ];

        return view('transaction-status/index', $data);
    }

    public function create()
    {
        $status = new User();

        if ($this->isPost()) {
            $status->name = $this->request->getVar("name");
            $status->description = $this->request->getVar("description");

            $this->model->save($status);

            return redirect("transaction-statuses")->with('success', "Status $status->name berhasil ditambahkan.");
        }

        $data = [
            'status' => $status
        ];

        return view('transaction-status/create', $data);
    }

    public function update($id)
    {
        $status = $this->model->find($id);

        if (is_null($status)) {
            return $this->notFound();
        }

        if ($this->isPost()) {
            $status->name = $this->request->getVar("name");
            $status->description = $this->request->getVar("description");

            try {
                $this->model->save($status);
            } catch (DataException $e) {
            }

            return redirect("transaction-statuses")->with('success', "Status $status->name berhasil diperbaharui.");
        }

        $data = [
            'status' => $status
        ];

        return view('transaction-status/update', $data);
    }

    public function delete($id)
    {
        $this->model->delete($id);

        return redirect("transaction-statuses")->with('success', "Status berhasil dihapus.");
    }
}
