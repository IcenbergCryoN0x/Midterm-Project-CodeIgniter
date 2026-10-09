<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;

class Sales extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $sales = $db->table('sales')
            ->select('sales.*, products.name AS product_name,
                      customers.full_name AS customer_name,
                      users.full_name AS staff_name')
            ->join('products', 'products.id = sales.product_id')
            ->join('customers', 'customers.id = sales.customer_id', 'left')
            ->join('users', 'users.id = sales.sold_by')
            ->orderBy('sales.created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('sales/index', [
            'sales' => $sales
        ]);
    }

    public function newSale()
    {
        $productModel = new ProductModel();
        $customerModel = new CustomerModel();

        return view('sales/create', [
            'products' => $productModel
                ->where('stock_quantity >', 0)
                ->findAll(),
            'customers' => $customerModel->findAll(),
        ]);
    }

    public function create()
    {
        $rules = [
            'product_id'  => 'required|integer',
            'customer_id' => 'permit_empty|integer',
            'quantity'    => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $productModel = new ProductModel();
        $saleModel = new SaleModel();

        $productId = (int) $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity');
        $customerId = $this->request->getPost('customer_id');

        $product = $productModel->find($productId);

        if (! $product) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Product not found.');
        }

        if ($quantity > (int) $product['stock_quantity']) {
            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'Not enough stock. Available stock: ' . $product['stock_quantity']
                );
        }

        $totalPrice = (float) $product['price'] * $quantity;

        $db = \Config\Database::connect();

        $db->transStart();

        $saleModel->insert([
            'product_id'  => $productId,
            'customer_id' => $customerId ?: null,
            'sold_by'     => session()->get('user_id'),
            'quantity'    => $quantity,
            'total_price' => $totalPrice,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        $productModel->update($productId, [
            'stock_quantity' => (int) $product['stock_quantity'] - $quantity,
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sale could not be recorded.');
        }

        return redirect()->to('/sales')
            ->with('success', 'Sale recorded successfully!');
    }

    public function show($id)
    {
        $db = \Config\Database::connect();

        $sale = $db->table('sales')
            ->select('sales.*, products.name AS product_name,
                      customers.full_name AS customer_name,
                      users.full_name AS staff_name')
            ->join('products', 'products.id = sales.product_id')
            ->join('customers', 'customers.id = sales.customer_id', 'left')
            ->join('users', 'users.id = sales.sold_by')
            ->where('sales.id', $id)
            ->get()
            ->getRowArray();

        if (! $sale) {
            return redirect()->to('/sales')
                ->with('error', 'Sale record not found.');
        }

        return view('sales/show', [
            'sale' => $sale
        ]);
    }
}