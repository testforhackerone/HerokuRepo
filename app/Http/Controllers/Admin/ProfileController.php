<?php

namespace App\Http\Controllers\Admin;

use App\Repository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /*
     * userProfile
     *
     * User profile
     *
     *
     *
     *
     */

    public function userProfile()
    {
        $data['pageTitle'] = __('Profile');
        $data['menu'] = 'profile';
        $data['user'] = User::where('id', Auth::user()->id)->first();

        return view('admin.profile', $data);
    }

    /*
     * passwordChange
     *
     * password change page
     *
     *
     *
     *
     */

    public function passwordChange()
    {
        $data['pageTitle'] = __('Change Password');
        $data['menu'] = 'profile';
        $data['user'] = User::where('id', Auth::user()->id)->first();

        return view('admin.change-password', $data);
    }

    /*
     * updateProfile
     *
     * Profile Update process
     *
     *
     *
     *
     */

    public function updateProfile(Request $request)
    {
        $rules=[
            'name' => 'required',
        ];
        $messages = [
            'name.required' => __('The name field can not empty'),
        ];
        if (!empty($request->photo)) {
            $rules['photo'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:20000';
        }
        $this->validate($request, $rules,$messages);
        $userRepository = app(UserRepository::class);
        $response = $userRepository->profileUpdate($request->all(),Auth::user()->id);
        if ($response['status'] == false) {
            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('success', $response['message']);
        }
    }

    /*
     * changePassword
     *
     * Password change process
     *
     *
     *
     *
     */

    public function changePassword(Request $request)
    {
        $rules = [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ];
        $messages = [
            'password_confirmation.confirmed' => 'The password confirmation does not match.'
        ];
        $this->validate($request, $rules, $messages);
        $userRepository = app(UserRepository::class);
        $response = $userRepository->passwordChange($request->all(), Auth::user()->id);

        if ($response['status'] == false) {
            return redirect()->back()->withInput()->with('dismiss', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('success', $response['message']);
        }
    }
}
