<?php

namespace App\Http\Controllers;

use App\Models\CustomerApplication;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Ixudra\Curl\Facades\Curl;

class PaymongoController extends Controller
{
    public function pay(int $customerApplicationId)
    {
        $customer_application = CustomerApplication::where("id", $customerApplicationId)->first();


        $numberWithoutDecimal = str_replace('.', '', $customer_application->unit_monthly_amort);

        $data = [
            'data' => [
                'attributes' => [
                    'line_items' => [
                        [
                            'currency'      => 'PHP',
                            'amount'        => intval($numberWithoutDecimal),
                            'name'          => "Monhtly Amort. for Application No. ".$customer_application->id,
                            'quantity'      => 1,
                        ]
                    ],
                    'payment_method_types' => [
                        'gcash', 'card'
                    ],
                    // route("paymongo", ["customerApplicationId" => 1])
                    'success_url' => env('APP_DOMAIN')."customer/payments",
                    'cancel_url' => env('APP_DOMAIN').'customer/payments',
                    'description' => "Payment Description",
                ],
            ]
        ];

        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
                    ->withHeader('Content-Type: application/json')
                    ->withHeader('accept: application/json')
                    ->withHeader('Authorization: Basic '.config('app.auth_pay'))
                    ->withData($data)
                    ->asJson()
                    ->post();

        // dd(env('AUTH_PAY'));
        // dd($response);
    
        Session::put('session_id',$response->data->id);

        return redirect()->to($response->data->attributes->checkout_url);
    }

    public function success(int $customerApplicationId){
        $customer_application = CustomerApplication::where("id", $customerApplicationId)->first();
        $sessionId = Session::get('session_id');

        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions/'.$sessionId)
                ->withHeader('accept: application/json')
                ->withHeader('Authorization: Basic '.config('app.auth_pay'))
                ->asJson()
                ->get();

        $amount = $response->data->attributes->line_items[0]->amount;
        Payment::query()->create([
            'customer_application_id' => $customerApplicationId,
            'payment_status' => 'predefined',
            'payment_type' => 'predefined',
            'payment_amount' => str_replace(',', '', number_format($amount / 100, 2)),
        ]);
    }

}