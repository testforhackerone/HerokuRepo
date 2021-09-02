<?php

namespace App\Services;

use App\Model\AffiliationCode;
use App\Model\Coin;
use App\Model\Deposit;
use App\Model\QuestionOption;
use App\Model\UserCoin;
use App\Model\UserInfo;
use App\Model\UserSetting;
use App\Model\UserVerificationCode;
use App\Model\Wallet;
use App\Model\WalletAddress;
use App\Model\Withdrawal;
use App\Repository\AffiliateRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CommonService
{
    protected $logger;

    public function __construct()
    {
        $this->logger = app(Logger::class);
    }

    public function checkValidId($id){
        try {
            $id = decrypt($id);
        } catch (\Exception $e) {
            return ['success'=>false];
        }
        return $id;
    }

    public function save_login_setting($request)
    {
        $rules = [
            'password' => 'required|min:8|strong_pass|confirmed',
        ];

        $messages = [
            'password.required' => __('Password field can not be empty'),
            'password.min' => __('Password length must be above 8 characters.'),
            'password.strong_pass' => __('Password must be consist of one Uppercase, one Lowercase and one Number!')
        ];

        $request->validate($rules, $messages);
        $password = $request->password;

        $update ['password'] = Hash::make($password);

        $user = User::where(['id' => Auth::user()->id]);

        if ($user->update($update)) {
            return [
                'success' => true,
                'message' => 'Information Updated Successfully'
            ];
        }

        return [
            'success' => false,
            'message' => 'Information Update Failed. Try Again!'
        ];
    }

    public function isPhoneVerified($user)
    {
        if (empty($user->phone) || $user->phone_verified == PHONE_IS_NOT_VERIFIED) {
            return ['success' => false, 'phone_verify' => false, 'message' => __('Please Verify your phone.')];
        }else{
            return ['success' => true, 'phone_verify' => true, 'message' => __('Verified phone.')];
        }
    }

    public function userRegistration($request, $mailTemplet, $mail_key)
    {
        $randno = randomNumber(6);
        try {
            DB::transaction(function () use ($request, $mailTemplet, $mail_key, $randno) {
                $user = User::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'country' => $request->country,
                    'password' => Hash::make($request->password),
                    'role' => isset($request->role) ? $request->role : USER_ROLE_USER,
                    'active_status' => STATUS_SUCCESS,
                    'email_verified' => STATUS_PENDING,
                    'reset_code' => md5($request->get('email') . uniqid() . randomString(5)),
                    'language' => 'en'
                ]);
                UserVerificationCode::create(
                    ['user_id' => $user->id,
                        'type' => 1,
                        'code' => $mail_key,
                        'expired_at' => date('Y-m-d', strtotime('+10 days')),
                        'status' => STATUS_PENDING]
                );
                $this->create_coin_wallet($user->id);
                $this->sendVerificationMail($user, $mailTemplet, $mail_key);
            });
            return [
                'success' => true,
                'message' => __('We have just sent a verification link on Email . ')
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('Something went wrong . Please try again!')
            ];
        }
    }


    public function sendVerificationMail($user, $mailTemplet, $mail_key)
    {

        $mailService = app(MailService::class);
        $userName = $user->name;
        $userEmail = $user->email;
        $companyName = isset(allsetting()['app_title']) && !empty(allsetting()['app_title']) ? allsetting()['app_title'] : __('Coin Wallet');
        $subject = __('Email Verification | :companyName', ['companyName' => $companyName]);
        $data['data'] = $user;
        $data['key'] = $mail_key;
        $mailService->send($mailTemplet, $data, $userEmail, $userName, $subject);
    }

    public function create_coin_wallet($user_id)
    {
        $coin = 0;
        if(!empty(allsetting('signup_coin'))) {
            $coin = allsetting('signup_coin');
        }
        $createCoinWallet = UserCoin::create(['user_id' => $user_id, 'coin' => $coin]);
    }

    public function user_details($email)
    {
        $user = User::where('email', $email)->first();
        return $user;
    }


    public function addOrDeductCoin($coin, $type)
    {
        $response['status'] = false;
        $response['message'] = __('Invalid Request');

        try {
            $userCoin = UserCoin::where('user_id', Auth::user()->id)->first();
            $response['available_coin'] = 0;
            if (isset($userCoin)) {
                $response['available_coin'] = $userCoin->coin;
                if ($type == 1) {
                    if ($userCoin->coin < $coin) {
                        $response['status'] = false;
                        $response['message'] = __("You don't have sufficient coin");
                    } else {
                        $deductCoin = bcsub($userCoin->coin, $coin);
                        $dCoin = $userCoin->update(['coin' => $deductCoin]);
                        if ($dCoin) {
                            $response['status'] = true;
                            $response['available_coin'] = UserCoin::where('user_id', Auth::user()->id)->first()->coin;
                            $response['message'] = __('Coin deducted successfully');
                        } else {
                            $response['status'] = false;
                            $response['message'] = __('Operation failed');
                        }
                    }
                } else {
                    $addedCoin = bcadd($userCoin->coin, $coin);
                    $addCoin = $userCoin->update(['coin' => $addedCoin]);
                    if ($addCoin) {
//                        $currentCoin = UserCoin::where('user_id', Auth::user()->id)->first()->coin;
                        $response['status'] = true;
                        $response['available_coin'] = UserCoin::where('user_id', Auth::user()->id)->first()->coin;
                        $response['message'] = __('Coin earned successfully');
                    } else {
                        $response['status'] = false;
                        $response['message'] = __('Operation failed');
                    }
                }

            } else {
                $response['status'] = false;
                $response['message'] = __('User Coin Account Not Found');
            }
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => __('Something went wrong . Please try again!')
            ];
            return $response;
        }

        return $response;
    }


    public function saveOptions($request,$question_id)
    {
        if (!empty($request->option_text1)) {
            $data1 = [
                'question_id'=>$question_id,
                'is_answer'=>$request->ans_type1,
                'option_title'=>$request->option_text1,
                'option_image'=>'',
            ];
            if (!empty($request->edit_id)) {
                $option1 = QuestionOption::where('id', $request->text_option1)->first();
            }
            if (!empty($request->edit_id)) {
                if(isset($option1)) {
                    $option1->update($data1);
                }
            } else {
                QuestionOption::create($data1);
            }
        } else {
            $data1 = [
                'question_id'=>$question_id,
                'is_answer'=>$request->ans_type1,
                'option_title'=>''
            ];
            if (!empty($request->edit_id)) {
                $option1 = QuestionOption::where('id', $request->option1)->first();
            }
            if (!empty($request['option_image1'])) {
                $old_img = '';
                if (!empty($option1->option_image)) {
                    $old_img = $option1->option_image;
                }
                $option_image1 = fileUpload($request['option_image1'], path_question_option1_image(), $old_img);
                $data1['option_image'] = $option_image1;
            }
            if (!empty($request->edit_id)) {
                if(isset($option1)) {
                    $option1->update($data1);
                }
            } else {
                QuestionOption::create($data1);
            }
        }

        if (!empty($request->option_text2)) {
            $data2 = [
                'question_id'=>$question_id,
                'is_answer'=>$request->ans_type2,
                'option_title'=>$request->option_text2,
                'option_image'=>'',
            ];
            if (!empty($request->edit_id)) {
                $option2 = QuestionOption::where('id', $request->text_option2)->first();
            }
            if (!empty($request->edit_id)) {
                if(isset($option2)) {
                    $option2->update($data2);
                }
            } else {
                QuestionOption::create($data2);
            }
        } else {
            $data2 = [
                'question_id'=>$question_id,
                'is_answer'=>$request->ans_type2,
                'option_title'=>''
            ];
            if (!empty($request->edit_id)) {
                $option2 = QuestionOption::where('id', $request->option2)->first();
            }
            if (!empty($request['option_image2'])) {
                $old_img = '';
                if (!empty($option2->option_image)) {
                    $old_img = $option2->option_image;
                }
                $option_image2 = fileUpload($request['option_image2'], path_question_option2_image(), $old_img);
                $data2['option_image'] = $option_image2;
            }
            if (!empty($request->edit_id)) {
                if(isset($option2)) {
                    $option2->update($data2);
                }
            } else {
                QuestionOption::create($data2);
            }
        }

        if (!empty($request->option_text3)) {
            $data3 = [
                'question_id'=>$question_id,
                'is_answer'=>$request->ans_type3,
                'option_title'=>$request->option_text3,
                'option_image'=>'',
            ];
            if (!empty($request->edit_id)) {
                $option3 = QuestionOption::where('id', $request->text_option3)->first();
            }
            if (!empty($request->edit_id)) {
                if(isset($option3)) {
                    $option3->update($data3);
                }
            } else {
                QuestionOption::create($data3);
            }
        } else {
            $data3 = [
                'question_id'=>$question_id,
                'is_answer'=>$request->ans_type3,
                'option_title'=>''
            ];
            if (!empty($request->edit_id)) {
                $option3 = QuestionOption::where('id', $request->option3)->first();
            }
            if (!empty($request['option_image3'])) {
                $old_img = '';
                if (!empty($option3->option_image)) {
                    $old_img = $option3->option_image;
                }
                $option_image3 = fileUpload($request['option_image3'], path_question_option3_image(), $old_img);
                $data3['option_image'] = $option_image3;
            }
            if (!empty($request->edit_id)) {
                if(isset($option3)) {
                    $option3->update($data3);
                }
            } else {
                QuestionOption::create($data3);
            }
        }

        if (!empty($request->option_text4)) {
            $data4 = [
                'question_id'=>$question_id,
                'is_answer'=>$request->ans_type4,
                'option_title'=>$request->option_text4,
                'option_image'=>'',
            ];
            if (!empty($request->edit_id)) {
                $option4 = QuestionOption::where('id', $request->text_option4)->first();
            }
            if (!empty($request->edit_id)) {
                if(isset($option4)) {

                    $option4->update($data4);
                }
            } else {
                QuestionOption::create($data4);
            }
        } else {
            $data4 = [
                'question_id'=>$question_id,
                'is_answer'=>$request->ans_type4,
                'option_title'=>''
            ];
            if (!empty($request->edit_id)) {
                $option4 = QuestionOption::where('id', $request->option4)->first();
            }
            if (!empty($request['option_image4'])) {
                $old_img = '';
                if (!empty($option4->option_image)) {
                    $old_img = $option4->option_image;
                }
                $option_image4 = fileUpload($request['option_image4'], path_question_option4_image(), $old_img);
                $data4['option_image'] = $option_image4;
            }
            if (!empty($request->edit_id)) {
                if(isset($option4)) {
                    $option4->update($data4);
                }
            } else {
                QuestionOption::create($data4);
            }
        }

        if (!empty($request->option_text5)) {
            $data5 = [
                'question_id'=>$question_id,
                'is_answer'=>$request->ans_type5,
                'option_title'=>$request->option_text5,
                'option_image'=>'',
            ];
            if (!empty($request->edit_id)) {
                $option5 = QuestionOption::where('id', $request->text_option5)->first();
            }
            if (!empty($request->edit_id)) {
                if(isset($option5)) {
                    $option5->update($data5);
                }
            } else {
                QuestionOption::create($data5);
            }
        } else {
            $data5 = [
                'question_id'=>$question_id,
                'is_answer'=>$request->ans_type5,
                'option_title'=>''
            ];
            if (!empty($request->edit_id)) {
                $option5 = QuestionOption::where('id', $request->option5)->first();
            }
            if (!empty($request['option_image5'])) {
                $old_img = '';
                if (!empty($option5->option_image)) {
                    $old_img = $option5->option_image;
                }
                $option_image5 = fileUpload($request['option_image5'], path_question_option5_image(), $old_img);
                $data5['option_image'] = $option_image5;
            }
            if (!empty($request->edit_id)) {
                if(isset($option5)) {
                    $option5->update($data5);
                }
            } else {
                QuestionOption::create($data5);
            }
        }
    }
}
