<?php

namespace App\Controllers;

use App\Models\UserModel;

class Staff extends BaseController
{
    public function index()
    {
        $model = new UserModel();

        return view('staff/index', [
            'staff' => $model->findAll()
        ]);
    }

    public function newStaff()
    {
        return view('staff/create');
    }

    public function create()
    {
        $rules = [
            'username'  => 'required|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|max_length[100]',
            'password'  => 'required|min_length[6]',
            'avatar'    => 'permit_empty|is_image[avatar]|max_size[avatar,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $avatarName = null;
        $avatar = $this->request->getFile('avatar');

        if ($avatar && $avatar->isValid() && ! $avatar->hasMoved()) {
            $avatarName = $avatar->getRandomName();
            $uploadPath = FCPATH . 'uploads/staff/';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $avatar->move($uploadPath, $avatarName);
        }

        $model = new UserModel();

        $model->insert([
            'username'   => trim($this->request->getPost('username')),
            'full_name'  => trim($this->request->getPost('full_name')),
            'password'   => $this->request->getPost('password'),
            'avatar'     => $avatarName,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/staff')
            ->with('success', 'Staff account added successfully!');
    }

    public function edit($id)
    {
        $model = new UserModel();
        $staff = $model->find($id);

        if (! $staff) {
            return redirect()->to('/staff')
                ->with('error', 'Staff account not found.');
        }

        return view('staff/edit', [
            'staff' => $staff
        ]);
    }

    public function update($id)
    {
        $model = new UserModel();
        $staff = $model->find($id);

        if (! $staff) {
            return redirect()->to('/staff')
                ->with('error', 'Staff account not found.');
        }

        $rules = [
            'username'  => "required|max_length[50]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|max_length[100]',
            'password'  => 'permit_empty|min_length[6]',
            'avatar'    => 'permit_empty|is_image[avatar]|max_size[avatar,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username'  => trim($this->request->getPost('username')),
            'full_name' => trim($this->request->getPost('full_name')),
        ];

        $password = $this->request->getPost('password');

        if (! empty($password)) {
            $data['password'] = $password;
        }

        $avatar = $this->request->getFile('avatar');

        if ($avatar && $avatar->isValid() && ! $avatar->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/staff/';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            if (! empty($staff['avatar'])) {
                $oldAvatar = $uploadPath . $staff['avatar'];

                if (is_file($oldAvatar)) {
                    unlink($oldAvatar);
                }
            }

            $avatarName = $avatar->getRandomName();
            $avatar->move($uploadPath, $avatarName);
            $data['avatar'] = $avatarName;
        }

        $model->update($id, $data);

        return redirect()->to('/staff')
            ->with('success', 'Staff account updated successfully!');
    }

    public function delete($id)
    {
        if ((int) session()->get('user_id') === (int) $id) {
            return redirect()->to('/staff')
                ->with('error', 'You cannot delete the account currently logged in.');
        }

        $model = new UserModel();
        $staff = $model->find($id);

        if (! $staff) {
            return redirect()->to('/staff')
                ->with('error', 'Staff account not found.');
        }

        if (! empty($staff['avatar'])) {
            $avatarPath = FCPATH . 'uploads/staff/' . $staff['avatar'];

            if (is_file($avatarPath)) {
                unlink($avatarPath);
            }
        }

        $model->delete($id);

        return redirect()->to('/staff')
            ->with('success', 'Staff account deleted successfully!');
    }
}