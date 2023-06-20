<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repository\IAdminRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public $admin;

    public function __construct(IAdminRepository $admin)
    {
        $this->admin = $admin;
    }

    public function index()
    {
        $products = $this->admin->getAllProducts();

        return view('admin.index')->with('products', $products);
    }

    public function show($id)
    {
        $product = $this->admin->getSingleProduct($id);

        return view('admin.show')->with('product', $product);
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        // validate and store data
        $request->validate([
            'name' => 'required',
            'pieces' => 'required',
            'price' => 'required'
        ]);

        $data = $request->all();

        $data['price'] = str_replace(",", ".", $data['price']);

        //image upload
        if ($request->hasFile('image')) {
            $imagem = $request->file('image');
            $caminho = public_path('images');
            $nomeImagem = uniqid() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move($caminho, $nomeImagem);
            $data['image'] = $nomeImagem;
        } else {
            $data['image'] = 'noimage.jpg';
        }

        $this->admin->createProduct($data);

        return redirect('admin/products');
    }

    public function edit($id)
    {
        $product = $this->admin->editProduct($id);
        $product['price'] = str_replace(".", ",", $product['price']);

        return view('admin.edit')->with('product', $product);
    }

    public function update(Request $request, $id)
    {
        // validate and store data
        $request->validate([
            'name' => 'required',
            'pieces' => 'required',
            'price' => 'required'
        ]);

        $data = $request->all();

        $data['price'] = str_replace(",", ".", $data['price']);

        //image upload
        if ($request->hasFile('image')) {
            $imagem = $request->file('image');
            $caminho = public_path('images');
            $nomeImagem = uniqid() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move($caminho, $nomeImagem);
        }

        $dado = Product::find($id);
        if (isset($dado['image']) && !$request->hasFile('image')) {
            $data['image'] = $dado['image'];
        } else if ($request->hasFile('image')) {
            $data['image'] = $nomeImagem;
        } else {
            $data['image'] = 'noimage.jpg';
        }

        $this->admin->updateProduct($id, $data);

        return redirect('/admin/' . $id);
    }

    public function destroy($id)
    {
        $produto = Product::find($id);

        if (!$produto) {
            return redirect()->back()->withErrors('Produto não encontrado.');
        }

        $produto->delete();

        return redirect('admin/products');
    }
}
