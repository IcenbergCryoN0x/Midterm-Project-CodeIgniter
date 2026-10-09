<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index()
    {
        $model = new CustomerModel();

        return view('customers/index', [
            'customers' => $model->findAll()
        ]);
    }

    public function newCustomer()
    {
        return view('customers/create');
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new CustomerModel();

        $model->insert([
            'full_name' => trim($this->request->getPost('full_name')),
            'email'     => trim($this->request->getPost('email')),
            'phone'     => trim($this->request->getPost('phone')),
            'created_at'=> date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/customers')
            ->with('success', 'Customer added successfully!');
    }

    public function edit($id)
    {
        $model = new CustomerModel();
        $customer = $model->find($id);

        if (! $customer) {
            return redirect()->to('/customers')
                ->with('error', 'Customer not found.');
        }

        return view('customers/edit', [
            'customer' => $customer
        ]);
    }

    public function update($id)
    {
        $model = new CustomerModel();

        if (! $model->find($id)) {
            return redirect()->to('/customers')
                ->with('error', 'Customer not found.');
        }

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'full_name' => trim($this->request->getPost('full_name')),
            'email'     => trim($this->request->getPost('email')),
            'phone'     => trim($this->request->getPost('phone')),
        ]);

        return redirect()->to('/customers')
            ->with('success', 'Customer updated successfully!');
    }

    public function delete($id)
    {
        $model = new CustomerModel();

        if (! $model->find($id)) {
            return redirect()->to('/customers')
                ->with('error', 'Customer not found.');
        }

        $db = \Config\Database::connect();

        $saleExists = $db->table('sales')
            ->where('customer_id', $id)
            ->countAllResults();

        if ($saleExists > 0) {
            return redirect()->to('/customers')
                ->with('error', 'This customer has sales records and cannot be deleted.');
        }

        $model->delete($id);

        return redirect()->to('/customers')
            ->with('success', 'Customer deleted successfully!');
    }
}