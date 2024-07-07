<?php

namespace App\Http\Controllers;

use App\Models\payment;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
class PaymentController extends Controller
{
    public function payment($id){
        $payment=payment::find($id);
        $payer=User::find($payment->payer_id);
        $data = [];
        $data['invoice_id']=$payment->id;
        $data['invoice_description']="order #{$payment->id}";
        $data['payer_name']=$payment->payer_name;
        $data['payer_email']=$payer->email;
        $data['total']=$payment->total;
        $data['return_url']='http://localhost:8000/paypal/success';
        $data['cancel_url']='http://localhost:8000/cancel';
        return view('cart.checkOut');
    }

}
