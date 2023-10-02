<?php

namespace App\Http\Controllers;

use App\Support\Payment\Transaction;

class PaymentController extends Controller
{
    public function __construct(
        public Transaction $transaction
    )
    {
    }

    public function verify()
    {
		$result = $this->transaction->verify();
        return $result
            ? $this->sendSuccessResponse()
            : $this->sendErrorResponse();
    }

    private function sendErrorResponse()
    {
        return redirect()->route('home')->with('error','مشکلی در هنگام ثبت سفارش به وجود آمده است');
    }

    private function sendSuccessResponse()
    {
        return redirect()->route('home')->with('success','سفارش شما با موفقیت ایجاد شد');
    }
}
