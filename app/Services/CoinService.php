<?php

namespace App\Services;

use App\Model\Coin;
use App\Model\Sell;
use App\Model\UserCoin;
use App\User;
use Braintree_Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CoinService
{
    protected $logger;

    public function __construct()
    {
        $this->logger = app(Logger::class);
    }

    //save coin

    public function coinSave($request)
    {
        try {
            $response['success'] = false;
            $response['message'] = __('Invalid Request');
            $data = [
                'name' => $request->name,
                'amount' => $request->amount,
                'price' => $request->price,
            ];
            if ($data) {
                if (!empty($request->edit_id)) {
                    $coin = Coin::where('id', $request->edit_id)->first();
                    if($coin) {
                        $update = $coin->update($data);
                        if ($update) {
                            $response = [
                                'success' => true,
                                'message' => __('Coin updated successfully')
                            ];
                        }
                    }
                } else {
                    Coin::create($data);
                    $response = [
                        'success' => true,
                        'message' => __('New coin created successfully')
                    ];
                }
            } else {
                $response['success'] = false;
                $response['message'] = __('Operation failed');
            }
        } catch(\Exception $e) {
            $response['success'] = false;
            $response['message'] = __('Something went wrong');

        }

        return $response;
    }

    // coin buy process
    public function buyCoinProcess($request)
    {
        $response = ['success' => false,'message' => __('Invalid Request222')];
        DB::beginTransaction();
        try {
            $coin = Coin::where(['id'=> $request->coin_id, 'status'=> STATUS_ACTIVE, 'is_active'=> STATUS_ACTIVE])->first();
            if (isset($coin)) {
                if ($coin->amount >= ($coin->sold_amount + $request->amount)) {
                    $sellReport = $this->addSellReport($request,$coin);
                    if ($sellReport) {
                        $response['success'] = $sellReport['success'];
                        $response['message'] = $sellReport['message'];
                    }
                } else {
                    $response['success'] = false;
                    $response['message'] = __('Insufficient coin amount.');
                }

            } else {
                $response['success'] = false;
                $response['message'] = __('Coin not found.');
            }


        } catch (\Exception $e) {
            DB::rollBack();
            $response['success'] = false;
            $response['message'] = $e->getMessage();

            return $response;
        }

        DB::commit();
        return $response;
    }

    // create payment charge
    public function createPaymentCharge($request, $coin)
    {
        $response = ['success' => false, 'message' => __('Something went wrong !')];
        try {
            if (isset($request->payment_method_nonce) && isset($coin)) {
                $nonce = $request->payment_method_nonce;
                $status = Braintree_Transaction::sale([
                    'amount' => $coin->price * $request->amount,
                    'paymentMethodNonce' => $nonce,
                    'options' => [
                        'submitForSettlement' => True
                    ]
                ]);
//                $response = ['success' => true, 'message' => __('Payment successful.')];
                if (isset($status) && $status->success == true) {
                    $response = ['success' => true, 'message' => __('Payment successful.')];
                } else {
                    $response = ['success' => false, 'message' => __('Payment failed.')];
                }
            } else {
                $response = ['success' => false, 'message' => __('Invalid request!')];
            }
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
            return $response;
        }

        return $response;
    }

    // create sell report

    public function addSellReport($request, $coin)
    {
        $response = ['success' => false, 'message' => __('Something went wrong !')];
        DB::beginTransaction();
        try {
            if (isset($request) && isset($coin)) {
                $userCoinWallet = UserCoin::where(['user_id' => Auth::user()->id])->first();
                if(isset($userCoinWallet)) {
                    $coin->increment('sold_amount', $request->amount);
                    $userCoinWallet->increment('coin', $request->amount);

                    $sellReport = Sell::create(['coin_id'=> $coin->id, 'user_id'=>Auth::user()->id,
                        'payment_id'=> $request->payment_id, 'amount'=>$request->amount, 'price'=> $coin->price]);

                    $payment = $this->createPaymentCharge($request, $coin);

                    if (isset($payment) && $payment['success'] == true) {
                        $response = ['success' => true, 'message' => $payment['message']];
                    } else {
                        DB::rollBack();
                        $response = ['success' => false, 'message' => $payment['message']];
                    }
                } else {
                    $response = ['success' => false, 'message' => __('User coin wallet not found.')];
                }

            } else {
                $response = ['success' => false, 'message' => __('Invalid request!')];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $response = ['success' => false, 'message' => $e->getMessage()];
            return $response;
        }

        DB::commit();
        return $response;
    }

    // user buy coin history

    public function userBuyCoinHistory()
    {
        $response = ['success' => false, 'message'=> __('Something went wrong.')];
        $items = Sell::where(['user_id'=> Auth::user()->id])->get();
        $datas = [];
        if (isset($items[0])) {
            $datas = [];
            foreach ($items as $item) {
                $datas[] = [
                    'user_name' => $item->user->name,
                    'coin_name' => $item->coin->name,
                    'payment_method' => $item->payment->name,
                    'amount' => $item->amount,
                    'price_rate' => $item->price,
                    'date' => date('d M y', strtotime($item->created_at)),
                ];
            }
            $response = [
                'success' => true,
                'buy_history' => $datas,
                'message'=> __('Data get successfully.')];
        } else {
            $response = ['success' => false,'buy_history' => [], 'message'=> __('No data found.')];
        }

        return $response;
    }
}
