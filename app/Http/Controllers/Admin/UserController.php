<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserSaveRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Repository\UserRepository;
use App\Services\CommonService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /*
     * generate_email_verification_key
     *
     * Generate email verification key
     *
     *
     *
     */

    private function generate_email_verification_key()
    {
        do {
            $key = Str::random(60);
        } While (User::where('email_verified', $key)->count() > 0);

        return $key;
    }
    /*
     * userList
     *
     * Active user list
     *
     *
     *
     *
     */

    public function userList()
    {
        $data['pageTitle'] = __('User List');
        $data['menu'] = 'userlist';
        $data['users'] = User::where('id','<>', Auth::user()->id)->orderBy('id', 'desc')->get();

        return view('admin.user.list', $data);
    }
    /*
     * userDetails
     *
     * User Details page
     *
     *
     *
     *
     */
    public function userDetails($id)
    {
        $data['pageTitle'] = __('User Details');
        $data['menu'] = 'userlist';
        $data['user'] = User::where('id', $id)->first();

        return view('admin.user.user-profile', $data);
    }

    /*
     * userMakeAdmin
     *
     * Make the user to admin
     *
     *
     *
     *
     */

    public function userMakeAdmin($id) {
        $affected_row = User::where('id', $id)
            ->update(['role' => USER_ROLE_ADMIN]);

        if (!empty($affected_row)) {
            return redirect()->back()->with('success', 'Made Admin successfully.');
        }
        return redirect()->back()->with('dismiss', 'Operation failed !');
    }

    /*
     * userMakeUser
     *
     * Make the user to General User
     *
     *
     *
     *
     */

    public function userMakeUser($id) {
        $affected_row = User::where('id', $id)
            ->update(['role' => USER_ROLE_USER]);

        if (!empty($affected_row)) {
            return redirect()->back()->with('success', 'Made user successfully.');
        }
        return redirect()->back()->with('dismiss', 'Operation failed !');
    }

    /*
     * addUser
     *
     * User add page
     *
     *
     *
     *
     */
    public function addUser()
    {
        $data['pageTitle'] = __('Add New User');
        $data['menu'] = 'userlist';

        return view('admin.user.add-edit', $data);
    }

    /*
     *
     * edit user
     */
    public function editUser($id)
    {
        $data['pageTitle'] = __('Update User');
        $data['menu'] = 'userlist';
        $id = app(CommonService::class)->checkValidId($id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('User not found.')]);
        }
        $data['user'] = User::where('id',$id)->first();

        return view('admin.user.add-edit', $data);
    }

    /**
     * userAddProcess
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function userAddProcess(UserSaveRequest $request)
    {
        if ($request->isMethod('post')) {

            $mail_key = $this->generate_email_verification_key();
            $mailTemplet = 'email.verify';

            $response = app(CommonService::class)->userRegistration($request, $mailTemplet, $mail_key);
            if (isset($response['success']) && $response['success']) {
                return redirect()->route('userList')->with('success', __('New user added successfully'));
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        }
        return redirect()->back();
    }

    /**
     * userUpdateProcess
     *
     * update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userUpdateProcess(UserUpdateRequest $request)
    {
        if($request->edit_id) {
            $id = $request->edit_id;
            $userRepository = app(UserRepository::class);
            $response = $userRepository->profileUpdate($request->all(),$id);
            if ($response['status'] == false) {
                return redirect()->back()->withInput()->with('dismiss', $response['message']);
            } else {
                return redirect()->route('userList')->with('success', __('User updated successfully'));
            }
        } else {
            return redirect()->back()->with(['dismiss' => __('User not found')]);
        }
    }

    /**
     * userDelete
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function userDelete($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('User not found.')]);
            }
            $user = User::where(['id' => $id])->update(['active_status' => STATUS_DELETED]);
            if (isset($user)) {
                return redirect()->back()->with(['success' => __('User has been deleted successfully!')]);
            } else {
                return redirect()->back()->with(['dismiss' => __('Something went wrong. Please try again later!')]);
            }
        }
        return redirect()->back();
    }

    /**
     * userActivate
     *
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function userActivate($id)
    {
        if (isset($id)) {
            $id = app(CommonService::class)->checkValidId($id);
            if (is_array($id)) {
                return redirect()->back()->with(['dismiss' => __('User not found.')]);
            }
            $user = User::where(['id' => $id])->update(['active_status' => STATUS_ACTIVE]);
            if (isset($user)) {
                return redirect()->back()->with(['success' => __('User has been activated successfully!')]);
            } else {
                return redirect()->back()->with(['dismiss' => __('Something went wrong. Please try again later!')]);
            }
        }
        return redirect()->back();
    }
}
