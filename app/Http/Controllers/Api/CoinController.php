<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\BuyCoinRequest;
use App\Model\Coin;
use App\Model\PaymentMethods;
use App\Model\UserCoin;
use App\Services\CoinService;
use App\Services\CommonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CoinController extends Controller
{
    //deduct user coin
    public function deductCoin(Request $request)
    {
        $data = ['success' => false, 'message' => __('Something Went wrong.')];
        $rules=[
            'coin' => 'required|numeric',
        ];
        $messages = [
            'coin.required' => 'The Coin field can not empty'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $response = ['success' => false, 'message' => $errors];

            return response()->json($response);
        }
        $type= 1;
        $response = app(CommonService::class)->addOrDeductCoin($request->coin, $type);

        if (isset($response['status']) && isset($response['message'])) {
            $data['success'] = $response['status'];
            $data['available_coin'] = $response['available_coin'];
            $data['message'] = $response['message'];
        }

        return response()->json($data);

    }

    //earn coin process
    public function earnCoin(Request $request)
    {
        $data = ['success' => false, 'message' => __('Something went wrong.')];
        $rules=[
            'coin' => 'required|numeric',
        ];
        $messages = [
            'coin.required' => 'The Coin field can not empty'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $response = ['success' => false, 'message' => $errors];

            return response()->json($response);
        }
        $type= 2;
        $response = app(CommonService::class)->addOrDeductCoin($request->coin, $type);

        if (isset($response['status']) && isset($response['message'])) {
            $data['success'] = $response['status'];
            $data['message'] = $response['message'];
            $data['available_coin'] = $response['available_coin'];
        }

        return response()->json($data);

    }

    // availabe coin
    public function availabeCoin()
    {
        $data = ['success' => false, 'message' => __('Something Went wrong.')];
        $coin = Coin::where(['status'=> STATUS_ACTIVE, 'is_active' => STATUS_ACTIVE])->first();
        if (isset($coin)) {
            $item = [
                'coin_id' => $coin->id,
                'name' => $coin->name,
                'amount' => $coin->amount,
                'available_amount' => $coin->amount - $coin->sold_amount,
                'price' => $coin->price
            ];
            $data['success'] = true;
            $data['coin'] = $item;
            $data['message'] = __('Data get successfully');
        } else {
            $data['success'] = false;
            $data['message'] = __('No coin found');
        }

        return response()->json($data);
    }

    // payment method
    public function paymentMethod()
    {
        $data = ['success' => false, 'message' => __('Something went wrong.')];
        $items = PaymentMethods::where(['status'=> STATUS_ACTIVE])->get();
        if (isset($items[0])) {
            $data['success'] = true;
            $data['payment_methods'] = $items;
            $data['message'] = __('Data get successfully');
        } else {
            $data['success'] = false;
            $data['message'] = __('No data found');
        }

        return response()->json($data);
    }

    // buy coin
    public function buyCoin(BuyCoinRequest $request)
    {
        $data = ['success' => false, 'message' => __('Something went wrong.')];
        $available_coin = 0;

        $response = app(CoinService::class)->buyCoinProcess($request);
        $userCoin = UserCoin::where('user_id', Auth::user()->id)->first();
        if ($userCoin) {
            $available_coin = $userCoin->coin;
        }
        if (isset($response['success'])) {
            $data['success'] = $response['success'];
            $data['message'] = $response['message'];
            $data['available_coin'] = $available_coin;
        }
        return response()->json($data);
    }

    // buy Coin History
    public function buyCoinHistory()
    {
        $data = ['success' => false, 'message' => __('Something went wrong.')];

        $response = app(CoinService::class)->userBuyCoinHistory();

        if (isset($response)) {
            $data = $response;
        }
        return response()->json($data);
    }

    // coin setting
    public function coinSetting()
    {
        $adm_setting = allsetting();
        $data['braintree_mode'] = isset($adm_setting['braintree_mode']) ? $adm_setting['braintree_mode'] : '';
        $data['braintree_marchant_id'] = isset($adm_setting['braintree_marchant_id']) ? $adm_setting['braintree_marchant_id'] : '';
        $data['braintree_public_key'] = isset($adm_setting['braintree_public_key']) ? $adm_setting['braintree_public_key'] : '';
        $data['braintree_private_key'] = isset($adm_setting['braintree_private_key']) ? $adm_setting['braintree_private_key'] : '';
        $data['braintree_client_token'] = isset($adm_setting['braintree_client_token']) ? $adm_setting['braintree_client_token'] : '';

        return response()->json($data);
    }
}
