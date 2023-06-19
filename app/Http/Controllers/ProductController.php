<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repository\IProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $product;

    public function __construct(IProductRepository $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $products = $this->product->getAllProducts();

        return view('product.index')->with('products', $products);
    }

    public function show($id)
    {
        $product = $this->product->getSingleProduct($id);

        return view('product.show')->with('product', $product);
    }

    public function create()
    {
        return view('product.create');
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

        $this->product->createProduct($data);

        return redirect('/products');
    }

    public function edit($id)
    {
        $product = $this->product->editProduct($id);
        $product['price'] = str_replace(".", ",", $product['price']);

        return view('product.edit')->with('product', $product);
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

        // return $data['image'];

        $this->product->updateProduct($id, $data);

        return redirect('/products/' . $id);
    }

    public function destroy($id)
    {
        $produto = Product::find($id);

        if (!$produto) {
            return redirect()->back()->withErrors('Produto não encontrado.');
        }

        $produto->delete();

        return redirect()->route('product.index')->with('success', 'Produto excluído com sucesso.');
    }
}
