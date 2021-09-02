<?php

namespace App\Http\Controllers;

use App\Model\UserVerificationCode;
use App\Services\CommonService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /*
     * userSignUp
     *
     * User Sign up page
     *
     *
     *
     */

    public function userSignUp()
    {
        $data['pageTitle'] = __('Registration');
        return view('Auth.signup', $data);
    }

    /*
     * userSave
     *
     * User Sign up process
     *
     *
     *
     */

    public function userSave(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|strong_pass|confirmed',
                'password_confirmation' => 'required',
            ];

            if ($request->phone) {
                $rules['phone'] = 'numeric|phone_number';
            }
            $messages = [
                'name.required' => __('Name field can not be empty'),
                'password.required' => __('Password field can not be empty'),
                'password_confirmation.required' => __('Password confirmed field can not be empty'),
                'password.min' => __('Password length must be above 8 characters.'),
                'password.strong_pass' => __('Password must be consist of one Uppercase, one Lowercase and one Number!'),
                'email.required' => __('Email field can not be empty'),
                'email.unique' => __('Email Address already exists'),
                'email.email' => __('Invalid email address'),
                'phone.phone_number' => __('Invalid Phone Number'),
            ];

            $this->validate($request, $rules,$messages);
            //verification key s for email and phone

            $mail_key = $this->generate_email_verification_key();
            $mailTemplet = 'email.verify';

            $response = app(CommonService::class)->userRegistration($request, $mailTemplet, $mail_key);
            if (isset($response['success']) && $response['success']) {
                return redirect()->route('login')->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('error', $response['message']);
        }
        return redirect()->back();
    }

    /*
     * userSignIn
     *
     * User Login page
     *
     *
     *
     */

    public function userSignIn()
    {
        if (Auth::user() && (Auth::user()->role == 1)) {
            return redirect()->route('adminDashboardView');
        } elseif (Auth::user() && (Auth::user()->role == 2)) {
            return redirect()->route('userDashboardView');

        } else {
            return view('Auth.signin');
        }
    }

    /*
     * loginProcess
     *
     * User Login process
     *
     *
     *
     */

    public function loginProcess(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $messages = [
            'email.email' => __('Invalid Email.'),
            'email.required' => __('Your Email is required!'),
            'password.required' => __('The password is required!'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $data['message'] = $errors[0];

            return redirect()->route('login')->withInput()->with(['dismiss' => $data['message']]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (auth::user()->role == USER_ROLE_ADMIN) {
                if (auth::user()->email_verified == STATUS_PENDING) {
                    $mailTemplet = 'email.verify';
                    $mail_key = randomNumber(6);
                    UserVerificationCode::where(['id' => Auth::user()->id])->update(['status' => STATUS_SUCCESS]);
                    UserVerificationCode::create(['user_id' => Auth::user()->id, 'type' => 1, 'code' => $mail_key, 'expired_at' => date('Y-m-d', strtotime('+10 days'))]);
                    $response = app(CommonService::class)->sendVerificationMail(Auth::user(), $mailTemplet, $mail_key);
                    Auth::logout();
                    return redirect()->route('login')->with(['dismiss' => 'Your email is not verified Yet. A verification link has been send to your email. Click on the verification link to verify your email.</a>']);
                }
                return redirect()->route('adminDashboardView');
            } else {
                Auth::logout();
                return redirect()->route('login')->with(['dismiss' => __('You are not authorised')]);
            }
        } else {
            return redirect()->route('login')->with(['dismiss' => __('Email or Password Not matched')]);
        }
    }

    /*
     * verifyEmail
     *
     * Verify email code
     *
     *
     *
     */

    public function verifyEmail($code)
    {
        $uvc = UserVerificationCode::where(['code' => $code, 'status' => STATUS_PENDING, 'type' => 1])
            ->where('expired_at', '>=', date('Y-m-d'))->first();
        if ($uvc) {
            UserVerificationCode::where(['id' => $uvc->id])->update(['status' => STATUS_SUCCESS]);
            User::where(['id' => $uvc->user_id])->update(['email_verified' => STATUS_SUCCESS]);
            return redirect()->route('login')->with(['success' => __('Email Verification Successfull.')]);
        } else {
            return redirect()->route('login')->with(['dismiss' => __('Verification Code Expired or Not found!')]);
        }
    }

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
     * logOut
     *
     *
     *
     *
     */

    public function logOut(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('login');
    }

    /*
     * forgetPassword
     *
     * Forget Password page
     *
     *
     *
     */

    public function forgetPassword()
    {
        $data['pagetitle'] = __('Forget Password');
        return view('Auth.forget-pass', $data);
    }

    /*
     * forgetPasswordProcess
     *
     * Forget Password Process
     *
     *
     *
     */

    public function forgetPasswordProcess(Request $request)
    {
        $rules = [
            'email' => 'required',
        ];

        $messages = [
            'email.required' => __('Email field can not be empty'),
        ];
        $email = $request->email;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = User::where(['email' => $request->email])->first();

            if ($user) {
                // send verifyemail
                $userName = $user->name;
                $userEmail = $request->email;
                $subject = __('Forget Password');
                $defaultmail = allsetting()['primary_email'];
                $defaultname = allsetting()['app_title'];
                $sentmail = Mail::send('email.forgetpass', ['data' => $user],
                    function ($message) use ($userName, $userEmail, $subject, $defaultmail, $defaultname) {
                        $message->to($userEmail, $userName)->subject($subject)->replyTo(
                            $defaultmail, $defaultname
                        );
                    }
                );
                if (count(Mail::failures()) > 0) {
                    return redirect()->back();
                } else {
                    return redirect()->route('forgetPasswordReset')->with(['success' => __('Successfully send email')]);
                }
            } else {
                return redirect()->back()->with(['dismiss' => __('Your email is not correct !!!')]);
            }

        }
    }

    /*
     * forgetPasswordReset
     *
     * Password reset page
     *
     *
     *
     */

    public function forgetPasswordReset()
    {
        $data['pagetitle'] = __('Reset Password');
        return view('Auth.forgetpassreset', $data);
    }

    /*
     * forgetPasswordChange
     *
     * Change the forgotten password
     *
     *
     *
     */

    public function forgetPasswordChange($reset_code)
    {
        $data['reset_code'] = $reset_code;
        $user = User::where(['reset_code' => $reset_code])->first();
        if ($user) {
            return view('Auth.reset-pass', $data);
        } else {
            return redirect()->route('login')->with(['dismiss' => __('Invalid request!')]);
        }
    }

    /*
     * forgetPasswordResetProcess
     *
     * Reset process of forgotten password
     *
     *
     *
     */

    public function forgetPasswordResetProcess(Request $request, $reset_code)
    {
        $rules = [
            'password' => 'required|min:8|strong_pass|confirmed',
            'password_confirmation' => 'required',
        ];

        $messages = [
            'password.required' => __('Password Field can not be Empty'),
            'password.min' => __('Password length must be above 6 characters.'),
            'password.strong_pass' => __('Password must be consist of one Uppercase, one Lowercase and one Number!'),
            'password_confirmation.required' => __('Confirm Password Field can not be Empty!')
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = User::where(['reset_code' => $reset_code])->first();
            if ($user) {
                $update_password['reset_code'] = md5($user->email . uniqid() . randomString(5));
                $update_password['password'] = Hash::make($request->password);

                $updated = User::where(['id' => $user->id, 'reset_code' => $user->reset_code])->update($update_password);

                if ($updated) {
                    return redirect()->route('login')->with(['success' => __('Password successfully Changed')]);
                } else {
                    return redirect()->back()->with(['dismiss' => __('Password not Changed try again')]);
                }
            } else {
                return redirect()->route('login')->with(['dismiss' => __('Password not Changed try again')]);
            }
        }
    }

    // privacy and policy

    public function privacyPolicy()
    {
        $data['pageTitle'] = __('Privacy Policy');
        $data['adm_setting'] = allsetting();

        return view('privacy.privacy', $data);
    }
    // terms and conditions

    public function termsCondition()
    {
        $data['pageTitle'] = __('Terms & Conditions');
        $data['adm_setting'] = allsetting();

        return view('privacy.terms', $data);
    }
}
