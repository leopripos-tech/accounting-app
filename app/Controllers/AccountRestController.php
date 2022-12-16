<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Entities\AccountEntity;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class AccountRestController extends ResourceController
{
    use ResponseTrait;
    
    protected $model;

    function __construct()
    {
        $this->model = new AccountModel();
    }

    public function index()
    {
        $data = [
            'accounts' => $this->model->orderBy("code", "asc")->findAll(),
        ];

        return $this->respond($data);
    }

    public function create($parentId = null)
    {
        $account = new AccountEntity();
        $parentAccount = null;

        if ($parentId != null) {
            $parentAccount = $this->model->find($parentId);
            if ($parentAccount === null) {
                return $this->failNotFound();
            }
        }

        if ($parentAccount !== null) {
            $account->parent_id = $parentAccount->id;
            $account->code = $parentAccount->code . "." . $this->request->getVar("code");
        } else {
            $account->type = $this->request->getVar("code");
        }
        $account->name = $this->request->getVar("name");
        $account->description = $this->request->getVar("description");

        $this->model->save($account);

        $data = [
            'account' => $account,
            'parentAccount' => $parentAccount,
        ];
        
        return $this->respond($data);
    }

    public function update($id = null)
    {
        $account = $this->model->find($id);

        if (is_null($account)) {
            return $this->failNotFound();
        }

        $parentAccount = null;
        if (!is_null($account->parent_id)) {
            $parentAccount = $this->model->find($account->parent_id);
        }

        $account->name = $this->request->getVar("name");
        $account->description = $this->request->getVar("description");

        $this->model->save($account);

        $data = [
            'account' => $account,
            'parentAccount' => $parentAccount,
        ];

        return $this->respond($data);
    }

    public function delete($id = null)
    {
        $this->model->delete($id);

        return $this->respondNoContent();
    }
}
