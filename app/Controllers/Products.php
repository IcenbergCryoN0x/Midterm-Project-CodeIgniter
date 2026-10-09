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
                    'image/jpeg', 'image/png', 'image/webp'
                ], true)
                || $image->getSizeByUnit('mb') > 2
            ) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Use JPG, PNG, or WEBP up to 2 MB.');
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

    public function edit($id)
    {
        $model = new ProductModel();
        $product = $model->find($id);

        if (! $product) {
            return redirect()->to('/products')
                ->with('error', 'Product not found.');
        }

        return view('products/edit', ['product' => $product]);
    }

    public function update($id)
    {
        $model = new ProductModel();
        $product = $model->find($id);

        if (! $product) {
            return redirect()->to('/products')
                ->with('error', 'Product not found.');
        }

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

        $imageName = $product['image'];
        $image = $this->request->getFile('image');

        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            if (! $image->isValid()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Image upload failed.');
            }

            if (
                ! in_array($image->getMimeType(), [
                    'image/jpeg', 'image/png', 'image/webp'
                ], true)
                || $image->getSizeByUnit('mb') > 2
            ) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Use JPG, PNG, or WEBP up to 2 MB.');
            }

            $newImageName = $image->getRandomName();
            $uploadPath = FCPATH . 'uploads/products/';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            if (! $image->move($uploadPath, $newImageName)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Could not save the image.');
            }

            // Remove the previous image after the new one is saved.
            if (! empty($product['image'])) {
                $oldImage = $uploadPath . $product['image'];

                if (is_file($oldImage)) {
                    unlink($oldImage);
                }
            }

            $imageName = $newImageName;
        }

        $model->update($id, [
            'name' => trim($this->request->getPost('name')),
            'price' => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'image' => $imageName,
        ]);

        return redirect()->to('/products')
            ->with('success', 'Product updated successfully!');
    }

    public function delete($id)
    {
        $model = new ProductModel();
        $product = $model->find($id);

        if (! $product) {
            return redirect()->to('/products')
                ->with('error', 'Product not found.');
        }

        // Prevent deletion if sales records reference this product.
        $db = \Config\Database::connect();
        $saleExists = $db->table('sales')
            ->where('product_id', $id)
            ->countAllResults();

        if ($saleExists > 0) {
            return redirect()->to('/products')
                ->with('error', 'This product has sales records and cannot be deleted.');
        }

        if (! empty($product['image'])) {
            $imagePath = FCPATH . 'uploads/products/' . $product['image'];

            if (is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        $model->delete($id);

        return redirect()->to('/products')
            ->with('success', 'Product deleted successfully!');
    }
}