<?php

namespace App\Http\Controllers\Admin;

use App\Model\PaymentMethods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /*
    * paymentMethods
    *
    * payment methods list
    *
    *
    *
    */
    public function paymentMethods()
    {
        $data['pageTitle'] = __('Payment Methods');
        $data['menu'] = 'payment';
        $data['items'] = PaymentMethods::orderBy('id', 'ASC')->get();

        return view('admin.payment.payment-methods', $data);
    }

    // chnage payment method status
    public function changePaymentMethodStatus(Request $request)
    {
        if (!empty($request->active_id) && is_numeric($request->active_id)) {
            $item = PaymentMethods::findOrFail($request->active_id);
            if ($item->status == 1) {
                $item->status = 0;
            } elseif ($item->status == 0) {
                $item->status = 1;
            }
            $item->save();
        }
        return response()->json(['message'=>__('Status changed successfully')]);
    }
}
