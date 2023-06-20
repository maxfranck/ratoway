<?php

namespace App\Repository;

use App\Models\Product;

class ProductRepository implements IProductRepository
{
    public function getAllProducts()
    {
        return Product::all();
    }

    public function getSingleProduct($id)
    {
        return  Product::find($id);
    }

    public function createProduct(array $data)
    {
        $product = new Product();
        $product->name = $data['name'];
        $product->flavor = $data['flavor'];
        $product->description = $data['description'];
        $product->size = $data['size'];
        $product->pieces = $data['pieces'];
        $product->image = $data['image'];
        $product->price = $data['price'];

        $product->save();
    }

    public function editProduct($id)
    {
        return Product::find($id);
    }

    public function updateProduct($id, array $data)
    {
        Product::find($id)->update([
            'name' => $data['name'],
            'flavor' => $data['flavor'],
            'description' => $data['description'],
            'size' => $data['size'],
            'pieces' => $data['pieces'],
            'image' => $data['image'],
            'price' => $data['price']
        ]);
    }
}
