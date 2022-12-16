<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountModel;
use App\Entities\AccountEntity;

class AccountController extends BaseController
{
    private $model;

    function __construct()
    {
        $this->model = new AccountModel();
    }

    public function index()
    {
        $data = [
            'accounts' => $this->model->orderBy("code", "asc")->findAll(),
        ];

        return view('account/index', $data);
    }

    public function create($parentId = null)
    {
        $account = new AccountEntity();
        $parentAccount = null;

        if ($parentId != null) {
            $parentAccount = $this->model->find($parentId);
            if ($parentAccount === null) {
                return $this->notFound();
            }
        }

        if ($this->isPost()) {
            if ($parentAccount !== null) {
                $account->parent_id = $parentAccount->id;
                $account->code = $parentAccount->code . "." . $this->request->getVar("code");
            } else {
                $account->type = $this->request->getVar("code");
            }
            $account->name = $this->request->getVar("name");
            $account->description = $this->request->getVar("description");

            $this->model->save($account);

            return redirect("accounts")->with('success', "Akun berhasil $account->name ditambahkan.");
        }

        $data = [
            'account' => $account,
            'parentAccount' => $parentAccount,
        ];

        return view('account/create', $data);
    }

    public function update($id)
    {
        $account = $this->model->find($id);

        if (is_null($account)) {
            return $this->notFound();
        }

        $parentAccount = null;
        if (!is_null($account->parent_id)) {
            $parentAccount = $this->model->find($account->parent_id);
        }

        if ($this->isPost()) {
            $account->name = $this->request->getVar("name");
            $account->description = $this->request->getVar("description");

            $this->model->save($account);

            return redirect("accounts")->with('success', "Akun berhasil $account->name ditambahkan.");
        }

        $data = [
            'account' => $account,
            'parentAccount' => $parentAccount,
        ];

        return view('account/update', $data);
    }

    public function delete($id)
    {
        $this->model->delete($id);

        return redirect("accounts")->with('success', "Akun berhasil dihapus.");
    }
}
