<?php
namespace App\Repository;
use App\Model\Deposit;
use App\Model\UserActivity;
use App\Model\UserInfo;
use App\Model\UserVerificationCode;
use App\Model\Wallet;
use App\Model\Withdrawal;
use App\Services\SmsService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

class UserRepository
{
    public static function createUser($request){

        $data=[
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'role'=>USER_ROLE_USER,
        ];
       return User::create($data);
    }
    public static function updatePassword($request,$user_id){
       return User::where(['id'=>$user_id])->update(['password'=>bcrypt($request->password)]);
    }
    public static function apiUpdatePassword($request,$user_id){
        return User::where(['id'=>$user_id])->update(['password'=>bcrypt($request->new_password)]);
    }

    public function profileUpdate($request, $user_id)
    {
        $response['status'] = false;
        $response['message'] = __('Invalid Request');
        $user = User::find($user_id);
        $userData = [];
        if ($user) {
            $userData = [
                'name' => $request['name'],
            ];
            if (!empty($request['country'])) {
                $userData['country'] = $request['country'];
            }
            if (!empty($request['role'])) {
                $userData['role'] = $request['role'];
            }
            if (!empty($request['address'])) {
                $userData['address'] = $request['address'];
            }
            if (!empty($request['state'])) {
                $userData['state'] = $request['state'];
            }
            if (!empty($request['zip'])) {
                $userData['zip'] = $request['zip'];
            }
            if (!empty($request['language'])) {
                $userData['language'] = $request['language'];
            }
            if (!empty($request['phone'])) {
                $userData['phone'] = $request['phone'];
            }
            if (!empty($request['city'])) {
                $userData['city'] = $request['city'];
            }
            if (!empty($request['photo'])) {
                $old_img = '';
                if (!empty($user->photo)) {
                    $old_img = $user->photo;
                }
                $userData['photo'] = fileUpload($request['photo'], pathUserImage(), $old_img);
            }

            $affected_row = User::where('id', $user_id)->update($userData);
            if ($affected_row) {
                $response['status'] = true;
                $response['message'] = __('Profile Updated successfully');
            }

        } else {
            $response['status'] = false;
            $response['message'] = __('Invalid User');
        }

        return $response;
    }

    public function passwordChange($request, $user_id)
    {
        $response['status'] = false;
        $response['message'] = __('Invalid Request');
        $user = User::find($user_id);

        if ($user) {
            $old_password = $request['old_password'];
            if (Hash::check($old_password, $user->password)) {
                $user->password = bcrypt($request['password']);
                $user->save();

                $affected_row = $user->save();

                if (!empty($affected_row)) {
                    $response['status'] = true;
                    $response['message'] = __('Password Changed Successfully.');
                }
            } else {
                $response['status'] = false;
                $response['message'] = __('Incorrect old Password !');
            }
        } else {
            $response['status'] = false;
            $response['message'] = __('Invalid User');
        }

        return $response;
    }

}
