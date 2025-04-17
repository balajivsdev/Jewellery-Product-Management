<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductImageModel;
use PSpell\Config;

class Product extends BaseController
{
    public function index()
    {
        $model = new ProductModel();
        $data['products'] = $model->findAll();
        echo view('layouts/header', $data);
        echo view('products/index', $data);
        echo view('layouts/footer', $data);
    }

    public function create()
    {
        echo view('layouts/header');
        echo view('products/create');
        echo view('layouts/footer');
    }

    public function store()
    {
        $productModel = new ProductModel();
        $imageModel = new ProductImageModel();
        $validation = \Config\Services::validation();

        if (!$this->validate([
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $productData = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'category' => $this->request->getPost('category'),
        ];
        $productModel->insert($productData);
        
        $productId = $productModel->getInsertID();

        $images = $this->request->getFiles();

        foreach ($images['images'] as $image) {
            if ($image->isValid() && !$image->hasMoved()) {
                $newName = $image->getRandomName();

                \Config\Services::image()
                    ->withFile($image)
                    ->resize(500, 500, true, 'width')
                    ->save(FCPATH . 'uploads/' . $newName);

                $imageModel->insert([
                    'product_id' => $productId,
                    'images' => $newName,
                ]);
            }
        }

        return redirect()->to('product')->with('message', 'Product created successfully');

    }

    public function edit($id)
    {
        $model = new ProductModel();
        $imageModel = new ProductImageModel();
        $data['product'] = $model->find($id);

        if (!$data['product']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Product with ID $id not found.");
        }

        $data['product_image'] = $this->db->table('product_images')->where('product_id',$id)->get()->getResult();
        
        echo view('layouts/header', $data);
        echo view('products/edit', $data);
        echo view('layouts/footer', $data);
    }

    public function update($id)
    {

        $productModel = new ProductModel();
        $imageModel = new ProductImageModel();
        $validation = \Config\Services::validation();

        $data['product'] = $productModel->find($id);

        if (!$data['product']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Product with ID $id not found.");
        }

        if (!$this->validate([
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $productData = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'category' => $this->request->getPost('category'),
        ];
        $productModel->update($id, $productData);
        

        $newImages = $this->request->getFiles();
        if (isset($newImages['images'])) {
            foreach ($newImages['images'] as $image) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();

                    \Config\Services::image()
                        ->withFile($image)
                        ->resize(500, 500, true, 'width')
                        ->save(FCPATH . 'uploads/' . $newName);

                    $imageModel->insert([
                        'product_id' => $id,
                        'images' => $newName
                    ]);
                }
            }
        }

        return redirect()->to('/product')->with('message', 'Product updated successfully');

    }

    public function delete($id)
    {
        $productModel = new ProductModel();

        $product_delete = $productModel->find($id);

        if($product_delete){
            $product_image_data = $this->general_model->fetch_data('product_images',array('product_id'=>$id));

            if (!empty($product_image_data)) {
                foreach ($product_image_data as $img) {

                    $filePath = FCPATH . './uploads/' . $img->images;
                    if (file_exists($filePath)) { 
                        unlink($filePath);
                    }
                }

                $this->general_model->delete_condition('product_images',array('product_id'=>$id));
            }

            $productModel->delete($id);

        }
       
        return redirect()->to('product')->with('message', 'Product deleted successfully');
    }

    public function deleteImage()
    {
        $imageId = $this->request->getVar('image_id');
        $product_id = $this->request->getVar('product_id');
        // print_r($product_id);exit;
        // $db->table('product_images')->where('id',$imageId,'product_id',$product_id)
        $product_image_data = $this->general_model->fetch_data('product_images',array('id'=>$imageId,'product_id'=>$product_id));

        if(!empty($product_image_data[0]->images)){
            unlink('./uploads/'.$product_image_data[0]->images);
        }
        $this->general_model->delete_condition('product_images',array('id'=>$imageId,'product_id'=>$product_id));
        
        return $this->response->setJSON(['success' => true]);
    }

    public function fetchProducts()
    {
        $request = service('request');
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $builder->select('products.*');

        $searchValue = $request->getPost('search')['value'];
        if ($searchValue) {
            $builder->groupStart()
                    ->like('products.name', $searchValue)
                    // ->orLike('products.description', $searchValue)
                    ->groupEnd();
        }

        $totalRecords = $builder->countAllResults(false);

        $order = $request->getPost('order');
        $columns = ['products.id', 'products.name', 'products.description', 'products.price', 'products.category'];
        if ($order) {
            $builder->orderBy($columns[$order[0]['column']], $order[0]['dir']);
        }

        $start = $request->getPost('start');
        $length = $request->getPost('length');
        $builder->limit($length, $start);

        $query = $builder->get();
        $data = [];

        foreach ($query->getResult() as $row) {
            $data[] = [
                'id' => $row->id,
                'name' => esc($row->name),
                'description' => esc($row->description),
                'price' => $row->price,
                'category_name' => esc($row->category),
                'actions' => '<a href="'.site_url('product/edit/'.$row->id).'" class="btn btn-sm btn-primary">Edit</a>
<form action="'.site_url('product/delete/'.$row->id).'" method="post" style="display:inline;" onsubmit="return confirm(\'Are you sure you want delete this product?\')">
    '.csrf_field().'
    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
</form>'            ];
        }

        return $this->response->setJSON([
            'draw' => intval($request->getPost('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }


}
