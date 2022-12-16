<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Entities\User;

class UserController extends BaseController
{
    private $model;

    function __construct() {
        $this->model = model('UserModel');
    }

    public function index()
    {
        $data = [
            'users' => $this->model->findAll(),
        ];

        return view('user/index', $data);
    }

    public function create()
    {
        $user = new User();

        if($this->isPost()) {
            $user->username = $this->request->getVar("username");
            $user->email = $this->request->getVar("email");
            $user->password = $this->request->getVar("password");

            $this->model->save($user);

            return redirect("users")->with('success', "User $user->username berhasil ditambahkan.");
        }

        $data = [
            'user' => $user
        ];

        return view('user/create', $data);
    }

    public function update($id)
    {
        $user = $this->model->find($id);

        if(is_null($user)) {
            return $this->notFound();
        }

        if($this->isPost()) {
            $user->username = $this->request->getVar("username");
            $user->email = $this->request->getVar("email");
            $user->password = $this->request->getVar("password");

            $this->model->save($user);

            return redirect("users")->with('success', "User $user->username berhasil diperbaharui.");
        }

        $data = [
            'user' => $user
        ];

        return view('user/update', $data);
    }

    public function delete($id)
    {
        $this->model->delete($id);

        return redirect("users")->with('success', "User berhasil dihapus.");
    }
}
