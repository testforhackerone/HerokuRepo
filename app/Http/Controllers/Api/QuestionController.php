<?php

namespace App\Http\Controllers\Api;

use App\Model\Category;
use App\Model\Question;
use App\Model\QuestionOption;
use App\Model\UserAnswer;
use App\Model\UserCoin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /*
     * questionCategory
     *
     * Question category list
     *
     *
     *
     *
     */
    public function questionCategory()
    {
        $data = ['success' => false, 'data' => [], 'message' => __('Something went wrong')];

        $categories = Category::where('status', STATUS_ACTIVE)->orderBy('serial', 'ASC')->whereNull('parent_id')->get();
        $data['user_available_coin'] = 0;
        $data['user_available_point'] = calculate_score( Auth::user()->id);
        if (isset(Auth::user()->userCoin->coin)) {
            $data['user_available_coin'] = Auth::user()->userCoin->coin;
        }
        $item = [];
        if (isset($categories)) {
            foreach ($categories as $list) {
                $item[] = [
                    'id' => $list->id,
                    'category_id' => encrypt($list->id),
                    'name' => $list->name,
                    'description' => $list->description,
                    'image' => !empty($list->image) ? asset(path_category_image() . $list->image) : "",
                    'qs_limit' => $list->qs_limit,
                    'time_limit' => $list->time_limit,
                    'max_limit' => $list->max_limit,
                    'serial' => $list->serial,
                    'status' => $list->status,
                    'coin' => $list->coin,
                    'sub_category' => $list->count_sub_category->count(),
                    'question_amount' => count_question($list->id),
                    'is_locked' => check_category_unlock($list->id,$list->coin)
                ];
            }

            if (!empty($item)) {
                $data['message'] = __('Category List');
                $data['success'] = true;
                $data['category_list'] = $item;
            }
        } else {
            $data ['success'] =  false;
            $data['message'] = __('No data found');
        }
        return response()->json($data);
    }

    /*
     * questionSubCategory
     *
     * Question sub category list
     *
     *
     *
     *
     */
    public function questionSubCategory($id)
    {
        $data = ['success' => false, 'data' => [], 'message' => __('Something went wrong')];
        try {
            $id = decrypt($id);
        } catch (\Exception $e) {
            $data = [
                'success' => false,
                'message' => __('Invalid Category id')
            ];

            return response()->json($data);
        }
        $category = Category::findOrFail($id);
        $categories = Category::where('status', STATUS_ACTIVE)->orderBy('serial', 'ASC')->where(['parent_id'=>$id])->get();
        $data['user_available_coin'] = 0;
        $data['user_available_point'] = calculate_score( Auth::user()->id);
        $data['parent_category_name'] = $category->name;
        if (isset(Auth::user()->userCoin->coin)) {
            $data['user_available_coin'] = Auth::user()->userCoin->coin;
        }
        $item = [];
        if (isset($categories)) {
            foreach ($categories as $list) {
                $item[] = [
                    'id' => $list->id,
                    'sub_category_id' => encrypt($list->id),
                    'name' => $list->name,
                    'description' => $list->description,
                    'image' => !empty($list->image) ? asset(path_category_image() . $list->image) : "",
                    'qs_limit' => $list->qs_limit,
                    'time_limit' => $list->time_limit,
                    'max_limit' => $list->max_limit,
                    'serial' => $list->serial,
                    'status' => $list->status,
                    'coin' => $list->coin,
                    'question_amount' => count_question($list->id),
                    'is_locked' => check_category_unlock($list->id,$list->coin)
                ];
            }

            if (!empty($item)) {
                $data['message'] = __('Category List');
                $data['success'] = true;
                $data['sub_category_list'] = $item;
            }
        } else {
            $data ['success'] =  false;
            $data['message'] = __('No data found');
        }
        return response()->json($data);
    }

    /*
     * singleCategory
     *
     * Show the Question list under this category
     *
     *
     *
     *
     */

    public function singleCategoryQuestion($type,$id)
    {
        try {
            $id = decrypt($id);
        } catch (\Exception $e) {
            $data = [
                'success' => false,
                'message' => __('Invalid Category id')
            ];

            return response()->json($data);
        }
        $data = ['success' => false, 'data' => [], 'message' => __('Something went wrong')];
        $data['user_available_coin'] = 0;
        $data['user_available_point'] = calculate_score( Auth::user()->id);;
        if (isset(Auth::user()->userCoin->coin)) {
            $data['user_available_coin'] = Auth::user()->userCoin->coin;
        }
        $category = Category::where('id',$id)->first();
        $limit = $category->qs_limit;
        $timeLimit = $category->time_limit;
        $availableQuestions = '';

        if($type ==1) {
            $availableQuestions = Question::with('question_option')
                ->where(['questions.category_id' => $id,'questions.status'=> STATUS_ACTIVE])
                ->whereNotIn('questions.id', UserAnswer::select('question_id')->where(['user_id' => Auth::id()]))
                ->select('questions.*')
                ->inRandomOrder()
                ->limit($limit)
                ->get();
        } else {
            $availableQuestions = Question::with('question_option')
                ->where(['questions.sub_category_id' => $id,'questions.status'=> STATUS_ACTIVE])
                ->whereNotIn('questions.id', UserAnswer::select('question_id')->where(['user_id' => Auth::id()]))
                ->select('questions.*')
                ->inRandomOrder()
                ->limit($limit)
                ->get();
        }

        $data['hints_coin'] = 0;
        if (!empty(allsetting('hints_coin'))) {
            $data['hints_coin'] = allsetting('hints_coin');
        }
        $lists = [];

        if (isset($availableQuestions)) {
            $totalQuestion = 0;
            $totalCoin = 0;
            $totalPoint = 0;
            foreach ($availableQuestions as $question) {
                $itemImage = [];
                if(isset($question->question_option[0])) {
                    $itemImage [] = [
                        'id' => isset($question->question_option[0]) ? $question->question_option[0]->id : '',
                        'question_option' => isset($question->question_option[0]) && (!empty($question->question_option[0]->option_image)) ?  asset(path_question_option1_image() . $question->question_option[0]->option_image) : $question->question_option[0]->option_title,
                        'type' => isset($question->question_option[0]) && (!empty($question->question_option[0]->option_image)) ? 1 : 0
                    ];
                }
                if(isset($question->question_option[1])) {
                    $itemImage [] = [
                        'id' => isset($question->question_option[1]) ? $question->question_option[1]->id : '',
                        'question_option' => isset($question->question_option[1]) && (!empty($question->question_option[1]->option_image)) ?  asset(path_question_option2_image() . $question->question_option[1]->option_image) : $question->question_option[1]->option_title,
                        'type' => isset($question->question_option[1]) && (!empty($question->question_option[1]->option_image)) ? 1 : 0
                    ];
                }


                if(isset($question->question_option[2])) {
                    $itemImage [] = [
                        'id' => isset($question->question_option[2]) ? $question->question_option[2]->id : '',
                        'question_option' => isset($question->question_option[2]) && (!empty($question->question_option[2]->option_image)) ? asset(path_question_option3_image() . $question->question_option[2]->option_image) : $question->question_option[2]->option_title,
                        'type' => isset($question->question_option[2]) && (!empty($question->question_option[2]->option_image)) ? 1 : 0
                    ];
                }
                if(isset($question->question_option[3])) {
                    $itemImage [] = [
                        'id' => isset($question->question_option[3])  ? $question->question_option[3]->id : '',
                        'question_option' => isset($question->question_option[3]) && (!empty($question->question_option[3]->option_image)) ? asset(path_question_option4_image() . $question->question_option[3]->option_image) : $question->question_option[3]->option_title,
                        'type' => isset($question->question_option[3]) && (!empty($question->question_option[3]->option_image)) ? 1 : 0
                    ];
                }
                if(isset($question->question_option[4])) {
                    $itemImage [] = [
                        'id' => isset($question->question_option[4]) ? $question->question_option[4]->id : '',
                        'question_option' => isset($question->question_option[4]) && (!empty($question->question_option[4]->option_image)) ? asset(path_question_option5_image() . $question->question_option[4]->option_image) : $question->question_option[4]->option_title,
                        'type' => isset($question->question_option[4]) && (!empty($question->question_option[4]->option_image)) ? 1 : 0
                    ];
                }

                $lists[] = [
                    'category' => $question->qsCategory->name,
                    'sub_category' => isset($question->qsSubCategory->name) ? $question->qsSubCategory->name : '',
                    'category_id' => $question->qsCategory->id,
                    'sub_category_id' => isset($question->qsSubCategory->id) ? $question->qsSubCategory->id : '',
                    'id' => $question->id,
                    'question_id' => encrypt($question->id),
                    'title' => $question->title,
//                    'has_video' => !empty($question->video_link) ? 1 : 0,
//                    'video_link' => $question->video_link,
                    'has_image' => !empty($question->image) ? 1 : 0,
                    'image' => !empty($question->image) ? asset(path_question_image() . $question->image) : "",
                    'point' => $question->point,
                    'coin' => $question->coin,
                    'time_limit' => isset($question->time_limit) ? $question->time_limit : $timeLimit,
                    'status' => $question->status,
                    'hints' => $question->hints,
                    'skip_coin' => $question->skip_coin,
                    'option_type' => $question->type,
                    'options' => $itemImage,
//                    'options2' => $itemImage,
//                    'options' => $question->question_option->toArray()
                ];

                $totalQuestion ++;
                $totalPoint = $totalPoint + $question->point;
                $totalCoin = $totalCoin + $question->coin;
            }


            if (!empty($lists)) {
                $data['success'] = true;
                $data['totalQuestion'] = $totalQuestion;
                $data['totalPoint'] = $totalPoint;
                $data['totalCoin'] = $totalCoin;
                $data['availableQuestionList'] = $lists;
                $data['message'] = __('Available Question List');
            } else {
                $data = [
                    'success' => false,
                    'message' => __('No question found.')
                ];
            }
        } else {
            $data = [
                'success' => false,
                'message' => __('No question found.')
            ];
        }

        return response()->json($data);
    }


    /*
     * submitAnswer
     *
     * Submit the answer
     *
     *
     *
     *
     */
    public function submitAnswer(Request $request, $id)
    {
        $data = ['success' => false, 'data' => [], 'message' => __('Something Went wrong !')];
        try {
            $id = decrypt($id);
        } catch (\Exception $e) {
            $data = [
                'success' => false,
                'message' => __('Invalid Question id')
            ];

            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'answer' => 'required',
//            'time_limit' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $data['message'] = $errors;

            return response()->json($data);
        }
        try {
            $rightAnswer = [];
            $userCoins = UserCoin::where('user_id', Auth::user()->id)->first();
            if(empty($userCoins)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User coin account not found.',
                ]);
            }
            $correctAnswer = QuestionOption::where(['question_id'=> $id, 'is_answer' => ANSWER_TRUE])->first();
            if(isset($correctAnswer)) {
                $rightAnswer = [
                    'option_id' => $correctAnswer->id,
//                    'option_title' => $correctAnswer->option_title,
                ];
            }
            $question = Question::where(['id' => $id])->first();
            $option = QuestionOption::where(['id'=> $request->answer, 'question_id'=> $id])->first();
            $userAnswer = UserAnswer::where(['question_id' => $id, 'user_id' => Auth::user()->id])->first();

            $input =[
                'user_id' => Auth::user()->id,
                'category_id' => $question->qsCategory->id,
                'question_id' => $question->id,
                'type' => $question->type,
            ];
            if ($option) {

//                $viewTime = Carbon::parse($userAnswer->created_at);
//                $checkTime = Carbon::parse(Carbon::now());
//                $diffTime = $checkTime->diffInSeconds($viewTime);
//                //dd($sendTime,$checkTime, $diffTime);
//                if ($diffTime <= (60 * $request->time_limit)) {
                        if ($option->is_answer == ANSWER_TRUE) {
                            $input['is_correct'] = ANSWER_TRUE;
                            $input['point'] = $question->point;
                            $input['coin'] = $question->coin;
                            if (empty($userAnswer)) {
                                $updatePoint = $userCoins->increment('coin', $question->coin);
                            }
                            $data = [
                                'success' => true,
                                'message' => __('Right Answer'),
                            ];
                        } else {
                            $data = [
                                'success' => false,
                                'message' => __('Wrong Answer'),
                                'right_answer' => $rightAnswer
                            ];
                        }
//                } else {
//                    $data = [
//                        'success' => false,
//                        'message' => __('Sorry Time out!')
//                    ];
//                }
            } else {
                $data = [
                    'success' => false,
                    'message' => __('Wrong Answer'),
                    'right_answer' => $rightAnswer
                ];
            }
            if ($userAnswer) {
                $userAnswer->update($input);
            } else {
                $insert = UserAnswer::create($input);
            }

            $data['total_point'] = calculate_score( Auth::user()->id);
            $data['total_coin'] = User::where('id',Auth::user()->id)->first()->userCoin->coin;

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
//                'message' => 'Something went wrong. Please try again!',
            ]);
        }

        return response()->json($data);
    }

    /*
     * leaderBoard
     *
     * Leader board who have attend the quiz
     * And show their score and ranking
     *
     *
     *
     */
    public function leaderBoard($type=null)
    {
        $data = ['success' => false, 'data' => [], 'message' => __('Something Went wrong !')];
        if ($type == 2) {
            $leaders = UserAnswer::select(
                DB::raw('SUM(point) as score, user_id'))
                ->groupBy('user_id')
                ->whereDate('created_at', Carbon::today())
                ->orderBy('score', 'DESC')
                ->get();
        } elseif($type == 3) {
            $leaders = UserAnswer::select(
                DB::raw('SUM(point) as score, user_id'))
                ->groupBy('user_id')
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->orderBy('score', 'DESC')
                ->get();
        } else {
            $leaders = UserAnswer::select(
                DB::raw('SUM(point) as score, user_id'))
                ->groupBy('user_id')
                ->orderBy('score', 'DESC')
                ->get();
        }

        $lists = [];
        if (isset($leaders)) {
            $rank = 1;
            foreach ($leaders as $item) {

                $lists[] = [
                    'user_id' => $item->user_id,
                    'photo' => asset(pathUserImage() . $item->user->photo),
                    'name' => $item->user->name,
                    'score' => $item->score,
                    'coin' => isset($item->user->userCoin->coin) ? $item->user->userCoin->coin : 0,
                    'ranking' => $rank++,
                ];
            }
            if (!empty($lists)) {
                $data = [
                    'success' => true,
                    'leaderList' => $lists,
                ];
            } else {
                $data = [
                    'success' => false,
                    'message' => __('No data found')
                ];
            }
        } else {
            $data = [
                'success' => false,
                'message' => __('No data found')
            ];
        }

        return response()->json($data);
    }

}
