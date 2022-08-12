<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Stripe;


class StripeController extends Controller
{
    public function __construct()
    {
        Stripe\Stripe::setApiKey('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
    }
    //

    public function index(){
        $stripe = new Stripe\StripeClient(
            'sk_test_4eC39HqLyjWDarjtT1zdp7dc'
        );
       $res=$stripe->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'number' => '4000000000003220',
                'exp_month' => 8,
                'exp_year' => 2023,
                'cvc' => '314',
            ],
        ]);
        if($res->card->three_d_secure_usage->supported){
            $rs=$stripe->setupIntents->create([
                'payment_method'=>$res->id,
                'confirm'=>true,
                'return_url'=>'http://localhost:8000/process',
                'payment_method_options'=>['card'=>['request_three_d_secure'=>'any']]
            ]);
            return $rs;
             $res2=$stripe->setupIntents->create([
                'payment_method'=>$res->id,
                'amount'=>1000,
                'currency'=>'eur',
                'confirmation_method'=>'manual',
            ]);
        }else{
            return "it not 3d secured";
        }


        return $res;
    }

    public function setup(Request $request){
        $data= $request->all();
        $stripe = new Stripe\StripeClient(
            'sk_test_DldSvDrhMKdjGsfBYvEHz5qh00F6zXXg0y'
        );
        $res=$stripe->paymentMethods->create(
            [
                'type' => 'card',
                'card' => [
                    'number' => $data['cardNumber'],
                    'exp_month' => $data['month'],
                    'exp_year' => $data['year'],
                    'cvc' => $data['cvc'],
                ],
            ]
        );

        if($res->card->three_d_secure_usage->supported){
            $rs=$stripe->setupIntents->create([
                'payment_method'=>$res->id,
                'confirm'=>true,
                'return_url'=>'http://localhost:8000/process',
                'payment_method_options'=>['card'=>['request_three_d_secure'=>'any']]
            ]);
          //  return $rs;
            if($rs->next_action!=null){
                //return ['client_secret'=>$rs->client_secret];
                return $rs;
            }else{
                return ['error'=>"not 3d secure"];
            }
          //-  return $rs;

        }else{
            return ['error'=>"it not 3d secured"];
        }

        }

    public function form(){
        return view('stripe');
    }

    public function process(Request $r){

        $stripe = new Stripe\StripeClient(
            'sk_test_DldSvDrhMKdjGsfBYvEHz5qh00F6zXXg0y'
        );
        $res=$stripe->setupIntents->retrieve(
            $r->query('setup_intent'),
            []
        );
        if($res->last_setup_error == null && $res->status == '"succeeded'){

        }else{

        }
        return $res;
    }
}
