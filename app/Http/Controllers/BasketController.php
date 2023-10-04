<?php

namespace App\Http\Controllers;

use App\Exceptions\QuantityExceededException;
use App\Http\Requests\checkoutRequest;
use App\Models\Product;
use App\Support\Basket\Basket;
use App\Support\Payment\Transaction;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function __construct(
        private Basket $basket,
        private Transaction $transaction,
    )
    {
    }

    public function add(Product $product)
    {

        try {
            $this->basket->add($product,1);

            return back()->with('success',__('payment.added to basket'));
        }catch (QuantityExceededException $exception){
            return back()->with('error',__('payment.quantity exceeded'));
        }
    }

    public function index()
    {
       	return view('basket');
    }

    public function update(Request $request, Product $product)
    {
        $this->basket->update($product,$request->quantity);

        return back();
    }

    public function checkoutForm()
    {
		return view('checkout');
    }

    public function checkout(checkoutRequest $request)
    {
		$order = $this->transaction->checkout();

        return redirect()->route('home')->with('success',__('payment.your order has been registered',['orderNum' => $order->id]));
    }
}
