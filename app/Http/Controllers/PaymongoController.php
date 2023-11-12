<?php

namespace App\Http\Controllers;

use App\Models\CustomerApplication;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Ixudra\Curl\Facades\Curl;

class PaymongoController extends Controller
{
    public function pay()
    {

        $data = [
            'data' => [
                'attributes' => [
                    'line_items' => [
                        [
                            'currency'      => 'PHP',
                            'amount'        => 10000,
                            'name'          => "Monhtly Amort. for Application No. ",
                            'quantity'      => 1,
                        ]
                    ],
                    'payment_method_types' => [
                        'gcash'
                    ],
                    // route("paymongo", ["customerApplicationId" => 1])
                    'success_url' => 'http://127.0.0.1:8000/customer/payments',
                    'cancel_url' => 'http://127.0.0.1:8000/customer/payments',
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

        Session::put('session_id',$response->data->id);

        $paymentStatus = $this->checkPaymentStatus($response->data->id);


        // Handle payment status
        if ($paymentStatus === 'paid') {
            dd("");
        }
        return redirect()->to($response->data->attributes->checkout_url);
    }

    private function checkPaymentStatus($sessionId)
    {
        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions/'.$sessionId)
        ->withHeader('accept: application/json')
        ->withHeader('Authorization: Basic '.config('app.auth_pay'))
        ->asJson()
        ->get();

        dd($response);
        
    // Check if the request was successful (2xx status code)
    if ($response->code == 200) {

        // Check if the necessary data is present in the response
        if (isset($responseData['data']['attributes']['status'])) {
            $paymentStatus = $responseData['data']['attributes']['status'];

            // Return the payment status
            return $paymentStatus;
        } else {
            // Handle missing status in the JSON structure
            return 'error'; // You can customize this based on your needs
        }
    } else {
        // Handle HTTP errors
        return 'error'; // You can customize this based on your needs
    }
    
    }

    public function success(array $form){
        $sessionId = Session::get('session_id');

        dd("Succes Url");

        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions/'.$sessionId)
                ->withHeader('accept: application/json')
                ->withHeader('Authorization: Basic '.env('AUTH_PAY'))
                ->asJson()
                ->get();

        $amount = $response->data->attributes->line_items[0]->amount;
        // Payment::query()->create([
        //     'customer_application_id' => $customerApplicationId,
        //     'payment_status' => 'predefined',
        //     'payment_type' => 'predefined',
        //     'payment_amount' => str_replace(',', '', number_format($amount / 100, 2)),
        // ]);
    }

}
