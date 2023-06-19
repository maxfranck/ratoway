<?php

namespace App\Http\Controllers;

use App\Models\Apportionment;
use App\Models\ApportionmentProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ApportionmentController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('apportionment.index', compact('products'));
    }

    public function select(Request $request)
    {

        // Obter os produtos selecionados do formulário
        $selectedProducts = $request->input('selectedProducts');

        // Percorrer os produtos selecionados e salvá-los na tabela "ApportionmentProduct"
        foreach ($selectedProducts as $productId => $quantity) {
            $product = ApportionmentProduct::find($productId);

            // Verificar se o produto existe
            if ($product) {
                // Salvar os detalhes do produto selecionado
                $apportionmentProduct = new ApportionmentProduct();
                $apportionmentProduct->product_id = $product->id;
                $apportionmentProduct->name = $product->name;
                $apportionmentProduct->price = $product->price;
                $apportionmentProduct->quantity = $quantity;
                $apportionmentProduct->save();
            }
        }

        // Redirecionar ou exibir uma mensagem de sucesso
        return redirect()->back()->with('success', 'Produtos selecionados foram salvos com sucesso.');
    }
}
