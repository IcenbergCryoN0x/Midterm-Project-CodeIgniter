<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    public function index()
    {
        $model = new ProductModel();

        $data['products'] = $model->findAll();

        return view('products/index', $data);
    }

    public function newProduct()
    {
        return view('products/create');
    }

    public function create()
    {
        $rules = [
            'name' => 'required|max_length[100]',
            'price' => 'required|decimal|greater_than_equal_to[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $imageName = null;
        $image = $this->request->getFile('image');

        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            if (! $image->isValid()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Image upload failed.');
            }

            if (
                ! in_array($image->getMimeType(), [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ], true)
                || $image->getSizeByUnit('mb') > 2
            ) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Use a JPG, PNG, or WEBP image up to 2 MB.');
            }

            $imageName = $image->getRandomName();

            $uploadPath = FCPATH . 'uploads/products/';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            if (! $image->move($uploadPath, $imageName)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Could not save the image.');
            }
        }

        $model = new ProductModel();

        $model->insert([
            'name' => trim($this->request->getPost('name')),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'image' => $imageName,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/products')
            ->with('success', 'Product added successfully!');
    }
}