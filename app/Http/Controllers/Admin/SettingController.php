<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SettingRequest;
use App\Model\AdminSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /*
    * generalSetting
    *
    * general Setting
    *
    *
    *
    *
    */

    public function generalSetting()
    {
        $data['pageTitle'] = __('General Setting');
        $data['menu'] = 'setting';
        $data['adm_setting'] = allsetting();

        return view('admin.setting', $data);
    }

    /*
    * saveSettings
    *
    * save admin setting data
    *
    *
    *
    *
    */

    public function saveSettings(SettingRequest $request)
    {
        try {
            if (isset($request->company_name)) {
                AdminSetting::where(['slug' => 'company_name'])->update(['value' => $request->company_name]);
            }
            if (isset($request->lang)) {
                AdminSetting::where(['slug' => 'lang'])->update(['value' => $request->lang]);
            }
            if (isset($request->user_registration)) {
                AdminSetting::where(['slug' => 'user_registration'])->update(['value' => $request->user_registration]);
            }
            if (isset($request->app_title)) {
                AdminSetting::where(['slug' => 'app_title'])->update(['value' => $request->app_title]);
            }
            if (isset($request->primary_email)) {
                AdminSetting::where(['slug' => 'primary_email'])->update(['value' => $request->primary_email]);
            }
            if (isset($request->copyright_text)) {
                AdminSetting::where(['slug' => 'copyright_text'])->update(['value' => $request->copyright_text]);
            }
            if (isset($request->hints_coin)) {
                AdminSetting::updateOrCreate(['slug' => 'hints_coin'],['value' => $request->hints_coin]);
            }
            if (isset($request->admob_coin)) {
                AdminSetting::updateOrCreate(['slug' => 'admob_coin'],['value' => $request->admob_coin]);
            }
            if (isset($request->signup_coin)) {
                AdminSetting::updateOrCreate(['slug' => 'signup_coin'],['value' => $request->signup_coin]);
            }
            if (isset($request->privacy_policy)) {
                AdminSetting::updateOrCreate(['slug' => 'privacy_policy'],['value' => $request->privacy_policy]);
            }
            if (isset($request->login_text)) {
                AdminSetting::updateOrCreate(['slug' => 'login_text'],['value' => $request->login_text]);
            }
            if (isset($request->signup_text)) {
                AdminSetting::updateOrCreate(['slug' => 'signup_text'],['value' => $request->signup_text]);
            }
            if (isset($request->terms_conditions)) {
                AdminSetting::updateOrCreate(['slug' => 'terms_conditions'],['value' => $request->terms_conditions]);
            }
            if (isset($request->logo)) {
//                AdminSetting::updateOrCreate(['slug' => 'logo'], ['value' => uploadthumb($request->logo, path_image(), 'logo_', '', '', allsetting()['logo'])]);
                AdminSetting::updateOrCreate(['slug' => 'logo'], ['value' => fileUpload($request['logo'], path_image(), allsetting()['logo'])]);
            }
            if (isset($request->favicon)) {
                AdminSetting::updateOrCreate(['slug' => 'favicon'], ['value' => fileUpload($request['favicon'], path_image(), allsetting()['favicon'])]);
            }
            if (isset($request->login_logo)) {
                AdminSetting::updateOrCreate(['slug' => 'login_logo'], ['value' => fileUpload($request['login_logo'], path_image(), allsetting()['login_logo'])]);
            }

            return redirect()->back()->with(['success' => __('Updated Successfully')]);
        } catch (\Exception $e) {
//            dd($e->getMessage());
            return redirect()->back()->with(['dismiss' => __('Something went wrong')]);
        }
    }

    // save payment setting
    public function savePaymentSettings(Request $request)
    {
        try {
            if (isset($request->braintree_mode)) {
                AdminSetting::updateOrCreate(['slug' => 'braintree_mode'],['value' => $request->braintree_mode]);
            }
            if (isset($request->braintree_marchant_id)) {
                AdminSetting::updateOrCreate(['slug' => 'braintree_marchant_id'],['value' => $request->braintree_marchant_id]);
            }
            if (isset($request->braintree_public_key)) {
                AdminSetting::updateOrCreate(['slug' => 'braintree_public_key'],['value' => $request->braintree_public_key]);
            }
            if (isset($request->braintree_private_key)) {
                AdminSetting::updateOrCreate(['slug' => 'braintree_private_key'],['value' => $request->braintree_private_key]);
            }
            if (isset($request->braintree_client_token)) {
                AdminSetting::updateOrCreate(['slug' => 'braintree_client_token'],['value' => $request->braintree_client_token]);
            }

            return redirect()->back()->with(['success' => __('Updated Successfully')]);
        } catch (\Exception $e) {
//            dd($e->getMessage());
            return redirect()->back()->with(['dismiss' => __('Something went wrong')]);
        }
    }

}
