<?php

namespace App\Http\Controllers;

use App\Models\Apportionment;
use App\Models\ApportionmentProduct;
use App\Models\Contributor;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApportionmentController extends Controller
{
    public function create()
    {
        return view('apportionment.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $apportionment = new Apportionment;
        $apportionment->name = $request->name;
        $apportionment->user_id = auth()->user()->id; // Assume que o usuário está autenticado
        $apportionment->save();

        return redirect()->route('apportionment.show', $apportionment->id);
    }

    public function show($id)
    {
        $apportionment = Apportionment::findOrFail($id);
        $products = Product::all();

        return view('apportionment.show', compact('apportionment', 'products'));
    }

    public function destroy($id)
    {
        $apportionment = Apportionment::find($id);
        $apportionment->delete();

        return redirect()->route('apportionment.create');
    }

    public function storeProduct(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $apportionmentProduct = new ApportionmentProduct;
        $apportionmentProduct->apportionment_id = $id;
        $apportionmentProduct->product_id = $request->product_id;
        $apportionmentProduct->quantity = $request->quantity;
        $apportionmentProduct->save();

        // Recalculate and update the total price
        $apportionment = Apportionment::findOrFail($id);
        $products = $apportionment->products()->get();

        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;
        }

        $apportionment->total = $totalPrice;
        $apportionment->save();

        return redirect()->route('apportionment.show', $id)->with('success', 'Product added successfully!');
    }

    public function destroyProduct($apportionmentId, $productId)
    {
        $apportionment = Apportionment::findOrFail($apportionmentId);

        $apportionment->products()->detach($productId);

        // Recalculate and update the total price
        $products = $apportionment->products()->get();

        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;
        }

        $apportionment->total = $totalPrice;
        $apportionment->save();

        return redirect()->route('apportionment.show', $apportionmentId)->with('success', 'Product removed successfully!');
    }

    public function contributors($id)
    {
        $apportionment = Apportionment::findOrFail($id);

        return view('apportionment.contributors', compact('apportionment'));
    }

    public function storeContributor(Request $request, $id)
    {
        $apportionment = Apportionment::findOrFail($id);

        $data = $request->validate([
            'name' => 'required',
        ]);

        $contributor = $apportionment->contributors()->create([
            'name' => $data['name'],
        ]);

        return redirect()->route('apportionment.contributors', $apportionment->id)->with('success', 'Contributor saved successfully!');
    }

    public function destroyContributor($apportionmentId, $contributorId)
    {
        $apportionment = Apportionment::findOrFail($apportionmentId);
        $apportionment->contributors()->findOrFail($contributorId)->delete();

        return redirect()->route('apportionment.contributors', $apportionment->id)->with('success', 'Contributor removed successfully!');
    }

    public function showSummary($apportionmentId)
    {
        $apportionment = Apportionment::findOrFail($apportionmentId);
        $apportionmentProducts = $apportionment->products;
        $contributors = $apportionment->contributors;

        // Cálculo dos pedaços
        $pedacos = 0;
        foreach ($apportionmentProducts as $product) {
            if ($product->pieces > 1) {
                $quantity = $product->pivot->quantity;
                $pedacos += $product->pieces * $quantity;
            }
        }
        $pedacos /= count($contributors);

        // Calculo pay
        $pay = $apportionment->total / count($contributors);
        foreach ($contributors as $key => $contributor) {
            Contributor::where('id', $contributor->id)
                ->update(['pay' => $pay]);
        }

        return view('apportionment.summary', compact('apportionment', 'apportionmentProducts', 'contributors', 'pedacos'));
    }

    public function abater(Request $request, $apportionmentId)
    {
        $apportionment = Apportionment::findOrFail($apportionmentId);
        $valorAbater = $request->input('apart');

        // Salvar o valor em 'apart' e abater do campo 'total'
        $apportionment->apart = $valorAbater;
        $apportionment->total -= $valorAbater;
        $apportionment->save();

        return redirect()->route('apportionment.summary', $apportionment->id)->with('success', 'Valor abatido com sucesso!');
    }

    public function final($apportionmentId)
    {
        $apportionment = Apportionment::findOrFail($apportionmentId);
        $pendingPayments = $apportionment->contributors()->where('contributed', '<>', 1)->sum('pay');


        return view('apportionment.final', compact('apportionment', 'pendingPayments'));
    }

    public function markAsPaid(Contributor $contributor)
    {
        $contributor->contributed = 1;
        $contributor->save();

        return redirect()->back()->with('success', 'Contributor marcado como Pago!');
    }
}
