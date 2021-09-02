<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CoinSaveRequest;
use App\Model\Coin;
use App\Model\Sell;
use App\Services\CoinService;
use App\Services\CommonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CoinController extends Controller
{
    /**
     * coinList
     *
     * List of specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function coinList()
    {
        $data['pageTitle'] = __('Coin List');
        $data['menu'] = 'coin';
        $data['items'] = Coin::orderBy('id', 'DESC')->get();

        return view('admin.coin.list', $data);
    }
    /**
     * coinActive
     *
     * active one coin and deactive others
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function coinActive($id) {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('Item not found.')]);
            }
            DB::table('coins')->update(['is_active'=>COIN_IS_NOT_ACTIVE]);
            $coin = Coin::where(['id'=>$id])->update(['is_active'=>COIN_IS_ACTIVE]);
            if (isset($coin)) {
                return redirect()->back()->with(['success' => __('Coin activate successfully')]);
            } else {
                return redirect()->back()->with(['dismiss' => __('Something went wrong. Please try again later!')]);
            }
        }
        return redirect()->back();
    }

    /**
     * coinAdd
     *
     * store a newly created resource page in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function coinAdd()
    {
        $data['pageTitle'] = __('Add New Coin');
        $data['menu'] = 'coin';

        return view('admin.coin.addEdit', $data);
    }

    /**
     * coinAddProcess
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function coinAddProcess(CoinSaveRequest $request)
    {
        $response = app(CoinService::class)->coinSave($request);
        if (isset($response['success']) && $response['success'] == true) {
            return redirect()->route('coinList')->with('success', $response['message']);
        }

        return redirect()->back()->withInput()->with('dismiss', $response['message']);
    }

    /*
    * coinEdit
    * edit coin
    */
    public function coinEdit($id)
    {
        $data['pageTitle'] = __('Update Coin');
        $data['menu'] = 'coin';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Data not found.')]);
        }
        $data['coin'] = Coin::where('id',$id)->first();

        return view('admin.coin.addEdit', $data);
    }

    /**
     * saleReport
     *
     * List of specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saleReport()
    {
        $data['pageTitle'] = __('Sales Report');
        $data['menu'] = 'sale';
        $data['items'] = Sell::orderBy('id', 'DESC')->get();

        return view('admin.coin.sales-report', $data);
    }
}
